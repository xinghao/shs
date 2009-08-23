<?php


class Refloc extends Zend_Db_Table
{
	protected $_name = 'ref_loc';
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
    	try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('country','state', 'city', 'id' => 'min(id)'))
	    	       ->distinct(true)
	    	       ->group(array('country', 'state', 'city'));
	    	
	    	return $cities = $this->fetchAll($select);
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}    	
    }
    
    /**
     * Get all states in country
     * @return unknown_type
     */
    public function getAllStatesInCountry($country)
    {
    	try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('state', 'stateid'))
	    	       ->distinct(true)
	    	       ->where('country = ?', $country);
	    	    
	    	
	    	logfire('select', $select->__toString());
	    	return $states = $this->fetchAll($select);
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}    	
    }   

    /**
     * Get all cities in one state.
     * @param $stateid
     * @return unknown_type
     */
    public function getAllCityByStateId($stateid)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('city', 'cityid'))
	    	       ->distinct(true)
	    	       ->where('stateid = ?', $stateid);
	    	    
	    	
	    	logfire('select', $select->__toString());
	    	return $states = $this->fetchAll($select);
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}   	
    }
}

