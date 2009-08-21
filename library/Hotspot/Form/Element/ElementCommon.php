<?php
/**
 * CrFramework_Form_Element_ElementCommon
 * provide statice function for all the CrFramework Form Elemtns.
 * There are duplicated code in these CrFramework Form Elemtns, such as setRequired, setStringLength.
 * Since we cann't use multiple extends, we use this class to provide some static function.
 *   
 *      @version	$Id: ElementCommon.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Xinghao Yu <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form_Element_ElementCommon 
{

    
	/**
	 * set Sdandard decorator as default decorator
	 * set element's css class
	 * add stringtrim filter
	 * @param $element
	 * @param $cssClass
	 */
	public static function init($element, $cssClass)
	{
		$element->addPrefixPath('CrFramework_Form_Decorator', 'CrFramework/Form/Decorator', 'decorator');	
		$element->addPrefixPath('CrFramework_Validate', 'CrFramework/Validate', 'validate');
		$filterTrim = new Zend_Filter_StringTrim();
		$element->addFilter($filterTrim);
		$element->setDecorators(array('Standard'));
		$element->setAttrib('class',$cssClass);
		$element->setLabel(Common::titleCase($element->getName()));
	}
	
	/**
	 * set no empty validator and overrider the error message
	 * @param $element
	 * @param $flag
	 */
    public static function setRequired($element, $flag = true)
    {
        $validatorNotEmpty = new CrFramework_Validate_NotEmpty();
        $validatorNotEmpty->overriderErrorMsgwithFieldName($element->getLabel());
        $element->addValidator($validatorNotEmpty, true);

    }
    
	/**
	 * set string length validator
	 * @param $element
	 * @param $min
	 * @param $max
	 */	
	public static function setStringLength($element, $min, $max)
	{
       $validatorStringLength = new CrFramework_Validate_StringLength($min, $max);
       $validatorStringLength->overriderErrorMsgwithFieldName($element->getLabel());
       $element->addValidator($validatorStringLength);		
	}
	
}
