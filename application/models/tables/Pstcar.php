<?php


class Pstcar extends Zend_Db_Table
{
	protected $_name = 'pst_cars';
    protected $_primary = 'id';
    
    public  function getTableName()
    {
    	return $this->_name;
    }
     
}

