<?php
/**
 * CrFramework_Form_Element_Select
 * Implements default layout
 *   
 *      @version	$Id: Select.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form_Element_Select extends Zend_Form_Element_Select
{
	/**
	 * @var String
	 */
	protected $_cssClass = 'formselect';
	
  	/**
	 * set checkbox css sytle
	 * @param $cssclass the css sytle for diaplay checkbox
	 */   
    public function setCssClass($cssclass)
    {
    	$this->_cssClass = $cssclass;
    	$this->setAttrib('class', $this->_cssClass);
    }
    
    /**
     * (non-PHPdoc)
     * @see library/Zend/Form/Zend_Form_Element#init()
     */
	public function init()
	{
		parent::init();
		// call the CrFramework form element common init function
		// refer to CrFramework_Form_Element_ElementCommon.php
		CrFramework_Form_Element_ElementCommon::init($this, $this->_cssClass);
	}

	public function getFirstOption($getkey = false)
	{
//		logfire('sdfsdfdsfs vlaue', $this->getValue());
		$tempArray = $this->getMultiOptions();
		if ($tempArray == null)
		{
			return null;
		} 
		else
		{
			if ($getkey) {
				$tempArray = array_keys($tempArray);
			}
			
			return array_shift($tempArray);
		}
	}
	
/*
    public function setRequired($flag = true)
    {
        $validatorNotEmpty = new CrFramework_Validate_SelectNotEmpty();
        $validatorNotEmpty->overriderErrorMsgwithFieldName($this->getLabel());
        $this->addValidator($validatorNotEmpty, true);        
		// call parent's method
        parent::setRequired($flag);
        
        return $this;
    }
    

    public function setMultiOptions(array $options)
    {
    	if ($this->isRequired()) 
    	{
    		parent::setMultiOptions(array('0' => '--Please Select--'));
    		$this->addMultiOptions($options);
    	} 
    	else{
    		parent::setMultiOptions($options);	
    	}
    } 
  */  
	
}
