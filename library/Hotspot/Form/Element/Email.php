<?php
/**
 * CrFramework_Form_Element_Email
 * the CrFramework form email element.
 * do the hostname and email validate.
 *   
 *      @version	$Id: Email.php 5091 2009-05-21 00:44:49Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Form
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class CrFramework_Form_Element_Email extends CrFramework_Form_Element_Text
{			        
    /**
     * (non-PHPdoc)
     * @see library/Zend/Form/Zend_Form_Element#init()
     */
	public function init()
	{
		parent::init();

		/**
         * @todo Change this wired error messages to something more user friendly, or even use simple email regex matching validator
         */
		$validatorHostname = new Zend_Validate_Hostname();
        $validatorHostname->setMessages(
	       array(
		        Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED  => ("'%value%' appears to be an IP address, but IP addresses are not allowed"),
		        Zend_Validate_Hostname::UNKNOWN_TLD             => ("'%value%' appears to be a DNS hostname but cannot match TLD against known list"),
		        Zend_Validate_Hostname::INVALID_DASH            => ("'%value%' appears to be a DNS hostname but contains a dash (-) in an invalid position"),
		        Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => ("'%value%' appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'"),
		        Zend_Validate_Hostname::UNDECIPHERABLE_TLD      => ("'%value%' appears to be a DNS hostname but cannot extract TLD part"),
		        Zend_Validate_Hostname::INVALID_HOSTNAME        => ("'%value%' does not match the expected structure for a DNS hostname"),
		        Zend_Validate_Hostname::INVALID_LOCAL_NAME      => ("'%value%' does not appear to be a valid local network name"),
		        Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED  => ("'%value%' appears to be a local network name but local network names are not allowed")
	        ) 
        );
 
        $validatorEmail = new Zend_Validate_EmailAddress(Zend_Validate_Hostname::ALLOW_DNS, false, $validatorHostname);
        $validatorEmail->setMessages(
	        array(
		        Zend_Validate_EmailAddress::INVALID            => ("'%value%' is not a valid email address"),
		        Zend_Validate_EmailAddress::INVALID_HOSTNAME   => ("'%hostname%' is not a valid hostname for email address '%value%'"),
		        Zend_Validate_EmailAddress::INVALID_MX_RECORD  => ("'%hostname%' does not appear to have a valid MX record for the email address '%value%'"),
		        Zend_Validate_EmailAddress::DOT_ATOM           => ("'%localPart%' not matched against dot-atom format"),
		        Zend_Validate_EmailAddress::QUOTED_STRING      => ("'%localPart%' not matched against quoted-string format"),
		        Zend_Validate_EmailAddress::INVALID_LOCAL_PART => ("'%localPart%' is not a valid local part for email address '%value%'")
	        )
        );
        
        $this->addValidator($validatorEmail);   
	}
	
}
