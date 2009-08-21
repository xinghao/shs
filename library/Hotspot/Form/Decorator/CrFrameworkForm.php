<?php


class CrFramework_Form_Decorator_CrFrameworkForm extends Zend_Form_Decorator_FormElements
{
 
    /**
     * Render form elements
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
    	logfire('dfsfdsf','--------------------');
        $form    = $this->getElement();
 		return '<table class="' . '">' . parent::render($content) . '</table>';
    }
}
