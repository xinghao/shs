<?php


class Refprice extends Zend_Db_Table
{
	protected $_name = 'ref_price';
    protected $_primary = 'ID';
    
    public  function getPriceOptions($priceTab, $currency, $addAny = true)
    {
    	try{
    		
	    	$select = $this->select();
	    	$select->where('PriceTab = ?', $priceTab);
	    	$select->where('country = ?', $currency);
	    	
	    	
	    	logfire('Price', $select);
	    	$prices = $this->fetchAll($select);
	    	
	    	if (empty($prices))
	    	{
	    		throw new Exception('No price for that priceTab ('. $priceTab . ')');
	    	}
	    	
	    	$retArray = array();
	    	
    		if ($addAny)
			{
				$retArray['Any'] = 'Any';
			}
			
	    	foreach($prices as $price)
	    	{
	    		$retArray[$price->PriceDataCalc] = $price->PriceData;
	    	}
	    	
	    	return $retArray;
    	}catch(Exception $e)
 		{
 			logError('Refloc failed!', $e);
 			throw $e;
 		}  
 		
    }
     
}

