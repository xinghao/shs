<?php
/**
 * CrFramework_Session_Handler
 * Implements memcached session handling.
 * Sessions will be persisted to the master database in the case of memcache failure.
 * 
 * @author		Tim Woo <tim@airarena.net>
 * @version		$Rev: 3670 $ $Author: timw $ $Date: 2009-03-24 21:13:09 +1100 (Tue, 24 Mar 2009) $
 * @package		CrFramework
 * @subpackage	Session
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */
 
require_once 'Zend/Session/SaveHandler/Interface.php';

class Hotspot_Session_Handler implements Zend_Session_SaveHandler_Interface {
	private $maxlifetime = 3600;
	public $cache = '';
	public $cacheType = 'memcache';

    /**
     * This is instance of Session_data, which extends Zend_Db_Table and manages the database connection
     *
     * @var Session_Data
     */
    private static $sessionData;
 
    private static $thisIsOldSession = false;
	private static $originalSessionId = '';


	public function __construct($cacheHandler) {
		$this->cache = $cacheHandler;

		// try to connect to the cache
		
		$cacheIsAlive = false;
		try {
			$cacheIsAlive = $this->cache->save('test', 'test', array(), 100);
		} catch (Exception $e) {
			
		}
		if (!$cacheIsAlive) {
			logDebug('session','No memcache available...');
			$this->cacheType = 'database';
			
		} else {
			$this->cacheType = 'memcache';
		}
		
		logDebug('session','Session store in use: '.$this->cacheType.'...');
	}

	public function open($save_path, $name) {
		if ($this->cacheType != 'memcache') {
			self::$sessionData = new CrFramework_Session_Data();
		}
		return true;
	}
	
	public function close() {
		return true;
	}

	public function read($id) {
		if ($this->cacheType == 'memcache') {
			if(!($data = $this->cache->load($id))) {
				$ret = '';
			} else {
				$ret = $data;
			}
		} else {
			try {		
				$rows = self::$sessionData->find($id);
				$row = $rows->current();
		        if ($row) {
		            self::$thisIsOldSession = true;
					self::$originalSessionId = $id;
		            $ret = $row->session_data;
		        } else {
		            $ret = '';
		        }
			} catch (Exception $e) {
				$ret = '';
			}
		}
        return $ret;
	}
	
	public function write($id, $sessionData) {
		if ($this->cacheType == 'memcache') {
			$this->cache->save($sessionData, $id, array(), $this->maxlifetime);
		} else {
			// database write
			$data = array (
	            'session_data' => $sessionData,
	            't_updated' => new Zend_Db_Expr('NOW()'),
	        );
	 
			if (self::$thisIsOldSession && self::$originalSessionId != $id) {
	            // session ID is regenerated, so set $thisIsOldSession to false, so we insert new row
	            self::$thisIsOldSession = false;
	        }
	 
	        if (self::$thisIsOldSession) {
	            self::$sessionData->update(
	            	$data,
	            	self::$sessionData->getAdapter()->quoteInto('session_id = ?', $id)
	            );
	        } else {
	            //no such session, create new one
	            $data['session_id'] = $id;
	            $data['t_created'] = new Zend_Db_Expr('NOW()');
	            self::$sessionData->insert($data);
	        }
		}		
		return true;
	}

	public function destroy($id) {
		if ($this->cacheType == 'memcache') {
			$this->cache->remove($id);
		} else {
			self::$sessionData->delete(self::$sessionData->getAdapter()->quoteInto('session_id = ?', $id));
		}
		return true;
	}
	
	public function gc($notusedformemcache) {
		if ($this->cacheType != 'memcache') {
			$maxLifetime = intval($maxLifetime);
        	self::$sessionData->delete("DATE_ADD(t_updated, INTERVAL $maxLifetime SECOND) < NOW()");
		}
		return true;
	}
}
