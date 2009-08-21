<?php
/**
 * CrFramework_Form
 * Implements default layout
 *   
 *      @version	$Id: Form.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form extends Zend_Form
{    
	public function addHiddenElement($name,$value){
		$hidden = new Zend_Form_Element_Hidden($name);
		$hidden ->setValue($value);
		$this->addElement($hidden);
	}
	
	public function init(){
		
		$this->setDisableLoadDefaultDecorators(true);
		$this->setAttrib('class','crframeworkform');
		$this->setDecorators(array(
		    'FormElements',
		    array('HtmlTag', array('tag' => 'table', 'class' => 'form element', 'width' => '100%')),
		    array('Description', array('placement' => 'prepend')),
		    'Form'
		));
		//$this->addPrefixPath('CrFramework_Form_Decorator', 'CrFramework/Form/Decorator', 'decorator');
		//$this->setDecorators(array(
		//	'CrFrameworkForm'
		//));
	}
}
