<?php
/*
 * Created on Jan 21, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once 'Zend/Controller/Router/Route/Module.php';

class CrRoute extends Zend_Controller_Router_Route_Module {
	public function __construct(Zend_Controller_Dispatcher_Interface $dispatcher,Zend_Controller_Request_Abstract $request) {
		parent::__construct(array('module'=>'','action'=>'index','page'=>''),$dispatcher,$request);
		$this->_controllerKey = 'page';
	}
}
