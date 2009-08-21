<?php
/**
 * Acl
 * Implements an Access Control List
 *   
 *      @version	$Id: Acl.php 5141 2009-05-22 05:05:28Z xinghao $
 *      @package	CrFramework
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Acl extends Zend_Acl {

	private $_noAuth;  
	private $_noAcl;
	  
    public function __construct(Zend_Auth $auth) {
         $acl		= Zend_Registry::get('ACL');  
         $roles		= $acl->acl->roles;  
         $resources	= $acl->acl->resources;  
         $this->_addRoles($roles);  
         $this->_addResources($resources);
    }
    
	public function _addRoles($roles) {  
		foreach ($roles as $name => $parents) {  
			if (!$this->hasRole($name)) {  
				if (empty($parents)) {  
					$parents = null;  
				} else {  
					$parents = explode(',', $parents);  
				}  
				$this->addRole(new CrFramework_Acl_Role($name), $parents);  
			}  
		}  
	}  
               
	public function _addResources($resources) {  
		foreach ($resources as $permissions => $controllers) {  
			foreach ($controllers as $controller => $actions) {  
				if ($controller == 'all') {  
					$controller = null;  
				} else {  
					if (!$this->has($controller)) {  
						$this->add(new Zend_Acl_Resource($controller));  
					}  
				}  
  
				foreach ($actions as $action => $role) {  
					if ($action == 'all') {  
						$action = null;  
					}  
					if ($permissions == 'allow') {  
						$this->allow($role, $controller, $action);  
					}  
					if ($permissions == 'deny') {  
						$this->deny($role, $controller, $action);  
					}  
				}  
			}  
		}  
	}  
}