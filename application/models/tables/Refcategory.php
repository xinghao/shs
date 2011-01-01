<?php


class Refcategory extends Zend_Db_Table
{
	protected $_name = 'ref_category_en';
    protected $_primary = 'id';

    public  function getTableName()
    {
    	return $this->_name;
    }

 	public function getAllCat2OfSpecificCategory($busTypeId)
 	{
		try{
	 		$select = $this->select();
	 		$select->where('PrimId = ?', $busTypeId);
	 		return $this->fetchAll($select);
 	 	}catch(Exception $e)
 		{
 			logError('Refcategory failed!', $e);
 			throw $e;
 		}
 	}


 	public function getAllCatsBySubPrimIdBusinessTypeId($SubPrimId, $busTypeId)
 	{
		try{
	 		$select = $this->select();
	 		$select->where('busPostTypeId = ?', $busTypeId);
	 		$select->where('SubPrimCatId = ?', $SubPrimId);
	 		$select->order('name');
			//logfire("getAllCatsBySubPrimIdBusinessTypeId", $select);
	 		return $this->fetchAll($select);
 	 	}catch(Exception $e)
 		{
 			logError('Refcategory failed!', $e);
 			throw $e;
 		}
 	}

 	public function getAllCat3OfSpecificCat2($cat2, $busTypeId)
 	{
 		try{
	 		$select = $this->select();
	 		$select->where('SetID in (select SetId from ' . $this->_name . ' where id = ?)', $cat2)
	 				->where('PrimId is null')
	 				->where('busPostTypeId = ?', $busTypeId);
	 		logfire('select cat3 from cat3', $select->__toString());
	 		return $this->fetchAll($select);
 	 	}catch(Exception $e)
 		{
 			logError('Refcategory failed!', $e);
 			throw $e;
 		}
 	}

	public function getCatNameById($catId)
 	{
 	 	try{
 			$select = $this->select();
 			$select->where('id = ?', $catId);
 			logfire('select', $select->__toString());
 			$cat =  $this->fetchRow($select);

 			if(empty($cat))
 			{
 				return null;
 			}
 			else
 			{
 				return $cat->name;
 			}
 		}catch(Exception $e)
 		{
 			logError('ref_cat1 failed!', $e);
 			throw $e;
 		}
 	}
}

