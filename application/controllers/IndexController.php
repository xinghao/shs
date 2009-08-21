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
  
}
