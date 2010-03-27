<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class ContactForm extends Zend_Form
{

	protected function buildElements()
	{
		// Quick search field
		$full_name = new Zend_Form_Element_Text('fullname');
		$full_name->setLabel('Your Name:');
		$full_name->setAttrib('class','refineforminput');
		$this->addElement($full_name);

        // create EMAIL input tag
        // Unique check, require, email address valid check, length less than 100(database length for this field)
		//  do email address validation(default each email element do email address validation)
        $credit_email = new CrFramework_Form_Element_Email('email_from');
		$credit_email->setLabel('Your Email:');
		$credit_email->setStringLength(0,100);

		// create Description Textarea tag
		// filed type in db is Text
		$description = new CrFramework_Form_Element_Textarea('question');
		$description->setLabel('Your Question:');
		$this->addElement($description);


		// Quick search btn
        $send = new Zend_Form_Element_Image('quicksearchbtn');
       	$send->setImage('/images/sitetemplate/find-2-60.png');
       	$send->setAttribs(array(
        	'rows' => 22,
        	'cols' => 60
    	));
    	$send->setAttrib('onclick', 'return setsearch(1);');
       	$send->setImageValue(true);
       	$this->addElement($send);

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
		logfire('dsfsdf','sdfsdfdsfs');
		$this->setMethod('post');
		$this->setName('refineform');


		$this->buildQuickSearchElements();

       	$this->setAction('/refine/'.str_replace(' ','',strtolower($this->_business->getBusinessType())));




        //$this->addAttribs(array('onsubmit'=>'beforeSubmit()'));
		// use view script to render form
		$this->setDecorators(array(
			'FormElements',
			array('ViewScript', array(
    		'viewScript' => 'forms/_refineform.phtml',
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


}
