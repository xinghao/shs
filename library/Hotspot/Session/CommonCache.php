<?php
/**
 * Common_Cache
 * Wrapper class for accessing the Memcached server.
 *  
 * @author		Tim Woo <tim@airarena.net>
 * @version		$Rev: 3670 $ $Author: timw $ $Date: 2009-03-24 21:13:09 +1100 (Tue, 24 Mar 2009) $
 * @package		CrFramework
 * @subpackage	Session
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */

// define memcached farm
// you have to setup all memcached servers here
$memcached_servers[0]['ip'] = "192.168.26.70";
$memcached_servers[0]['port'] = "11211";

function mcache_connect()
{
	// get servers
	global $memcached_servers;

	// create an object
	$memcache = new Memcache;

	// create server pool
	foreach($memcached_servers as $server)
	$memcache->addServer($server['ip'], $server['port']);

	// return object for external usage
	return $memcache;
}


function mcache_query($sql)
{
	// globals
	global $CACHE_TTL;
	global $mcache_row_cnt;
	global $mcache_row_num;

	// init memcached
	$memcache = mcache_connect();
	$mcache_row_num = 0;

	// set default cache time
	if(empty($CACHE_TTL)) $CACHE_TTL = 30;

	// use the query as the key
	$key = &$sql;

	// check cache first
	if($result = $memcache->get($key))
	{
		// found it in cache
		$mcache_row_cnt = mcache_num_rows($result);
		return $result;
	}

	// get it from the database
	$result = mysql_query($sql);
	if($row = mysql_fetch_array($result))
	{
		// init
		$x=0;
		$mcache_row_cnt = mysql_num_rows($result);

		// create new object
		$data = new stdClass;

		// save rows in $data object
		do 
		{
			$data->$x = $row; 
			$x++;
		}
		while($row=mysql_fetch_array($result));

		// save in memcached
		$memcache->set($key, $data, false, $CACHE_TTL);

		// return $data object
		return $data;
	}

	// if we got here there was nothing in the database
	return 0;		
}

function mcache_fetch_array($result)
{
	// globals
	global $mcache_row_cnt;
	global $mcache_row_num;

	// get data
	$row = $result->$mcache_row_num;

	// get ready for next row
	$mcache_row_num++;

	// check for end of results
	if($mcache_row_num > $mcache_row_cnt) return 0;

	// return row
	return $row;
}

function mcache_fetch_row($result)
{
	// globals
	global $mcache_row_cnt;
	global $mcache_row_num;

	// get data
	$row = $result->$mcache_row_num;

	// strip non-int keys
	foreach($row as $key => $val)
	if(is_int($key)) $new_row[$key] = $val;

	// get ready for next row
	$mcache_row_num++;

	// check for end of results
	if($mcache_row_num > $mcache_row_cnt) return 0;

	// return row
	return $row;
}

function mcache_fetch_assoc($result)
{
	// globals
	global $mcache_row_cnt;
	global $mcache_row_num;

	// get data
	$row = $result->$mcache_row_num;

	// strip int keys
	foreach($row as $key => $val)
	if(!is_int($key)) $new_row[$key] = $val;

	// get ready for next row
	$mcache_row_num++;

	// check for end of results
	if($mcache_row_num > $mcache_row_cnt) return 0;

	// return row
	return $row;
}

function mcache_num_rows($result)
{
	// count elements
	foreach($result as $item) $x++;
	return $x;
}

?>
