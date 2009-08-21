<?php
/**
 * Weather Controller
 * 
 *      @version	$Id: WeatherController.php 4342 2009-04-09 05:51:01Z timw $
 *      @package	Application
 *      @subpackage	Controllers
 *      @author		Sandrine Reboul <sandrine@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

class WeatherController extends CrFramework_Controller_Action {
	protected $location;

	public function setlocationAction(){//used in ajax 

	try {
			$common = new Common();
			$datasUser= $common->GeoIPArray();
			$timeZone = DateTimeZone::listIdentifiers();
			
			$townRandom[0] = array('city' =>'Los Angeles','timezone'=>'America/Los_Angeles','state'=>'Ca');
			$townRandom[1] = array('city' =>'New york'   ,'timezone'=>'America/New_York','state'=>'Ny');
			$townRandom[2] = array('city' =>'Tennessee'  ,'timezone'=>'America/Chicago','state'=>'Il');
			$townRandom[3] = array('city' =>'Denver'     ,'timezone'=>'America/New_York','state'=>'Ny');
			$townRandom[4] = array('city' =>'Las vegas'  ,'timezone'=>'America/Denver','state'=>'Nv');
			   
			if (( Zend_Controller_Action::_getParam('name')=='autodetect' )){
				$city_name=strtolower(Tag::myUrlEncode($datasUser['city']));
				$state_code=strtolower(Tag::myUrlEncode($datasUser['region']));
				$this->view->locationweather = ucfirst($city_name).', '.ucfirst($state_code);//always a state from geoip
				
				$timezoneUser=$datasUser['timezone'];
				if (empty($timezoneUser)){//in case there is a  bug
					$nbtown=count($townRandom);
					$whichone=rand(0,$nbtown-1);
					$this -> view -> locationweather =$townRandom[$whichone]['city'].', '.$townRandom[$whichone]['state'];
					$timezoneUser    =  $townRandom[$whichone]['timezone'];
					logEmpty('Weather issue: ',Tag::myUrlEncode($datasUser['city']));
				}
				setcookie("yellowpages_location",'',-1);//delete cookie
				
			}elseif(strpos(Zend_Controller_Action::_getParam('name'), '*') ){//submit search - basic 
	
				$city=str_replace('*','',Zend_Controller_Action::_getParam('name'));

				$citys=explode(',',$city);
				$city_name=trim(strtolower($citys[0]));
				$state_code=isset($citys[1]) && $citys[1]!='' ? trim(strtolower($citys[1])): '';
				$this -> view -> locationweather = $state_code!='' ? ucfirst($city_name).", ".ucfirst($state_code) : ucfirst($city_name);
				$coord= $this -> getCoordinates( $city_name,$state_code);

				$timezoneUser    = $coord['timezone'];
		
				if (empty($timezoneUser)){//in case of bug
					$nbtown=count($townRandom);
					$whichone=rand(0,$nbtown-1);
					$this -> view -> locationweather =ucfirst($townRandom[$whichone]['city']).', '.ucfirst($townRandom[$whichone]['state']);
					$timezoneUser    =  $townRandom[$whichone]['timezone'];
					logEmpty('Weather issue: ',$city);
				}
				setcookie("yellowpages_location",'',-1);//delete cookie
			} elseif (isset($_COOKIE["yellowpages_location"])){ //if there is a cookie
			
				$this->view->locationweather =$_COOKIE["yellowpages_location"];

				$city=explode(',',$_COOKIE["yellowpages_location"]);
				$city_name=strtolower($city[0]);
				$state_code=isset($citys[1]) && $citys[1]!='' ? trim(strtolower($citys[1])): '';
					
				$coord= $this -> getCoordinates( $city_name,$state_code);

				$timezoneUser    = $coord['timezone'];
				if (empty($timezoneUser)){//in case of bug
					$nbtown=count($townRandom);
					$whichone=rand(0,$nbtown-1);
					$this -> view -> locationweather =$townRandom[$whichone]['city'].', '.$townRandom[$whichone]['state'];
					$timezoneUser    =  $townRandom[$whichone]['timezone'];
					logEmpty('Weather issue: ',$_COOKIE["yellowpages_location"]);
				}
			} else {

				$varcity=Zend_Controller_Action::_getParam('name');
				if(empty($varcity)){//then its first page

					$this->view->locationweather = ucfirst(strtolower(Tag::myUrlEncode($datasUser['city']))).', '.ucfirst(strtolower(Tag::myUrlEncode($datasUser['region'])));

					$timezoneUser=$datasUser['timezone'];
					if (empty($timezoneUser)){//in case there is a  bug
						$nbtown=count($townRandom);
						$whichone=rand(0,$nbtown-1);
						$this -> view -> locationweather =$townRandom[$whichone]['city'].', '.$townRandom[$whichone]['state'];
						$timezoneUser    =  $townRandom[$whichone]['timezone'];
						logEmpty('Weather issue: ',Tag::myUrlEncode($datasUser['city']));
					}

				}else{//save for the future
					$citys=explode(',',$varcity);
					$city_name=strtolower($citys[0]);
					$state_code=isset($citys[1]) && $citys[1]!='' ? trim(strtolower($citys[1])): '';
					
					$this -> view -> locationweather = $state_code!='' ? ucfirst($city_name).", ".ucfirst($state_code) : ucfirst($city_name);
				

					$coord = $this->getCoordinates($city_name,$state_code);

					$timezoneUser    = $coord['timezone'];
					if (empty($timezoneUser)){//in case of bug
						$nbtown=count($townRandom);
						$whichone=rand(0,$nbtown-1);
						$this -> view -> locationweather =$townRandom[$whichone]['city'].', '.$townRandom[$whichone]['state'];
						$timezoneUser    =  $townRandom[$whichone]['timezone'];
						logEmpty('Weather issue: ',$_COOKIE["yellowpages_location"]);
					}
				}
				
				
				
			}
			
			$city=trim($this->view->locationweather);
			
			$googleapiweather ='http://www.google.com/ig/api?weather='.$city.','.$datasUser['country_name'];	

			//time
			if(isset($timezoneUser) && in_array($timezoneUser,$timeZone)){
				//changed by xinghao 27/02/2009 for feature #97
				$timeUser = $common->getTimeByTimeZone($timezoneUser);				
				$this->view->hours		= $timeUser["hours"];
        		$this->view->minutes	= $timeUser["minutes"];
		
			}else{//in case of bug display local time from server 
				//changed by xinghao 27/02/2009 for feature #97
				$timeUser = $common->getLocalTime();			
				$this->view->hours		= $timeUser["hours"];
        		$this->view->minutes	= $timeUser["minutes"];				
			}
			if( Zend_Controller_Action::_getParam('cookie')=='yes')//if saved for future => creating cookie
			{
				
				setcookie("yellowpages_location", $this -> view -> locationweather,time()+60*60*24*30*2 );	
			}
	
		
			//get  the xml for the weather
			$xml=simplexml_load_file($googleapiweather);
			if($xml->weather->current_conditions->condition['data']){
				
				//current weather
				$this -> view -> currentWeather = $xml->weather->current_conditions->condition['data'];
				$this -> view -> currentTemperature = $xml->weather->current_conditions->temp_f['data'];
				$this -> view -> picture = 'http://www.google.com/ig'.$xml->weather->current_conditions->icon['data'];
				
				//tomorrow weather
				$this -> view -> tomorrowDay     =$xml->weather->forecast_conditions[0]->day_of_week['data'];
				$this -> view -> tomorrowLow     =$xml->weather->forecast_conditions[0]->low['data'];
				$this -> view -> tomorrowHigh    =$xml->weather->forecast_conditions[0]->high['data'];
				$this -> view -> tomorrowIcon    ='http://www.google.com/ig'.$xml->weather->forecast_conditions[0]->icon['data'];
				$this -> view -> tomorrowWeather =$xml->weather->forecast_conditions[0]->condition['data'];
			
				
			}else{
				$this -> view -> currentWeather = '';
				$this -> view -> currentTemperature ='';
				$this -> view -> picture = '';
				
				//tomorrow weather
				$this -> view -> tomorrowDay     ='Sorry, The weather is not available for this town.';
				$this -> view -> tomorrowLow     ='';
				$this -> view -> tomorrowHigh    ='';
				$this -> view -> tomorrowIcon    ='';
				$this -> view -> tomorrowWeather ='';
			}

		$this -> view -> locationweather =Tag::nameDecode($this -> view -> locationweather);
		} catch (Exception $e) {
			logError('WeatherController', $e->getMessage());
		}
	}
	

	function getCoordinates($city,$state=''){

		try{
			$coord = array();
			$coord['state']		= '';
			$coord['timezone']	= '';
			
			//Solr Request
			$query = "city_exact:\"".trim($city)."\"";
			if($state!='')$query .= " and state_exact:\"".trim($state)."\"";
			
	     	$fields ='zip-code,latitude,longitude,city,state,county';

	    	$this->solrQuery	= new SolrQuery();
	    	$response = $this->solrQuery-> getCoordByCity($query,$fields);

			if ($response->numFound>0) {
				$coord['state']=isset($response->docs[0]->state) ?$response->docs[0]->state : '';
				$coord['timezone'] =Timezone::getTimezone('US',$coord['state']);
	
			}	
			return $coord;
		} catch (Exception $e) {
			logError('WeatherController::getCoordinates()', $e->getMessage());
		}
	}
	
	
}
?>
