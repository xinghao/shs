<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class RealestateRefineForm extends RefineForm
{
	
	protected function buildCat1Element()
	{

	}	
	
	protected function buildCat2Element()
	{
    	$cat2 = new Zend_Form_Element_Radio('cat2');
       	$cat2->setLabel($this->_business->getCat2Name());
       	$cat2->addMultiOptions($this->_business->getCat2Array(null, false));
       	$cat2->setValue($this->_business->getFirstCat2(null, false));
       	$cat2->setAttrib('class','refineformselect');
        $cat2->setAttrib('onclick',"changeCat2(this.id,this.value, '/ajax/realestate/changecat2/')");
       	$this->addElement($cat2);
		
	}
	
	protected function buildCat3Element()
	{
       	$cat3 = new Zend_Form_Element_Select('cat3');
       	$cat3->setLabel($this->_business->getCat3Name());
       	$cat3->setAttrib('class','refineformselect');
       	$cat2selected = $this->cat2->getValue();

		
       	$cat3->addMultiOptions($this->_business->getCat3Array($cat2selected, false));
        $this->addElement($cat3);
		
	}

	protected function  buildExtraElements()
	{
		$pricesTable = new Refprice();
		
		logfire('$this->_business->getBusinessTypeId()', $this->_business->getBusinessTypeId());
		$prices = $pricesTable->getPriceOptions($this->_business->getBusinessTypeId(), $this->_location->getSearchRules()->currency);
		
       	$min = new Zend_Form_Element_Select('min');
       	$min->setLabel('Min');
       	$min->setAttrib('class','refineformmoneyselect');
       	$min->addMultiOptions($prices);
       	$this->addElement($min);
       	
       	$max = new Zend_Form_Element_Select('max');
       	$max->setLabel('Max');
       	$max->setAttrib('class','refineformmoneyselect');
       	$max->addMultiOptions($prices);
       	$this->addElement($max);   

       	$facilifies = array('Any'=>'Any', '0'=>'0', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7');
       	$bedOptions = array('Any'=>'Any', '1'=>'Studio', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7');

       	$bed = new Zend_Form_Element_Select('bed');
       	$bed->setLabel('Bed');
       	$bed->setAttrib('class','refineformmoneyselect');
       	$bed->addMultiOptions($bedOptions);
       	$this->addElement($bed);   
       	
      	$cars = new Zend_Form_Element_Select('cars');
       	$cars->setLabel('Cars');
       	$cars->setAttrib('class','refineformmoneyselect');
       	$cars->addMultiOptions($facilifies);
       	$this->addElement($cars); 

      	$bath = new Zend_Form_Element_Select('bath');
       	$bath->setLabel('Bath');
       	$bath->setAttrib('class','refineformmoneyselect');
       	$bath->addMultiOptions($facilifies);
       	$this->addElement($bath); 
       	       	
		return parent::buildExtraElements();
	}
	
	
	
	
	
	public function printExtraElements()
	{
		echo '<div class="priceselectdiv">';
		echo '<div class="priceselectdivtitle">Select Price Range: (' . $this->_location->getCurrencyAndSymbol() . ')</div>';
		echo '<div class="virticalgap"></div>';
		echo '<div class="priceselectdivbox">';
		echo '<span class="min">';
		/*
		$element = $this->min;
		echo 'min: ' . $element->getView()->{$element->helper}(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
        */
		echo $this->min;
        echo '</span><span class="max">';
		/*$element = $this->max;
		echo 'max: ' . $element->getView()->{$element->helper}(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
        */
        echo $this->max; 
        echo '</span>';
        echo '<div class="clear"></div>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class="facilityselectdiv">';
        echo '<span class="facilityselect">';
		echo $this->bed;
		echo '</span><span class="facilityselect">';
		echo $this->cars;
		echo '</span><span class="facilityselect">';
		echo $this->bath;
		echo '</span></div>';
		
		return parent::printExtraElements();
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

	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#populate()
	 */

	public function populate(array $values)
	{
				
		if(array_key_exists('cat2',$values) && !empty($values['cat2']))
		{
			$this->cat3->setMultiOptions($this->_business->getCat3Array($values['cat2'],false));
		}
			


		
		// Call the father's render function.
		return parent::populate($values);
	}

	protected function _getSearchHint($category, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $Cat5 = null)
	{
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
	}	
}
