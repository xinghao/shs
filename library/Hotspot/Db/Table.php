<?php
/**
 * CrFramework_Db_Table
 * Extends Zend_Db_Table to implement a multiple Master/Slave strategy for global database access.
 * Databases are configured in application/config.ini
 * Note: Master and Slave databases must be the same type (MySQL, Postgres, etc).
 * Otherwise differences in the generated SQL will cause an error.
 * 
 * @author		Tim Woo <tim@airarena.net>
 * @version		$Rev: 5946 $ $Author: xinghao $ $Date: 2009-07-30 15:41:50 +1000 (Thu, 30 Jul 2009) $
 * @package		CrFramework
 * @subpackage	Db
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Db_Table extends Zend_Db_Table {

	/**
	 * Classname for row
	 *
	 * @var string
	 */
	protected $_rowClass = 'CrFramework_Db_TableRow';
	
	// We don't need the following statement because the
	// Zend_Db_Adapter_Pdo_Mysql file will be loaded for us by the Zend_Db
	// factory method.
	
	// require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
	
	// Automatically load class Zend_Db_Adapter_Pdo_Mysql
	// and create an instance of it.

	
	public function insert(array $data)
	{
		$this->_db = CrFramework_Db_Control::getAdapter('write');
     	$this->setDefaultAdapter($this->_db);
		//logStd(get_class($this).'->createRow()', 'Write to MASTER:'.$id);
		return parent::insert($data);
	}

	/**
	 * Change data from 0 or '' to null.
	 * @param $data
	 * @return array
	 */
	private static function _changeEmptyToNull(array $data)
	{
		// If the field is not set in form, the value is empty string.
		// We want the value of field which is not set to be null.
	    foreach($data as $key=>$value)
    	{
    		if(empty($value)) 
    		{
    			$data[$key] = null;	
    		}
    	}
    	return $data;		
	}


	/**
	 * Returns the Field Names of the Table
	 * @return array
	 */
	public function fetchFields()
	{
		return $this->_getCols();	
	}
	
	

    /**
     * Remove the fields in the form but not in the database.s
     * @param $data
     * @return array
     * @see trunk/library/CrFramework/Db/CrFramework_Db_Table#_removeNoDatabaseField()
     */
    protected function _removeNoDatabaseField(array $data)
    {
    	$returnArray = array();
    	foreach($this->_getCols() as $col)
    	{
    		//echo $col.'=>'.$data[$col]."\n";
    		if (array_key_exists($col,$data))
    		{
    			$returnArray[$col] = $data[$col];
    		}
    	}
		return $returnArray;
    }

    
	

	
	
	/**
	 * Used by edit form (Edit an entry from a form)
	 * @param $data array
	 * @param $where array | string
	 */
	public function updateFromFormData(array $data, $where)
	{

		$data = $this->_removeNoDatabaseField($data);
    	$data = self::_changeEmptyToNull($data);
    	$data['update_date']  = new Zend_Db_Expr('NOW()') ;
    	$data['update_user']  = Common::getUserId();  
		return $this->update($data, $where);
		
	}
	
	/**
	 * Used by new form (Create a new entry from a form)
	 * @param $data
	 * @return unknown_type
	 */
	public function insertFromFormData(array $data)
	{
		$data = $this->_removeNoDatabaseField($data);
		$data = self::_changeEmptyToNull($data);    	
    	
		$data['update_date']  = $data['create_date']  = new Zend_Db_Expr('NOW()') ;
    	$data['update_user']  = $data['create_user']  = Common::getUserId();  
		return $this->insert($data);
		
	}
	
	public function update(array $data, $where)
	{
		// add a timestamp
		/*
		if (empty($data['update_date'])) {
		    $data['update_date'] = time();
		}
		*/
		//$id = $this->getMasterAdapter();
		$this->_db = CrFramework_Db_Control::getAdapter('write');
	    $this->setDefaultAdapter($this->_db);
		return parent::update($data, $where);
	}

	public function delete($where)
	{
		$this->_db = CrFramework_Db_Control::getAdapter('write');
	    $this->setDefaultAdapter($this->_db);
	    logStd(get_class($this).'->delete()', 'Write to MASTER');
		return parent::delete($where);
	}
	
	public function createRow(array $data = array(), $defaultSource = null)
	{
		$this->_db = CrFramework_Db_Control::getAdapter('write');
	    $this->setDefaultAdapter($this->_db);
		logStd(get_class($this).'->createRow()', 'Write to MASTER');
		return parent::createRow($data);
	}
	
	public function fetchRow($where = null, $order = null)
	{
		$this->_db = CrFramework_Db_Control::getAdapter('read');
	    $this->setDefaultAdapter($this->_db);    
	    $row = parent::fetchRow($where, $order);
		return $row;
	}

	
    	
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
		$this->_db = CrFramework_Db_Control::getAdapter('read');
	    $this->setDefaultAdapter($this->_db);   	
    	$rowset = parent::fetchAll($where, $order, $count, $offset);
    	return $rowset;
    }


	public function fetchRowMaster($where = null, $order = null)
	{
		$this->_db = CrFramework_Db_Control::getMasterAdapter();
	    $this->setDefaultAdapter($this->_db);
		logStd(get_class($this).'->fetchRow()', 'Read from MASTER');
		$row = parent::fetchRow($where, $order);
		return $row;
	}
	
    public function fetchAllMaster($where = null, $order = null, $count = null, $offset = null)
    {
		$this->_db = CrFramework_Db_Control::getMasterAdapter();
	    $this->setDefaultAdapter($this->_db);
    	logStd(get_class($this).'->fetchAll()', 'Read from MASTER');
    	$rowset = parent::fetchAll($where, $order, $count, $offset);
    	return $rowset;
    }
    
	public function find()
	{
		return parent::find();
	}

	
    /**
     * Gets a Master database adapter from the pool.
     *
     * @param  none
     * @return $id	database server id
     */
    public function getMasterAdapter()
    {
		$this->_db = CrFramework_Db_Control::getMasterAdapter();
	    $this->setDefaultAdapter($this->_db);
    	return $this->_db;
    }

 }
