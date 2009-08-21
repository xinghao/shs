<?php
/**
 * CrFramework_Form_Decorator_LoginInput
 * Implements default layout
 * -------------------------------
 * |       Lable: |Input         |
 * -------------------------------
 * |         Desctiption         |
 * -------------------------------
 * |          Field Error        |
 * -------------------------------   
 *      @version	$Id: Standard.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Xinghao Yu<xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
 
class CrFramework_Form_Decorator_LoginInput extends CrFramework_Form_Decorator_Standard
{
	

    /**
     * build input tag
     * return likes <td class=forminput valign="middle" align="left" width="65%"><input... /></td>
     * @return string
     */
    public function buildInput()
    {
        $element = $this->getElement();
        
        // use current element' viewhelper to biuld <input.. /> tag
        $helper  = $element->helper;
        
        $content = $element->getView()->$helper(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
        
        return '<td class=forminput>' . $content . '</td>'; 
    }

}
