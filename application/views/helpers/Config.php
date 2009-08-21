<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_Config {
    function config(){
		$registry   = Zend_Registry::getInstance();
		return $registry->get('CONFIG');    
	}
}