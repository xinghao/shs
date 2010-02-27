<?php


class Pstjob extends Zend_Db_Table
{
	protected $_name = 'pst_jobs';
    protected $_primary = 'id';

    public  function getTableName()
    {
    	return $this->_name;
    }

    public function getPstJob($id)
    {
		try{
 			$select = $this->select();
 			$select->where('id = ?', $id);
 			//logfire('cat1 select', $select->__toString());
 			return $this->fetchRow($select);
 		}catch(Exception $e)
 		{
 			logError('pst job failed!', $e);
 			echo $e;
 			throw $e;
 		}

    }

}

