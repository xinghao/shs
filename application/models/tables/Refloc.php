<?php


class Refloc extends Zend_Db_Table
{
	protected $_name = 'Ref_loc';
    protected $_primary = 'id';
    
    // Use the Book class for returned rows, to add utility methods, like getting zips covered by the book.
    //protected $_rowClass = 'Book';      
    
    /**
     * Get all cities with country.
     * Called to generate location drop down list.
     * @return Zend_Db_TableRowSet
     */
    public function getAllCityWithCountry()
    {
    	$select = $this->select();
    	$select->from($this->_name, array('country','state', 'city', 'id' => 'min(id)'))
    	       ->distinct(true)
    	       ->group(array('country', 'state', 'city'));
    	
    	return $cities = $this->fetchAll($select);
    	
    }

}

