<?php
/**
 * Solr_Server
 * Calls Solr service from PHP
 * Created on 18/12/2008
 *
 *      @version	$Id: Server.php 5735 2009-07-20 07:48:31Z xinghao $
 *      @package	CrFramework
 *      @subpackage	Solr
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */

class CrFramework_Solr_Server {
	private $solrBalancer;

	private $selectTime = 0;

	public function __construct() {
		$config = Zend_Registry::getInstance()->get('CONFIG');
		$solrServers = $config->solr->toArray();
		$this->solrBalancer = new Apache_Solr_Service_Balancer();
		foreach ($solrServers as $serverName=>$params) {
			if (substr_compare($serverName, 'master', 0, 6) == 0) {
				logDebug('SolrServer', 'Adding new Solr master: '.$params['host'].':'.$params['port'].'<br>');
				$this->solrBalancer->addWriteService(new Apache_Solr_Service($params['host'], $params['port']));
			} else if (substr_compare($serverName, 'slave', 0, 5) == 0) {
				logDebug('SolrServer', 'Adding new Solr slave: '.$params['host'].':'.$params['port'].'<br>');
				$this->solrBalancer->addReadService(new Apache_Solr_Service($params['host'], $params['port'], 'solr/listings'));
			}
		}
		$this->solrBalancer->setReadPingTimeout(1);
	}

	protected function makeId($coreName, $query, $params = array()) {
		$id 	= 	$coreName.
					$query.
					implode('|', $params);
		$id_md5 = 	md5($id);
		return $id_md5;
	}

	/**
	 * 
	 * addDocument
	 * Adds a document to a solr core
	 * 
	 * @param string              $coreName
	 * @param array of strings    $document
	 * @return unknown_type
	 * @author	Michael Chan <michael@kazaa.com>
	 */
	public function addDocument($coreName, Apache_Solr_Document $document, $allowDups = false, $overwritePending = true, $overwriteCommitted = true) {
		$returnResponse = null;
		$startTime = microtime(true);
		$solrPath = '/solr/'.$coreName;
		
		// remove score since its not a document field
		if (isset($document->score))
			unset($document->score);
		
		try {
	    	$response = $this->solrBalancer->addDocument($solrPath,$document,$allowDups,$overwritePending,$overwriteCommitted);
			if ($response->getHttpStatus() == 200) {
				$returnResponse = $response->response;

			} else {
				logError('Solr http status msg: ', $response->getHttpStatusMessage());
			}
			$store = 'SOLR';
		} catch (Exception $e) {
			logError('Solr server fatal error ', $e);
			throw new Exception('Solr Server fatal exception');
		}
		
		$this->selectTime = microtime(true) - $startTime;

		$logString = '[core: '.$coreName.'] ';
		$logString .= '[time: '.sprintf("%.2f",$this->selectTime).' secs]';
		logStd('SolrServer', $logString);
	
		return $returnResponse;
	}

	/**
	 * 
	 * addDocuments
	 * Adds a group of documents to a solr core
	 * 
	 * @param string                        $coreName
	 * @param array of (array of strings)   $documents
	 * @return unknown_type
	 * @author	Michael Chan <michael@kazaa.com>
	 */
	public function addDocuments($coreName, $documents, $allowDups = false, $overwritePending = true, $overwriteCommitted = true) {
		$returnResponse = null;
		$startTime = microtime(true);
		$solrPath = '/solr/'.$coreName;

		// remove score since its not a document field
		if (isset($document->score))
			unset($document->score);
			
		try {
	    	$response = $this->solrBalancer->addDocuments($solrPath,$documents,$allowDups,$overwritePending,$overwriteCommitted);
			if ($response->getHttpStatus() == 200) {
				$returnResponse = $response->response;

			} else {
				logError('Solr http status msg: ', $response->getHttpStatusMessage());
			}
			$store = 'SOLR';
		} catch (Exception $e) {
			logError('Solr server fatal error ', $e);
			throw new Exception('Solr Server fatal exception');
		}

		$this->selectTime = microtime(true) - $startTime;

		$logString = '[core: '.$coreName.'] ';
		$logString .= '[query: '.$query.'] ';
		$logString .= '[time: '.sprintf("%.2f",$this->selectTime).' secs]';
		logStd('SolrServer', $logString);
		return $returnResponse;
	}

	/**
	 * 
	 * deleteById
	 * Deletes a documents by Id in a solr core - Id is the value of the document's unique key field
	 * 
	 * @param string                        $coreName
	 * @param string   						$id
	 * @return unknown_type
	 * @author	Michael Chan <michael@kazaa.com>
	 */
	public function deleteById($coreName, $id, $fromPending = true, $fromCommitted = true) {
		$startTime = microtime(true);
		$solrPath = '/solr/'.$coreName;
		try {
	    	$response = $this->solrBalancer->deleteById($solrPath, $id, $fromPending, $fromCommitted);
			if ($response->getHttpStatus() == 200) {
				
				// store docs in cache
				$returnResponse = $response->response;

				$startTime1 = microtime(true);

				// [tim] Store object in memcache using gzip to get around the 1Mb memcache limit
				$memcache->save(gzdeflate(serialize($returnResponse)), $id);

			} else {
				logError('Solr http status msg: ', $response->getHttpStatusMessage());
			}
			$store = 'SOLR';
		} catch (Exception $e) {
			logError('Solr server fatal error ', $e);
			throw new Exception('Solr Server fatal exception');
		}

		$this->selectTime = microtime(true) - $startTime;

		$logString = '[core: '.$coreName.'] ';
		$logString .= '[id: '.$id.'] ';
		$logString .= '[time: '.sprintf("%.2f",$this->selectTime).' secs]';
		logStd('SolrServer', $logString);
		
	}
	
