<?php
/**
 * CrFramework_Form_Element_Password
 * Implements default layout
 *   
 *      @version	$Id: Password.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form_Element_Password extends Zend_Form_Element_Password
{
	/**
	 * @var String
	 */
 	protected $_cssClass = 'tdinput';

 	/**
	 * set checkbox css sytle
	 * @param $cssclass the css sytle for diaplay checkbox
	 */
    public function setCssClass($cssclass)
    {
    	$this->_cssClass = $cssclass;
    }
       
    /**
     * (non-PHPdoc)
     * @see library/Zend/Form/Zend_Form_Element#init()
     */
	public function init()
	{
		// Call parent's init method	
		parent::init();
		
		// call the CrFramework form element common init function
		// refer to CrFramework_Form_Element_ElementCommon.php
		CrFramework_Form_Element_ElementCommon::init($this, $this->_cssClass);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Form/Zend_Form_Element#setRequired()
	 */
    public function setRequired($flag = true)
    {
    	// call the CrFramework form element common setRequired function
		// refer to CrFramework_Form_Element_ElementCommon.php
		CrFramework_Form_Element_ElementCommon::setRequired($this, $flag);
        
        // call parent's method
        parent::setRequired($flag);
        return $this;
    }
    
	/**
	 * set string length validator
	 * @param $min
	 * @param $max
	 */
	public function setStringLength($min, $max)
	{
	    // call the CrFramework form element common setStringLength function
		// refer to CrFramework_Form_Element_ElementCommon.php
		CrFramework_Form_Element_ElementCommon::setStringLength($this, $min, $max);	
	}
	
}
