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
   	
    	//echo   "jobs";
    	$this->setRequiredParamsToMakeContentHeader();
    	
 
    	    	
 //   	$this->view->location = new Location(Tag::myUrlDecode($this->_getParam('city')), Tag::myUrlDecode($this->_getParam('state')), Tag::myUrlDecode($this->_getParam('country')), Tag::myUrlDecode($this->_getParam('region')));
    	$this->view->category = 'Jobs';
 
    	
    	//echo 'quick search btn:' . $this->_getParam('quicksearchbtn') . "\n";
    	//echo 'submit btn:' . $this->_getParam('submit');
    	
    	try{
    	$this->view->business = new Jobs($this->view->location);
    	$this->view->form = new RefineForm($this->view->business);
    	
    	//$values['cat4'] = Location::getStateIdByName($this->view->location->getState());
    	
    //	$values['cat5'] = Location::getCityIdByName($this->view->location->getCity());
    	
     $cat1 = ($this->view->paramsHolder->cat1)?($this->view->paramsHolder->cat1):12;
     
     $select = $this->view->business->search($this->view->location,$this->view->limit,$this->view->offset,
	    	       $this->view->paramsHolder->query, $cat1, $this->view->paramsHolder->cat2, 
	    	       $this->view->paramsHolder->cat3, null, null);
	    	       
	//echo '------select: '.$select->__toString() . "\n";
	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
  	
    $paginator = new Zend_Paginator($adapter);
    
    $paginator->setItemCountPerPage($this->view->limit);
    $paginator->setCurrentPageNumber($this->view->offset);

    Zend_Paginator::setDefaultScrollingStyle('Sliding');
	Zend_View_Helper_PaginationControl::setDefaultViewPartial('sitetemplate/_pagination.phtml');
	$this->view->currentItemCount = $paginator -> getCurrentItemCount();
	$this->view->itemCount = $paginator->getTotalItemCount();
	
	//echo '------currentItemCoutn: ' .  $this->view->currentItemCount;
	$paginator->setView($this->view);
	
	$this->view->postings = $paginator;
	    	       
		/*
	    	foreach($this->view->postings as $key=>$value)
	    	{
	    		echo $key .'=>'.$value->title."<br />";	
	    	}
	    	*/
    	}
    	catch(Exception $e)
    	{
    		echo $e;
    	}
    				
    	$this->renderScript('jobs/index.phtml');
    	
  //  	echo Tag::link('jobsbasic',$this->view->location->toStdClass(),'test'); 
    	
    }
    
    /**
     * /Jobs/:query/:city/:state/:country/:region/search/
     * @return unknown_types
     */
    function  jobssearchAction()
    {
    	
    	$this->jobsAction();
    	//echo "jobssearch";
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }

    function  jobsrefineAction()
    {
	   	// Using homepage template.
    	//Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	//$this->_helper->viewRenderer->setNoRender();
    	
    	//echo "jobsrefine";
    	$this->jobsAction();
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
    function  jobssearchrefineAction()
    {
	   	// Using homepage template.
    	//Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	//$this->_helper->viewRenderer->setNoRender();
    	
    	//echo "jobssearchrefine";
    	
    	$this->jobsAction();
    	
    	//$this->setRequiredParamsToMakeContentHeader();
    	
    }
    
	public function changecat2Action()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$param1 = $this->_getParam('param1', 0);
		logfire('param1', $param1);
		
		$cat3 = array();
		
		$jobs = new Jobs(); 
		
		$cat3 = $jobs->getCat3Array($param1);
				
		if (!empty($cat3))
		{

			$jsonArray = array();
			foreach($cat3 as $id=>$name)
			{
				$cat3row = array('id' => $id, 'name' => $name);
				$jsonArray[] = $cat3row;
			}
			
		
			$json = Zend_Json::encode($jsonArray);			
			echo $json;
			unset($json);
		}
		
	}   

	
	public function changestateAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$param1 = $this->_getParam('param1', 0);
		logfire('param1', $param1);
		
		$location = new Location(); 
		
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
    
	
	function refinedispatchAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo $businessType = $this->_getParam('controller');
		
		$formData = array();
    	    	
    	$request = $this->getRequest();

		// Init lisitng form.
		//$this->form = new RefineForm();
		
		if ($request->isPost()) 
		// User submit listing form.
		// We add new listing into the database.	
		{
			// Get the form data form post.
			$formData = $request->getPost();
			foreach($formData as $key=>$value)
				echo $key . '=>'. $value . "<br />";
			
			if (array_key_exists('quicksearchbtn' ,$formData))
			{
				//echo $this->buildSearchUri($businessType, $formData);
				$this->_redirect($this->buildSearchUri($businessType, $formData));
			}
			if (array_key_exists('submit' ,$formData))
			{ 
				//echo $this->buildRefineUri($businessType, $formData);
				$this->_redirect($this->buildRefineUri($businessType, $formData));
				
			}
			
		}
		
	}
	
	
	protected function buildSearchUri($businessType, $formData)
	{
		try{
		echo strtolower($businessType). 'search';
		
/*		$refcat1 = new Refcat1();
		$formData['cat1name'] = $refcat1->getCatNameById($formData['cat1']);
		
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
		
		echo 'sss'.'1';
*/		
		$formData = Common::encodeUriParams($formData);
		return Tag::url(strtolower($businessType). 'search', Common::arrayToStdClass($formData));
		}catch(Exception $e)
		{
			echo $e;
		}
	}
	
	protected function buildRefineUri($businessType, $formData)
	{
		try{
		echo strtolower($businessType). 'jobsbasicrefine';
		
		$refcat1 = new Refcat1();
		$formData['cat1name'] = $refcat1->getCatNameById($formData['cat1']);
		
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
		
		$formData['city'] = Location::getCityNameById($formData['cat5']);
		$formData['state'] = Location::getStateNameById($formData['cat4']);
		$formData['region'] = null;
		
		logfire('city', $formData['city']);
		logfire('state', $formData['state']);
		logfire('cat3name', $formData['cat3name']);
		echo 'sss'.'1';
		
		$formData = Common::encodeUriParams($formData);
		return Tag::url(strtolower($businessType). 'basicrefine', Common::arrayToStdClass($formData));
		}catch(Exception $e)
		{
			echo $e;
		}
	}
	
}
