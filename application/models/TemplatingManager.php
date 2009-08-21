<?php
/*
 * Templating system manager.
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class TemplatingManager 
{
	// Flag to use text version template.
	const TEXTTEMPLATE = 1;
	
	// Flag to use html version template.
	const HTMLTEMPLATE = 2;
	
	// Html template.
	
	// Legal template.
	const HTMLLOCATIONPATH = 'web/location_html.phtml';

	
	// Text template

	//const VIEWSCRIPTPATH = '../../html/public/template';

	/**
	 * Get Legal string from template.
	 * @param $templateType
	 * @return String
	 */
	public static function getLocationOption($templateType = null)
	{
		try{
			// Get Templating script path.
			$registry = Zend_Registry::getInstance();
			$scriptPath = $registry->get('TEMPLATINGSYSTEMPATH');
			
			// Set view path.
			$view = new Zend_View();
			$view->addScriptPath($scriptPath);
			
			// Get html/text template file name
			if ($templateType == self::HTMLTEMPLATE)
			{
				$scriptFile = self::HTMLLOCATIONPATH;
			} 
			else
			{
				$scriptFile = self::HTMLLOCATIONPATH;
			}
			
			// Get view string.
			return $view->render($scriptFile);
			
		}catch(Exception $e)
		{
			logError('Read location template file failed! does this file exist or do we have proper rights to read?', $e);
			//echo $e;
			throw $e;
		}
	}
	
	
	/**
	 * Get Package descripton.
	 * @param $product_code
	 * @param $publisherName
	 * @param $bookname
	 * @return unknown_type
	 */
	public static function getPackageDescription($product_code, $publisherName, $bookname = '', $templateType = null)
	{
		try{
			// Get Templating script path.
			$registry = Zend_Registry::getInstance();
			$scriptPath = $registry->get('TEMPLATINGSYSTEMPATH');
			
			// Set view path.
			$view = new Zend_View();	
			$view->setScriptPath($scriptPath);
			
			$view->publisher_name = $publisherName;
			$view->book_name = $bookname;

			// Get html/text template file name
			if ($templateType == self::HTMLTEMPLATE)
			{
				$scriptFile = self::HTMLPACKAGEDESCRIPTIONPATH;
			} 
			else
			{
				$scriptFile = self::TEXTPACKAGEDESCRIPTIONPATH;
			}
			
			// Return view string.
			$rendScriptPath = 'web/' . strtolower($product_code) . $scriptFile;
			return $view->render($rendScriptPath);
			
		}catch(Exception $e)
		{
			logError('Read package description template file failed! does this file exist or do we have proper rights to read?', $e);
			//echo $e;
			throw $e;
		}
	}
	

	/**
	 * Get lastest receipt template.
	 * @param $listing_id
	 * @return unknown_type
	 */
	public static function getLastestReceipt($listing_id, $receipt_number = null, $templateType = null)
	{
		try{
			// Get Templating script path.
			$registry = Zend_Registry::getInstance();
			$scriptPath = $registry->get('TEMPLATINGSYSTEMPATH');
			
			// Set view path.
			$view = new Zend_View();	
			$view->setScriptPath($scriptPath);
			     	    		
			// Set all the listing detail, subscription detail etc to view 
			// so that the view script can user those data.
			$view = self::_setListingSubscriptionPublisherDataToView($listing_id, $view, $templateType);

			$view->receipt_number = $receipt_number;
			
			
			// Get html/text template file name
			if ($templateType == self::HTMLTEMPLATE)
			{
				$scriptFile = self::HTMLRECEIPTPATH;
			} 
			else
			{
				$scriptFile = self::TEXTRECEIPTPATH;
			}
			
			// Return view string.
			//$rendScriptPath = strtolower($product_code) . self::PACKAGEDESCRIPTIONPATH;
			return $view->render($scriptFile);
			
		}catch(Exception $e)
		{
			logError('Read cancel subscription template file failed! does this file exist or do we have proper rights to read?', $e);
			throw $e;
		}		
	}
		
	/**
	 * Get cancel subscription template.
	 * @param $listing_id
	 * @return unknown_type
	 */
	public static function getCancelSubscription($listing_id, $templateType = null)
	{
		try{
			// Get Templating script path.
			$registry = Zend_Registry::getInstance();
			$scriptPath = $registry->get('TEMPLATINGSYSTEMPATH');
			
			// Set view path.
			$view = new Zend_View();	
			$view->setScriptPath($scriptPath);
			     	    		
			// Set all the listing detail, subscription detail etc to view 
			// so that the view script can user those data.
			$view = self::_setListingSubscriptionPublisherDataToView($listing_id, $view, $templateType);

			// Get html/text template file name
			if ($templateType == self::HTMLTEMPLATE)
			{
				$scriptFile = self::HTMLCANCELSUBSCRIPTIONPATH;
			} 
			else
			{
				$scriptFile = self::TEXTCANCELSUBSCRIPTIONPATH;
			}
			
			// Return view string.
			//$rendScriptPath = strtolower($product_code) . self::PACKAGEDESCRIPTIONPATH;
			return $view->render($scriptFile);
			
		}catch(Exception $e)
		{
			logError('Read cancel subscription template file failed! does this file exist or do we have proper rights to read?', $e);
			throw $e;
		}		
	}

	/**
	 * Get subscription registration template.
	 * @param $listing_id
	 * @return unknown_type
	 */
	public static function getSubscriptionRegistration($listing_id, $templateType = null)
	{
		try{
			// Get Templating script path.
			$registry = Zend_Registry::getInstance();
			$scriptPath = $registry->get('TEMPLATINGSYSTEMPATH');
			
			// Set view path.
			$view = new Zend_View();	
			$view->setScriptPath($scriptPath);
			     	    		
			// Set all the listing detail, subscription detail etc to view 
			// so that the view script can user those data.
			$view = self::_setListingSubscriptionPublisherDataToView($listing_id, $view, $templateType);

			// Get html/text template file name
			if ($templateType == self::HTMLTEMPLATE)
			{
				$scriptFile = self::HTMLREGISTRATIONPATH;
			} 
			else
			{
				$scriptFile = self::TEXTREGISTRATIONPATH;
			}
			
			// Return view string.
			//$rendScriptPath = strtolower($product_code) . self::PACKAGEDESCRIPTIONPATH;
			return $view->render($scriptFile);
			
		}catch(Exception $e)
		{
			logError('Read cancel subscription template file failed! does this file exist or do we have proper rights to read?', $e);
			throw $e;
		}		
	}	
	/**
	 * Set all the listing detail and subscription detail to view.
	 *    1. listing detail (basic info, keywords, categories etc)
	 *    2. current publisher info.
	 *    3. subscription detail (payment card, payment history etc)
	 *    4. current time.
	 *    5. current listing's business detail page url.  
	 *    6. current subscripiton's package.
	 *    7. ypex legal.    
	 * @param $listing_id
	 * @param $view
	 * @return zend_view
	 */
	protected static function _setListingSubscriptionPublisherDataToView($listing_id, $view, $templateType = null)
	{
		//   1. listing detail (basic info, keywords, categories etc)
		$view = self::_setListingDataToView($listing_id,$view);
			
		//   2. current publisher info.
		$view = self::_setPublisherDataToView($view->listing_publisher_id, $view);
		
		//   3. subscription detail (payment card, payment history etc)	
		//logfire('1', $listing_id);
		$view = self::_setSubscriptionDataToView($listing_id, $view);
		
		// 	 4. current time.
		$tmp = new DateTime();			
    	$view->now = date_format($tmp,"m/d/y h:ia");

    	// 	 5. current listing's business detail page url.
    	$view->businessURL = self::_getBusinessURL($listing_id, $view->listing_business_name);
 
    	//   6. current subscripiton's package.
		$view->packageDescription = self::getPackageDescription($view->subscription_product_code, $view->publisher_publisher_name, null, $templateType);
   		
		//   7. ypex legal.
		$view->ypexLegal = self::getLegal($templateType);
		
		
		return $view;
		
	}
	
	
	/**
	 * Set listing detail to view (basic info, keywords, categories etc)
	 * @param $listing_id
	 * @param $view
	 * @exception Exception
	 */
	protected static function _setListingDataToView($listing_id, $view)
	{
		// Valid listing id.
		Listings::validateListingId($listing_id);
		
		// get listing detail.
		$listingsTable = new Listings();
		$listing = $listingsTable->getListing($listing_id);

		if (empty($listing))
		{
			throw new Exception('[TemplatingManager][setListingDataToView] :Can not get listing info for listing[listing_id = ' . $listing_id .']');
		}
		
		foreach($listing->toArray() as $key=>$value)
		{
			$keyname = 'listing_' . $key;
			$view->$keyname = $value;
			//echo $keyname . "\n";
		}
		
		$bdcs = $listingsTable->getListingBDCs($listing_id);
		
		$categories = '';
		if (!empty($bdcs))
		{
			foreach($bdcs as $bdc)
			{
				if (empty($categories))
				{
					$categories .= $bdc->getName();	
				}
				else
				{
					$categories .= ', ' .$bdc->getName();
				}
				
			}
		}
		$view->listing_categories = $categories;
		
	    // Get current listing's keywords.
		$keywordsTable = new ListingKeywords();
		$keywords = $keywordsTable->getListingKeywords($listing_id);
		
		$keywordsString = '';
		if (!empty($keywords))
		{
			foreach($keywords as $keyword)
			{
				if (empty($keywordsString))
				{
				   $keywordsString .= $keyword;
				}
				else
				{
					$keywordsString .= ', ' . $keyword;
				}
			}
		}
		$view->listing_keywords = $keywordsString;
		
		return $view;
	}
	
	/**
	 * Set publisher detail to view.
	 * @param $publisher_id
	 * @param $view
	 * @exception Exception
	 */
	protected static function _setPublisherDataToView($publisher_id, $view)
	{
		if (empty($publisher_id))
		{
			throw new Exception('[TemplatingManager][setPublisherDataToView] :Can not get publisher info for publisher[publisher id = ' . $publisher_id .']');
		}
		
		$publishersTable = new Publishers();
		$publisher = $publishersTable->getPublisherByPublisherId($publisher_id);
		
		if (empty($publisher))
		{
			throw new Exception('[TemplatingManager][setPublisherDataToView] :Can not get pubisher info for publisher[publisher id = ' . $publisher_id .']');
		}
		
		foreach($publisher->toArray() as $key=>$value)
		{
			$keyname = 'publisher_' . $key;
			$view->$keyname = $value;
			//echo $keyname . "\n";
		}
		
		return $view;
	}
	
	/**
	 * Get subscription info.
	 * @param $listing_id
	 * @return unknown_type
	 */
	protected static function _setSubscriptionDataToView($listing_id, $view)
	{
		// Valid listing id.
		Listings::validateListingId($listing_id);
		
		// Get subscription of current lisitng.
		$subscription = new Subscription($listing_id);
		
		// If current lisitng does not have a subscription we jsut return. 
		if (!$subscription->isSubscribed())
		{
			return $view;
		}
		
		// Get general subscription info (lisitng_id, publisher_id etc)
		
		$subscriptionGeneral = $subscription->getGeneralSubscriptionInfoArray();
		if (!empty($subscriptionGeneral))
		{
			foreach($subscriptionGeneral as $key=>$value)
			{
				$keyName = 'subscription_' . $key;
				$view->$keyName = $value;
				//echo $keyName . "\n";
			}
			// Change postgres timestamp format to ypex datetime format.
			$view->subscription_start_date = Common::getTimeByMonthDayYearHourMinute($view->subscription_start_date);
			$view->subscription_expiry_date = Common::getTimeByMonthDayYearHourMinute($view->subscription_expiry_date);
			
			// Get sales person name.
			$usersTable = new Users;
			$view->subscription_sales_person = $usersTable->getUserNamebyId($view->subscription_sales_person);
		}
		
		
		// Get price and product of current subscription.
		$priceAndProduct = $subscription->getPriceContractArray();
		
		if (!empty($priceAndProduct))
		{
			foreach($priceAndProduct as $key=>$value)
			{
				$keyName = 'subscription_' . $key;
				$view->$keyName = $value;
				//echo $keyName . "\n";
			}
		}
		
		// Get last successful billing history
		$lastSuccessfulHistory = $subscription->getLastSuccessfulBillHistory();
		if (!empty($lastSuccessfulHistory))
		{
			foreach($lastSuccessfulHistory as $key=>$value)
			{
				$keyName = 'subscription_successful_' . $key;
				$view->$keyName = $value;
				//echo $keyName . "\n";
			}
			// Change postgres timestamp format to ypex datetime format.
			$view->subscription_successful_payment_datetime = Common::getTimeByMonthDayYearHourMinute($view->subscription_successful_payment_datetime);
			
		}		
		
		
		// Get Payment card info.
		$paymentCard = $subscription->getPaymentCardArrayWithHashedName();
		if (!empty($paymentCard))
		{
			foreach($paymentCard as $key=>$value)
			{
				$keyName = 'subscription_' . $key;
				$view->$keyName = $value;
				//echo $keyName . "\n";
			}
		}		
		return $view;
		
		
	}
	/**
	 * Get business detail page's url.
	 * @param $listing_id
	 * @param $business_name
	 * @return string
	 */
	protected static function _getBusinessURL($listing_id, $business_name)
	{
    	// Get web host name form registry (http://ypex.com).
    	$registry = Zend_Registry::getInstance();
		$config = $registry->get('CONFIG');
        $hostName =  $config->website->host;
        
        // Create a std class and pass it to Tag::url function to 
        // build business detail page uri.
		$doc = new stdClass();
    	$doc->business_name = $business_name;
    	$doc->listing_id = $listing_id;
        
    	// Get business detail page's url.
    	 return $hostName . Tag::url('businessBase', $doc);
		
	}
}    
?>
