<?php
/**
 * Tag
 * Implements a tag library for building views in PHP
 *
 *      @version	$Id: Tag.php 5734 2009-07-20 07:48:13Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Utility
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */
class Tag {

   		public static function a($url, $title = '', $target = '_self',$typeurl='',$query='', $class='') {
		if ($url == null || $url == '') {
			$a	= '';
		} else {

			$cssClass = "";
			if($class != ''){
				$cssClass = ' class="'.$class.'" ';
			}

			$titleurl=Tag::seo($typeurl,$query,'yes');//seo

			$urlParts = explode('|', $url);
			/*if($typeurl=='premium')
			{
				$rel =' rel="follow" ';
			}else{
				$rel =' rel="nofollow" ';
			}*/
			$a	=  '<a '.$cssClass.$titleurl.' title="'.$query.'"  href="';

			//$a	=  '<a href="';
			$a	.= 'http://'.$urlParts[0].'" target="'.$target.'">';
			$a	.= ($title=='url')?$urlParts[0]:$title;
		}
		return $a;
	}

	public static function rssButton($url, $title = '', $target = '_self',$typeurl='',$query='', $class='') {
		if ($url == null || $url == '') {
			$a	= '';
		} else {

			$cssClass = "";
			if($class != ''){
				$cssClass = $class;
			}

			$titleurl=Tag::seo($typeurl,$query,'yes');//seo

			$urlParts = explode('|', $url);

			$a	=  '<a rel="nofollow"'.$cssClass.$titleurl.' title="'.$title.'"  href="';
			$a	.= 'http://'.$urlParts[0].'" target="'.$target.'">';
			$a	.= '<div class="rssbtn '.$cssClass.'"></div>';
		}
		return $a;
	}


	public static function rss($url, $title = '', $typeurl='',$query='') {
		if ($url == null || $url == '') {
			$rss	= '';
		} else {


			//$titleurl=Tag::seo($typeurl,$query,'yes');//seo

			$urlParts = explode('|', $url);
			/*if($typeurl=='premium')
			{
				$rel =' rel="follow" ';
			}else{
				$rel =' rel="nofollow" ';
			}*/
			$rss	=  '<link title="'.$title.'"  href="';

			$rss	.= 'http://'.$urlParts[0].'" rel="alternate" type="application/rss+xml" />';
		}
		return $rss;
	}

	public static function href($url, $target = '_self') {
		if ($url == null || $url == '') {
			$a	= '';
		} else {
			$urlParts = explode('|', $url);
			$a	= 'http://'.$urlParts[0];
		}
		return $a;
	}

	/**
	 * 	Create a link, with a URL format specified by a route.
	 *
	 *  Example route file "default" (application/config/routes/default.ini).
	 *	Example route name "premium_geo".
	 *
	 *	routes.premium_geo.route = "/:query/:city_name/:state_code/:zip/:page/:sortType/:letter"
	 *
	 *	@param $routeName Name of url specified as routefile/routeName e.g. default/category
	 *	@param $values Object Contains member variables for each URL parameter (e.g. $value->city_name, $value->state_code). A request object, view object or infact any object can be passed in and used to generate a URL
	 *  @param $title String The text to use in the anchor tag, also used for the link's title attribute.
	 *  @param $attributes String Any additional attributes to add to the link.
	 *  @param $nofollow Boolean Whether to mark the link as nofollow for search engines.
	 *  @return An url in the form specified by $routeName, using $values to fill in any parameters in $routeName, etetera!
	 */
	public static function link($routeName, $values, $title = '', $attributes = '', $nofollow = false) {
		// TODO: Document this function.
		// TODO: Use a better parameter name than $values.
		// TODO: Stop passing this function the whole view! Use modular programming.
		// TODO: check if not a top 300 link and no-follow it
		return '<a href="'.self::url($routeName, $values).'" '.($nofollow?'rel="nofollow"':'').' '.$attributes.' title="'.$title.'">'.$title.'</a>';
	}

	public static function img($input, $variable) {
		if (!isset($input->$variable) || $input->$variable == null || trim($input->$variable) == '') {
			return '';
		} else {
			return Common::titleCase(str_replace('_', ' ', $variable)).': '.$input->$variable;
		}
	}

	/**
	 * 	Creates an SELECT tag
	 *	@param $options	arrays of options
	 *	@param $attributes	html attributes to use in the tag
	 *  @param $selected the active option
	 *  @return <select><option></option></select>
	 */
	public static function select($options, $attributes, $selected = '') {
		if ($options == null or sizeof($options) == 0) return '';
		$selectString = '<select '.$attributes.'>';
		foreach($options as $value=>$name) {
			$selectString .= '<option value="'.Tag::myUrlEncode($value).'"'.(($value==$selected)?' selected="yes"':'').'>'.$name.'</option>';
		}
		$selectString .= '</select>';
		return $selectString;
	}

