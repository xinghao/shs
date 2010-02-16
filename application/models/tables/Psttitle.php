<?php


class Psttitle extends Zend_Db_Table
{
	protected $_name = 'pst_title';
    protected $_primary = 'id';

    public  function getTableName()
    {
    	return $this->_name;
    }

    public function getPsttitle($id)
    {
    	try{
			$select = $this->select();
			$select->where('id = ?', $id);
			$posting_title = $this->fetchRow($select);
			return $posting_title->title;
		}catch(Exception $e)
		{
 			logError('Pst_title failed!', $e);
 			throw $e;
		}
    }
}

