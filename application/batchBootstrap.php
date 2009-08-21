<?php
/**
 * batchBootstrap.php - Bootstrap Command Line Batch processes for the application.
 *
 * This initializion file is for  batch processes that are initiated from the command-line or by the Unix cron facility. 
 * These batch processes are called "command line" because they are not initiated by going to a web page.
 * 
 * Batch processes *may* need different initialization from the web environment
 * (e.g. potentially different database conneciton requirements, logging requirements, 
 * Apache server variables not present, etc.).
 * 
 * Due to these potentially different requirements, I've used a separate bootstrap file,
 * which all batch processes should use.
 *
 */
 
require_once 'commonBootstrap.php';