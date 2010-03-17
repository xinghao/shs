<?php


class Reffeature extends Zend_Db_Table
{
	protected $_name = 'ref_feature';
    protected $_primary = 'id';

    public  function getTableName()
    {
    	return $this->_name;
    }

	public function getFeatures($list, $busTypeId)
	{
		try{
			$list = trim($list);
			$lastPostionOfComma = strripos($list, ',');
			logfire('ref_features $lastPostionOfComma', $lastPostionOfComma);
			logfire('ref_features $sizeof($list)', strlen($list));
			if (strlen($list) == $lastPostionOfComma + 1)
			{
				$list = substr($list, 0, $lastPostionOfComma);
			}
 			$select = $this->select();
 			$select->where('postTypeId = ?', $busTypeId);
 			$select->where('id in (' . $list . ')');
 			logfire('ref_features select', $select->__toString());
 			return $this->fetchAll($select);
 		}catch(Exception $e)
 		{
 			logError('ref_features failed!', $e);
 			throw $e;
 		}

	}

}

