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

class InformationController extends BusinessController {


	protected $_busTypeId = 99;
	protected $_busType = 'Information';
	protected $_cat1All = 1;

    public function getBusiness()
    {
    	return new Information();
    }

    protected function _setRequiredParamsToView($view){

    	$view = parent::_setRequiredParamsToView($view);

    	$view->paramsHolder->headingid =  Tag::myUrlDecode($this->_getParam('headingid'));


    	$view->paramsHolder->headingid = ($view->paramsHolder->headingid)?($view->paramsHolder->headingid):$this->_cat1All;

    	return $view;
    }

    public function getForm($business, $location)
    {
    	return new JobsRefineForm($business, $location);
    }

    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function  informationAction()
    {
/*
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


    	}
    	catch(Exception $e)
    	{
    		echo $e;
    	}
 */
    	$this->businessAction();
    	//$heading = $this->view->business->getHeadingById($this->view->paramsHolder->headingid);
    	//$this->view->headingTitle = $heading->heading;
    	//$this->view->headingText = $heading->headingText;
    	$this->renderScript('information/index.phtml');

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


	protected function buildRefineUri($businessType, $formData)
	{
		if (strtolower($formData['cat2']) == strtolower('ALL') || strtolower($formData['cat2']) == strtolower('Any'))
		{
			$formData['cat2name'] = 'Any';
		}
		else{
			$refcat2 = new Refcategory();
			$formData['cat2name'] = $refcat2->getCatNameById($formData['cat2']);
		}

		if (strtolower($formData['cat3']) == strtolower('ALL') || strtolower($formData['cat3']) == strtolower('Any'))
		{
			$formData['cat3name'] = 'Any';
		}
		else{
			$refcat3 = new Refcategory();
			$formData['cat3name'] = $refcat3->getCatNameById($formData['cat3']);
		}

		return parent::buildRefineUri($businessType, $formData);
	}
}
