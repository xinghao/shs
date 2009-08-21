<?php
/**
 * Created on Jan 21, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once('Zend/Controller/Router/Rewrite.php');

class CrRouter extends Zend_Controller_Router_Rewrite {
	
	public function route(Zend_Controller_Request_Abstract $request) {

	    // Let the Rewrite router route the request first
	    $request = parent::route($request);
		logFire("ROUTE", $request->getParam('controller'));
	    if($request->getParam('controller') == '') {
			// If the page param isn't set, route to default page and controller
			$defaultPage = PageManager::getInstance()->getDefaultPage();
			  
			$request->setControllerName($defaultPage->pageType->controller);
			$request->setParam('controller',$defaultPage->page);
			$request->setParam('action','index');
		} else {
			// Route to current page's controller
			$controller = PageManager::getInstance()->getPage($request->getParam('controller'));
			$request->setControllerName($controller->pageType->controller);
			$request->setActionName('index');
	    }
		$request->setParam('controller','search');
		$request->setParam('action','search');
		return $request;
	}
}