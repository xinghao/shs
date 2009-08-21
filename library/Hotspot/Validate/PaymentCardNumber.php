<?php
/**
 * CrFramework_Validate_NotEmpty
 * Extends Zend_Validate_NotEmpty to output our Error message to users
 * 
 * @author		Xinghao <xinghao@airarena.net>
 * @version		$Id: NotEmpty.php 5091 2009-05-21 00:44:49Z xinghao $
 * @package		CrFramework
 * @subpackage	Validate
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Validate_PaymentCardNumber extends Zend_Validate_NotEmpty {
	
	const INVALIDPAYMENTCARDNUMBER = 'invalidPaymentCardNumber';
	const MISSINGFIELDNAME = 'missingFieldName';	
	const INVALIDFIELDNAME = 'invalidFieldName';
	const INVALIDEXPIRYDATE = 'invalidExpiry';

	protected $_messageTemplates = array(
	    self::INVALIDFIELDNAME  =>
	      'INNER ERROR: The field "%fieldName%" was not provided to match against.',
		self::INVALIDPAYMENTCARDNUMBER  =>
      	  '%errorMsg%',	
		self::INVALIDEXPIRYDATE  =>
      	  'Invalid Expiry',		    
		self::MISSINGFIELDNAME  =>
      	  'INNER ERROR: Field name to match against was not provided.',	    
	  );

/**
   * @var array
  */
  protected $_messageVariables = array(
    'fieldName' => '_fieldName',
    'fieldTitle' => '_fieldTitle',
    'errorMsg' => '_errorMsg'
  );
  

  protected $_errorMsg;
  /**
   * Name of the field as it appear in the $context array.
   *
   * @var string
   */
  protected $_fieldName;
 
  /**
   * Title of the field to display in an error message.
   *
   * If evaluates to false then will be set to $this->_fieldName.
   *
   * @var string
  */
  protected $_fieldTitle;
  
  

  /**
  * Sets validator options
  *
   * @param  string $fieldName
   * @param  string $fieldTitle
   * @return void
  */
  public function __construct($fieldName, $fieldTitle = null) {
    $this->_fieldName = $fieldName;
    $this->_fieldTitle = $fieldTitle;
    $this->_errorMsg = '';
  }
	  
  /**
   * check if payment card number is valid number.
   * @see branches/michael-test/library/Zend/Validate/Zend_Validate_NotEmpty#isValid()
   */
 public function isValid($value, $context = null) {
    
 	// Filter the card number.
 	// If it includes hash we will return empty.
 	$value = PaymentCards::CardNUmberFilter($value);
 	
 	if (empty($value))
 	{
 		return true;
 	}
    
 	$this->_setValue($value);
    $field = $this->_fieldName;
 	$expiry = '';
 	
 	// Get field of expiry date.
    if (empty($field)) {
      $this->_error(self::MISSINGFIELDNAME);
     return false;
   } elseif (!isset($context[$field])) {
      $this->_error(self::INVALIDFIELDNAME);
      return false;
    } elseif (is_array($context)) {
    	$expiry = $context[$field];

    } elseif (is_string($context)) {
    	$expiry = $context;
    }
    // Explode to array
    $expiryarray = explode('/', $expiry);
    
    // Check if expiry is valid.
    if (empty($expiryarray) || !array_key_exists(1,$expiryarray))
    {
    	$this->_error(self::INVALIDEXPIRYDATE);
    	return false;
    }

    $paymentCardsTable = new PaymentCards();
    
    // Check payment card number valid.
    // If it returns false we also get the error message.
    $validFlag = $paymentCardsTable->isCreditCardValid(trim($value), $expiryarray[0], '20' . $expiryarray[1]);
    logfire('valid:', '[' . trim($value) . '][' . $expiryarray[0] . ']['.  '20' . $expiryarray[1] . ']');
    //logError('valid', $paymentCardsTable->getCreditCardValidErrorMsg());
    if ($validFlag)
    {
    	
    	return true;
    }
    else
    {
    	$this->_errorMsg = $paymentCardsTable->getCreditCardValidErrorMsg();
    	$this->_error(self::INVALIDPAYMENTCARDNUMBER);
    	return false;
    }

  }
	
}