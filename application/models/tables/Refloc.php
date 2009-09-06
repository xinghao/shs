<?php


class Refloc extends Zend_Db_Table
{
	protected $_name = 'ref_loc';
    protected $_primary = 'id';
    
    public  function getTableName()
    {
    	return $this->_name;
    }
    
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
    
	/**
	 * 
	 * @param $stateName
	 * @param $country  mixed   country_id or country_name.
	 * @return unknown_type
	 */
    public function getStateIdByName($stateName, $country = null)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('stateid'))
	    	       ->distinct(true)
	    	       ->where('lower(state) = lower(?)', Common::titleCaseUpper($stateName));
	    	       //->where('country = ? or countryid = ?', Common::titleCaseUpper($country));
	    	logfire('select', $select->__toString());
	    	$state = $this->fetchRow($select);
	    	
	    	if (empty($state))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $state->stateid;
	    	}
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}   	
    }

        /**
     * Get State id by name
     * @param $stateid
     * @return integer
     */
    public function getStateNameById($stateid)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('state'))
	    	       ->distinct(true)
	    	       ->where('stateid = ?', $stateid);
	    	    
	    	
	    	logfire('select', $select->__toString());
	    	$state = $this->fetchRow($select);
	    	
	    	if (empty($state))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $state->state;
	    	}
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}   	
    }
    
    
    /**
     * Get State id by name
     * @param $stateid
     * @return integer
     */
    public function getCityIdByName($cityName)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('cityid'))
	    	       ->distinct(true)
	    	       ->where('city = ?', Common::titleCase($cityName));
	    	    
	    	
	    	logfire('select', $select->__toString());
	    	$city = $this->fetchRow($select);
	    	
	    	if (empty($city))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $city->cityid;
	    	}
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}   	
    } 

       /**
     * Get State id by name
     * @param $stateid
     * @return integer
     */
    public function getCityNameById($cityid)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('city'))
	    	       ->distinct(true)
	    	       ->where('cityid = ?', Common::titleCase($cityid));
	    	    
	    	
	    	logfire('select', $select->__toString());
	    	$city = $this->fetchRow($select);
	    	
	    	if (empty($city))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $city->city;
	    	}
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}   	
    } 
    
    
    public function getRegionIdByName($regionName)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('regionid'))
	    	       ->distinct(true)
	    	       ->where('region = ?', Common::titleCase($regionName));
	    	    
	    	
	    	logfire('region select', $select->__toString());
	    	$region = $this->fetchRow($select);
	    	
	    	if (empty($region))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $region->regionid;
	    	}
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}   	
    }   

    public function getAllCityByCountryAndStateName($state, $country = null)
    {
    	$stateId = $this->getStateIdByName($state, $country);
    	
    	return $this->getAllCityByStateId($stateId);
    }
    
}

