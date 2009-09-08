<?php
class Jobs 
{
	protected $_cat1;
	
	protected $_cat2;
	
	protected $_cat3;
	
	protected $_cat4;
	
	protected $_busTypeId;
	
	protected $_location;
	
	protected $_cat1Name = 'Select:';

	protected $_cat2Name = 'Job Type';
	
	protected $_cat3Name = 'Job Sub-Type';
	
	protected $_cat4Name = 'State';
	
	protected $_cat5Name = 'City';
	
	
	public function __construct($location = null)
	{	
		$this->_location = $location;
		$this->_busTypeId = 5;
		//parent::__construct();
	}
	
	public function getLocation()
	{
		return $this->_location;	
	}
	
	public function getBusinessType()
	{
		return 'Jobs';
	}
	
	public function getCat1Name(){
		return $this->_cat1Name;
	}

	public static function getCat1NameById($cat1)
	{
		$refCat1Tables = new Refcat1();
		return $refCat1Tables->getCatNameById($cat1);
	}
	
	public function getCat2Name(){
		return $this->_cat2Name;
	}

	public function getCat3Name(){
		return $this->_cat3Name;
	}
	
	public function getCat4Name(){
		return $this->_cat4Name;
	}

	public function getCat5Name(){
		return $this->_cat5Name;
	}
	
	public function getCat1()
	{
		if (empty($this->_cat1))
		{
			$refcat1 = new Refcat1();
			return $this->_cat1 = $refcat1->getAllCat1OfSpecificCategory($this->_busTypeId);
		}
		else
		{
			return $this->_cat1; 
		}
	}
	
	public function getCat2()
	{
		if (empty($this->_cat2))
		{
			$refcat2 = new Refcategory();
			return $this->_cat2 = $refcat2->getAllCat2OfSpecificCategory($this->_busTypeId);
		}
		else
		{
			return $this->_cat2; 
		}
		
	}

	public function getCat3($cat2)
	{
		$refcat3 = new Refcategory();
		return $this->_cat3 = $refcat3->getAllCat3OfSpecificCat2($cat2);
		
	}
	
	/**
	 * Get states.
	 * @return unknown_type
	 */
	public function getCat4()
	{
		if (empty($this->_cat4))
		{
			return $this->_cat4 = $this->_location->getAllStateInCountry();
		}
		else
		{
			return $this->_cat4; 
		}
			
	}
	
	/**
	 * Get all citis in one state.
	 * @return unknown_type
	 */
	public function getCat5($stateid)
	{

		return $this->_cat5 = $this->_location->getAllCityByStateId($stateid);			
	}
	
	
		

	
	public function getCat1Array()
	{
		$cat1 = $this->getCat1();
		
		$retArray = array();
		
		if (!empty($cat1))
		{
			foreach($cat1 as $cat1row)
			{
				//$retArray[$cat1row->cat1Id . '|' . $cat1row->catName] = $cat1row->catName;
				$retArray[$cat1row->cat1Id] = $cat1row->catName;
			}
		}
		
		return $retArray;
	}
	
	public function getFirstCat1()
	{
		$cat1s = $this->getCat1Array();
		
		if (empty($cat1s))
		{
			return null;
		}
		
		
		foreach($cat1s as $key=>$value)
		{
			return $key;
		}		
	}

	public function getCat2Array()
	{
		$cat2 = $this->getCat2();
		
		$retArray = array();
		
		if (!empty($cat2))
		{
			$retArray['ALL'] = 'ALL';
			foreach($cat2 as $cat2row)
			{
				//$retArray[$cat2row->id . '|' . $cat2row->name] = $cat2row->name;
				$retArray[$cat2row->id] = $cat2row->name;
			}
		}
		
		return $retArray;
	}

	public function getFirstCat2()
	{
		$cat2s = $this->getCat2Array();
		
		if (empty($cat2s))
		{
			return null;
		}
		
		
		foreach($cat2s as $key=>$value)
		{
			return $key;
		}
	}
	

	public function getCat3Array($cat2)
	{
		$cat3 = $this->getCat3($cat2);
		
		$retArray = array();
		
		if (!empty($cat3))
		{
			$retArray['ALL'] = 'ALL';
			foreach($cat3 as $cat3row)
			{
				// $retArray[$cat3row->id . '|' . $cat3row->name] = $cat3row->name;
				$retArray[$cat3row->id] = $cat3row->name;
			}
		}
		
		return $retArray;
	}
	
	public function getCat4Array()
	{
		$cat4 = $this->getCat4();
		
		$retArray = array();
		
		if (!empty($cat4))		
		{
			
			foreach($cat4 as $cat4row)
			{
				$retArray[$cat4row->stateid] = $cat4row->state; 
			}
		
		}
		
		return $retArray;
	}	

	public function getFirstCat4()
	{
		$cat4s = $this->getCat4Array();
		
		if (empty($cat4s))
		{
			return null;
		}
		
		
		foreach($cat4s as $key=>$value)
		{
			return $key;
		}
	}
	
	
	public function getCat5Array($cat4)
	{
		$cat5 = $this->getCat5($cat4);
		
		$retArray = array();
		
		if (!empty($cat5))
		{
			foreach($cat5 as $cat5row)
			{
				// $retArray[$cat3row->id . '|' . $cat3row->name] = $cat3row->name;
				$retArray[$cat5row->cityid] = $cat5row->city;
			}
		}
		
		return $retArray;
	}	
	
	
	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null)
	{
		
		
		$countryid = null;
		$stateid = null;
		$cityid = null;
		$regionid = null;
		$suburbid = null;

		$suburbid = $location->getSuburbId();
		if (empty($suburbid))
		{
			$regionid = $location->getRegionId();
			if (empty($regionid))
			{
				$cityid = $location->getCityId();
				if (empty($cityid))
				{
					$stateid = $location->getStateId();
					if (empty($statid))
					{
						$countryid = $location->getCountryId();
					}
				}
			}
		}
		$pstitleTable = new Pstposting();
		
		if ($cat1 == 12)
		{
			$cat1 = null;
		}
		return $pstitleTable->search($limit,$offset, $countryid, $stateid, $cityid, $regionid, $suburbid, $query, $cat1, $cat2, $cat3, $cat4, $cat5);
	}

	protected function getBusiness()
	{
		
	}
}    
?>