	/**
	 * 	Creates an unordered list
	 *	@param $options	arrays of options
	 *	@param $attributes	html attributes to use in the tag
	 *  @param $selected the active option
	 *  @return <ul><li></li></ul>
	 */
	public static function showLocations($locations, $attributes,  $query) {
		if ($locations == null or sizeof($locations) == 0) return '';
		$listString = '';

		$locations = array_slice($locations, 0, 1);

		$doc = new Apache_Solr_Document();
		$doc->query = $query;

		foreach($locations as $state=>$cities) {

			$cities = array_slice($cities, 0, min(sizeof($cities),10));


			$listnumber = sizeof($cities);
			//logfire('city number',$listnumber);
			$lestheight = ceil(18+21*$listnumber);
			$submenuCss = 'style="top:-'.$lestheight.'px;"';

			$listString .= 	'<div class="menutabs" id="id_menu_profile">' .
							'<div id ="nearbybutton"><a id="nearbyclick">' .
							'Nearby cities </a></div>' .
							'<div id="submenu" '.$submenuCss.'>' .
							'<ul>';



			foreach($cities as $city) {
				$listString .= '<li>';
			//	$doc->location	= Tag::myUrlEncode($city.', '.$state);
				$doc->city_name	= self::myUrlEncode($city);
				$doc->state_code	= self::myUrlEncode($state);
				$listString .= self::link('location', $doc, $city, $attributes, true);
				$listString .= '</li>';
			}
			$listString .= '</ul></div></div>';
		}

		return $listString;
	}

	/**
	 * 	Create URLs using the format specified in a route file.
	 *
	 *  Example route file "default" (application/config/routes/default.ini).
	 *	Example route name "premium_geo".
	 *
	 *	routes.premium_geo.route = "/:query/:city_name/:state_code/:zip/:page/:sortType/:letter"
	 *
	 *	@param $routeName Name of url specified as routefile/routeName e.g. default/category
	 *	@param $values Object with member variables for each URL parameter (e.g. $value->city_name, $value->state_code). A request object, view object or infact any object can be passed in and used to generate a URL
	 *  @return url of format specified in config.ini e.g. /:query/:city_name/:state_code/:zip/:page/:sortType/:letter
	 */
	public static function url($routeName = '', $values = null) {
		// Get URL format from config file
		try{


		$tokens				= explode ('/', $routeName);
		if (sizeof($tokens) > 0 && sizeof($tokens) == 1) {
			$routeFile		= 'default';
			$routeName 		= $tokens[0];
		} else {
			$routeFile		= $tokens[0];
			$routeName 		= $tokens[1];
		}
		// Lazy load routes:
		// Try and load route file from registry, if not then load from config file
		$registry		= Zend_Registry::getInstance();
		if ($registry->offsetExists($routeFile)) {
			$routes		= $registry->get($routeFile);
		} else {
			$routes		= new Zend_Config_Ini(APPLICATION_PATH.'/config/routes/'.$routeFile.'.ini', APPLICATION_ENVIRONMENT);
			$routes		= $routes->routes;
			$registry->set($routeFile, $routes);
		}
		//logfire('route name', $routeName);
		$route			= $routes->$routeName->route;
		$url			= '';
		// construct the url with supplied input values
		$tokens = explode('/', $route);
		foreach($tokens as $token) {
			if (strncmp(':', $token, 1) == 0) { // only process parameters
				$paramName	= substr($token, 1, strlen($token)-1);
				$paramValue	= isset($values->$paramName) ? $values -> $paramName:'';
				//echo $paramValue;
				// Apply filters, if any
				$filtersConfig = $routes->$routeName->$paramName;
				if ($filtersConfig != null) {
					$filters	= $filtersConfig->toArray();
					$max		= ceil(sizeof($filters)/2);
					for($i=1;$i<=$max;$i++) {
						$infilterName	= 'infilter'.$i;
						$infilter		= $routes->$routeName->$paramName->$infilterName;
						$outfilterName	= 'outfilter'.$i;
						$outfilter		= $routes->$routeName->$paramName->$outfilterName;
						$paramValue = preg_replace($infilter, $outfilter, $paramValue);
					}
				}
				$url .= self::myUrlEncode($paramValue).'/';
			} else {
				$url .= $token.'/';
			}
		}
		$url = rtrim($url, '/');
		$url = trim($url, '*');
		return $url;

		}catch(Exception $e){
			logError('Build url error', $e);
			echo $e;
		}
	}

	public static function myUrlEncode($url) {
	  //  $url = urlencode(utf8_decode(trim($url)));
	  //	$url = str_replace('|', '--', $url);   // replace '|' with '--'
	 // 	$url = str_replace('\'', '', $url);    // replace '\'' with ''
	 //   $url = str_replace('/', '-', $url);   // replace '/' with '-'
	 //   $url = str_replace('$', 'S', $url);   // replace '$' with ''
	 //   $url = str_replace('#', '', $url);    // replace '#' with ''
	 //   $url = str_replace('(', '', $url);    // replace '(' with ''
	 //   $url = str_replace(')', '', $url);    // replace ')' with ''
	 //   $url = str_replace('&amp;', 'and', $url);    // replace '&amp;' with 'and'
	 //   $url = str_replace('&', 'and', $url);    // replace '&' with 'and'
	 //   $url = str_replace('?', '', $url);    // replace '?' with ''
	    //$url = str_replace(' ', '-', $url);   // replace ' ' with '-'
	  //  $url = str_replace('+', '-', $url);   // replace '+' with '-'
	    return $url = urlencode(trim($url));
	    //return trim($url,'-');
	}

	public static function myUrlDecode($url) {
	    return $url = urldecode(trim($url));
	    //return trim($url,'-');
	}

