<?php
/**
 * Error Controller
 * 
 *      @version	$Id: ErrorController.php 4334 2009-04-09 05:05:52Z sandrine $
 *      @package	Application
 *      @subpackage	Controllers
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class ErrorController extends Hotspot_Controller_Action {

	public function errorAction() {
$this->_helper->viewRenderer->setNoRender();
			$this->_helper->viewRenderer->setViewSuffix('phtml');
		$errors = $this->_getParam('error_handler');

		if ($errors) {
	        switch ($errors->type) {
	            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
	            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
	            //case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
	                // 404 error -- controller or action not found
	            	$this->_helper->viewRenderer('404');
		            $this->getResponse()->setHttpResponseCode(404);
		            $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found'); 
        		    echo $this->view->message = 'Page not found'; 
        		    //$this->view->errorMessage = $this->_defaultMessages['ERROR_404'];
					
	                break;
	            default:
	                // application error; display error page, but don't change
	                // status code
	
	                // Log the exception:
	                $exception = $errors->exception;
	                logError('ERROR HANDLER',
	                		$exception->getMessage()."\n".
							$exception->getTraceAsString());
	                break;
	        }
		} else {
			$this->_helper->viewRenderer('404');
			$this->getResponse()->setHttpResponseCode(404); 
			$this->view->message = 'Page not found'; 
		}
	}
	
	public function rendererrorcodeAction() {
		$code = $this->getSessionParam("error_code");
		$code = empty($code) ? "404" : $code;
		$this->_helper->viewRenderer($code);
		$this->getResponse()->setHttpResponseCode(intval($code));
	}
  
	
	
}
