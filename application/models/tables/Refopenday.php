<?php


class Refopenday extends Zend_Db_Table
{
	protected $_name = 'ref_open_day';
    protected $_primary = 'openId';

    public  function getTableName()
    {
    	return $this->_name;
    }

    public function getOpenday($id)
    {
    	if (empty($id))
    	{
    		return '';
    	}

		try{
 			$select = $this->select();
 			$select->where('openId = ?', $id);
 			//logfire('cat1 select', $select->__toString());
 			$openday =  $this->fetchRow($select);
 			return $openday->openDay;
 		}catch(Exception $e)
 		{
 			logError('pst job failed!', $e);
 			echo $e;
 			throw $e;
 		}

    }

}

