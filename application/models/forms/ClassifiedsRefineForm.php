<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class ClassifiedsRefineForm extends RefineForm
{
	
	protected function buildCat1Element()
	{

	}	
	
	protected function buildCat2Element()
	{
    	$cat2 = new Zend_Form_Element_Select('cat2');
       	$cat2->setLabel($this->_business->getCat2Name());
       	$cat2->addMultiOptions($this->_business->getCat2Array(null,true));
       	$cat2->setValue($this->_business->getFirstCat2(null,true));
       	$cat2->setAttrib('class','refineformselect');
       	$this->addElement($cat2);
		
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
	protected function _getSearchHint($category, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $Cat5 = null)
	{
		/*
		if (empty($cat2))
		{
			return  $category;
		}  
		
		if ($cat2 == '630')
		{
			$cat2Name = 'For SALE';
		}
		else
		{
			$cat2Name = 'For ' . $this->_business->getCat2NameById($cat2);
		}
		
		if ($cat3 == '631')
		{
			return 'ALL ' . $cat2Name;
		}
		else
		{
			return  $this->_business->getCat3NameById($cat3) . ' ' . $cat2Name;	
		}
		*/
		return parent::_getSearchHint($category, $cat1, $cat2, $cat3, $cat4, $Cat5);		
	}	
}
