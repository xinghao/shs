<?php
/**
 * Index Controller
 *   
 *      @version	$Id: IndexController.php 5711 2009-07-20 07:39:29Z xinghao $
 *      @package	Application
 *      @subpackage	Controllers
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class JobsController extends Hotspot_Controller_Action {
    
    

    
    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function  jobsAction()
    {
   	
    	//echo   "jobs";
    	$this->setRequiredParamsToMakeContentHeader();
    	
 //   	$this->view->location = new Location(Tag::myUrlDecode($this->_getParam('city')), Tag::myUrlDecode($this->_getParam('state')), Tag::myUrlDecode($this->_getParam('country')), Tag::myUrlDecode($this->_getParam('region')));
    	$this->view->category = 'Jobs';
 
  //  	echo Tag::link('jobsbasic',$this->view->location->toStdClass(),'test'); 
    	
    }
    
    
    function  jobssearchAction()
    {
    	$this->setRequiredParamsToMakeContentHeader();
    	
 //   	$this->view->location = new Location(Tag::myUrlDecode($this->_getParam('city')), Tag::myUrlDecode($this->_getParam('state')), Tag::myUrlDecode($this->_getParam('country')), Tag::myUrlDecode($this->_getParam('region')));
    	$this->view->category = 'Jobs';
    	    	
    	echo "jobssearch";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }

    function  jobsrefineAction()
    {
	   	// Using homepage template.
    	//Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	echo "jobsrefine";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
    function  jobssearchrefineAction()
    {
	   	// Using homepage template.
    	//Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	echo "jobssearchrefine";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
}
