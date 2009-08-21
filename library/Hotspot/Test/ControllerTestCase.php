<?php
/**
 * Controller Test Case
 * Base class for Zend phpUnit test cases.
 *   
 *      @version	$Id: ControllerTestCase.php 4294 2009-04-09 00:52:52Z timw $
 *      @package	CrFramework
 *      @subpackage	Test
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Test_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
	// To stop serialization of PDO DB objects
	protected $backupGlobals = FALSE;
	
    public function setUp() {
        $this->bootstrap = APPLICATION_PATH.'/tests/bootstrap.php';
        parent::setUp();
    }

    public function appBootstrap() {
        $this->frontController->registerPlugin(
            new Bugapp_Plugin_Initialize('test')
        );
    }
    
    /**
     * Dispatch the MVC
     *
     * If a URL is provided, sets it as the request URI in the request object. 
     * Then sets test case request and response objects in front controller, 
     * disables throwing exceptions, and disables returning the response.
     * Finally, dispatches the front controller.
     * 
     * @param  string|null $url 
     * @return void
     */
	public function dispatch($url = null)
    {
        // redirector should not exit
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        $redirector->setExit(false);

        // json helper should not exit
        $json = Zend_Controller_Action_HelperBroker::getStaticHelper('json');
        $json->suppressExit = true;

        $request    = $this->getRequest();
        if (null !== $url) {
            $request->setRequestUri($url);
            $_SERVER['REQUEST_URI']  = $url;
        } else {
        	unset($_SERVER['REQUEST_URI']);
        }
        $request->setPathInfo(null);
        $router = new CrFramework_Controller_Router_Rewrite();
		$router->setParams($this->frontController->getParams());
		$router->removeDefaultRoutes();
		$router->setRoutesDirectory(APPLICATION_PATH.'/config/routes', array(APPLICATION_ENVIRONMENT, 'routes'));
		$this->frontController->setRouter($router);
        
        $this->frontController
             ->setRequest($request)
             ->setResponse($this->getResponse())
             ->throwExceptions(false)
             ->returnResponse(false);
        $this->frontController->dispatch();
    }

}