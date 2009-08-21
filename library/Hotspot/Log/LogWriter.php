<?php
/**
 * LogWriter
 * Implements application and error logging using Zend_Log.
 *
 * @author		Tim Woo <tim@airarena.net>
 * @version		$Rev: 3820 $ $Author: sandrine $ $Date: 2009-03-30 15:25:49 +1100 (Mon, 30 Mar 2009) $
 * @package		CrFramework
 * @subpackage	Session
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */

function logStd($source, $msg) {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_std')->log($source.': '.$msg, Zend_Log::INFO);
}

function logWarn($msg) {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_std')->log($msg, Zend_Log::WARN);
}

function logError($source, $msg) {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_err')->log('"'.$source.'"="'.$msg.'"', Zend_Log::CRIT);
}
function logEmpty($source, $msg) {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_empty')->log('"'.$source.'"="'.$msg.'"', Zend_Log::CRIT);
}
function logUsers($source, $msg) {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_users')->log('"'.$source.'"="'.$msg.'"', Zend_Log::CRIT);
}
function logDebug($source, $msg = '') {
	//if (DEBUG) echo $source.' : '.$msg;
	//if (DEBUG) {
		$registry = Zend_Registry::getInstance();
		$registry->get('log_debug')->log('"'.$source.'"="'.$msg.'"', Zend_Log::INFO);
		
	//}
}

function logFire($source, $msg) {
	if (DEBUG) {
		$registry = Zend_Registry::getInstance();
		$registry->get('log_fire')->log($source.' '.$msg, Zend_Log::DEBUG);
	}
}
//adlisting
function logAdlistAcxiom($type,$adId='', $msg='',$adName='',$msg2='',$date='',$msg3='',$search='',$msg4='',$ipaddress='',$msg5='',$referrer='',$msg6='') {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_adlist')->log('type="'.$type.'": ["'.$adId.'"="'.$msg.'"] ["'.$adName.'"="'.$msg2.'"] ["'.$date.'"="'.$msg3.'"] ["'.$search.'"=""'.$msg4
	.'"] ["'.$ipaddress.'"="'.$msg5.'"] ["'.$referrer.'"="'.$msg6.'"]', Zend_Log::INFO);
	
}
//add details
function logDetailsAcxiom($adId='', $msg='',$adName='',$msg2='',$date='',$msg3='',$search='',$msg4='',$ipaddress='',$msg5='',$referrer='',$msg6='',$type='',$msg7='') {
	$registry = Zend_Registry::getInstance();
	$registry->get('log_addetail')->log('["'.$adId.'"="'.$msg.'"] ["'.$adName.'"="'.$msg2.'"] ["'.$date.'"="'.$msg3.'"] ["'.$search.'"="'.$msg4
	.'"] ["'.$ipaddress.'"="'.$msg5.'"] ["'.$referrer.'"="'.$msg6.'"]["'.$type.'"="'.$msg7.'"]', Zend_Log::INFO);
	
}

function logRoute($function, $controller) {
	logStd($function, $controller->getFrontController()->getRouter()->getCurrentRouteName());
}