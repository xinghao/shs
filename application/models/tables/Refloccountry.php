<?php


class Refloccountry extends Zend_Db_Table
{
	protected $_name = 'ref_loc_country';
    protected $_primary = 'countryid';
    
    public  function getTableName()
    {
    	return $this->_name;
    }
    
	public function getSearchRuleByCountryName($country)
	{
		try
		{
			$select = $this->select();
			$select->where('lower(country) = lower(?)', $country);
			
			$row = $this->fetchRow($select);
			
			if (empty($row))
			{
				throw new Exception("No search rule exists for " . $country);
			}
		
			return $row->searchRule;
	  	}catch(Exception $e)
 		{
 			logError('ref_loc_country', $e);
 			throw $e;
 		} 
	}

	public function getSearchRule($country_id)
	{
		try
		{
			$select = $this->select();
			$select->where('lower(countryid) = lower(?)', $country_id);
			
			$row = $this->fetchRow($select);
			
			if (empty($row))
			{
				throw new Exception("No search rule exists for " . $country_id);
			}
		
			return $row;
	  	}catch(Exception $e)
 		{
 			logError('ref_loc_country', $e);
 			throw $e;
 		} 
	}    
	
}

