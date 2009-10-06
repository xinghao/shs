<?php


class Psthome extends Zend_Db_Table
{
	protected $_name = 'pst_home';
    protected $_primary = 'id';
    
    public  function getTableName()
    {
    	return $this->_name;
    }
     
}

