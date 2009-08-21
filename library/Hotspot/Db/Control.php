<?php
/**
 * This class is to manage Master/slave Adapters and transactions.
 * 
 * The main reason to add this class is to fix the transaction problems.
 * In transaction, we should stick on master db.
 * Fix the problem like this:
 * 1. begin transaction:
 * 2. insert a new record in master db.
 * 3. fetch this new record from slave db.
 * 4. commit
 * Step 3 does not work, you can not get the value form slave db until commit.
 *
 * Transaction example after fixing:
 * 
 * $dbControl = new CrFramework_Db_Control();
 * try{
 * 		$dbControl->beginTransaction();
 *		...
 *      $dbControl->commit();
 * }catch(Exception $e){
 *      	$dbControl->rollBack();
 *		throw new Exception($e->getMessage());
 * }
 * @author		Xinghao <xinghao@airarena.net>
 * @version		$Rev: 5571 $ $Author: xinghao $ $Date: 2009-07-10 12:30:53 +1000 (Fri, 10 Jul 2009) $
 * @package		CrFramework
 * @subpackage	Db
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class CrFramework_Db_Control {
	
	/**
	 * Used to save adapter object temporarily during transation.
	 * @var Zend_Db_Adapter_Abastract
	 */
	private $_adapter;
	
	/**
	 * Flag to show if current it is in transaction.
	 * @var bool
	 */
	private static $_isInTransaction = false;
    
    /**
     * Leave autocommit mode and begin a transaction.
     *
     * @return bool True
     */
    public function beginTransaction()
    {
    	// Get writable adapter.
		$this->_adapter = self::_getAdapterFromPool('master');
		
		// Begin a transaction.
		$successFlag = $this->_adapter->beginTransaction();
		
		if ($successFlag) {
			// If begining transaction is successful, set $_isInTransaction flag to true.
			// Once $_isInTransaction = ture, all the adpater return by CrFramework_Db_Control::getAdapter
			// will be master.
			self::$_isInTransaction = true;
		}
		
		return $successFlag;
    }
    
    /**
     * Commit.
     * @return bool
     */
    public function commit()
    {
   		// If $this->_adapter is empty we throw exception.
    	if (empty($this->_adapter)) {
    		logError('commit function failed', 'Adapter is Null');
    		throw new Zend_Db_Exception('commit function failed: Adapter is Null');
    	}
    	
    	return $this->_adapter->commit();
    }
    
    /**
     * rollBack.
     * @return bool
     */
    public function rollBack()
    {
    	// If $this->_adapter is empty we throw exception.
	   	if (empty($this->_adapter)) {
	   			logError('rollBack function failed','Adapter is Null');
	    		throw new Zend_Db_Exception('rollBack function failed: Adapter is Null');
	    	}
	    
	    return $this->_adapter->rollBack();
    }
    
    /**
     * Get Adapter based on database access type.
     * If database access type is 'write', we return master.
     * If database access type is 'read' and current is in transaction, we also return master.
     * If database access type is 'read' and current is not in transaction,
     * we return slave.
     * @param $accessType
     * @return Zend_Db_Adapter_Abstract
     */
    public static function getAdapter($accessType = 'write')
    {
    	if ($accessType == 'read' && !self::$_isInTransaction) {
    		logStd($accessType, 'Slave');
    		return self::_getAdapterFromPool('slave');
    	}
    	else
    	{
    		logStd($accessType, 'Master');
    		return self::_getAdapterFromPool();
    	}
    	
    }
    
    /**
     * Get Master's adapter
     * @return Zend_Db_Adapter_Abstract
     */
    public static function getMasterAdapter()
    {
    	return self::_getAdapterFromPool();
    }
    
    /**
     * Get Slave's adapter
     * @return Zend_Db_Adapter_Abstract
     */
    public static function getSlaverAdapter()
    {
    	return self::_getAdapterFromPool('slave');
    }
	/**
	 * Gets the specified database adapter from the pool.<br>
	 * This method ensures that a random active adapter is made available.
	 * If no slave adapters are found, the default master adapter will be used.
	 * If no master adapters are found, an error will be thrown.
	 *
	 * @var		$type	the type of connection required: master|slave
	 * @return Zend_Db_Adapter_Abstract	 
	 * @author	Tim Woo <tim@airarena.net>
	 */
	private static function _getAdapterFromPool($type = 'master')
    {
    	// Get server pool from the registry
    	$registry = Zend_Registry::getInstance();
	    $servers = $registry->get($type.'_servers');
	    
     	// Pick a random connection until we have an active connection
     	$unconnected = true;
     	$attempts = array();
		do {
	     	$id = rand(1, sizeof($servers));
	     	if ($servers[$id] != null) {
	     		$db = $servers[$id];
				$db->getConnection();
	     		//$this->_db = $servers[$id];
	     		//$this->_db->getConnection();
	     		//$this->setDefaultAdapter($this->_db);
     			$unconnected = false;
     			logStd('db', 'Connected to '.$type.': '.$id.' of '.sizeof($servers));
	     	} else {
	     		if (array_key_exists($id, $attempts)){
	     			logStd('db', 'Skipping failed connection to '.$type.': '.$id.' of '.sizeof($servers));
	     		} else {
		     		$attempts[$id]=$id;
		     		logStd('db', 'Connection failed to '.$type.': '.$id.' of '.sizeof($servers));
		     		$id=null;
	     		}		
	     	}
	    } while ($unconnected && sizeof($attempts)<sizeof($servers)); //ensure we don't loop forever
	    		
     	//return $id;
     	return $db;
    }
}
