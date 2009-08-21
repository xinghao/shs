<?php
/**
 * CrFramework_Validate_NotEmpty
 * Extends Zend_Validate_NotEmpty to output our Error message to users
 * 
 * @author		Xinghao <xinghao@airarena.net>
 * @version		$Id: NotEmpty.php 5091 2009-05-21 00:44:49Z xinghao $
 * @package		CrFramework
 * @subpackage	Validate
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Validate_NotEmpty extends Zend_Validate_NotEmpty {

     /**
	 *  overrider Error Msg with Field Name
	 *  @param $fieldName field name
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */
	public function overriderErrorMsgwithFieldName($fieldName){
		$this->_messageTemplates = array(
        self::IS_EMPTY => $fieldName .' is required, you cannot leave it empty'
    );
	}
	
	
}