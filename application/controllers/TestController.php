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
class TestController extends Hotspot_Controller_Action {

	// dev.test.com/test/generallocationoptions
	public function generallocationoptionsAction() {
		   	// Using homepage template.
    	//Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::SIMPLEVIEW);
		
		$this->_helper->viewRenderer->setNoRender();
		
		try{
			$ref_locTable = new Refloc();
			$cities = $ref_locTable->getAllCityWithCountry();
			if(empty($cities))
			{
				echo 'Empty in table!';
			}
			else
			{	
				//echo '<option value="-1|All|All" selected="selected">All</option>' . "\n";
				echo '<option value="All|All|All" selected="selected">All</option>' . "\n";
				foreach($cities as $city)
				{
					//echo '<option value="' . $city->id . '|' . $city->city . '|' . $city->country .  '">' . $city->city . ' - ' . $city->country . '</option>' . "\n";
					echo '<option value="' .  $city->city . '|' . $city->state . '|' . $city->country .  '">' . $city->city . ' - ' . $city->country . '</option>' . "\n";
				}
			}
		}catch(Exception $e)
		{
			echo $e;
		}
			
	}
	
  
}
