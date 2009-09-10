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
		$query->setLabel('Refine Search:');
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
       	$cat2->setValue($this->_business->getFirstCat2());
       	$cat2->setAttrib('class','refineformselect');
       	$cat2->setAttrib('onchange','changeCat2(this.id,this.options[this.selectedIndex].value)');
       	$this->addElement($cat2);
		
	}
	
	protected function buildCat3Element()
	{
       	$cat3 = new Zend_Form_Element_Select('cat3');
       	$cat3->setLabel($this->_business->getCat3Name());
       	$cat3->setAttrib('class','refineformselect');
       	$cat2selected = $this->cat2->getValue();
       	$cat3->addMultiOptions($this->_business->getCat3Array($cat2selected));
       	$this->addElement($cat3);
		
	}
	
	protected function buildCat4Element()
	{
       	$cat4 = new Zend_Form_Element_Select('cat4');
       	$cat4->setLabel($this->_business->getCat4Name());
       	$cat4->setAttrib('class','refineformselect');
       	$cat4->setAttrib('onchange','changeState("cat5",this.options[this.selectedIndex].value)');
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
	
	protected function buildLocationElements()
	{
		$location = $this->_business->getLocation();
		if (!empty($location))
		{
			$this->addElement(Common::createHiddenElement('city', $location->getCity()));
			$this->addElement(Common::createHiddenElement('state', $location->getState()));
			$this->addElement(Common::createHiddenElement('country', $location->getCountry()));
			$this->addElement(Common::createHiddenElement('region', $location->getRegion()));
		}
		else
		{
			$this->addElement(Common::createHiddenElement('city', ''));
			$this->addElement(Common::createHiddenElement('state', ''));
			$this->addElement(Common::createHiddenElement('country', ''));
			$this->addElement(Common::createHiddenElement('region', ''));
		}
	}
	
	/*
	public function printLocationElements()
	{
		echo 
		
		echo $this->city;
	    echo $this->state;
		echo $this->country;
		echo $this->region;

	}
	*/	
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

		$this->buildCat1Element();
		
		$this->buildCat2Element();
		
		$this->buildCat3Element();
		
		$this->buildCat4Element();
		
		$this->buildCat5Element();
		
       	
       	$this->buildLocationElements();
       	
       //	$this->addElement(Common::createHiddenElement('businessType', $this->_business->getBusinessType()));
       
       	$this->setAction('/refine/'.strtolower($this->_business->getBusinessType()));
       	
       	
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
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#populate()
	 */
	public function populate(array $values)
	{
		
		// Job specifically.
		if ( (!array_key_exists('cat4',$values) || empty($values['cat4'])) && array_key_exists('state',$values) && !empty($values['state']) )
		{
			$values['cat4'] = Location::getStateIdByName($values['state']);
		}

		// Job specifically.
		//	if ( (!array_key_exists('cat5',$values) || empty($values['cat5'])) && array_key_exists('city',$values) && !empty($values['city']) )
		// In case it comes from the links on the header.
		if ( array_key_exists('city',$values) && !empty($values['city']) )
		{
			$values['cat5'] = Location::getCityIdByName($values['city']);
			
		}
		
		
		if(array_key_exists('cat2',$values) && !empty($values['cat2']))
		{
			$this->cat3->setMultiOptions($this->_business->getCat3Array($values['cat2']));
		}
			
		if(array_key_exists('cat4',$values) && !empty($values['cat4']))
		{
			$this->cat5->setMultiOptions($this->_business->getCat5Array($values['cat4']));
		}

		if(array_key_exists('cat1',$values) && empty($values['cat1']))
		{
			unset($values['cat1']);
		}
		
		// Call the father's render function.
		return parent::populate($values);
	}
	
}