		/**
	 * 
	 * deleteById
	 * Deletes a documents by Id in a solr core - Id is the value of the document's unique key field
	 * 
	 * @param string                        $coreName
	 * @param string   						$id
	 * @return unknown_type
	 * @author	Michael Chan <michael@kazaa.com>
	 */
	public function deleteByQuery($coreName, $rawQuery, $fromPending = true, $fromCommitted = true) {
		$startTime = microtime(true);
		$solrPath = '/solr/'.$coreName;
		try {
	    	$response = $this->solrBalancer->deleteByQuery($solrPath, $rawQuery, $fromPending, $fromCommitted);
			if ($response->getHttpStatus() == 200) {
				
				// store docs in cache
				$returnResponse = $response->response;

				$startTime1 = microtime(true);

				// [tim] Store object in memcache using gzip to get around the 1Mb memcache limit
				$memcache->save(gzdeflate(serialize($returnResponse)), $id);

			} else {
				logError('Solr http status msg: ', $response->getHttpStatusMessage());
			}
			$store = 'SOLR';
		} catch (Exception $e) {
			logError('Solr server fatal error ', $e);
			throw new Exception('Solr Server fatal exception');
		}

		$this->selectTime = microtime(true) - $startTime;

		$logString = '[core: '.$coreName.'] ';
		$logString .= '[query: '.$rawQuery.'] ';
		$logString .= '[time: '.sprintf("%.2f",$this->selectTime).' secs]';
		logStd('SolrServer', $logString);
		
	}

	/**
	 * Query Solr. Provide the core to search, a starting offset
	 * for result documents, and the maximum number of result
	 * documents to return.
	 */
    public function select($coreName, $query = '', $fields = '', $offset = 0, $limit = 10, $exact = false, $sort = '', $solrParams = array()) {
		$startTime = microtime(true);

		$returnResponse = null;
		$version = '2.2';
		$indent = 'on';
		$queryType = 'standard';

		// construct the params for Solr
		$solrQuery = array($query);
		$solrPath = '/solr/'.$coreName;
		$solrParams['start'] = $offset;
		$solrParams['rows'] = $limit;
		$solrParams['indent'] = $indent;
		if ($sort) $solrParams['sort'] = $sort;
		$solrParams['fl'] = $fields;
		if ($exact) $solrParams['qt'] = $queryType;

		$startTime1 = microtime(true);
		// get memcache instance
		$registry = Zend_Registry::getInstance();
		$memcache = $registry->get('MEMCACHE');

 		$solrUseCache	= $registry->get('CONFIG')->solr->usecache;

 		// get id of query
 		$id = $this->makeId($coreName, $query, $solrParams);

		// try to get the solrQuery from memcached first
		if ($solrUseCache) {
			$store = 'MEMCACHED';
			$returnResponse = $memcache->load($id);
			try {
				// [tim] Retrieve object from memcache and ungzip
				// [tim] only unzip if response is a string
				if (is_string($returnResponse)) {
					$returnResponse = unserialize(gzinflate($returnResponse));
				}
			} catch (Exception $e) {
				logError('Solr could not inflate object from memcache ', $e);
				// Force retrieval from Solr further down
				$returnResponse = null;
			}
		} else {
			$memcache->remove($id); // clear cache entry to force to go to Solr
		}

		if (!$returnResponse) {
			try {
				$response = $this->solrBalancer->search($solrPath, $solrQuery, $offset, $limit, $solrParams);


				if ($response->getHttpStatus() == 200) {

					// store docs in cache
					$returnResponse = $response->response;

					$startTime1 = microtime(true);

					// [tim] Store object in memcache using gzip to get around the 1Mb memcache limit
					$memcache->save(gzdeflate(serialize($returnResponse)), $id);

				} else {
					logError('Solr http status msg: ', $response->getHttpStatusMessage());
				}
				$store = 'SOLR';
			} catch (Exception $e) {
				logError('Solr server fatal error ', $e);
				throw new Exception('Solr Server fatal exception');
			}
		}

		$size = mb_strlen(serialize($returnResponse), '8bit');
		$numFound = (isset($returnResponse->numFound))?$returnResponse->numFound:0;

		$this->selectTime = microtime(true) - $startTime;

		$logString = '[core: '.$coreName.'] ';
		$logString .= '[query: '.$query.'] ';
		$logString .= '[sort: '.$sort.'] ';
		$logString .= '[found: '.$numFound.'] ';
		$logString .= '[store: '.$store.'] ';
		$logString .= '[size: '.$size.'] ';
		$logString .= '[time: '.sprintf("%.2f",$this->selectTime).' secs]';
		logStd('SolrServer', $logString);

    	return $returnResponse;
	}

	public function getSelectTime() {
		return $this->selectTime;
	}
	
	

}