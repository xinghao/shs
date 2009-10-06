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

class LocationController  extends Zend_Controller_Action {
    
		
	public function changestateAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$param1 = $this->_getParam('param1', 0);
		logfire('param1', $param1);
		
		$location = new Location($param1); 
		
		$cities = $location->getAllCityByStateId($param1);
			
				
		if (!empty($cities))
		{

			
			$jsonArray = array();
			foreach($cities as $city)
			{
				$cityrow = array('id' => $city->cityid, 'name' => $city->city);
				$jsonArray[] = $cityrow;
			}
			
			
		
			$json = Zend_Json::encode($jsonArray);			
			echo $json;
			unset($json);
		}
		
		
	}
    
	public function changecityAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$param1 = $this->_getParam('param1', 0);
		logfire('param1', $param1);
		
		$location = new Location($param1); 
		
		$regions = $location->getRegionOptionsByCityId($param1);
			
				
		if (!empty($regions))
		{

			
			$jsonArray = array();
			foreach($regions as $key=>$value)
			{
				$cityrow = array('id' => $key, 'name' => $value);
				$jsonArray[] = $cityrow;
			}
			
			
		
			$json = Zend_Json::encode($jsonArray);			
			echo $json;
			unset($json);
		}
		
		
	}

	
	public function changeregionAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$param1 = $this->_getParam('param1', 0);
		logfire('param1', $param1);
		
		$location = new Location($param1); 
		
		$suburbs = $location->getSuburbOptionsByRegionId($param1);
			
				
		if (!empty($suburbs))
		{

			
			$jsonArray = array();
			foreach($suburbs as $key=>$value)
			{
				$cityrow = array('id' => $key, 'name' => $value);
				$jsonArray[] = $cityrow;
			}
			
			
		
			$json = Zend_Json::encode($jsonArray);			
			echo $json;
			unset($json);
		}
		
		
	}
	
}
