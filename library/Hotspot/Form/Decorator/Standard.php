<?php
/**
 * CrFramework_Form_Decorator_Standard
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
 
class CrFramework_Form_Decorator_Standard extends Zend_Form_Decorator_Abstract
{
	
	/**
	 * Get Label name, if it is required, addd a =n "*" befire the label name
	 * and ": " at the end of label
	 * returns like: <td class=formlabel valign="middle" align="right" width="35%">Label</td>
	 * @return String
	 */
    public function buildLabel()
    {
    	// get the current element and label name
        $element = $this->getElement();
        $label = $element->getLabel();
        
        // get translator and  do translate if this element has a translator 
        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }

        // if it is required, addd a =n "*" befire the label name
  //      if ($element->isRequired()) {
  //         $label = '*' . $label;
  //      }

        // and ": " at the end of label
        //$label .= ": ";
        return '<td class=formlabel>' . $element->getView()->formLabel($element->getName(), $label) . '&nbsp;&nbsp;</td>';
    }

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

        if ($element->isRequired()) {
           $cssClass = $element->getAttrib('class');
           if (!$cssClass) {
           		$cssClass = '';
           }
           $cssClass .= ' inputrequired';
           $element->setAttrib('class', $cssClass);
        }        
        
        $content = $element->getView()->$helper(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
        
        return '<td class=forminput>' . $content . '</td>'; 
    }

    /**
     * field error output
     * return like <tr><td colspan=2 valign="middle"><span class=elementerror>ErrorMsg</span></td></tr>
     * if message is null, returns empty
     * @return String
     */
    public function buildErrors()
    {
        $element  = $this->getElement();
        $messages = $element->getMessages();
        
        if (empty($messages)) {
            return '';
        }
        
        $display = $element->getAttrib('display');
        return '<tr id="' . $element->getName() . 'error" class="' . $display . '"><td></td><td valign="middle" align="center"><span class=elementerror>' . $element->getView()->formErrors($messages) . '</span></td></tr>';
    }

    /**
     * field description message
     * return likes <tr><td colspan=2 valign="middle"><span class=elementdescription>Description</span></td></tr>
     * if it is null, returns empty tag
     * @return String
     */
    public function buildDescription()
    {
        $element = $this->getElement();
        $desc    = $element->getDescription();
        
        if (empty($desc)) {
            return '';
        }
        
        
        $display = $element->getAttrib('display');
        
        return '<tr id="' . $element->getName() . 'desc" class="' . $display . '"><td></td><td valign="middle"  align="center"><span class=elementdescription>' . $desc . '</span></td></tr>';
    }

    /**
     * render this element
     * (non-PHPdoc)
     * @see library/Zend/Form/Decorator/Zend_Form_Decorator_Abstract#render()
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

        // get all the layout components.
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $label     = $this->buildLabel();
        $input     = $this->buildInput();
        $errors    = $this->buildErrors();
        $desc      = $this->buildDescription();

        // build the layout
        // input line
        // description line
        // error line  
        $display = $element->getAttrib('display');
        $output = '<tr id="' . $element->getName() . 'main" class="' . $display . '">' . $label . $input . '</tr>' . "\n"
                . $desc . "\n"
                . $errors . "\n";
        
        // based on placement flag, choose the right position to put output.
		//logfire($element->getName(), $output);
        switch ($placement) {
            case (self::PREPEND):
                return $output . $separator . $content;
            case (self::APPEND):
            default:
                return $content . $separator . $output;
        }
    }
}
