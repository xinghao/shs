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


class PostingController extends Zend_Controller_Action {

	// Initial by the child.
	protected $_busTypeId;
	protected $_busType;
	//protected $_privatekey = "6LfQHQwAAAAAAIsnkFWW8atwyS9WbVnIaEfLB3Jh";


	public function init() {
    	// Used by content header.
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
	}

    protected function _setRequiredParamsToView($view){
    	//$this->_helper->viewRenderer->setNoRender();

    	$view->posting_id = $this->_getParam('postingid');

    	$pstPosing  =  new Pstposting();
    	$view->posting =$pstPosing->getPosting($view->posting_id);

    	logfire("posting locId", $view->posting->locId);
    	$view->location = new Location($view->posting->locId);

    	$view->category = BusinessType::getBusinessType($view->posting->typeID);

    	$view->paramsHolder = $view->location->toStdClass();


    	$view->paramsHolder->category = $view->category;

    	//echo "categoy: " . $view->category;

		//$this->view->paramsHolder = $this->view->location->mergeToAnotherClass($this->view->paramsHolder);
    	$view->paramsHolder->posting_id =  $view->posting_id;



    	$view->router = Common::getRouteName();

    	return $view;
    }

    /**
     * Implemented by child
     * @return unknown_type
     */

    /**
     * Job basic for seo.
     * show all the jobs in the city.
     * @return unknown_type
     */
    function  indexAction()
    {



       	try{
       		$this->view = $this->_setRequiredParamsToView($this->view);
	    	$this->view->business = BusinessType::getBusiness($this->view->posting->typeID);
    		$this->view->form = BusinessType::getBusinessForm($this->view->posting->typeID, $this->view->business, $this->view->location);
    		//print_r($this->view->form);

			$this->view->detailTab = DetailTab::DetailTabFactory($this->view->posting);
			if (!empty($this->view->formData))
			{
				$this->view->detailTab->setFormData($this->view->formData);
			}
			//$detailTab->printTabs();

       	}catch(Exception $e)
	    {
	    	logError("Posting data error: ", $e);
	    	echo $e;

	    }

    }


	function contactAction()
	{
	   try{

		   	// Check if the form is posted.
			if ($this->getRequest()->isPost())
			// User submit listing form.
			{
				// [Xinghao] Get form data.
				$this->view->formData = $this->getRequest()->getPost();
				//print_r($this->view->formData);

				$this->indexAction();
				//$this->view->tab = $this->view->detailTab->getFormTabName();
				$this->view->detailTab->setTabSequence($this->view->detailTab->formTabSeq);

				$form = $this->view->detailTab->getForm();

				if ($form->isValid($this->view->formData))
				{

					$this->view->detailTab->setDisplayForm(false);
				//	print_r($this->view->detailTab->getPostingDataForContactForm());
					EmailManager::sentContactEmail($this->view->formData, $this->view->detailTab->getPostingDataForContactForm());
/*
					Email::sendMail($this->view->formData["email_from"],
									$this->view->formData["fullname"],
									"Query form " . $this->view->formData["fullname"],
									$this->view->formData["question"]);
*/
				}
				else
				{
					$this->view->detailTab->setDisplayForm(true);
				}

				$this->renderScript('posting/index.phtml');

			}
			else
			{
				//TODO::redirect ot 404 page.
			}


        }catch(Exception $e)
	    {
	    	logError("contactAction: ", $e);
	    	echo $e;

	    }
	}

}
