<?php
/**
 * CrFramework_Acl_Role
 * Implements an Access Control Plugin
 *   
 *      @version	$Id: Plugin.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Acl
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
 
class CrFramework_Acl_Role extends Zend_Acl_Role 
{

	/**
	 * @var Zend_config
	 */
	private $_acl;
	
	/**
	 * @var Zend_config
	 */
	private $_backendfuncionnamelist;

	/**
	 * array(
	 * 		modulename => 
	 * 		'<span>first level menu(text/link)</span>
 	 * 		<ul>
 	 * 			<li>second level menu link</li>
 	 * 			<li>second level menu link</li>
 	 * 		</ul>'
	 * 		)
	 * @var array
	 */
	private $_functionListArray;
	
	/**
	 * Call the _buildFunctionListArray() to build function lists for current Role (including his and his father's)
	 * We hope that current Role's fucntion links can always be at the beginning.
	 * Since when we do array_merge we put his father's fucntion lings before him, we do array reverse here.
	 * @return array
	 */
	public function getFunctionListArray(){
		return array_reverse($this->_buildFunctionListArray());
	}
	
   /**
     * if current use is Leaf(Guest) return true
     * else return false
     * if father is null it is a Guest.
     * @param $role
     * @return boolen
     */
    private function _isLeaf()
    {
    	$role = $this->getRoleId();
    	$parent		= $this->_acl->acl->roles->$role;
    	//parent is null if it is Super user.
    	if(empty($parent)) {
    		return true;
    	}else {
			return false;
		}
    }
    

      /**
     * if current use is Root(Super User) return true
     * else return false
     * father is null if it is a Root.
     * @param $role
     * @return boolen
     */
    private function _isRoot()
    {
    	$role = $this->getRoleId();
    	$parent		= $this->_acl->acl->roles->$role;
    	//parent is null if it is Super user.
    	if(empty($parent)){
    		return true;
    	}else{
    		return false;
    	}
    	
    }
    
    /**
     * get father's role name
     * @return string
     */
    private function _getFather()
    {
    	 $role = $this->getRoleId();
    	 //logfire('role dig: '.$role, $this->_acl->acl->roles->$role);
     	 return $this->_acl->acl->roles->$role;   	 
    }
    
    /**
     * return current role's function list
     * @return array
     * controller => array(action = link name)
     */
	private function _getFunctionList()
	{
		$role = $this->getRoleId();
		return $this->_backendfuncionnamelist->$role;
	}
	
	/**
	 * get all the function links for the current Role
	 * If it is a Guest, we return empty array.
	 * If it is not a Guest,we get all the function lists and store them to $this->_functionListArray
	 * Then, we get his father's function links' array and merge them toghter.
	 * For example, the current Role is Super_user.
	 * 		step1: get Super_user's function links array (publishers => 
	 * 						'<span>Publisher</span><ul><li>List Publishers</li><li>New Publisher +</li></ul>')
	 * 	    step2: get his faher(Publisher)'s function links array ( books => 
	 * 						'<span>Books</span><ul><li>List Books</li><li>New Books +</li></ul>')
	 * 		step3: merge these two array.
	 * 
	 * When we do array merge, we put current Role father's array before current one's
	 * so that current one's fucntion links can override his father's.
	 * @return array
	 */
	private function _buildFunctionListArray(){
		
		// read all the roles and their relationship to member variable.
		$this->_acl = Common::getIni('ACL','/config/acl.ini');
		
		$this->_functionListArray = array();
		
		// if current role is Guest(leat), we return null.
		if(!$this->_isLeaf()) {
			//member init
			$this->_backendfuncionnamelist = Common::getIni('BFNL','/config/backendfunctionnamelist.ini');
    		// get current Role's function links
    		// and store them into $this->_functionListArray
    		$this->_setCurrentFunctionalLinkstoArray($this->_getFunctionList(), 'subfunctionlist');
    		
    		// get current Role's fatehr
			$fatherString = $this->_getFather();
			//logfire('father', $fatherString);
			
			// if current Role has father, get his father's funciton links array and merge them.
			if(!empty($fatherString)) {
				$father = new  CrFramework_Acl_Role($fatherString);
				$tempArray = $father->_buildFunctionListArray();
				$this->_functionListArray = array_merge($tempArray, $this->_functionListArray);
			}
		}	
    	
		return $this->_functionListArray;
	}
	
	
    /**
     * print link per line.
     * @param $ulCss string
     * @param $functionList Zend_config_ini
     * @return string
     */
	private function _setCurrentFunctionalLinkstoArray($functionList, $ulCss)
	{
		// if functionlist is empty, return.
		if(empty($functionList)){
			return;
		}

    	$registry = Zend_Registry::getInstance();
		$root = $registry->get('CONFIG')->website->host;	
		
		foreach($functionList as $module=>$allmenus){
			
			// module string
	 		// 	<li>
	 		// 		<span>first level menu(text/link)</span>
	 		// 		<ul>
	 		// 			<li>second level menu link</li>
	 		// 			<li>second level menu link</li>
	 		// 		</ul>
	 		//  </li> 
			$oneModuleLinks = '';
			
			// get the firstlevel menu(mainmenu)
			// it always return one link/text/empty
			// we don't want to wrap it with <li> tag.
			$strtemp = $this->_buildMenus($root, $allmenus->firstlevel, false);
			if(!empty($strtemp)) {
				$strtemp = '<span class="modulename">' . $strtemp . '</span>' . "\n";
			}
			$oneModuleLinks .= $strtemp;
			
			// get the second menu(submenu)
			// it always return more than one links/texts/empty	
			// we organise submenu as ul	
			$strtemp = $this->_buildMenus($root, $allmenus->secondlevel, true);
			if(!empty($strtemp)) {
				$strtemp = '<ul class="' . $ulCss . '">' . $strtemp . '</ul>' . "\n";
			}
			$oneModuleLinks .= $strtemp;

			if(!empty($oneModuleLinks)) {			
				$this->_functionListArray[$module] = $oneModuleLinks;
			}
			
		}
		
	}

	
	
		/**
	 * $menus = array(controller => array(action => linkname))
	 * using $menus to make links
	 * <li><a href='/app/controller/action'>linkname</a></li>
	 * @params $menus Zend_config_init
	 * @params $isWithLiTag bool
	 * @return string
	 */
	private function _buildMenus($root, $menus, $isWithLiTag)
	{
		//init the return string.
		$returnStr = '';
		
		// loop the menus
		// menu = array(controller => array(action => linkname))
		foreach($menus as $controller=>$actions){
			
			//if actions is empty, skip this row
			if(empty($actions)){
				continue;
			}
			
			// if controller = 'none' that means doesn't show this menu.
			//   sometimes we just want to show the submenu and hide the mainmenu
    		// if controller = 'text' that means this menu is just text not link
    		//   most of time mainmenu is just text not link
    		// other times the menu is link
    		if(!strcasecmp($controller, 'none')){
    			continue;
    		}elseif(!strcasecmp($controller, 'Text')){
    			foreach($actions as $type=>$text){
    				$tmpstr = $text;
    				if($isWithLiTag) {
    					$tmpstr = '<li>' . $tmpstr . '</li>' ;
    				}
    				$returnStr .= $tmpstr . "\n"; 
    			}
    		}else{
    		    foreach($actions as $action=>$linkName){
    		    	//logfire('link',$linkName);
    		        $tmpstr = '<a href="' .  $root .  '/app/'. $controller .'/' . $action . '">' .$linkName . '</a>' ;
    				if($isWithLiTag) {
    					$tmpstr = '<li>' . $tmpstr . '</li>' ;
    				}
    				$returnStr .= $tmpstr . "\n";
    			}    			
    		}						
		}

		return $returnStr;
	}	
   	
}