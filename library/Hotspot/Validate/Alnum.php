<?php
/**
 * CrFramework_Validate_Alnum
 * Extends Zend_Validate_Alnum to output our Error message to users
 * 
 * @author		Xinghao <xinghao@airarena.net>
 * @version		$Id: Alnum.php 5091 2009-05-21 00:44:49Z xinghao $
 * @package		CrFramework
 * @subpackage	Validate
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Validate_Alnum extends Zend_Validate_Alnum {

     /**
	 *  overrider Error Msg with Field Name
	 *  @param $fieldName field name
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */
	public function overriderErrorMsgwithFieldName($fieldName){
		$this->_messageTemplates = array(
        self::NOT_ALNUM    => 'You can use only latin letters and numbers in ' . $fieldName,
        self::STRING_EMPTY => $fieldName .' is required, you cannot leave it empty'
    );
	}
	
	
}