	public static function nameEncode($name) {
	    // encodes city and country names for url

	    $name = str_replace(' ', '-', ucwords(strtolower($name)));
	    $name = str_replace('_', '-', $name);
	    return $name;
	}

	public static function nameDecode($name)
	{
	    // encodes city and country names for url
	    $name = str_replace('-', ' ', $name);
	    return $name;
	}





	/**
	 * Convert a top 300 heading (e.g. Artists' Materials & Supplies) into its basic search query string (e.g. Artists Materials and Supplies).
	 *
	 * What does this actually mean?
	 *
	 * When a user clicks a top 300 heading link, which can include strange punctuation,
	 * the link URI uses a clean form of the heading (e.g. /Artists-Materials-and-Supplies).
	 * The link URI, mapped to the parameter 'query' by YPEX's Zend Framework routing rules,
	 * is preprocessed by the Creagency library to remove dashes (e.g. Artists Materials and Supplies).
	 *
	 * This function takes the top 300 headings original text (with punctuation), and returns the query string that will pop up to the controller in a search.
	 *
	 * This function is presently used to populate a column in the top_headings table called "query", which lets us identify the top heading from the query string.
	 * TODO: There is other code (for example top_heading memcache code and top 300 heading footer link generation code) that should use this function, but doesn't.
	 *
	 * @author Tasman Hayes <tasman.hayes@gmail.com>
	 * @param String $topHeading  A top 300 heading in its original Yellow Pages Association (YPA) form (e.g. Accountants-Certified/Public).
	 * @return String  The top 300 heading, as it shows up in a search query string to YPEX (e.g. Accountants Certified Public).
	 */
	public static function queryFromTopHeading($topHeading)
	{
		return self::nameDecode(self::myUrlEncode($topHeading));
	}





	public static function categoryEncode($name) {
	    // encodes city and country names for url

		$nametokens = explode('|',$name);
		$name = self::myUrlEncode($nametokens[0]);
	    $name = str_replace(' ', '-', ucwords(strtolower($name)));
	    $name = str_replace('_', '-', $name);
	    return $name;
	}

	public static function categoryDecode($name) {
	    // encodes city and country names for url

	    $name = str_replace('+', ' ', $name);
	    return Common::titleCase($name);
	}

	public static function categories($doc, $charsToShow, $separator = ', ', $urlType = 'premium', $nofollow = false) {
		if (!isset($doc) || $doc == null) {
			return array();
		} else {
			return self::split($doc->heading1.'|'.$doc->heading2.'|'.$doc->heading3.'|'.$doc->heading4.'|'.$doc->heading5.'|'.$doc->heading6,
							 $doc,
							 $charsToShow,
							 $urlType,
							 $separator,
							 $nofollow);
		}
	}

	public static function categoriesMore($doc, $charsToShow, $separator = ', ', $urlType = 'premium', $nofollow = false) {

		return self::splitMore($doc->heading1.'|'.$doc->heading2.'|'.$doc->heading3.'|'.$doc->heading4.'|'.$doc->heading5.'|'.$doc->heading6,
								$doc,
								$charsToShow,
								$urlType,
								$separator,
								$nofollow);
	}

	/* split
	 * @author Tim Woo <tim@airarena.net>
	 * Originally written to split $input strings into more/less expanders for jQuery
	 * Now largely historic since the app doesn't use more/less expanders.
	 * @param	$input 			input string delimited by | eg. nike|adidas|puma
	 * @param	$doc			Solr doc for creating url links
	 * @param	$charsToShow	length of string to display before showing the more... link
	 * @param	$url			the url route to display for links
	 * @param	$separator		separates the items in the expander
	 * @param	$nofollow		switch nofollow on or off in the links
	 * @param	$more			true if we're displaying the more portion, false if we're displaying the top portion.
	 */
	public static function split($input, $doc, $charsToShow, $url = '', $separator = ', ', $nofollow = false, $more = false) {
		if ($input == null || $doc == null) return '';
	    $first = true;
	    $returnString = '';
		$inTokens = explode('|', $input);
		$tokens = array();
	    asort($inTokens);
	    $numItems = 0;
	    foreach($inTokens as $token) {
	    	if ($token!='') {
	    		$numItems++;
	    		$tokens[] = $token;
	    	}

	    }
	    $totalChars =isset($tokens[0])? strlen($tokens[0]) :0;
	    $numToShow = 1;

		// work out longest length to display
	    while (($totalChars < $charsToShow) && ($numToShow < $numItems)) {
	    	$totalChars += strlen($tokens[$numToShow]);
   	 		$numToShow++;
		}

	    if (!$more) {
	    	$start	= 0;
	    	$end	= min($numItems,$numToShow);
	    } else {
	    	$start	= 0;
	    	$end	= sizeof($tokens);
	    }

	    for($i=$start;$i<$end;$i++) {
			$token = $tokens[$i];
			if ($token != null && $token != '') {
		    	if ($first) {
		    		$first = false;
		    	} else {
		    		$returnString .= $separator;
		    	}
		    	$token = strtolower(self::categoryDecode($token));
		    	if ($url != '' && $url != 'no-link') {

					$sNoFollow = ' rel="nofollow"';
					if(!$nofollow){
						$sNoFollow="";
					}

		    		$doc->query		= $token;
		    		$returnString .= '<a href="'.self::url($url, $doc).'"'.$sNoFollow.' title="'.$token.'">'.$token.'</a>';
	    		} else {
		    		$returnString .= $token;
		    	}
			}
		}

	/*	if (!$more && $numToShow<$numItems) {
			$returnString .= $separator;
			$returnString .= ($url != '')?'<a class="more">':'';
			$returnString .= 'more...&nbsp;&nbsp;&nbsp;&nbsp;';
			$returnString .= ($url != '')?'</a>':'';
		}*/
		return $returnString;
	}


