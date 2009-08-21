<?php
/**
 * @version	$Id: RequestUri.php 3646 2009-03-24 04:29:55Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_RequestUri {
    function requestUri(){
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getRequest()->getRequestUri();
    }
}