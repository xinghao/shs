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
	    	
	    	logfire('get all cities by state id: ', $select->__toString());
	    	
	    	return $cities = $this->fetchAll($select);
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}    	
    }

    /**
     * Get all cities by countryid.
     * Called to generate location drop down list.
     * @return Zend_Db_TableRowSet
     */
    public function getAllCityByCountryId($country_id)
    {
    	try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('city', 'cityid'))
	    	       ->distinct(true)
	    	       ->where('countryid = ?', $country_id);
	    	       
	    	logfire('get all cities by country id: ', $select->__toString());
	    	
	    	$cities = $this->fetchAll($select);
	    	
	    	if (empty($cities))
	    	{
	    		throw new Exception("No cities in this country. Country id = ". $country_id);	
	    	}
	    	
	    	return $cities;
	    	
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
    public function getAllStatesByCountryId($country_id)
    {
    	try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('state', 'stateid'))
	    	       ->distinct(true)
	    	       ->where('countryid = ?', $country_id);
	    	    
	    	
	    	logfire('get all states by country id: ', $select->__toString());
	    	
    		$states = $this->fetchAll($select); 
	    	if (empty($states))
	    	{
	    		throw new Exception("No states in this country. Country id = ". $country_id);	
	    	}
	    	
	    	return $states;
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
	    	    
	    	
	    	logfire('state select', $select->__toString());
	    	
	    	$cities = $this->fetchAll($select);
	    	
	    	if (empty($cities))
	    	{
	    		throw new Exception("No cities in this state. state id = ". $stateid);	
	    	}
	    	
	    	return $cities;
	    	
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
    public function getAllRegionByCityId($cityid)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('region', 'regionid'))
	    	       ->distinct(true)
	    	       ->where('cityid = ?', $cityid);
	    	    
	    	
	    	logfire('etAllRegionByCityId', $select->__toString());
	    	
	    	$regions = $this->fetchAll($select);
	    	
	    	if (empty($regions))
	    	{
	    		throw new Exception("No regiond in this city. city id = ". $cityid);	
	    	}
	    	
	    	return $regions;
	    	
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
    public function getAllSuburbByRegionId($regionid)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('suburb', 'suburbid'))
	    	       ->distinct(true)
	    	       ->where('regionid = ?', $regionid);
	    	    
	    	
	    	logfire('getAllSuburbByRegionId', $select->__toString());
	    	
	    	$suburbs = $this->fetchAll($select);
	    	
	    	if (empty($suburbs))
	    	{
	    		throw new Exception("No suburb in this region. region id = ". $regionid);	
	    	}
	    	
	    	return $suburbs;
	    	
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
	 * 
	 * @param $stateName
	 * @param $country  mixed   country_id or country_name.
	 * @return unknown_type
	 */
    public function getCountryIdByName($country)
    {
        try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('countryid'))
	    	       ->distinct(true)
	    	       ->where('lower(country) = lower(?)', $country);
	    	       //->where('country = ? or countryid = ?', Common::titleCaseUpper($country));
	    	//logfire('select', $select->__toString());
	    	$country = $this->fetchRow($select);
	    	
	    	if (empty($country))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $country->countryid;
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
    
    
    public function getAllCityByCountry($country)
    {
    	$countryId = $this->getCountryIdByName($country);
    	
    	return $this->getAllCityByCountryId($countryId);
    }    
    
    /**
     * Get city, regin, suburb, state, country by it.
     * @param $location_id
     * @return location.
     * @exception if illegal paramter passed in or can not find result.
     */
    public function getLocationById($location_id)
    {
    	
    	if (empty($location_id))
    	{
    		throw new Exception('Location id passed in is empty. location_id:['.$location_id.']');
    	}
         try{
	    	$select = $this->select();
	    	$select->from($this->_name, array('country', 'countryid', 'state', 'stateid', 'city', 'cityid', 'region', 'regionid', 'suburb', 'suburbid'))
	    	       ->distinct(true)
	    	       ->orWhere('countryid <> 0 and countryid = ?', $location_id)
	    	       ->orWhere('stateid = ?', $location_id)
	    	       ->orWhere('cityid = ?', $location_id)
	    	       ->orWhere('regionid <> 0 and regionid = ?', $location_id)
	    	       ->orWhere('suburbid <> 0 and suburbid = ?', $location_id);
	    	       
	    	logfire('getlocationbyId: ', $select->__toString());
	    	$location = $this->fetchRow($select);
	    	
	    	if (empty($location))
	    	{
	    		throw new Exception('Location id does not exist. location_id:['.$location_id.']');
	    	}
	    	else
	    	{
	    		
	    		return $location;
	    	}
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}     	
    }
}

