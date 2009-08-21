<?php
 
 
/**
 * My_Form_Decorator_Captcha
 *      @version	$Id: Captcha.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Decorator
 *      @author		Xinghao Yu <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 *      
 * Shows CAPTCHA image
 * -------------------------------
 * |       Lable: |Input         |
 * -------------------------------
 * |              |              |
 * -------------------------------
 * |              |Hint          |
 * -------------------------------
 * |              |CAPTCHA image |
 * -------------------------------
 * |  Word veri..:|Input         |
 * -------------------------------
 * Options that must be provided are:
 * - namespace: The id of the captcha to show (the key in the session namespace, where the value is saved)
 * - captchaId: The id of the captcha to show (the key in the session namespace, where the value is saved)
 * - tag: tag to use in decorator
 */
class CrFramework_Form_Decorator_Captcha extends Zend_Form_Decorator_Abstract
{
    /**
     * Default placement: append
     * @var string
     */
    protected $_placement = 'PREPEND';
 
    /**
     * HTML tag with which to surround image
     * @var string
     */
    protected $_tag;   
 
    /**
     * Set HTML tag with which to surround image
     * 
     * @param  string $tag 
     * @return My_Form_Decorator_Captcha
     */
    public function setTag($tag)
    {
        $this->_tag = (string) $tag;
        return $this;
    }
 
 
    /**
     * Get HTML tag, if any, with which to surround image
     * 
     * @return void
     */
    public function getTag()
    {
        if (null === $this->_tag) {
            $tag = $this->getOption('tag');
            if (null !== $tag) {
                $this->removeOption('tag');
                $this->setTag($tag);
            }
            return $tag;
        }
 
        return $this->_tag;
    }
 
 
    /**
     * Render a captcha image
     * 
     * @param  string $content 
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }
 
        $tag       = $this->getTag();
        $placement = $this->getPlacement();
        $separator = $this->getSeparator();
 
        $namespace = $this->getOption('namespace');
        $captchaId = $this->getOption('captchaId');

        if (!$namespace || !$captchaId)
        {
            require_once ('Zend/Form/Decorator/Exception.php');
            $exception = new Zend_Form_Decorator_Exception('namespace or captchaId not set');
            throw $exception;
        }
 
        $image = '<img src="/app/user/captcha/'.$namespace.'/'.$captchaId.'" alt="CAPTCHA challange" />'; 
 		//$red = imagecolorallocate($image, 255, 0,0); 
        if (null !== $tag) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();
            $decorator->setOptions(array('tag' => $tag));
            $image = $decorator->render($image);
        }else {	 
        	$image = '<tr><td>&nbsp;</td><td class=forminput valign="middle" align="left" width="65%">' . $image . '</td></tr>' . "\n";
        	$image = '<tr><td>&nbsp;</td><td></td></tr><tr><td>&nbsp;</td><td class=forminput valign="middle" align="left" width="65%">Type the characters you see in the picture below.</td></tr>' . "\n" . $image;
        }
 		logfire('captcha', $image);
        switch ($placement) {
            case self::PREPEND:
                return $image . $separator . $content;
            case self::APPEND:
            default:
                return $content . $separator . $image;
        }
    }
}
?>