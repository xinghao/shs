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

class RestaurantsController extends BusinessController {
    
		
	protected $_busTypeId = 1;
	protected $_busType = 'Restaurants';
    
    public function getBusiness()
    {
    	return new Restaurants();
    } 
    
    public function getForm($business, $location)
    {
    	return new RestaurantsRefineForm($business, $location);
    }
    
    
    protected function _setRequiredParamsToView($view){
    	
    	$view = parent::_setRequiredParamsToView($view);
    	
    	
    	//$view->paramsHolder->cat2 = ($view->paramsHolder->cat2)?($view->paramsHolder->cat2):nul;
    	
    	return $view;
    }  

    
    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function  restaurantsAction()
    {
 	
    	$this->businessAction();
    				
    	$this->renderScript('jobs/index.phtml');
    	 
    	
    }
    
    /**
     * /Jobs/:query/:city/:state/:country/:region/search/
     * @return unknown_types
     */
    function  restaurantssearchAction()
    {
    	
    	$this->restaurantsAction();
    	
    }

    function  restaurantsrefineAction()
    {
    	$this->restaurantsAction();
    	
    }
    
     
	public function changecat2Action($addALL = true)
	{
		parent::changecat2Action(false);		
	}   

	

    

	protected function buildRefineUri($businessType, $formData)
	{
		if (strtolower($formData['cat2']) == strtolower('Any'))
		{
			$formData['cat2name'] = 'Any';	
		}
		else{
			$refcat2 = new Refcategory();
			$formData['cat2name'] = $refcat2->getCatNameById($formData['cat2']);			
		}

		if (strtolower($formData['cat3']) == 25)
		{
			$formData['cat3name'] = 'Any';	
		}
		else{
			$refcat3 = new Refcat1();
			$formData['cat3name'] = $refcat3->getCatNameById($formData['cat3']);			
		}
		
		return parent::buildRefineUri($businessType, $formData);		
	}	
	

}
