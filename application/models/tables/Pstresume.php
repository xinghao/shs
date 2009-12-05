<?php


class Pstresume extends Zend_Db_Table
{
	protected $_name = 'pst_resumes';
    protected $_primary = 'id';
    
    public  function getTableName()
    {
    	return $this->_name;
    }
     
}

