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

class SearchController extends Hotspot_Controller_Action {
	// Routing rules in config.ini handle the homepage so no need for this at the moment.
    function searchdispatchAction() 
    {
    	try{
 $this->_helper->viewRenderer->setNoRender();
    	$location = $this->_getParam('qlocation');
    	$category = $this->_getParam('qcategory');

    	//echo $location;
    	//echo $category;
    	if (empty($location) || empty($category))
    	{
    					
			$this->_redirect('/');
    	}
    	else
    	{
    		$locationArray = explode('|', $location);
    		$this->_redirect("/" . Tag::myUrlEncode($category) . "/" . Tag::myUrlEncode($locationArray[0]). "/" . Tag::myUrlEncode($locationArray[1]) . "/" . Tag::myUrlEncode($locationArray[2]));
    		
    		/*
    		$routerParams = array(
    			'query' => $category,
    		    'city'  => $locationArray[0],
    			'country' => $locationArray[1]
    		);
    		*/
    		
    		//echo $this->_help->url($routerParams, 'user');
    		// Redirect to results page
			//$this->_redirect("/" . Tag::myUrlEncode($category) . "/" . Tag::myUrlEncode($locationArray[0]). "/" . Tag::myUrlEncode($locationArray[1]));
    	}
    	// Using homepage template.
    	//Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::SIMPLEVIEW);
    	//$this->_helper->viewRenderer->setNoRender();
    	//echo 'wlecome to hotspot101';
    	}catch(Exception $e)
    	{
    		echo $e;
    	}
    }
    
    
    protected function setRequiredParamsToMakeContentHeader(){
    	// Used by content header.
    	$this->view->location = new Location(Tag::myUrlDecode($this->_getParam('city')), Tag::myUrlDecode($this->_getParam('state')), Tag::myUrlDecode($this->_getParam('country')), Tag::myUrlDecode($this->_getParam('region')));
    	$this->view->category = 'Jobs';
    }
    
    
    function  searchjobsAction()
    {
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	$this->_helper->viewRenderer->setNoRender();
    	
    	$this->setRequiredParamsToMakeContentHeader();
    	
    }
  
}
