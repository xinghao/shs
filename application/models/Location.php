<?php
/**
 * ref_loc_country:searchRule = 1
 * show distinct city from home search's state)     - eg if home page we choose "<option value="Lake Macquarie|NSW|Australia">Lake Macquarie - Australia</option>"... the resulty page shoudl show distinct NSW cities (as NSW was lake maquiries state
 *
 * ref_loc_country:searchRule = 2
 * distinct city from home search country
 *
 * ref_loc_country:searchRule = 3
 * distinct state from home search country

 * @author xinghao
 *
 */
class Location
{
	/**
	 * Basic id to construct the Location.
	 * @var string
	 */
	protected $_location_id;

	protected $_country = null;
	protected $_state = null;
	protected $_city = null;
	protected $_region = null;
	protected $_suburb = null;

	protected $_countryid = null;
	protected $_stateid = null;
	protected $_cityid = null;
	protected $_regionid = null;
	protected $_suburbid = null;

	protected $_searchRule;
	protected $_loc;
	/**
	 *
	 * @param $city
	 * @param $state
	 * @param $country
	 * @param $region
	 * @return unknown_type
	 */
	public function __construct($location_id)
	{
		$this->_location_id = $location_id;
		logfire('$this->_location_id', $this->_location_id);
	}

	public function getLocationId()
	{
		return $this->_location_id;
	}

	/**
	 * Get all the location info by locaiton id
	 * @return unknown_type
	 */
	protected function _fetchLocation()
	{
		$loc = $this->_getLocation();
		$searchRules = $this->getSearchRules();

		if (!empty($searchRules->city))
		{
			$this->_city = $loc->city;

		}
		$this->_cityid = $loc->cityid;

		if (!empty($searchRules->state))
		{
			$this->_state = $loc->state;
			$this->_stateid = $loc->stateid;
		}

		$this->_country = $loc->country;
		$this->_countryid = $loc->countryid;

		if (!empty($searchRules->region) && ($this->_location_id == $loc->suburbid || $this->_location_id == $loc->regionid))
		{
			$this->_region = $loc->region;
			$this->_regionid = $loc->regionid;
		}

		if (!empty($searchRules->suburb) && $this->_location_id == $loc->suburbid)
		{
			$this->_suburb = $loc->suburb;
			$this->_suburbid = $loc->suburbid;
		}



	}



