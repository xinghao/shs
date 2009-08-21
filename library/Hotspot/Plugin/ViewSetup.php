<?php
/**
 * CrFramework_Plugin_ViewSetup
 * apply 2 step view
 * Front Controller plug in to set up the site template view
 * path and some useful request variables.
 *   
 *      @version	$Id: CrFramework_Plugin_ViewSetup.php 4978 2009-05-13 07:28:44Z sandrine $
 *      @package	CrFramework
 *      @subpackage	Plugin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class Hotspot_Plugin_ViewSetup extends Zend_Controller_Plugin_Abstract
{    
    /**
     * @var Zend_View
     */
    protected $_view;
     /**
     * @var int
     * site template number
     */   
    protected $_renderLayout;
    //site tempate 1 : backend
    const FRONTENDVIEW = 1;
    const SIMPLEVIEW = 2;
   // const BACKENDVIEW = 3;
   // const BACKENDVIEWWITHOUTLEFTCOLUMN = 4;

   	/**
	 *  init
	 *  set not use sitetemplate
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */     
    public function init() {
       $this->_renderLayout = 0;
    }
    
     /**
	 *  called by action to setup site template
	 *  @param $template template number
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */ 
    public static function setUpSiteTemplate($template){
    	//get fontController and then get plugin instance
    	$front = Zend_Controller_Front::getInstance();
		$st = $front->getPlugin('Hotspot_Plugin_ViewSetup');
		//set template number
		$st->setRenderLayout($template);
    }
  
     /**
	 *  dispatchLoop startup plugin
	 *  set view object and set several useful param for view.
	 *  @param $template template number
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */     
   public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
    	//get view ojbect and init
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->init();
        
        $view = $viewRenderer->view;
        $this->_view = $view;
        // set up common variables for the view
       // $viewRenderer->view->baseUrl = $request->getBaseUrl();
       // $viewRenderer->view->module = $request->getModuleName();
       //get controller and action names
        $viewRenderer->view->controller = $request->getControllerName();
        $viewRenderer->view->action = $request->getActionName();
		//logfire('predispatch','happened');
    }
   
     /**
	 *  dispatchLoop shutdown plugin
	 *  get action view and wrap it with site template view
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */      
    public function dispatchLoopShutdown()
    {
    	//logfire('postdispatch','happened');
    	//chech whether using site template
    	if($this->_renderLayout > 0){
    		//logfire('isbackend', $this->_renderLayout);        
       		//get frontcontroller, request and response objects
    		$frontController = Zend_Controller_Front::getInstance(); 
        	$request = $frontController->getRequest(); 
        	
        	// If it is error page, we do not want wrap it with extra header and footer.
        	if (!strcasecmp($request->getControllerName(), 'Error'))
        	{
        		return;
        	}
        	
        	$response = $frontController->getResponse(); 
        	
        	//get action view and stored it in actionTempate var
        	$body = $response->getBody();
        	//logfire('body',$body);
        	$this->_view->actionTemplate = $body;
        
        	//get template script
        	$layoutScript = $this->getTemplateScript();
        	//logfire('script ', $layoutScript);
        	//$this->_view->actionTemplate = '/'.$request->getControllerName().'/'.$request->getActionName().'.phtml';
        	$content = $this->_view->render($layoutScript);
        	$response->setBody($content);
    	}
    }

    /**
	 *  get template script throught template number 
	 *  @return retrun the dirctory of ste template. reutn default if no template has been chosen.
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */      
    protected function getTemplateScript(){
    	if($this->_renderLayout == 1) {
    		return '/sitetemplate/_frontend.phtml';
    	}elseif($this->_renderLayout == 2) {
    		return '/sitetemplate/_simple.phtml';
    	}else {
    		return 'default';
    	}
    }

     /**
	 *  set template number
	 *  @param $renderLayout template number
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */ 
    private function setRenderLayout($renderLayout){
    	$this->_renderLayout = $renderLayout;
    }
    
 
}