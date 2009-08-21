<?php
/**
 * CrFramework_Db_TableRow
 * Extends Zend_Db_Table_Row to implement a multiple Master/Slave strategy for global database access.
 *  
 * @author		Tim Woo <tim@airarena.net>
 * @version		$Rev: 3670 $ $Author: timw $ $Date: 2009-03-24 21:13:09 +1100 (Tue, 24 Mar 2009) $
 * @package		CrFramework
 * @subpackage	Db
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */

class CrFramework_Db_TableRow extends Zend_Db_Table_Row {

protected $registry;
protected $masterdb = Array();
protected $slavedb = Array();

	

// We don't need the following statement because the
// Zend_Db_Adapter_Pdo_Mysql file will be loaded for us by the Zend_Db
// factory method.

// require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

// Automatically load class Zend_Db_Adapter_Pdo_Mysql
// and create an instance of it.


public function save()
{
	// write to master database pool
	$this->getTable()->getMasterAdapter();
	//logStd(get_class($this).'->save()', 'Write to MASTER.');
	
	return parent::save();
}



}
