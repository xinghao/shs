<?php
/**
 * Index Controller
 *
 *      @version	$Id: StaticController.php 7374 2010-01-28 00:38:29Z timw $
 *      @package	Application
 *      @subpackage	Controllers
 *      @author		Elton Stewart <elton@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class StaticController extends Hotspot_Controller_Action {
	// Routing rules in config.ini handle the homepage so no need for this at the moment.

	public function init() {
    	// Used by content header.
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::SIMPLEVIEW);
	}

	function showAction() {
 		// Get Params
 		try{
	      $query = $this->_getParam('document');
		  $this->view->document = str_replace(' ', '-', $query);
//$this->_helper->viewRenderer->setNoRender();
//echo $this->view->document . '.phtml';
$this->view->addScriptPath(WEBSITE_ROOT."/content/");

		$this->renderScript($this->view->document.'.phtml');

 		}catch(Exception $e)
 		{
 			echo $e;
 		}

	}


}
