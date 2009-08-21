<?php
/**
 *  Error Handler
 *  Gracefully handles errors and outputs them to the std log.
 * 
 * @author		Tim Woo <tim@airarena.net>
 * @version		$Rev: 3670 $ $Author: timw $ $Date: 2009-03-24 21:13:09 +1100 (Tue, 24 Mar 2009) $
 * @package		CrFramework
 * @subpackage	Utility
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */
 class CrFramework_Error_Handler {
 
    static public function handleError($errno, $errstr, $errfile, $errline){
        $errorType = array (
                           E_ERROR          => 'ERROR',
                           E_WARNING        => 'WARNING',
                           E_PARSE          => 'PARSING ERROR',
                           E_NOTICE         => 'NOTICE',
                           E_CORE_ERROR     => 'CORE ERROR',
                           E_CORE_WARNING   => 'CORE WARNING',
                           E_COMPILE_ERROR  => 'COMPILE ERROR',
                           E_COMPILE_WARNING => 'COMPILE WARNING',
                           E_USER_ERROR     => 'USER ERROR',
                           E_USER_WARNING   => 'USER WARNING',
                           E_USER_NOTICE    => 'USER NOTICE',
                           E_STRICT         => 'STRICT NOTICE',
                           E_RECOVERABLE_ERROR  => 'RECOVERABLE ERROR'
                       );
        logStd('APPLICATION ERROR',
        		 ('Error Type: '.$errorType[$errno]."\r\n".
                               'Error Message : '.$errstr."\r\n".
                               'Error File : '.$errfile."\r\n".
                               'Error Line : '.$errline."\r\n"
                              ));
                              
		if (!defined('ERROR')) define('ERROR', true);
                              
    } 
}