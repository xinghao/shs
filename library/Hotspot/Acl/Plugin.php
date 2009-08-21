<?php
/**
 * CrFramework_Acl_Plugin
 * Implements an Access Control Plugin
 *   
 *      @version	$Id: Plugin.php 5147 2009-05-25 02:31:43Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Acl
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
 
class CrFramework_Acl_Plugin extends Zend_Controller_Plugin_Abstract {
    protected $_action;
    protected $_auth;
    protected $_acl;
    protected $_controllerName;

    public function __construct(Zend_Auth $auth, Zend_Acl $acl) {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }

    public function init() {
        $this->_action = $this->getActionController();
        $controller = $this->_action->getRequest()->getControllerName();
    }

	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		
		// If the user is identified, get their role name to check if they have access to this page.
 		if ($this->_auth->hasIdentity()) {
            $role = $this->_auth->getIdentity()->rolename;
        } else {
        	// Otherwise, give them the guest role.
            $role = 'Guest';
        }
        
        // Get the dispatch details for the request for access checking.
        $request = $this->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $module = $request->getModuleName();
        $this->_controllerName = $controller;
        
        //logStd('acl', $role.':'.$module.':'.$controller.':'.$action);
        
        // We use Zend Framework access control lists (ACLs) to determine whether a
        // particular role has access to a particular admin function.
        // So we map the controller to a "resource" in ACL speak,
        // and the action to a "privilege" in ACL speak.
        $resource = $controller;
        $privilege = $action;
        
        // [taz] Here's my current best guess on the following code.
        // This took two programmers 20 minutes to only partially figure this out.
        // Document your code please!!!
        //
        // If the access control list does *not* have a listing for this controller (this resource)
        // set the resource to null.
        // Setting the resource to null will cause the isAllowed() check below,
        // to search all the resources (controllers) for a matching privilege (action),
        // to determine whether the role has the right to view that page.
        // i.e. We can set the right for a role to access a particular action in all controllers,
        // unless that controller has rights set for it specifically,
        // e.g. we can say the role "publisher staff" can access the action "publisher-staff-info"
        // on all controllers.
        if (!$this->_acl->has($resource)) {
            $resource = null;
        }
        
        // If the user's role does *not* have access to this controller (resource) and action (privilege),
        // send them to the login page.
        if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
            $request->setModuleName('default');
            $request->setControllerName('user');
            $request->setActionName('login');
            $request->setDispatched(false);
        }
    }
   

}