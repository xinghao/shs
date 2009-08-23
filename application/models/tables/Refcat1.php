<?php


class Refcat1 extends Zend_Db_Table
{
	protected $_name = 'ref_cat1';
    protected $_primary = 'cat1Id';
    
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
    
}

