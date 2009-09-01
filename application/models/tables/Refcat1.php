<?php


class Refcat1 extends Zend_Db_Table
{
	protected $_name = 'ref_cat1';
    protected $_primary = 'cat1Id';

    public  function getTableName()
    {
    	return $this->_name;
    }
    
 	public function getAllCat1OfSpecificCategory($busTypeId)
 	{
 		try{
 			$select = $this->select();
 			$select->where('busTypeId = ?', $busTypeId);
 			logfire('select', $select->__toString());
 			return $this->fetchAll($select);
 		}catch(Exception $e)
 		{
 			logError('ref_cat1 failed!', $e);
 			throw $e;
 		}
 	}
 	
 	public function getCatNameById($catId)
 	{
 	 	try{
 			$select = $this->select();
 			$select->where('cat1Id = ?', $catId);
 			logfire('select', $select->__toString());
 			$cat =  $this->fetchRow($select);
 			
 			if(empty($cat))
 			{
 				return null;
 			}
 			else
 			{
 				return $cat->catName;
 			}
 		}catch(Exception $e)
 		{
 			logError('ref_cat1 failed!', $e);
 			throw $e;
 		}		
 	}
    
}

