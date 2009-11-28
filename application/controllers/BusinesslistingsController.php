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

class BusinesslistingsController extends BusinessController {
    
		
	protected $_busTypeId = 10;
	protected $_busType = 'Business Listings';
    
    public function getBusiness()
    {
    	return new Listings();
    } 
    
    public function getForm($business, $location)
    {
    	return new ListingsRefineForm($business, $location);
    }
    
    
    protected function _setRequiredParamsToView($view){
    	
    	$view = parent::_setRequiredParamsToView($view);
    	
    	
    	//$view->paramsHolder->cat2 = ($view->paramsHolder->cat2)?($view->paramsHolder->cat2):nul;
    	//$view->paramsHolder->cat1 = ($view->paramsHolder->cat1)?($view->paramsHolder->cat1):28;
    	
    	return $view;
    }  

    
    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function listingsAction()
    {
 	
    	$this->businessAction();
    				
    	$this->renderScript('jobs/index.phtml');
    	 
    	
    }
    
    /**
     * /Jobs/:query/:city/:state/:country/:region/search/
     * @return unknown_types
     */
    function  listingssearchAction()
    {
    	
    	$this->listingsAction();
    	
    }

    function  listingsrefineAction()
    {
    	$this->listingsAction();
    	
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


		return parent::buildRefineUri($businessType, $formData);		
	}	
	

}
