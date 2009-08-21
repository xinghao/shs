<?php
/** 
 * Central class for generating internal links for the application.
 * 
 * Currently we only use this class to provide the unique canonical 
 * link for each of top 300 headings.
 * 
 * In future, all link generation functions, e.g. Tag::url(), will move into this class.
 * 
 * The point of this is to have Google page rank accrue against just one URL for the page,
 * instead of many URL versions, which could spread out the page rank over the different versions.
 * 
 * For example, for ypex.com/insurance, ypex.com/Insurance and ypex.com/Insurance/, 
 * the canonical link for all three pages is ypex.com/Insurance.
 *
 * @author		Xinghao Yu <xinghao@airarena.net>
 * @version		$Rev: 5231 $ $xinghao $Id: Link.php  $Date: 2009-06-02 15:34:13 +1000 (Tue, 02 Jun 2009) $
 * @package		application
 * @subpackage	models
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */
class Link 
// TODO: Just have a Link::canonicalUri() function, which automatically generates the canonical link for all pages.
// Implementation:
// We can ask for the route from Zend Framework.
// We can ask for the route parameters from Zend Framework.
// Based on the parameter name, CanonicalLink can decide the case function to apply for each parameter.
// e.g. Common:titleCase() for a top heading, or upper case for a state.
// This logic and the logic for url generation (Tag::url()?) should be shared, as these URLs should match exactly,
// and we don't want to maintain two sets of code with exactly the same output.
// Include the canonical link call in the YPEX sitewide META include.
{


    /**
     * Generate short format of canonical links for landing page (usually first page) of top headings.
     * The format of canonical links for these landing page is ypex.com/Query.
     * E.g. Ypex.com/Insurance.
     * The point why we use this short format of URL insteading of 
     *   long format of URL(/Insurance/New-York/NY/10021/2/) is to get high rank in Google (SEO).
     * @param $query String
     * @return String
     */
	public static function canonicalForTopHeading($query)
	{
		// We generate canonical urls using our Tag::url() method.
		// All of our internal links are generated using Tag::url().
		// By using Tag::url() we ensure our canonical links will be exactly the same
		// as our internal links.

		// We create a Solr document object, as we need it to pass parameters 
		// to the Tag::url() function.
		$paramValues = new Apache_Solr_Document(); 

 		// The query string is the only parameter we need to build the canonical url.
 		// We also TitleCase query string. That means capitalizing all the words in phrase
		// except and, or, the etc.
		$paramValues->query = Common::titleCase($query);
    	
		// Call Tag::url() to get canonical link.
		// The 'premium' parameter specifies the route name.
		// The  which specifies the form of the link.
		// The second parameter is an Apache_Solr_Document object which holds all the values needed 
		// to build the link.
		// Note that the return string is a uri (starts with slash but is not prefixed 
		// with the host name, e.g. /Insurance).
    	$canonicalUri = Tag::url('premium', $paramValues);

    	// Add host name at the begin ng of the link and return.
    	return Common::getHostName() . $canonicalUri;
	}
	
	
    /**
     * Generate long format of canonical links for top headings.
     * The format of canonical links for these landing page is 
     * 	 ypex.com/Query/City_name/STATE_CODE/zip/page/sortType/letter
     * E.g. Ypex.com/Insurance/New-York/NY/10021/2/.
     * The point why we use this long format of URL is to avoid duplicated content problem(SEO).
     * @param $query String
	 * @param $city_name String
	 * @param $state_code String
	 * @param $zip String
	 * @param $page String
	 * @param $sortType String
	 * @param $letter String
     * @return String
     */
	public static function canonicalForTopHeadingCityStateZipSortLetter($query, $city_name = '', $state_code = '', $zip = '', $page = '', $sortType = '', $letter = '')
	{
		// We create a solr document object to pass it to Tag::Url() function.
		// We call Tag::Url() to build our canonical link.
		// Tag::url() request two parameters. 
		// The first one is route name and here it is 'premium_geo'.
		// The other one is an Apache_Solr_Document object which holds all the values needed 
		//   to build link. 
		// We also TitleCase query string. That means capitalizing all the words in phrase
		//   except and, or, the etc.
		$paramValues = new Apache_Solr_Document(); 
		
 		// We TitleCase query string. That means capitalizing all the words in phrase
		// except and, or, the etc.
    	$paramValues->query = Common::titleCase($query);
    	
    	$paramValues->city_name = Common::titleCase($city_name);
    	$paramValues->state_code = strtoupper($state_code);
    	$paramValues->zip = $zip;
    	$paramValues->page = $page;
    	$paramValues->sortType = strtolower($sortType);    	
    	$paramValues->letter = $letter;
    	
		// Call Tag::url() to get canonical link.
		// The 'premium_geo' parameter specifies the route name.
		// The  which specifies the form of the link.
		// The second parameter is an Apache_Solr_Document object which holds all the values needed 
		// to build the link.
		// Note that the return string is a uri (starts with slash but is not prefixed 
		// with the host name, e.g. /Insurance/New-York/NY/10021/2/).
    	$canonicalUri = Tag::url('premium_geo', $paramValues);

    	// Add host name at the begin ng of the link and return.
    	return Common::getHostName() . $canonicalUri;
	}
			
} 
