<?php
/**
 * Common
 * Provides common utility functions for the application.
 * Includes GeoIP filtering, URL manipulations, text formatting.
 *
 * @version		$Id: Common.php 5945 2009-07-30 05:41:44Z xinghao $
 * @package		CrFramework
 * @subpackage	Utility
 * @author		Tim Woo <tim@airarena.net>
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */


class Common {

	/**
	 *
	 * @param $stringDateTime
	 * @return unknown_type
	 */
    public static function getTimeByWeekDayMonthDayMonthYearHourMinute($stringDateTime = null)
    {
    	if (empty($stringDateTime))
    	{
    		$tmp = new DateTime();
    	}
    	else
    	{
     		$tmp = new DateTime($stringDateTime);
    	}

     	return date_format($tmp,"D, j M y, h:i A");
    }



	/**
	 *  Convert string to Title Case
	 * 	@author	xinghao
	 *  @param	$title				any string
	 *  @param	$preserveOrigCase	preserve the original case, only upper case capWords
	 *  @return	the string in Title Case
	 */
	public static function titleCase($title, $preserveOrigCase = false) {
		// Our array of 'small words' which shouldn't be capitalised if
		// they aren't the first word. Add your own words to taste.
		$smallWords = array( 'of','a','the','and','an','or','nor','but','is','if','then','else','when', 'at','from','by','on','off','for','in','out','over','to','into','with' );
		$capWords	= array('KFC','LG\'S','IBM','LG','NY','HP','USA','BMW');
		// Split the string into separate words
		$words = explode(' ', $title);
		foreach ($words as $key => $word) {
			$upperCaseWord = strtoupper($word);
			$lowerCaseWord = strtolower($word);
			if (in_array($upperCaseWord, $capWords)) {
				// If this word is one of our capWords then force capitalisation
				$words[$key] = $upperCaseWord;
			} else if (($key == 0 or !in_array($lowerCaseWord, $smallWords)) and !$preserveOrigCase) {
				// If this word is the first, or it's not one of our small words, capitalise it
				// with ucwords() and capitalise hyphenated words.
				$words[$key] = str_replace(' ', '-', ucwords(str_replace('-', ' ', $lowerCaseWord)));
			} else {
				// Otherwise, preserve original case
				$words[$key] = $word;
			}
		}
		// Join the words back into a string
		$newTitle = implode(' ', $words);
		$newTitle = str_replace('\'S', '\'s', $newTitle); // lower case possessives
		return $newTitle;
	}

	/**
	 *  Convert string to Title Case if UPPER CASE
	 *  Only really used for listing names that come in as UPPER CASE
	 * 	@author	xinghao
	 *  @param	$title	any string
	 *  @return	the string in Title Case
	 */
	public static function titleCaseUpper($title) {
		if ($title == strtoupper($title)) {
			// All caps, so Title Case
			return self::titleCase($title);
		} else {
			// Mixed caps, so preserve original case
			return self::titleCase($title, true);
		}
	}


     /**
	 *  Return the current route name
	 * 	@author	xinghao
	 *  @param	null
	 *  @return	the name of the route that got us to the current page
	 */
	public static function getRouteName() {
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		$request = new Zend_Controller_Request_Http();
		// Convert current URL to MVC items
		$request = $router->route($request);
		// return route name
		return $router->getCurrentRouteName();
	}

	/**
	 *
	 * @param $name
	 * @param $value
	 * @return unknown_type
	 */
	public static function createHiddenElement($name,$value){
		$hidden = new Zend_Form_Element_Hidden($name);
		$hidden ->setValue($value);
		return $hidden;
	}

	public static function arrayToStdClass($dataArray)
	{
		if (empty($dataArray))
		{
			return null;
		}

		$retClass = new StdClass();
		foreach($dataArray as $key=>$value)
		{
			$retClass->$key = $value;
		}
		return $retClass;
	}

	public static function stdClassToArray($dataObject)
	{
		if (empty($dataObject))
		{
			return null;
		}

		$retArray = array();

		foreach($dataObject as $key=>$value)
		{
			$retArray[$key] = $value;
		}
		return $retArray;
	}


	public static function encodeUriParams($values)
	{

		for($i=1;$i<6;$i++)
		{
			if(array_key_exists('cat'.$i.'name',$values) && !empty($values['cat'.$i.'name']))
			{

				$values['cat'.$i.'name'] = str_replace('/', ' ', $values['cat'.$i.'name']);
			}
		}

		if(array_key_exists('query',$values) && !empty($values['query']))
		{

			$values['query'] = str_replace('/', ' ', $values['query']);
		}


		return $values;

	}


	public static function Rate($rateNumber)
	{
		return $rateNumber . '/5';
	}


	public static function GetRecaptchaKey($type = "private")
	{
		try{


			$registry = Zend_Registry::getInstance();
			$config = $registry->get('CONFIG');
	        if ($type == "private")
	        {
				return $config->recaptcha->privatekey;
	        }
	        else
	        {
	        	return $config->recaptcha->publickey;
	        }

		}catch(Exception $e)
		{
			echo $e;
		}
	}
}



