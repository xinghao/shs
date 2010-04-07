<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

require_once (WEBSITE_ROOT."/includes/recaptchalib.php");
class ContactForm extends Zend_Form
{

	public $table_name = "";
	public $hint = "contactformtable";
	public $_posting_element;
    public $validationErrorMsg = '';

	public function setHint($hint)
	{
		$this->hint = $hint;

	}

	public function setTableName($name)
	{
		$this->table_name = $name;
	}


	public function setPostingId($id)
	{
		$this->_posting_element = new Zend_Form_Element_Hidden('postingid');
		$this->_posting_element->setValue($id);
		$this->addElement($this->_posting_element);
	}

	protected function buildElements()
	{
		// Quick search field
		$full_name = new Zend_Form_Element_Text('fullname');
		$full_name->setLabel('Your Name:');
		$full_name->setAttrib('class','contactforminput');
		$full_name->setAttrib('hint','your name');
		$this->addElement($full_name);

        // create EMAIL input tag
        // Unique check, require, email address valid check, length less than 100(database length for this field)
		//  do email address validation(default each email element do email address validation)
        $credit_email = new Zend_Form_Element_Text('email_from');
		$credit_email->setLabel('Your Email:');
		$credit_email->setAttrib('class','contactforminput');
		$this->addElement($credit_email);

		// create Description Textarea tag
		// filed type in db is Text
		$description = new Zend_Form_Element_Textarea('question');
		$description->setLabel('Your Question:');
		$description->setAttrib('class','contactforminput');
		$description->setAttrib('hint','your question');
		$this->addElement($description);



		// Quick search btn
        $send = new Zend_Form_Element_Image('submit');
       	$send->setImage('/images/sitetemplate/send_button.png');
       	$send->setAttribs(array(
        	'rows' => 22,
        	'cols' => 60
    	));

       	$send->setImageValue(true);
       	$this->addElement($send);

		$this->setName("contactform");
		$this->setAttrib("onSubmit", "return ValidateForm();");
	}



	protected function  buildExtraElements()
	{
		return null;
	}

	public function printExtraElements()
	{
		return null;
	}

	/**
	 * build Listing Form
	 * @see library/CrFramework/CrFramework_Form#init()
	 */
	public function init()
	{

		$this->setMethod('post');
		$this->setName('contactform');


		$this->buildElements();


        //$this->addAttribs(array('onsubmit'=>'beforeSubmit()'));
		// use view script to render form
		$this->setDecorators(array(
			'FormElements',
			array('ViewScript', array(
    		'viewScript' => 'forms/_contactform.phtml',
    		'class'      => 'hotspotform',
			'placement' => false
				)),
			'Form'
		));

	}

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#populate()
	 */
	public function populate(array $values)
	{

		// Call the father's render function.
		return parent::populate($values);
	}


	public function isValid($data)
	{

		$resp = recaptcha_check_answer (Common::GetRecaptchaKey("private"),
                                $_SERVER["REMOTE_ADDR"],
                                $data["recaptcha_challenge_field"],
                                $data["recaptcha_response_field"]);

		//print_r($resp);

		if (!$resp->is_valid) {
			$this->validationErrorMsg = "Incorrect Validation Code!";
			 echo recaptcha_get_html(Common::GetRecaptchaKey("public"), $resp->error);
			return false;
		}

		return parent::isValid($data);
	}


}