	/* Taz: Ugly uppercase hack, based on split(). Need to use simpler, cleaner, documented function. */
	public static function splitUcFirst($input, $doc, $charsToShow, $url = '', $separator = ', ', $nofollow = false, $more = false) {
		if ($input == null || $doc == null) return '';
	    $first = true;
	    $returnString = '';
		$inTokens = explode('|', $input);
		$tokens = array();
	    asort($inTokens);
	    $numItems = 0;
	    foreach($inTokens as $token) {
	    	if ($token!='') {
	    		$numItems++;
	    		$tokens[] = $token;
	    	}

	    }
	    $totalChars =isset($tokens[0])? strlen($tokens[0]) :0;
	    $numToShow = 1;

		// work out longest length to display
	    while (($totalChars < $charsToShow) && ($numToShow < $numItems)) {
	    	$totalChars += strlen($tokens[$numToShow]);
   	 		$numToShow++;
		}

	    if (!$more) {
	    	$start	= 0;
	    	$end	= min($numItems,$numToShow);
	    } else {
	    	$start	= 0;
	    	$end	= sizeof($tokens);
	    }

	    for($i=$start;$i<$end;$i++) {
			$token = $tokens[$i];
			if ($token != null && $token != '') {
		    	if ($first) {
		    		$first = false;
		    	} else {
		    		$returnString .= $separator;
		    	}
		    	// TW: Use titleCase not titleCaseUpper, titleCaseUpper is only for $doc->business_name names
		    	$token = Common::titleCase($token);
		    	if ($url != '' && $url != 'no-link') {

					$sNoFollow = ' rel="nofollow"';
					if(!$nofollow){
						$sNoFollow="";
					}

		    		$doc->query		= $token;
		    		$returnString .= '<a href="'.self::url($url, $doc).'"'.$sNoFollow.' title="'.$token.'">'.$token.'</a>';
	    		} else {
		    		$returnString .= $token;
		    	}
			}
		}

		return $returnString;
	}



	public static function splitMore($input, $doc, $charsToShow, $url = '', $separator = ', ', $nofollow=false) {

		return self::split($input, $doc, $charsToShow, $url, $separator, $nofollow, true);
	}

	public static function splitMoreUcFirst($input, $doc, $charsToShow, $url = '', $separator = ', ', $nofollow=false) {

			return self::splitUcFirst($input, $doc, $charsToShow, $url, $separator, $nofollow, true);
	}

	/*
	 * This function is used in the file : rightcolumn.inc.php
	 * [xinghao] make the search term captalized in the URL
	 *           eg. change form ypex.com/brand/nike => ypex.com/brand/NIKE
	 * TW: cleaned up code
	 */
	public static function splitFromArray($input, $doc, $charsToShow, $url = '', $separator = ', ', $nofollow = false) {
		// Handle null input
		if ($input == null || $doc == null) return '';

		// Initialise values
	    $returnString	= '';
	    sort($input);

		// Work out longest length to display
		$numItems		= count($input);
		$numToShow 		= 15;
//		$totalChars 	= strlen($input[0]);
//	    while (($totalChars < $charsToShow) && ($numToShow < $numItems)) {
//	    	$totalChars += strlen($input[$numToShow]);
 //  	 		$numToShow++;
//		}
		//logfire('listnumber:',$numItems);
    	$end	= min($numItems,$numToShow);
		$returnString = '<ul>';
		for($i=0;$i<$end;$i++) {
			$token = $input[$i];
			if ($token != null && $token != '') {

				// [xinghao] change strtolower() => Common::titleCase()
				// to make the search term always capitalized.
				// $token = strtolower(self::categoryDecode($token));
				$token = Common::titleCase(self::categoryDecode($token));
		    	if ($url != '' && $url != 'no-link') {
					$sNoFollow = ' rel="nofollow"';
					if(!$nofollow){
						$sNoFollow="";
					}
		    		$doc->query		= $token;
		    		$returnString .= '<li><a href="'.self::url($url, $doc).'"'.$sNoFollow.' title="'.$token.'">'.Common::titleCase($token).'</a></li>';
		    		//logfire('list:',$returnString);
	    		} else {
		    		$returnString .= '<li>'.$token.'</li>';
		    	}
			}
		}
		return $returnString.'</ul>';
	}

	public static function out($input, $title = '', $newline = '<br>') {
		if ($input == null || $input == '') {
			return '';
		} else {
			return ($input=='')?$input:$title.$input.$newline;
		}
	}

	public static function var_out($input, $variable) {
		if (!isset($input->$variable) || $input->$variable == null || trim($input->$variable) == '') {
			return '';
		} else {
			return Common::titleCase(str_replace('_', ' ', $variable)).': '.$input->$variable;
		}
	}

