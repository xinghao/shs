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
	
	protected static $_searchRule;
	/**
	 * 
	 * @param $city
	 * @param $state
	 * @param $country
	 * @param $region
	 * @return unknown_type
	 */
	public function __construct($city = null, $state = null, $country = null, $region = null, $suburb = null)
	{
		$this->_city = $city;
		$this->_state = $state;
		$this->_country = $country;
		$this->_region = $region;
		$this->_suburb = $suburb;
		
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
	
	public static function getSearchRule($country = null)
	{
		if (empty(self::$_searchRule))
		{			
			$refloccountryTable = new Refloccountry();
		
			self::$_searchRule = $refloccountryTable->getSearchRule($country);
		}
		return self::$_searchRule;
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

	public static function getAllcitiesByCountry($country)
	{
		$refloc = new Refloc();
		
		return $refloc->getAllCityByCountry($country);
	
	}	
	/**
	 * 
	 * @param $city
	 * @param $state
	 * @param $country
	 * @return array(array('location'=location, current=true/false))
	 */
	public static function getLocations($city, $state, $country)
	{
		$retArray = array();
		$current = false;
		try{
			
			$searchRule = self::getSearchRule($country);
			logfire('searchrule', $searchRule);
			
			$currentloc = '';
			
			Switch ($searchRule) {
				case 1:
					$cities = self::getAllcitiesByCountryAndState($state, $country);
					$currentloc = $city;
					break;
				case 2:
					$cities = self::getAllcitiesByCountry($country);
					$currentloc = $city;
					break;
				case 3:
					$loc = new Location();
					$currentloc = $state;
					$cities = $loc->getAllStateInCountry($country);
					break;
				default:
					throw new Exception("No rule " . $searchRule . " handler exists.");
			}
			
			if (empty($cities)){
				throw new Exception("No cities exist in state: ". $state);
			}
			
			logfire('currentloc', $currentloc);
			foreach($cities as $row)
			{
				$rowloc = '';
				if($searchRule ==1 || $searchRule ==2)
				{
					$rowloc = $row->city;
				}
				elseif($searchRule ==3)
				{
					$rowloc = $row->state;
				}
				if ( trim($rowloc) == trim($currentloc))
				{
					$current = true;
				}
				else
				{
					$current = false;
				}
				$retArray[] = array('location' => $rowloc, 'current' => $current);
			}
			
		}catch(Exception $e)
		{
			logError('', $e);
			echo $e;
		}
		
		foreach($retArray as $q)
		{
			logfire($q['location'], $q['current']);
		}
		return $retArray;
	}
}    
?>
