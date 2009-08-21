<?php
class Location 
{
	protected $_country;
	protected $_state;
	protected $_city;
	protected $_region;
	
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
		
		if (empty($region))
		{
			$this->_region = $city;
		}
		else
		{
			$this->_region = $region;
		}
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
	
	public function getState()
	{
		return $this->_state;
	}
	
	public function getCountry()
	{
		return $this->_country;
	}
	
	public function getRegion()
	{
		return $this->_region;
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
}    
?>