	public static function creditCards($cards = '', $separator = '<br>') {

		$returnCards = $cards;
		if (strstr($cards, 'Z')) {
			$returnCards = 'All major cards';
		} else {
			$returnCards = str_replace('A', 'american express'.$separator, $returnCards);
			$returnCards = str_replace('M', 'master card'.$separator, $returnCards);
			$returnCards = str_replace('V', 'visa'.$separator, $returnCards);
			$returnCards = str_replace('D', 'discover card'.$separator, $returnCards);
			$returnCards = str_replace('C', 'diner\'s club'.$separator, $returnCards);
		}
 		return Common::titleCase($returnCards);
	}

	public static function hours($code) {
		$hours = '';
		switch(true) {
			case (strstr($code, 'A')): $hours .= '24 Hours a Day'; break;
			case (strstr($code, 'B')): $hours .= '24 Hours/7 Days'; break;
			case (strstr($code, 'C')): $hours .= '24 Hour Service'; break;
			case (strstr($code, 'D')): $hours .= '6 Days a Week'; break;
			case (strstr($code, 'E')): $hours .= '7 Days a Week/Daily/Everyday'; break;
			case (strstr($code, 'F')): $hours .= 'Mon-Fri/Weekdays'; break;
			case (strstr($code, 'G')): $hours .= 'Mon-Sat'; break;
			case (strstr($code, 'H')): $hours .= 'Open Sundays'; break;
			case (strstr($code, 'I')): $hours .= 'Open Saturdays'; break;
			case (strstr($code, 'J')): $hours .= 'Hours by Appointment'; break;
			case (strstr($code, 'K')): $hours .= 'Tuesday Through Saturday'; break;
			case (strstr($code, 'L')): $hours .= 'Wednesday Through Saturday'; break;
			case (strstr($code, 'M')): $hours .= 'Thursday Through Saturday'; break;
			case (strstr($code, 'N')): $hours .= 'Weekday Through Sunday'; break;
			case (strstr($code, 'O')): $hours .= 'Saturday & Sunday/Weekends'; break;
			case (strstr($code, 'P')): $hours .= 'Closed Mondays'; break;
			case (strstr($code, 'Q')): $hours .= 'Open Evenings'; break;
		}
		return trim($hours);
	}

	// add comma to a word only if it exists
	public static function comma($word) {
		return ($word == null || $word == '')?'':$word.', ';
	}

	public static function displayTwoColumns(array $array_list) {
	    $return_str = "";
	    $return_str .= "<table>";
	    $i=0;
	    foreach ($array_list as $item)
	    {
	        $i++;
	        if ($i % 2) {
	          $return_str .= "<tr><td>";
	          $return_str .= $item;
	          $return_str .= "</td><td>";
	        } else {

	          $return_str .= $item;
	          $return_str .= "</td></tr>";
	        }
	    }
	    $return_str .= "</table>";

	    return $return_str;
	}

	public static function displayFourColumns(array $array_list, $href=false) {
		$registry	= Zend_Registry::getInstance();
		$config		= $registry->get('CONFIG');
		$baseurl	= $config->website->baseurl;

	    $return_str = "";
	    $return_str .= '<table width="100%" cellspacing="10">';
	    $i=0;
	    foreach ($array_list as $item)
	    {
	     //   echo "item:".$item.":";
	        if ($i==4) {
	          $i=0;
	        }
	        $i++;
		if ($href)
			$item = '<a href="'.$baseurl."/".self::myUrlEncode($item).'">'.$item."</a>";

	        if ($i==1) {
	          $return_str .= '<tr><td valign="top" style="padding-right: 10px;">';
	          $return_str .= $item;
	          $return_str .= '</td><td valign="top" style="padding-right: 10px;">';
	        } else if ($i==4) {
	          $return_str .= $item;
	          $return_str .= '</td></tr>';
	        } else {
	          $return_str .= $item;
	          $return_str .= '</td><td valign="top">';
	        }

	    }
	    $return_str .= "</table>";

	    return $return_str;
	}

	public static function seoInfo($keyword) {
		$registry	= Zend_Registry::getInstance();
		$seo		= $registry->get('SEO');
		return 		isset($seo->seo->global->$keyword)?$seo->seo->global->$keyword:'';
	}

	public static function seo($typeUrl,$query='',$link='no'){
		$registry	= Zend_Registry::getInstance();
		$seo		= $registry->get('SEO');
		$term		= $seo->seo->global->keyword;
		$override	= $seo->seo->global->override;


		if($typeUrl=='premium' && $override=='true'){
			$url=' name="'.$query.'"';
			//if($link!='yes'){
			//	$url.=' rel="nofollow"';
			//}

		}else{
			$url=' name="'.$term.'" ';
			if($link=='yes'){
				$url.=' rel="nofollow"';
				//$url.='';
			}
		}
		return $url;

	}
	public static function imgSrc($link,$typeUrl='',$query=''){
		//ex src="/images/ypex_logo.png"
		$registry	= Zend_Registry::getInstance();
		$seo		= $registry->get('SEO');
		$term	    = strtolower($seo->seo->global->keyword);
		$override	= $seo->seo->global->override;
		$url        = '';
		$query=strtolower($query);

		//start
		$links=explode('/',$link);
		$nb=count($links);

		if($links[1]=='images')
		{
			$url=" src='".'/images/';
			if($typeUrl=='premium' && $override=='true'){
				$url.=self::nameEncode($query).'/';
			}else{
				$url.=$term.'/';
			}
			for ($i=2;$i<$nb;$i++){
				$url.=$links[$i];
			}
		}

		return $url."'";
	}

