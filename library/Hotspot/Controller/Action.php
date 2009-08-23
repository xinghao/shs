<?php
/**
 * CrControllerAction
 * Extends Zend_Controller_Action
 * Provides helper functions for param handling and session management.
 *   
 *      @version	$Id: Action.php 5155 2009-05-26 04:59:21Z tasman $
 *      @package	CrFramework
 *      @subpackage	Controller
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class Hotspot_Controller_Action extends Zend_Controller_Action 
{
	protected $params = array();
	public $cookie;

	public function init() {
		$this->params = self::getParams();
		$this->cookie = new Session_CookieHandler('YPEX');
		$this->cookie->init();
	}
	
    protected function setRequiredParamsToMakeContentHeader(){
    	// Used by content header.
	   	// Using homepage template.
    	Hotspot_Plugin_ViewSetup::setUpSiteTemplate(Hotspot_Plugin_ViewSetup::FRONTENDVIEW);
    	//$this->_helper->viewRenderer->setNoRender();

    	$this->view->paramsHolder = new StdClass();
    	
    	$this->view->location = new Location(Tag::myUrlDecode($this->_getParam('city')), Tag::myUrlDecode($this->_getParam('state')), Tag::myUrlDecode($this->_getParam('country')), Tag::myUrlDecode($this->_getParam('region')));
    	
		$this->view->paramsHolder = $this->view->location->mergeToAnotherClass($this->view->paramsHolder);
    	
    	$this->view->paramsHolder->query =  Tag::myUrlDecode($this->_getParam('query'));
    	
    	$this->view->paramsHolder->cat1 =  Tag::myUrlDecode($this->_getParam('cat1'));
    	$this->view->paramsHolder->cat2 =  Tag::myUrlDecode($this->_getParam('cat2'));
    	$this->view->paramsHolder->cat3 =  Tag::myUrlDecode($this->_getParam('cat3'));
    	$this->view->paramsHolder->cat4 =  Tag::myUrlDecode($this->_getParam('cat4'));
    	$this->view->paramsHolder->cat5 =  Tag::myUrlDecode($this->_getParam('cat5'));
    	
    	

    	$this->view->router = Common::getRouteName();
    }
    	
	/**
	 *  Get all parameters from the request object
	 * 
	 * 	@author	Tim Woo <tim@airarena.net>
	 *  @param	null	
	 *  @return	array of params
	 */
	public function getParams() {
		$params = $this->_getAllParams();
		// Format params
		foreach($params as $name=>$value) {
			// Ignore error_handler object
			if ($name != 'error_handler') {
				
				$params[$name] = Tag::nameDecode($value);			
			}
		}
		return $params;
	}

	/**
	 *  Get a single parameter from the request object
	 *  If not found in request then use default
	 *   
	 * 	@author	Tim Woo <tim@airarena.net>
	 *  @param	null	
	 *  @return	string $value
	 */
	public function getParam($name, $default = 'null') {
		$value = (isset($this->params[$name]))?$this->params[$name]:'';
		if ($value == '' && $default != 'null') {
			$value = $default;
		}
		return $value;
	}
	
	
	
	
	
	/**
	 * Creagency Set Parameter - Set a parameter to be later retrieved with getParams(), getParam(), _getParams() or getParam().
	 * Parameters are originally sourced from GET & POST parameters, as well as parameters generated from Zend Framework's router.
	 * 
	 * IMPORTANT: The parameter will not be changed at the Zend Framework (_getParam()) level.
	 * 
	 * Are you confused why we mirror Zend Framework's internal functions _getParams(), _getParam() and _setParam()?
	 * Me too.
	 * Have you called _setParam() only to find your change completely ignored when getParam() is called?
	 * Me too.
	 * Are you worried that every incoming parameter to the application, except "error_handler", will have dashes changed to spaces, and that this isn't documented anywhere?
	 * Me too.
	 * Are you incensed by the poor practice of passing a string value 'null' to indicate null?
	 * Me too.
	 * Are you worried about the maintainability of an application where the key framework functionality has been subtly changed without being clearly explained?
	 * Me too.
	 * 
	 * Improved design:
	 * 1. No 'null' === null.
	 * 2. Give the functions different names to the framework functions, to indicate they are different: e.g. crGetParam().
	 * 3. Give Tag::nameDecode() a clearer name and some comments.
	 * 4. Do not process and cache all parameters on initialization; fetch & decode indiviual parameters as they are retrieved.
	 * 5. Get rid of the getNoDecodeParams() function.
	 * 6. Document/comment these functions rigourously. What is difference *exactly* between crGetParam() and _getParam()? Why is nameDecode() being called?
	 * 
	 * A change to these functions will need quite a lot of testing, 
	 * and the YPEX code base is broken at present, 
	 * so I'm leaving these improvements for later.
	 * 
	 * TODO: Move getParams() and related functions to improved design and implementation.
	 * 
	 * @param $name   The name of the parameter.
	 * @param $value  The value of the parameter. This must be the parameter value after decoding (Tag::nameDecode(), i.e. slash removal).
	 */
	public function crSetParam($name, $value)
	{
		$this->_setParam($name, Tag::nameEncode($value));
		$this->params[$name] = $value;
	}	
	
	
	
	
	
	// TODO: Get rid of this function. If an application programmer needs this, something is wrong with the design. If infrastructure code needs this, it can call _getAllParams().
	public function getNoDecodeParams() {
		return $this->_getAllParams();
	}
	
	
	/**
	 *  Get a single parameter from the request object
	 *  If not found in request then use default
	 *  If no default try the cookies.
	 *  Can also be overriden with user supplied value
	 *   
	 * 	@author	Tim Woo <tim@airarena.net>
	 *  @param	$name		string	name of value to retrieve
	 *  @param	$default	string	default value if no request param found 
	 *  @param	$override	string	override value - always used, if supplied
	 *  @return	$value		string
	 */
	public function getSessionParam($name, $default = null, $override = null) {
		if ($override !== null) {
			// override value supplied, so use it
			$value = $override;
			$this->cookie->$name = $value;
			$this->cookie->send();
			// logStd('getSessionParam:'.$name, 'using override'); 
		} elseif (isset($this->params[$name]) && !empty($this->params[$name])) {
			// try to retrieve non-empty param from request
			$value = $this->params[$name];
			$this->cookie->$name = $value;
			$this->cookie->send();
			// logStd('getSessionParam:'.$name, 'using non-empty param');
		} elseif ($default !== null) {
			// default value supplied, so use it
			$value = $default;
			$this->cookie->$name = $value;
			$this->cookie->send();
			// logStd('getSessionParam:'.$name, 'using default');
		} elseif (isset($this->params[$name])) {
			// just retrieve from request
			$value = $this->params[$name];
			$this->cookie->$name = $value;
			$this->cookie->send();
			// logStd('getSessionParam:'.$name, 'using param');
		} else {
			// otherwise, use the cookie value, if available
			$value = ($this->cookie->$name != '')?$this->cookie->$name:'';
			// logStd('getSessionParam:'.$name, 'using cookie');
		}		
		return $value;
	}

	
	
	

	/**
	 *  Store parameters from the request object
	 * 	@author	Tim Woo <tim@airarena.net>
	 *  @param	null	
	 *  @return	array of params
	 */
	public function storeParams() {
		$this->cookie = new Session_CookieHandler('YPEX');
		$this->cookie->init();
		// store params
		foreach($this->params as $name=>$value) {
			$this->cookie->$name = $value;
		}
		$this->cookie->send();

	}
}