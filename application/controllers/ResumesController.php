<?php
/**
 * Index Controller
 *   
 *      @version	$Id: IndexController.php 5711 2009-07-20 07:39:29Z xinghao $
 *      @package	Application
 *      @subpackage	Controllers
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class ResumesController extends JobsController {
    
		
	protected $_busTypeId = 11;
	protected $_busType = 'Resumes';
	protected $_cat1All = 30;
    
    public function getBusiness()
    {
    	return new Resumes();
    } 
    
    
    	
}