	/**
	 *  Added by Xinghao Yu, 1/02/2009
	 * 	to show the correct sort tab. fFeathure #70
	 *	@param $sortType	sort type user choose
	 *	@param $currentTab	the current sort tab
	 *  @return if it is the corrent sort type retrn ' class="current_sort" '
	 *           else return empty string,
	 */

	public static function getSortTabCSSClass($sortType,$currentTab){
		//return $currentTab .' g '. $sortType . ' gh '.strpos($currentTab, $sortType);
		if( $sortType == $currentTab || substr_count($sortType, $currentTab) > 0)
			//return ' class="current_sort" ';
			return ' selected ';
			else
				return '';

	}

	/**
	 * display the page navigator
	 * eg. current page 13, pageGap is 5
	 *     we shouw  < 1 ... 9 10 11 12 13 14 15 16 17 18 ... 39 >
	 *     '<' means go to previous page
	 *     '...' means go back 10 pages
	 *  Added by Xinghao Yu, 19/02/2009 Feathure #69
	 *	@param $view	views
	 *  @return return page panel
	 */
	public static function getPagePanel($view,$urlType=''){
		$pageMenu = '';
		if($view->numFound > 0){

			// get total page number
			// if total listing number is 51 the total page is 60
			$numPages = ceil($view->numFound/$view->limit);

			//sanecho "this pages route: ".$view->pageRoute;
			// construct page navigation menu
			$currentPage = $view->page;

			// the return string
			// including all the html tag etc
			$pageMenu = '';

			//changed by Xinghao Yu, 19/02/2009 Feathure #69

			// how many pages we show around current page
			// eg. current page 13, pageGap is 5
			//     we shouw  9 10 11 12 13 14 15 16 17 18
			$pageGap = floor($view->limit / 2);

			// if urlType in defaut.ini(route file) is premium don't show nofollow
			$followrel=$urlType=='premium' ? false : true;


		    // caculate the start page number
		    // the start page is current page - pageGap(5)
		    // if the start page number is less than 1, we set it to 1
    		$startPageNo = $currentPage - $pageGap;
    		$startPageNo = ($startPageNo > 0)?$startPageNo:1;

		    // caculate the end page number
		    // the start page is current page + pageGap(5)
		    // if the start page number is greater than total page number, we set it to total page number
    		$endPageNo = $currentPage + $pageGap;
    		$endPageNo = ($endPageNo <= $numPages)?$endPageNo:$numPages;

    		// caculate the page span
    		// the max of page span is 10
    		// the min of page span is 0
    		// we want 4 pages before current page and 5 pages after current page
    		// Eg. current page 13, we want 9 10 11 12 13 14 15 16 17 18
    		// 		so we want page span to be 9.
    		$pagespan = $endPageNo - $startPageNo;

    		// if pagespan = 10, we add state page number by 1
    		// so the pagespan will be 9
	    	if( $pagespan >= $view->limit){
	    		 $startPageNo += 1;
	    	}elseif($pagespan + 1 != $numPages){

	    		// only when the start page is 1 or the end page is the total page number
	    		// the pagespan will less than 9
	    		// if start page is 1, we reset the endpage to the min of 10 or total page number
	    		// so instead of only show 1 2 3 4 5, we show more 1 2 3 4 5 6 7 8 9
	    		// if end page is total page number, we reset the start page to the max of 1 or current page -10
	    		// so instead show 14 15 16 17 18, we show more 9 10 11 12 13 14 15 16 17 18
		    	if( $pagespan < $view->limit ){
		    		if($startPageNo == 1){
		    			$endPageNo = min($view->limit, $numPages);
		    		}else{
		    			$startPageNo = max($numPages - $view->limit + 1, 1);
		    		}
		    	}
	    	}

			// only when the total page number is greater than 1, we show page navigater.
			if ($numPages>1) {

				// if current page is bigger than 1
				// we show '<' link to previous page
				if ($currentPage > 1) {
					$view->page = $currentPage-1;
					$pageMenu .= self::link($view->pageRoute,$view,'<','class="lt"',$followrel);
				}

				//changed by Xinghao Yu, 19/02/2009 Feathure #69
		   		// if start page is greater than 1 we show '1' and '...'
				if ($startPageNo > 1) {
					//$pageMenu .= '&nbsp;&nbsp;&nbsp;&nbsp;';
					if ($currentPage > 1) {
						$view->page = 1;
						$pageMenu .= self::link($view->pageRoute,$view,'1','class="otherpage"',$followrel);
					}
					//$this->view->page = ($curSet-1)*$this->view->limit;
					$view->page = max($currentPage - $view->limit, 1);
					$pageMenu .= self::link($view->pageRoute,$view,'...','class="dot"',$followrel);
				}

		    	// print out all the pages from start page to end page
				for ($i=$startPageNo;$i<=$endPageNo;$i++) {
					$view->page = $i;
					$pageMenu .= self::link($view->pageRoute,$view,$i, ($i==$currentPage)?'class="currentpage"':'class="otherpage"',$followrel);
		    	}

		    	//changed by Xinghao Yu, 19/02/2009 Feathure #69
		    	// if the end page is less than total page number we show 'total page number' and '...'
				if( $endPageNo < $numPages){
					$view->page = min($currentPage + $view->limit, $numPages);
					$pageMenu .= self::link($view->pageRoute,$view,'...','class="dot"',$followrel);
					if ($currentPage < $numPages) {
						$view->page = $numPages;
						$pageMenu .= self::link($view->pageRoute,$view,$view->page,'class="otherpage"',$followrel);
						}
				}


				// if current page is less than the total page number
				// we show '>' link to next page
				if ($currentPage < $numPages) {
					$view->page = $currentPage+1;
					$pageMenu .= self::link($view->pageRoute,$view,'>','class="gt"',$followrel);
				}
			}
			$view->page = $currentPage;

		}else
			$pageMenu = 'No result';
		return $pageMenu;
	}



