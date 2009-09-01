<?php


class Psttitle extends Zend_Db_Table
{
	protected $_name = 'pst_title';
    protected $_primary = 'id';
    
    public  function getTableName()
    {
    	return $this->_name;
    }
     
}

