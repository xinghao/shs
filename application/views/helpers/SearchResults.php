<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_SearchResults {
    function searchResults($cat1 = 'ALL', $categoty = '',  $region, $city){
		$retstr = '<div class="searchresult">';
		$retstr .= 'Below shows the <span class="emphasis">lastest</span> postings for ';
		
		if (empty($cat1))
		{
			$findstr = 'ALL ' .  $categoty;
		}  
		else
		{
			$findstr = Jobs::getCat1NameById($cat1) . ' ' . $categoty;	
		}
		
		/*
		if (strtolower($region) == strtolower($city))
		{
			$location = 'All ' . $city;
		}
		else
		{
			$location = $region . ' of ' . $city;
		}
		*/
		
		$retstr .= '<span class="emphasis">' . $findstr  . '</span> ';
		$retstr .= 'in <span class="emphasis">' . $city .'</span>. ';
		$retstr .= 'Please refine your search:</div>';	
		
		return $retstr;
    }
}