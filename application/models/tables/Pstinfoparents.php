<?php


class Pstinfoparents extends Zend_Db_Table
{
	protected $_name = 'pst_info_parent';
    protected $_primary = 'id';

    public  function getTableName()
    {
    	return $this->_name;
    }


 	public function getAllHeadings()
 	{
 		try{
 			$select = $this->select();
 			//$select->where('busTypeId = ?', $busTypeId);
 			//logfire('cat1 select', $select->__toString());
 			return $this->fetchAll($select);
 		}catch(Exception $e)
 		{
 			logError('ref_cat1 failed!', $e);
 			throw $e;
 		}
 	}

 	public function getHeadingById($headingId)
 	{
 	 	try{
 			$select = $this->select();
 			$select->where('id = ?', $headingId);
 			logfire('select', $select->__toString());
 			$cat =  $this->fetchRow($select);

 			if(empty($cat))
 			{
 				return null;
 			}
 			else
 			{
 				return $cat;
 			}
 		}catch(Exception $e)
 		{
 			logError('ref_cat1 failed!', $e);
 			throw $e;
 		}
 	}


}

