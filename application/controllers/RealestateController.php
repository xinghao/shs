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

class RealestateController extends BusinessController {
    
		
	protected $_busTypeId = 8;
	protected $_busType = 'Real Estate';
    
    public function getBusiness()
    {
    	return new Realestate();
    } 
    
    public function getForm($business, $location)
    {
    	return new RealestateRefineForm($business, $location);
    }
    
    
    protected function _setRequiredParamsToView($view){
    	
    	$view = parent::_setRequiredParamsToView($view);
    	
    	$view->paramsHolder->bed =  Tag::myUrlDecode($this->_getParam('bed'));
    	$view->paramsHolder->cars =  Tag::myUrlDecode($this->_getParam('cars'));
    	$view->paramsHolder->bath =  Tag::myUrlDecode($this->_getParam('bath'));
    	$view->paramsHolder->min =  Tag::myUrlDecode($this->_getParam('min'));
    	$view->paramsHolder->max =  Tag::myUrlDecode($this->_getParam('max'));
    	
    	$view->paramsHolder->cat2 = ($view->paramsHolder->cat2)?($view->paramsHolder->cat2):630;
    	
    	return $view;
    }  

    
    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function  realestateAction()
    {
 	
    	$this->businessAction();
    				
    	$this->renderScript('jobs/index.phtml');
    	 
    	
    }
    
    /**
     * /Jobs/:query/:city/:state/:country/:region/search/
     * @return unknown_types
     */
    function  realestatesearchAction()
    {
    	
    	$this->realestateAction();
    	
    }

    function  realestaterefineAction()
    {
    	$this->realestateAction();
    	
    }
    
     
	public function changecat2Action($addALL = true)
	{
		parent::changecat2Action(false);		
	}   

	

    

	protected function buildRefineUri($businessType, $formData)
	{
		if (strtolower($formData['cat2']) == strtolower('ALL'))
		{
			$formData['cat2name'] = 'ALL';	
		}
		else{
			$refcat2 = new Refcategory();
			$formData['cat2name'] = $refcat2->getCatNameById($formData['cat2']);			
		}

		if (strtolower($formData['cat3']) == strtolower('ALL'))
		{
			$formData['cat3name'] = 'ALL';	
		}
		else{
			$refcat3 = new Refcategory();
			$formData['cat3name'] = $refcat3->getCatNameById($formData['cat3']);			
		}
		
		return parent::buildRefineUri($businessType, $formData);		
	}	
	
	protected function _getAdditionalData($view){
		return array(
		'bed'=>$view->paramsHolder->bed,
    	'cars'=>$view->paramsHolder->cars,
    	'bath'=>$view->paramsHolder->bath,
    	'min'=>$view->paramsHolder->min,
    	'max'=>$view->paramsHolder->max
		);
	}	
}
