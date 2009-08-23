<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class RefineForm extends Zend_Form
{
	
	protected $_business;


	
	public function __construct($business)
	{
		$this->_business = 	$business;	
		
		parent::__construct();
	}
	
	
	protected function buildQuickSearchElements()
	{
		// Quick search field
		$query = new Zend_Form_Element_Text('query');
		$query->setLabel('Keywords or posting id:');
		$query->setAttrib('class','refineforminput');
		$this->addElement($query);

		// Quick search btn
        $quick_search = new Zend_Form_Element_Image('quicksearchbtn');
       	$quick_search->setImage('/images/sitetemplate/find-2-60.png');
       	$quick_search->setAttribs(array(
        	'rows' => 22,
        	'cols' => 60
    	)); 
       	$quick_search->setImageValue(true);
       	$this->addElement($quick_search);
		
	}
	
	protected function buildCat1Element()
	{
       	$cat1 = new Zend_Form_Element_Radio('cat1');
       	$cat1->setLabel($this->_business->getCat1Name());
       	 
       	$cat1->setMultiOptions($this->_business->getCat1Array());
       	//$cat1->setValue($this->_business->getFirstCat1());
       	//logfire('key',$this->_business->getFirstCat1());
       	$cat1->setValue($this->_business->getFirstCat1());
       	$cat1->setAttrib('class','refineformselect');
       	/*
       	if($this->_business->getCat1AsArray())
       	echo 'empty!!!!!!!!!!!!!!!!';
       	foreach ($this->_business->getCat1AsArray() as $key=>$value)
       	{
       		echo $key . '=>' . $value . "\n";
       	}
       	*/
       	$this->addElement($cat1);
		
	}
	
	protected function buildCat2Element()
	{
       	$cat2 = new Zend_Form_Element_Select('cat2');
       	$cat2->setLabel($this->_business->getCat2Name());
       	$cat2->addMultiOptions($this->_business->getCat2Array());
       	$cat2->setAttrib('class','refineformselect');
       	$this->addElement($cat2);
		
	}
	
	protected function buildCat3Element()
	{
       	$cat3 = new Zend_Form_Element_Select('cat3');
       	$cat3->setLabel($this->_business->getCat3Name());
       	$cat3->setAttrib('class','refineformselect');
       	$cat1selected = $this->_business->getFirstCat2();
       	$cat3->addMultiOptions($this->_business->getCat3Array($cat1selected));
       	$this->addElement($cat3);
		
	}
	
	protected function buildCat4Element()
	{
       	$cat4 = new Zend_Form_Element_Select('cat4');
       	$cat4->setLabel($this->_business->getCat4Name());
       	$cat4->setAttrib('class','refineformselect');
       	$cat4->addMultiOptions($this->_business->getCat4Array());
       	$this->addElement($cat4);		
	}
	
	protected function buildCat5Element()
	{
       	$cat5 = new Zend_Form_Element_Select('cat5');
       	$cat5->setLabel($this->_business->getCat5Name());
       	$cat5->setAttrib('class','refineformselect');
       	$cat4selected = $this->_business->getFirstCat4();
       	$cat5->addMultiOptions($this->_business->getCat5Array($cat4selected));
       	$this->addElement($cat5);		
	}
	
	/**
	 * build Listing Form
	 * @see library/CrFramework/CrFramework_Form#init()
	 */
	public function init()
	{
		$this->setMethod('post');
		$this->setName('refineform');

				
		$this->buildQuickSearchElements();

		$this->buildCat1Element();
		
		$this->buildCat2Element();
		
		$this->buildCat3Element();
		
		$this->buildCat4Element();
		
		$this->buildCat5Element();
		
       	
       	
       	
       	
       	/*
       	$cat4 = new Zend_Form_Element_Select('cat4');
       	$cat4->setLabel($this->_cat4Name);
       	
       	$cat3->addMultiOptions($this->_business->getCat3Options($cat1selectArray[0]));
       	$this->addElement($cat3);
       	
       	$cat3 = new Zend_Form_Element_Select('cat5');
       	$cat3->setLabel($this->_cat3Name);
       	
       	$cat1selectArray = explode('|', $this->_business->getFirstCat2Option());
       	$cat3->addMultiOptions($this->_business->getCat3Options($cat1selectArray[0]));
       	$this->addElement($cat3);
       	*/
       	
       			// Quick search btn
        $submit = new Zend_Form_Element_Image('submit');
       	$submit->setImage('/images/sitetemplate/find-2-80.png');
       	$submit->setAttribs(array(
        	'rows' => 22,
        	'cols' => 80
    	)); 
       	$submit->setImageValue(true);
       	$this->addElement($submit);
       	
       	
        
 		
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
	
}
