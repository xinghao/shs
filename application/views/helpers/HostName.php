<?php
/**
 * @version	$Id: HostName.php 3646 2009-03-24 04:29:55Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_HostName {
	function hostName(){
		$registry = Zend_Registry::getInstance();
		$config = $registry->get('CONFIG');
        return $config->website->host;
    }
}