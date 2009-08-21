<?php
/**
 * CrFramework_Form_Element_Button
 * Implements default layout
 *   
 *      @version	$Id: Submit.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form_Element_Button extends Zend_Form_Element_Button
{
	/**
	 * @var String
	 */
	protected $_cssClass = 'tdbutton';

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
		
		// default use the button name as button Label
		$this->setValue(Common::titleCase($this->getName()));
		
		//set  standard decorator	
		$this->addPrefixPath('CrFramework_Form_Decorator', 'CrFramework/Form/Decorator', 'decorator');	
		$this->setDecorators(array('Button'));
		
		$this->setAttrib('class',$this->_cssClass);
	}
	
	
}