	//added by xinghao for popular category
	public static function getTopCloud() {

		$terms = Zend_Registry::getInstance()->get('TERMS');
		$options  = $terms->toArray();

		if ($options == null or sizeof($options) == 0) return '';
		$strprex = '<li><a rel="nofollow" href="/';
		$strpost = "</a></li>\n";

		$selectString = '<ul>';
		foreach($options as $key => $value) {
			if(isset($value['category'])){
				$selectString .= $strprex.self::myUrlEncode($value['category']). "\" class=\"topcloud list fontSize4\">" .$value['category'].$strpost;
			}
		}
		$selectString .= '</ul>';
		return $selectString;

	}


	public static function getPageAlphabeticalPanel($view,$urlType=''){

		$pageMenu = '';
		$alpha=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9','0');
		if($view->numFound > 0){
			$numPages = ceil($view->numFound/$view->limit);

			// construct page navigation menu

			$pageMenu = '';
			$followrel=$urlType=='premium' ? false : true;
			$view->page=1;


			foreach($alpha as $letter){
				$view->letter=$letter;
				$pageMenu .= self::link('search',$view,strtoupper($letter),'',$followrel);

			}

			$view->page = 1;


		}else
			$pageMenu = 'No result';
		return $pageMenu;
	}

	// added by michael to swap terms - default use is to swap popular term to heading term
	// TW Fix: handle non-existent terms without causing a fatal error
	// TW Fix: initialise $returnTerm to $string
	// TODO: [taz] This function is not in use in the CategoryHeadingSearch object, and may not be in use elsewhere; it may be able to be removed.
	// Popular searches are presently mapped directly to top 300 categories, so this remapping of popular searches to Solr search strings may no longer be needed.
	// In future, popular searches will probably be high frequency searches from users, coupled with searches that are trending upwards.
	public static function swapTerms($search='popular', $replace = 'heading', $string) {
		$terms = Zend_Registry::getInstance()->get('TERMS');
		$terms  = $terms->toArray();
		$returnTerm = $string;
		//logfire('swapTerms',count($terms));
		foreach ($terms as $key=>$term) {
			if (isset($term[$search]) && isset($term[$replace])) {
				$searchTerm		= $term[$search];
				$replaceTerm	= $term[$replace];
				//logfire($searchTerm,$replaceTerm);
				if (strtolower($string) == strtolower($searchTerm)) {
					$returnTerm = $replaceTerm;
					logstd("PopularMapping", $string."=>" . $replaceTerm);
					break;
				}
			}
		}
		return $returnTerm;
	}

	// added by michael to display Popular Cloud terms
	public static function getPopularCloud() {
		$terms = Zend_Registry::getInstance()->get('TERMS');
		$terms  = $terms->toArray();
		$listString = '';

		// [taz 2009/6/12] We want Google to discover the canonical page links from our popular pages to top 300 heading pages.
		// TODO: After popular links disappear from Google's index, make popular searches nofollow (i.e. set $noFollowPolicy to true).
		$noFollowPolicy = false;

		$doc = new Apache_Solr_Document();

		foreach ($terms as $key => $value) {
			if (isset($value['popular'])) {
				// [taz 2009/6/12] Automatic URL lowercasing by the url() function has been disabled.
				// Currently popular URLs in Google's index are lowercase.
				// We want to canonical popular search pages through to top heading pages.
				// Until that process is complete, we lowercase the popular search term, so the URL remains lowercase.
				// TODO: After popular links disappear from Google's index, the strtolower() can be removed.
				$doc->query = strtolower($value['popular']);
				//logfire('', $value['popular'].'=>'.$value['fontSize'].'=>'.$value['heading']);
				if (isset($value['fontSize'])) {

					$fontSize = isset($value['fontSize']) ? $value['fontSize'] : "1";

					// @var noFollow Boolean [taz] Whether to put rel="nofollow" on the link for this specific popular search.
					// At present we follow the links that can be "canonicaled" to a top 300 heading,
					// and nofollow the remaining three links (auto insurance, new cars and used cars),
					// because they are not SEO targets at present.
					$noFollow = $noFollowPolicy || $doc->query == 'auto insurance' || $doc->query == "new cars" || $doc->query == "used cars";

					// [xinghao] In the popular search box.
					// the space of two words in one search terms is to big sometimes.
					//		Eg. Used Car  Home  improvement Doctor
					// Home insurance is one term but it looks like two words
					// The reason is that space is adjusted by browser to auto align.
					// We use '&nbsp;' instead of ' ', the browser thinks 'Home&nbsp;improvement' as one term. So that the space between
					// Home and inprovement can never be changed
					$listString .=  self::link('popular', $doc, str_replace(' ', '&nbsp;', $value['popular']), 'class="topcloud fontSize'.$fontSize.'"', $noFollow) ;
					$listString .= "\n";
				}
			}

		}
		return $listString;
	}

