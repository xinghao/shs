<?php
/**
 * Cookie Session
 * Implements a session stored in encrypted cookies
 *   
 * @author		Tim Woo <tim@airarena.net> based on an implementation by Ronald Zutsch
 * @version		$Rev: 3670 $ $Author: timw $ $Date: 2009-03-24 21:13:09 +1100 (Tue, 24 Mar 2009) $
 * @package		application
 * @subpackage	controllers
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */

   
class Session_CookieHandler implements Session_CookieInterface {

	// constants
	const iCryptIV = "81628100";
	const sCryptCipher = "blowfish";	
	const sCryptMode = "cbc";	
	
	// properties
	private $aValues;
	private $bEncryption;
	private $sCryptKey;
	
	public $name;
	public $expire;	

	// default methods
	function __construct($sName = NULL) {
		$registry		= Zend_Registry::getInstance();
		$config			= $registry->get('CONFIG');
		
		$this->aValues = array();
		$this->name = $sName;
		// set default parameters
		$this->sCryptKey	= isset($config->cookie->crypt->key)?$config->cookie->crypt->key:'sOmeDeFaulTkEy'; 
		$this->expire 		= isset($config->cookie->expire->time)?$config->cookie->expire->time:86400;
		// set encryption boolean
		if ($config->cookie->encryption != 0) {
		  $this->bEncryption = true;
		}
		else {
		  $this->bEncryption = false;		
		}		
	}
	
	function __destruct() { 
		unset($this->aValues);
	}	
	
 	public function __get($sValueName) {
 		if (!isset($this->aValues)) return '';
 		if (!isset($this->aValues[$sValueName])) return '';
    	$sValue = $this->aValues[$sValueName];
    			
    	return($sValue);
 	}
  
	public function __set($sValueName, $sValue) {
		$this->aValues[$sValueName] = $sValue;

	}	
	

	private function encryptValues($aValues) {
		// encrypt cookie values

		$handleMCrypt = mcrypt_module_open(Session_CookieHandler::sCryptCipher, '', Session_CookieHandler::sCryptMode, '');	
		$iKeySize = mcrypt_enc_get_key_size($handleMCrypt);
		$sKey = substr(md5($this->sCryptKey), 0, $iKeySize);
		mcrypt_generic_init($handleMCrypt, $sKey, Session_CookieHandler::iCryptIV);
		
		foreach($aValues as $sValueName => $sValue) {
			$sEncryptedValue = mcrypt_generic($handleMCrypt, $sValue);
			$sEncryptedValue = base64_encode($sEncryptedValue);
			$sEncryptedValue = trim($sEncryptedValue);		
		  $aEncryptedValues[$sValueName] = $sEncryptedValue;
		}
		
		mcrypt_generic_deinit($handleMCrypt);
		mcrypt_module_close($handleMCrypt);
				
		unset($handleMCrypt);
		unset($iKeySize);
		unset($sKey);		
		return($aEncryptedValues);
	}
	
	private function decryptValues($aEncryptedValues) {
		// decrypt cookie values
		$handleMCrypt = mcrypt_module_open(Session_CookieHandler::sCryptCipher, '', Session_CookieHandler::sCryptMode, ''); 
		$iKeySize = mcrypt_enc_get_key_size($handleMCrypt);
		$sKey = substr(md5($this->sCryptKey), 0, $iKeySize);
		mcrypt_generic_init($handleMCrypt, $sKey, Session_CookieHandler::iCryptIV);
		
		foreach($aEncryptedValues as $sValueName => $sEncryptedValue) {
			$sEncryptedValue = base64_decode($sEncryptedValue);		
			$sValue = mdecrypt_generic($handleMCrypt, $sEncryptedValue);
			$sValue = trim($sValue);		
		  $aDecryptedValues[$sValueName] = $sValue;
		}		
			
		mcrypt_generic_deinit($handleMCrypt);
		mcrypt_module_close($handleMCrypt);		
				
		unset($modeMCrypt);
		unset($iKeySize);
		unset($sKey);			
			
		return($aDecryptedValues);
	}
	
	public function init() {
		// initialize cookie object
		if(isset($_COOKIE[$this->name])) { // load cookie from client if exists
		  $aCookie = $_COOKIE[$this->name];
			// load all cookie values into cookie object properties
			if ($this->bEncryption) {
				$this->aValues = $this->decryptValues($aCookie);
			}
			else {
			  $this->aValues = $aCookie;
			}
 
			unset($aCookie);
		}	
	}
	
 	public function setcryptkey($sCryptKey) {
		// set cookie encryption key
		$this->sCryptKey = $sCryptKey;
		$this->bEncryption = true;
	}	
	
	public function nocrypt() {
		// disable encryption
		$this->bEncryption = false;
	}		

	public function send() {
		// send cookie to client
	  if (count($this->aValues) > 0) {
			// only send cookie if values are set
			if ($this->bEncryption) { 
				// encrypt all values
				$aEncryptedValues = $this->encryptValues($this->aValues);
				// send encrypted values to client as client-cookie
				foreach ($aEncryptedValues as $sValueName => $sEncryptedValue) {
					setcookie($this->name."[".$sValueName."]",$sEncryptedValue, time() + $this->expire, '/', ''); 
				}
			} else {
				// send non-encrypted values to client as client-cookie
				foreach ($this->aValues as $sValueName => $sValue) {
					setcookie($this->name."[".$sValueName."]",$sValue, time() + $this->expire, '/', '');
				}		
			}
		}
	}	
	
	public function destroy() {
		// destroy the client cookie 
		foreach ($this->aValues as $sValueName => $sValue) {
		// destroy all cookie values from the cookie object in memory
      		unset($this->aValues[$sValueName]);		
			// destroy all cookies on the client-side -> set to empty values and reset expiretime
			setcookie($this->name."[".$sValueName."]", '', time() - $this->expire, '/', '');
		}
	}	
	
	public function remove($sValueName) {
		// remove a value
	  	// remove a cookie value from the cookie object in memory */
		if (isset($this->aValues[$sValueName])) {
  	  		unset($this->aValues[$sValueName]);
		}
	  	// remove a cookie value from the client cookie		
		setcookie($this->name."[".$sValueName."]", '', time() - $this->expire, '/', '');
	}	
}