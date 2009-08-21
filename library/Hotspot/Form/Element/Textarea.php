<?php
/**
 * CrFramework_Form_Element_Textarea
 * Implements default layout
 *   
 *      @version	$Id: Text.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form_Element_Textarea extends Zend_Form_Element_Textarea
{
	/**
	 * @var int
	 */
	protected $_rows = 3;
	
	/**
	 * 
	 * @var int
	 */
	protected $_cols = 24;
	
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
    	$this->setAttrib('class', $this->_cssClass);
    }
    

	
  	/**
	 * set checkbox css sytle
	 * @param $cssclass the css sytle for diaplay checkbox
	 */   
    public function setRows($rows)
    {
    	$this->_rows = $rows;
    }

  	/**
	 * set checkbox css sytle
	 * @param $cssclass the css sytle for diaplay checkbox
	 */   
    public function setcols($cols)
    {
    	$this->_cols = $cols;
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
		$this->setAttrib('rows', $this->_rows);
		$this->setAttrib('cols', $this->_cols);
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
