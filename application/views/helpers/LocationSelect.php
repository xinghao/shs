<?php
/**
 * @version	$Id: HostName.php 3646 2009-03-24 04:29:55Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_LocationSelect {
	function locationSelect($location, $locationId){
		if (empty($location))
		{
			if ($locationId == 'Aus28')
			{
				echo 'selected="selected"';
			}
		}
		else
		{
			if ($locationId == $location->getCityId() || $locationId == $location->getStateId())
			{
				echo 'selected="selected"';
			}
		}
    }
}