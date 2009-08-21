<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_ReplaceRegionInUri
{
    function replaceRegionInUri($routerName, $value, $showRegion, $currentRegion){
    	
    	if (strtolower($showRegion) == strtolower($currentRegion))
    	{
	    	$attributes = 'class="menu_on"';
    	}
    	else
    	{
    		$attributes = '';
    	} 
    	$value->region = strtolower($showRegion);
		return Tag::link($routerName, $value, $showRegion, $attributes);
    }
}