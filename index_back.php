<?php
/**
 * index.php - Main HTML entry point for the YPEX application.
 *
 * @version		$Id: index.php 5231 2009-06-02 05:34:13Z Xinghao $
 * @package		Public
 * @author      Xinghao Yu
 * @copyright	Copyright (c) 2009
 */

// Bootstrap (initialize Zend Framework, connect to database, etc.).
require_once 'application/webBootstrap.php';
 
// Start Zend Framework's webpage processing.
$frontController->dispatch(null, null);

//echo phpinfo();