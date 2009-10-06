<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class JobsRefineForm extends RefineForm
{
	
	protected function buildCat2Element()
	{
       	$cat2 = new Zend_Form_Element_Select('cat2');
       	$cat2->setLabel($this->_business->getCat2Name());
       	$cat2->addMultiOptions($this->_business->getCat2Array());
       	$cat2->setValue($this->_business->getFirstCat2());
       	$cat2->setAttrib('class','refineformselect');
       	$cat2->setAttrib('onchange',"changeCat2(this.id,this.options[this.selectedIndex].value, '/ajax/jobs/changecat2/')");
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
/*	
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
*/	
	/*
	public function printLocationElements()
	{
		echo 
		
		echo $this->city;
	    echo $this->state;
		echo $this->country;
		echo $this->region;

	}

	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#populate()
	 */

	public function populate(array $values)
	{
				
		if(array_key_exists('cat2',$values) && !empty($values['cat2']))
		{
			$this->cat3->setMultiOptions($this->_business->getCat3Array($values['cat2']));
		}
			


		
		// Call the father's render function.
		return parent::populate($values);
	}

	
}
