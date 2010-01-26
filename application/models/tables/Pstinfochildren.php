<?php


class Pstinfochildren extends Zend_Db_Table
{
	protected $_name = 'pst_info_child';
    protected $_primary = 'id';

    public  function getTableName()
    {
    	return $this->_name;
    }

    public function getAllHeading2($headingId)
    {
 		try{
 			$select = $this->select();
 			$select->where('patrentId = ?', $headingId);
 			//logfire('cat1 select', $select->__toString());
 			return $this->fetchAll($select);
 		}catch(Exception $e)
 		{
 			logError('heading2 failed!', $e);
 			throw $e;
 		}

    }

}