	/**
	 * Get country id
	 * @return string
	 */
	public function getCountryId()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_countryid;
	}

	public function getCountry()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_country;

	}

	public function getState()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_state;

	}

	public function getStateId()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_stateid;
	}

	public function setStateId($stateid)
	{
		$this->_stateid = $stateid;
	}


	public function getCity()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_city;
	}

	public function getCityId()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_cityid;
	}

	public function setCityId($cityid)
	{
		$this->_cityid = $cityid;
	}

	public function getRegion()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_region;
	}

	public function getRegionId()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_regionid;
	}


	public function getSuburb()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_suburb;

	}

	public function getSuburbId()
	{
		if (empty($this->_loc))
		{
			$this->_fetchLocation();
		}
		return $this->_suburbid;

	}


	protected function _getLocation()
	{
		if (empty($this->_loc))
		{
			$reflocTable = new Refloc();
			$this->_loc = $reflocTable->getLocationById($this->_location_id);
		}

		return $this->_loc;

	}
	/**
	 * Get search rule
	 * @return unknown_type
	 */
	protected function _fetchSearchRule()
	{

		$country_id = $this->_getLocation()->countryid;

		$refloccountryTable = new Refloccountry();
		$this->_searchRule = $refloccountryTable->getSearchRule($country_id);
	}

	/**
	 * Return the search rule.
	 * @return integer
	 */
	public function getSearchRule()
	{
		if (empty($this->_searchRule))
		{
			$this->_fetchSearchRule();
		}

		return $this->_searchRule->searchRule;
	}

		/**
	 * Return the search rules.
	 * @return integer
	 */
	public function getSearchRules()
	{
		if (empty($this->_searchRule))
		{
			$this->_fetchSearchRule();
		}

		return $this->_searchRule;
	}


	public function toStdClass()
	{
		$stdc1 = new StdClass();

		$city = $this->getCity();
    	$state = $this->getState();

		// Some locaiton only has state.
    	if (empty($city))
    	{
    		$city = $state;
    	}

    	// Some locaiton only has city.
    	if (empty($state))
    	{
    		$state = $city;
    	}

		$stdc1->city = $city;
		$stdc1->state = $state;
		$stdc1->country = $this->getCountry();
		$stdc1->region = $this->getRegion();
		$stdc1->suburb = $this->getSuburb();
		$stdc1->locationid = $this->_location_id;
		return $stdc1;
	}

	public function getLocations()
	{
		$retArray = array();
		$current = false;
		try{

			$searchRule = $this->getSearchRule();
			logfire('searchrule', $searchRule);

			$currentloc = '';

			Switch ($searchRule) {
				case 1:
					$cities = $this->getAllCityByStateId();
					$currentloc = $this->getCity();
					break;
				case 2:
					$cities = $this->getAllCityBycountryId();
					$currentloc = $this->getCity();
					break;
				case 3:
					$currentloc = $this->getState();
					$cities = $this->getAllStateBycountryId();
					break;
				default:
					throw new Exception("No rule " . $searchRule . " handler exists.");
			}

			if (empty($cities)){
				throw new Exception("No cities exist");
			}

			logfire('currentloc', $currentloc);
			foreach($cities as $row)
			{
				$rowloc = '';
				$rowlocid = '';
				if($searchRule ==1 || $searchRule ==2)
				{
					$rowloc = $row->city;
					$rowlocid = $row->cityid;
				}
				elseif($searchRule ==3)
				{
					$rowloc = $row->state;
					$rowlocid = $row->stateid;
				}
				if ( trim($rowloc) == trim($currentloc))
				{
					$current = true;
				}
				else
				{
					$current = false;
				}
				$retArray[] = array('location' => $rowloc,'locationid' =>$rowlocid,  'current' => $current);
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


	public function getAllCityByStateId($stateid = null)
	{
		if (empty($stateid))
		{
			$stateid = $this->_stateid;
		}

		$refloc = new Refloc();

		return $refloc->getAllCityByStateId($stateid);

	}

	public function getAllRegionByCityId($cityid = null)
	{
		if (empty($cityid))
		{
			$cityid = $this->_cityid;
		}

		$refloc = new Refloc();

		return $refloc->getAllRegionByCityId($cityid);

	}

	public function getAllSuburbByRegionId($region = null)
	{
		if (empty($region))
		{
			$region = $this->_regionid;
		}

		if (empty($region))
		{
			return array();
		}

		$refloc = new Refloc();

		return $refloc->getAllSuburbByRegionId($region);

	}

	public function getCityOptionsByStateId($stateid = null)
	{
		$retArray = array();

		foreach($this->getAllCityByStateId($stateid) as $city)
		{
			$retArray[$city->cityid] = $city->city;
		}
		return $retArray;

	}

	public function getRegionOptionsByCityId($cityid = null)
	{
		$retArray = array();

		$retArray['ALL'] = 'ALL';

		foreach($this->getAllRegionByCityId($cityid) as $region)
		{
			$retArray[$region->regionid] = $region->region;
		}
		return $retArray;

	}

	public function getSuburbOptionsByRegionId($regionid = null)
	{
		$retArray = array();

		$retArray['ALL'] = 'ALL';

		foreach($this->getAllSuburbByRegionId($regionid) as $suburb)
		{
			$retArray[$suburb->suburbid] = $suburb->suburb;
		}
		return $retArray;

	}

	public function getAllCityBycountryId($countryid = null)
	{
		if (empty($countryid))
		{
			$countryid = $this->_countryid;
		}

		$refloc = new Refloc();

		return $refloc->getAllCityByCountryId($countryid);

	}

	public function getCityOptionsBycountryId($countryid = null)
	{
		$retArray = array();

		foreach($this->getAllCityBycountryId($countryid) as $city)
		{
			$retArray[$city->cityid] = $city->city;
		}
		return $retArray;

	}

	public function getAllStateBycountryId($countryid = null)
	{
		if (empty($countryid))
		{
			$countryid = $this->_countryid;
		}

		$refloc = new Refloc();

		return $refloc->getAllStatesByCountryId($countryid);

	}


	public function getStateOptionsBycountryId($countryid = null)
	{
		$retArray = array();

		foreach($this->getAllStateBycountryId($countryid) as $state)
		{
			$retArray[$state->stateid] = $state->state;
		}
		return $retArray;

	}


	public function getUriCity()
	{
		$searchRules = $this->getSearchRules();
			// Some locaiton only has state.
    	if (empty($searchRules->city))
    	{
    		return $this->getState();
    	}
    	else
    	{
    		return $this->getCity();
    	}
	}

	public function getUriState()
	{
		$searchRules = $this->getSearchRules();
			// Some locaiton only has state.
    	if (empty($searchRules->state))
    	{
    		return $this->getCity();
    	}
    	else
    	{
    		return $this->getState();
    	}
	}

	/*




	public function mergeToAnotherClass($outClass)
	{
		$outClass->city = $this->getCity();
		$outClass->state = $this->getState();
		$outClass->country = $this->getCountry();
		$outClass->region = $this->getRegion();

		return $outClass;
	}


	public function getAllStateInCountry($country = null)
	{
		$refloc = new Refloc();

		if(empty($country))
		{
			$country = $this->getCountry();
		}

		return $states = $refloc->getAllStatesInCountry($country);

	}


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
	*/

	public function getCurrencySymbol()
	{
		if (!empty($this->getSearchRules()->currencySymbol))
		{
			return $this->getSearchRules()->currencySymbol;
		}
		else
		{
			return $this->getSearchRules()->currency;
		}
	}

	public function getCurrencyAndSymbol()
	{

		if (!empty($this->getSearchRules()->currencySymbol))
		{
			return $this->getSearchRules()->currency.$this->getSearchRules()->currencySymbol;
		}
		else
		{
			return $this->getSearchRules()->currency;
		}
	}

	public function getLocationString()
	{
		$retStr = '';
		$suburb = $this->getSuburb();

		if (!empty($suburb))
		{
			$retStr = $suburb;
		}

		$region = $this->getRegion();
		if (!empty($region))
		{
			if ($retStr)
			{
				$retStr .= ', ' . $region;
			}
			else
			{
				$retStr .= $region;
			}
		}

		$city = $this->getCity();
		if (!empty($city))
		{
			if ($retStr)
			{
				$retStr .= ', ' . $city;
			}
			else
			{
				$retStr .= $city;
			}
		}

		$state = $this->getState();
		if (!empty($state))
		{
			if ($retStr)
			{
				$retStr .= ', ' . $state;
			}
			else
			{
				$retStr .= $state;
			}
		}

		return $retStr;
	}
}
?>
