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

class IndexController extends Hotspot_Controller_Action {
	// Routing rules in config.ini handle the homepage so no need for this at the moment.
    function indexAction() {
 
    	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::SIMPLEVIEW);
    	//$this->_helper->viewRenderer->setNoRender();
    	//echo 'wlecome to hotspot101';
    }

    	// Routing rules in config.ini handle the homepage so no need for this at the moment.
    function categorydispatchAction() 
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
    
}