	public static function showCloseStates($locations, $attributes,  $query,$city) {
		if ($locations == null or sizeof($locations) == 0) return '';
		$listString = '';
		$max =count($locations)>4 ? 4 :count($locations) ;
		$locations = array_slice($locations, 0, $max);

		$doc = new Apache_Solr_Document();
		$doc->query = $query;

$listString .= '<ul>';
		foreach($locations as $key=>$state) {

				$listString .= '<li>';
			//	$doc->location	= Tag::myUrlEncode($city.', '.$state);
				$doc->city_name	= self::myUrlEncode($city);
				$doc->state_code	= self::myUrlEncode($state);
				$city=ucfirst($city);
				$listString .= self::link('location', $doc,$city.' '.$state, $attributes, true);
				$listString .= '</li>';


		}$listString .= '</ul>';

		return $listString;
	}

	/* Escape single quotes in the SQL string provided.  Prevents SQL injection attacks when building queries */
	public static function safeSQL($sql) {
		//return pg_escape_string($sql);
		return $sql;
	}

	public static function publisherLogoURL($logo_filename) {
		return "/assets/publishers/logos/".urlencode($logo_filename);
	}

     /**
      * [xinghao]
	 *  Common phone number print function
	 *  return like: <skype image> (619) 224-3254
	 * 	@author	Xinghao Yu <xinghao@airarena.net>
	 *  @param $fullPhoneNumber
	 *  @return formatted phone number.
	 *  @throws none
	 */
	public static function phone($fullPhoneNumber) {
		logfire('full phone muber',$fullPhoneNumber);
		return '<img src="/images/search/pic_small.png" /></a>' . ' (' . substr($fullPhoneNumber, 0,3)
		       . ') ' . substr($fullPhoneNumber, 3,3) . '-' . substr($fullPhoneNumber, 6,4);
	}

	/**
	 * Render a simple table.
	 * Return html code.
	 *
	 * You can choose 2 format to render table ($verticalOrder):
	 * Normal format:
	 * ------------------
	 *    1     |    2
	 *    3     |    4
	 *    5     |    6
	 * ------------------
	 *
	 * Vertical format:
	 * Vertical means the cells is order by vertical sequence.
	 * ------------------
	 *    1     |    4
	 *    2     |    5
	 *    3     |    6
	 * ------------------
	 *
	 * @param integer $columnNumber number of columns
	 * @param array $data data to display in table.
	 * @param string $cssClass css class for table
	 * @param boolean $verticalOrder flag for desplay table in vertical format.
	 * @return string html code for table or null.
	 * @author		Xinghao <xinghao@airarena.net>
	 */
	public static function simpleTable($data, $columnNumber = 3, $cssClass = '', $verticalOrder = false)
	{
		// [Xinghao] return null if no data needs to be render.
		if (empty($data))
		{
			return null;
		}

		// [Xinghao] Get amount fo cells of table.
		$amputOfCells = sizeof($data);

		// [Xinghao] Get amout of lines of table.
		$amountOfLines = ceil($amputOfCells / $columnNumber);

		// [Xinghao] Print table tag.
		$returnString = '<table class="' . $cssClass . '">';

		// [Xinghao] Print lines.
		for($i = 0; $i < $amountOfLines; $i++)
		{
			$returnString .= '<tr>';

			// [Xinghao] Print every cell in this line.
			for($j =0; $j < $columnNumber; $j++)
			{
				$returnString .= '<td>';

				// [Xinghao] Get the sequence number of cell to print.
				if ($verticalOrder)
				{
					$cellSeq = $i + $j * $amountOfLines;
				}
				else
				{
					$cellSeq = $i * $columnNumber + $j;
				}

				// [Xinghao] Print data if we have.
				if ($cellSeq < $amputOfCells)
				{
					$returnString .= $data[$cellSeq];
				}

				$returnString .= '</td>';
			}
			$returnString .= '</tr>';
		}


		// [Xinghao] Print end of table tag.
		$returnString .= '</table>';

		// [Xinghao] Return html code for table.
		return $returnString;

	}


    	/**
	 *  Convert ISO8601 datatime to Tue US Time Format
	 *  Eg: Tuesday, May 12, 2009
	 *  @param	$datetimeString	data info(ISO8601) from database
	 *  @return	$htmlDatatime html format datatime
	 */
    public static function getHtmlDateTime($stringDateTime){
    	$tmp = new DateTime($stringDateTime);
    	//return the format as Tuesday, May 12th, 2009
    	//return date_format($tmp,"D, F d")."<sup>".date_format($tmp,"S")."</sup>".date_format($tmp,", Y");

    	//return the format as Tuesday, May 12, 2009
    	return date_format($tmp,"F d, Y");
    }

    public static function getHourMinute($strTime){
    	$tmp = new DateTime($strTime);
    	//return the format as Tuesday, May 12th, 2009
    	//return date_format($tmp,"D, F d")."<sup>".date_format($tmp,"S")."</sup>".date_format($tmp,", Y");

    	//return the format as Tuesday, May 12, 2009
    	return date_format($tmp,"H:i");

    }
}