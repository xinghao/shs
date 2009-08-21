<?php
/**
 * Cookie Session Interface
 * Interface for a session stored in encrypted cookies
 *   
 * @author		Tim Woo <tim@airarena.net> based on an implementation by Ronald Zutsch
 * @version		$Rev: 3670 $ $Author: timw $ $Date: 2009-03-24 21:13:09 +1100 (Tue, 24 Mar 2009) $
 * @package		application
 * @subpackage	controllers
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */
 
interface Session_CookieInterface {
	/**
	 * Initialize the cookie object and read existing client-cookie values into
	 * the cookie object in memory.
	 */
	public function init();
	
	/**
	 * Set the encryptionkey for the cookie object in memory.
	 * @param string $sCryptKey - the encryption/decryption key
	 */	
	public function setcryptkey($sCryptKey);
	
	/**
	 * Disable encryption for the cookie object in memory.
	 */		
	public function nocrypt();
	
	/**
	 * Send the cookie object from memory to the client, set a client-cookie
	 */		
	public function send();
	
	/**
	 * Remove the client-cookie and the cookie object from memory
	 */	
	public function destroy();
	
	/**
	 * Remove the a value from the client-cookie and from the cookie object in memory
	 */	
	public function remove($sValueName);
}