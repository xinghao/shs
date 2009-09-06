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
    	
    	$cities = Location::getAllcitiesByCountryAndState($value->state,$value->country);
    	
    	foreach($cities as $city)
    	{
    		if (strtolower($currentCity) == strtolower($city->city))
    		{	
    	    	$attributes = 'class="menu_on"';
	    	}
	    	else
	    	{
	    		$attributes = '';
	    	} 
	    	
	    	$value->city = $city->city;
	    	$retStr .= '<li>' . Tag::link($routerName, $value, $city->city, $attributes) . '</li>' . "\n" ; 
    	}
    	
    	$value->city = $currentCity;
    	//$value->city = strtolower($showRegion);
		return $retStr;
    }
}