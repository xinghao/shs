<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_BasicCategoryUri
{
    function basicCategoryUri($showCategory, $value, $currentCategory){
    	logfire('$showCategory',$showCategory);
    	logfire('$$currentCategory',$currentCategory);
    	if (strtolower($showCategory) == strtolower($currentCategory))
    	{
	    	$attributes = 'class="menu_on"';
    	}
    	else
    	{
    		$attributes = '';
    	} 
    	
    	switch ($showCategory)
    	{
    		case 'Car sale' : 
    			$showCategory = 'cars';
    			break;
    		
    	}
    	//echo str_replace(' ', '', str_replace('&', 'and', strtolower($showCategory))) . 'basic' . "     ";
		return Tag::link(str_replace(' ', '', str_replace('&', 'and', strtolower($showCategory))) . 'basic', $value, $showCategory, $attributes);
    }
}