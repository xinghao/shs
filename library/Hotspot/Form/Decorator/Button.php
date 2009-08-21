<?php
/**
 * CrFramework_Form_Decorator_Button
 * Implements default layout
 * the Decorator of button is like
 * -------------------------------
 * |       Lable: |Input         |
 * -------------------------------
 * |              |              |
 * -------------------------------
 * |              |Button        |
 * _______________________________
 *   
 *      @version	$Id: Button.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
 
class CrFramework_Form_Decorator_Button extends CrFramework_Form_Decorator_Standard
{

    /**
     * build input tag
     * return likes <td class=forminput valign="middle" align="left" width="65%"><input... /></td>
     * @return string
     */
    public function buildInput()
    {
        $element = $this->getElement();
        $helper  = $element->helper;
        $content = $element->getView()->$helper(
            $element->getName(),
            $element->getLabel(),
            $element->getAttribs(),
            $element->options
        );
        return  $content ; 
    }

 
	/**
	 * (non-PHPdoc)
	 * @see library/CrFramework/Form/Decorator/CrFramework_Form_Decorator_Standard#render()
	 */
    public function render($content)
    {
    	
        $element = $this->getElement();
        
        // if it is not a zend form's element return.
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }
        
        // if this element doesn't have a view related to, return.
        if (null === $element->getView()) {
            return $content;
        }

        $input     = $this->buildInput();
		//$output = '<tr><td colspan = 2>&nbsp;</td></tr>' . "\n";
        //$output = '<tr><td>&nbsp;</td>'  . $input . '</tr>' . "\n";

		return $input;
    }
}
