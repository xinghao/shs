<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_ListAllCitiesInState
{
    function listAllCitiesInState($routerName, $value){
    	
    	$retStr = '';

    	
    	$currentCity = $value->city;
    	$currentState = $value->state;
    	$cities = Location::getLocations($value->city, $value->state,$value->country);
		$searchRule = Location::getSearchRule();
		    	
    	foreach($cities as $city)
    	{
    		if ($city["current"])
    		{	
    	    	$attributes = 'class="menu_on"';
	    	}
	    	else
	    	{
	    		$attributes = '';
	    	} 
	    	
	    	if ($searchRule == 1 || $searchRule ==2)
	    	{
	    		$value->city = $city["location"];
	    	}
	    	elseif($searchRule ==3)
	    	{
	    		$value->city = $value->state = $city["location"];
	    	}
	    	$retStr .= '<li>' . Tag::link($routerName, $value, $city["location"], $attributes) . '</li>' . "\n" ; 
    	}
    	
    	$value->city = $currentCity;
    	$value->state = $currentState;
    	//$value->city = strtolower($showRegion);
		return $retStr;
    }
}