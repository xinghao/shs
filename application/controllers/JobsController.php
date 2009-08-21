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
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	echo "jobs";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
    
    function  jobssearchAction()
    {
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	echo "jobssearch";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }

    function  jobsrefineAction()
    {
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	echo "jobsrefine";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
    function  jobssearchrefineAction()
    {
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	echo "jobssearchrefine";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
}
