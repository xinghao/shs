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

class BusinessController extends Zend_Controller_Action {

	// Initial by the child.
	protected $_busTypeId;
	protected $_busType;

	public function init() {
    	// Used by content header.
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
	}

    protected function _setRequiredParamsToView($view){
    	//$this->_helper->viewRenderer->setNoRender();

    	$location_id = $this->_getParam('locationid');

    	$view->location = new Location($location_id);

    	$view->paramsHolder = $view->location->toStdClass();

		//$this->view->paramsHolder = $this->view->location->mergeToAnotherClass($this->view->paramsHolder);
    	$view->paramsHolder->locationid =  $location_id;

    	// Get all category ids.
    	$view->paramsHolder->query =  Tag::myUrlDecode($this->_getParam('query'));
    	$view->paramsHolder->cat1 =  Tag::myUrlDecode($this->_getParam('cat1'));
    	$view->paramsHolder->cat2 =  Tag::myUrlDecode($this->_getParam('cat2'));
    	$view->paramsHolder->cat3 =  Tag::myUrlDecode($this->_getParam('cat3'));
    	$view->paramsHolder->cat4 =  Tag::myUrlDecode($this->_getParam('cat4'));
    	$view->paramsHolder->cat5 =  Tag::myUrlDecode($this->_getParam('cat5'));

		// Get all category names  (only for display)
       	$view->paramsHolder->cat1name =  Tag::myUrlDecode($this->_getParam('cat1name'));
    	$view->paramsHolder->cat2name =  Tag::myUrlDecode($this->_getParam('cat2name'));
    	$view->paramsHolder->cat3name =  Tag::myUrlDecode($this->_getParam('cat3name'));
    	$view->paramsHolder->cat4name =  Tag::myUrlDecode($this->_getParam('cat4name'));
    	$view->paramsHolder->cat5name =  Tag::myUrlDecode($this->_getParam('cat5name'));

  		$registry = Zend_Registry::getInstance();
		$config = $registry->get('CONFIG');
        $view->limit = $config->search->pagelimit;

    	$view->offset = $this->_getParam('page');

		if (empty($view->offset))
		{
			$view->offset = 0;
		}
		else
		{
			$view->offset = ($this->view->offset - 1) * $view->limit;
		}


    	$view->router = Common::getRouteName();

    	return $view;
    }

    /**
     * Implemented by child
     * @return unknown_type
     */
    public function getBusiness()
    {
   	 	throw new Exception("Must be override by children");
    }

    public function getForm($business, $location)
    {
    	throw new Exception("Must be override by children");
    }
    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function  businessAction()
    {

    	//echo   "jobs";
    	$this->view = $this->_setRequiredParamsToView($this->view);

    	$this->view->category = $this->_busType;



    	try{
	    	$this->view->business = $this->getBusiness();
    		$this->view->form = $this->getForm($this->view->business, $this->view->location);

    	//$values['cat4'] = Location::getStateIdByName($this->view->location->getState());

    //	$values['cat5'] = Location::getCityIdByName($this->view->location->getCity());

     $cat1 = $this->view->paramsHolder->cat1;

     $additonalData = $this->_getAdditionalData($this->view);

     $select = $this->view->business->search($this->view->location,$this->view->limit,$this->view->offset,
	    	       $this->view->paramsHolder->query, $cat1, $this->view->paramsHolder->cat2,
	    	       $this->view->paramsHolder->cat3, $this->view->paramsHolder->cat4, $this->view->paramsHolder->cat5, $additonalData);

	 if (!empty($select))
	 {
			logfire('------select: ', $select->__toString() );
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
	  }


    }
    catch(Exception $e)
    {
    echo $e;
    }

    	//$this->renderScript('jobs/index.phtml');

  //  	echo Tag::link('jobsbasic',$this->view->location->toStdClass(),'test');

    }


	public function changecat2Action($addALL = true)
	{
		Hotspot_Plugin_ViewSetup::setUpSiteTemplate(-1);
		$this->_helper->viewRenderer->setNoRender();

		$param1 = $this->_getParam('param1', 0);
		logfire('param1', $param1);

		$cat3 = array();

		$business = $this->getBusiness();

		$cat3 = $business->getCat3Array($param1, $addALL);

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

/*
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
 */

	function refinedispatchAction()
	{
		Hotspot_Plugin_ViewSetup::setUpSiteTemplate(-1);
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

			if ($formData['searchtype'] == 1)
			{
				echo $this->buildSearchUri($businessType, $formData);
				$this->_redirect($this->buildSearchUri($businessType, $formData));
			}
			elseif ($formData['searchtype'] == 2)
			{
				echo $this->buildRefineUri($businessType, $formData);
				$this->_redirect($this->buildRefineUri($businessType, $formData));

			}

		}

	}


	protected function buildSearchUri($businessType, $formData)
	{
		try{
		echo strtolower($businessType). 'search';

		$formData = Common::encodeUriParams($formData);

		if (!array_key_exists('locationid', $formData) || empty($formData['locationid']))
		{
			throw new Exception('No location id');
		}

		$location = new Location($formData['locationid']);
    	$formData['country'] = $location->getCountry();
    	$formData['city'] = $location->getUriCity();
    	$formData['state'] = $location->getUriState();

		return Tag::url(str_replace(' ', '', strtolower($businessType)). 'search', Common::arrayToStdClass($formData));
		}catch(Exception $e)
		{
			echo $e;
		}
	}

	protected function buildRefineUri($businessType, $formData)
	{
		try{
		echo str_replace(' ', '', strtolower($businessType)). 'basicrefine';

		if (array_key_exists('cat1', $formData) && !empty($formData['cat1']) && strtolower($formData['cat1']) != strtolower('ALL') && strtolower($formData['cat1']) != strtolower('Any'))
		{
			$refcat1 = new Refcat1();
			$formData['cat1name'] = $refcat1->getCatNameById($formData['cat1']);
		}

		/*
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
		*/

		if (array_key_exists('suburbid', $formData) && !empty($formData['suburbid']) && strtolower($formData['suburbid']) != strtolower('ALL'))
		{
			$locationid = $formData['suburbid'];
		}
		elseif (array_key_exists('regionid', $formData) && !empty($formData['regionid']) && strtolower($formData['regionid']) != strtolower('ALL'))
		{
			$locationid = $formData['regionid'];
		}
		elseif (array_key_exists('cityid', $formData) && !empty($formData['cityid']) && strtolower($formData['cityid']) != strtolower('ALL'))
		{
			$locationid = $formData['cityid'];
		}
		elseif (array_key_exists('stateid', $formData) && !empty($formData['stateid']) && strtolower($formData['stateid']) != strtolower('ALL'))
		{
			$locationid = $formData['stateid'];
		}

		$location = new Location($locationid);
    	$formData['country'] = $location->getCountry();
    	$formData['city'] = $location->getUriCity();
    	$formData['state'] = $location->getUriState();
		$formData['locationid'] = $locationid;

		logfire('city', $formData['city']);
		logfire('state', $formData['state']);
		//logfire('cat3name', $formData['cat3name']);
		echo 'sss'.'1';

		$formData = Common::encodeUriParams($formData);
		return Tag::url(str_replace(' ', '', strtolower($businessType)). 'basicrefine', Common::arrayToStdClass($formData));
		}catch(Exception $e)
		{
			echo $e;
		}
	}


	protected function _getAdditionalData($view){
		return null;
	}

}
