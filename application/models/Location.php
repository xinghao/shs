<?php
class Location 
{
	protected $_country;
	protected $_state;
	protected $_city;
	protected $_region;
	protected $_suburb = null;

	protected $_countryid;
	protected $_stateid;
	protected $_cityid;
	protected $_regionid;
	protected $_suburbid = null;
	/**
	 * 
	 * @param $city
	 * @param $state
	 * @param $country
	 * @param $region
	 * @return unknown_type
	 */
	public function __construct($city = null, $state = null, $country = null, $region = null)
	{
		$this->_city = $city;
		$this->_state = $state;
		$this->_country = $country;
		
		logfire('region1', $region);
		/*
		if (empty($region))
		{
			$this->_region = $city;
		}
		else
		{
			$this->_region = $region;
		}
		*/
		$this->_region = null;
		logfire('region2', $this->_region);
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getCity()
	{
		return $this->_city;
	}

	/**
	 * 
	 * @return unknown_type
	 */
	public function getSuburb()
	{
		return $this->_suburb;
	}

	public function getSuburbId()
	{
		return null;
	}
	
	public function getState()
	{
		return $this->_state;
	}
	
	public function getStateId()
	{
		if (empty($this->_stateid))
		{
			$this->_stateid = self::getStateIdByName($this->_state);
		}
		return $this->_stateid;
	}

	public function setStateId($stateid)
	{
		$this->_stateid = $stateid;
	}

	public function getCityId()
	{
		if (empty($this->_cityid))
		{
			$this->_cityid = self::getCityIdByName($this->_city);
		}
		return $this->_cityid;
	}

	public function setCityId($cityid)
	{
		$this->_cityid = $cityid;
	}
	
	public function getCountry()
	{
		return $this->_country;
	}

	public function getCountryId()
	{
		return $this->_countryid;
	}
	
	public function getRegion()
	{
		return $this->_region;
	}

	public function getRegionId()
	{
		if (empty($this->_regionid))
		{
			$this->_regionid = self::getCityIdByName($this->_region);
		}
		return $this->_regionid;
	}

	public function setRegionId($regionid)
	{
		$this->_regionid = $regionid;
	}
		
	public function toStdClass()
	{
		$stdc1 = new StdClass();
		$stdc1->city = $this->getCity();
		$stdc1->state = $this->getState();
		$stdc1->country = $this->getCountry();
		$stdc1->region = $this->getRegion();
		
		return $stdc1;
	}
	
	public function mergeToAnotherClass($outClass)
	{
		$outClass->city = $this->getCity();
		$outClass->state = $this->getState();
		$outClass->country = $this->getCountry();
		$outClass->region = $this->getRegion();
		
		return $outClass;		
	}
	
	
	/**
	 * Get all states of country
	 * @return unknown_type
	 */
	public function getAllStateInCountry($country = null)
	{
		$refloc = new Refloc();
		
		if(empty($country))
		{
			$country = $this->getCountry();
		}
		
		return $states = $refloc->getAllStatesInCountry($country);
			
	}

	/**
	 * Get all states of country
	 * @return unknown_type
	 */
	public function getAllCityByStateId($stateid)
	{
		$refloc = new Refloc();
		
		return $states = $refloc->getAllCityByStateId($stateid);
			
	}	
	
	public static function getStateIdByName($stateName)
	{
		$refloc = new Refloc();
		
		return $refloc->getStateIdByName($stateName);
		
	}

	public static function getStateNameById($stateid)
	{
		$refloc = new Refloc();
		
		return $refloc->getStateNameById($stateid);
		
	}
	
	public static function getCityIdByName($cityName)
	{
		$refloc = new Refloc();
		
		return $refloc->getCityIdByName($cityName);
		
	}
	
	public static function getCityNameById($cityid)
	{
		$refloc = new Refloc();
		
		return $refloc->getCityNameById($cityid);
		
	}	
	
	public static function getRegionIdByName($regionName)
	{
		$refloc = new Refloc();
		
		return $refloc->getRegionIdByName($regionName);
		
	}

	public static function getAllcitiesByCountryAndState($state, $country)
	{
		$refloc = new Refloc();
		
		return $refloc->getAllCityByCountryAndStateName($state, $country);
	
	}
}    
?>
