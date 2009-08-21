<?php
/**
 * CrFramework_Validate_IdenticalField
 * Extends Zend_Validate_Abstract to compare if two fields are same.
 * Used by comfirm password or email.
 * 
 * @author		Xinghao <xinghao@airarena.net>
 * @version		$Id: StringLength.php 5091 2009-05-21 00:44:49Z xinghao $
 * @package		CrFramework
 * @subpackage	Validate
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Validate_IdenticalField extends Zend_Validate_Abstract {

	const NOTMATCH = 'notMatch';
	const MISSINGFIELDNAME = 'missingFieldName';	
	const INVALIDFIELDNAME = 'invalidFieldName';

	protected $_messageTemplates = array(
	    self::INVALIDFIELDNAME  =>
	      'INNER ERROR: The field "%fieldName%" was not provided to match against.',
	    self::NOTMATCH =>
	      'Does not match %fieldTitle%.',
		self::MISSINGFIELDNAME  =>
      	  'INNER ERROR: Field name to match against was not provided.',	    
	  );

/**
   * @var array
  */
  protected $_messageVariables = array(
    'fieldName' => '_fieldName',
    'fieldTitle' => '_fieldTitle'
  );
 
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
  }
 
  /**
   * Returns the field name.
   *
   * @return string
  */
  public function getFieldName() {
    return $this->_fieldName;
  }

  /**
   * Sets the field name.
   *
   * @param  string $fieldName
   * @return Zend_Validate_IdenticalField Provides a fluent interface
     */
  public function setFieldName($fieldName) {
    $this->_fieldName = $fieldName;
    return $this;
  }
 
  /**
   * Returns the field title.
   *
   * @return integer
  */
  public function getFieldTitle() {
    return $this->_fieldTitle;
  }
 
  /**
   * Sets the field title.
   *
   * @param  string:null $fieldTitle
   * @return Zend_Validate_IdenticalField Provides a fluent interface
  */
  public function setFieldTitle($fieldTitle = null) {
    $this->_fieldTitle = $fieldTitle ? $fieldTitle : $this->_fieldName;
    return $this;
  }
 
  /**
   * Defined by Zend_Validate_Interface
   *
   * Returns true if and only if a field name has been set, the field name is available in the
   * context, and the value of that field name matches the provided value.
   *
   * @param  string $value
   *
   * @return boolean
  */
  public function isValid($value, $context = null) {
    $this->_setValue($value);
    $field = $this->_fieldName;
 
    if (empty($field)) {
      $this->_error(self::MISSINGFIELDNAME);
     return false;
   } elseif (!isset($context[$field])) {
      $this->_error(self::INVALIDFIELDNAME);
      return false;
    } elseif (is_array($context)) {
      if ($value == $context[$field]) {
        return true;
      }
    } elseif (is_string($context) && ($value == $context)) {
      return true;
    }
   $this->_error(self::NOTMATCH);
    return false;
  }

	
}