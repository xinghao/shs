<?php
/**
 * CrFramework_Validate_StringLength
 * Extends Zend_Validate_StringLength to output our Error message to users
 * 
 * @author		Xinghao <xinghao@airarena.net>
 * @version		$Id: StringLength.php 5091 2009-05-21 00:44:49Z xinghao $
 * @package		CrFramework
 * @subpackage	Validate
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Validate_StringLength extends Zend_Validate_StringLength {

     /**
	 *  overrider Error Msg with Field Name
	 *  @param $fieldName field name
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 */
	public function overriderErrorMsgwithFieldName($fieldName){
		$this->_messageTemplates = array(
        	self::TOO_SHORT => "Your ".$fieldName." have to be between %min% and %max% characters long",
        	self::TOO_LONG  => "Your ".$fieldName." have to be between %min% and %max% characters long"
    	);		
	}
	
	
}