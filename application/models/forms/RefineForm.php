<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */
class RefineForm extends Zend_Form
{
	
	protected $_business;
	protected $_location;


	
	public function __construct($business, $location)
	{
		$this->_business = 	$business;	
		$this->_location =  $location;
		parent::__construct();
	}
	
	
    
	protected function buildQuickSearchElements()
	{
		// Quick search field
		$query = new Zend_Form_Element_Text('query');
		$query->setLabel('Refine Search:');
		$query->setAttrib('class','refineforminput');
		$this->addElement($query);

		// Quick search btn
        $quick_search = new Zend_Form_Element_Image('quicksearchbtn');
       	$quick_search->setImage('/images/sitetemplate/find-2-60.png');
       	$quick_search->setAttribs(array(
        	'rows' => 22,
        	'cols' => 60
    	)); 
    	$quick_search->setAttrib('onclick', 'return setsearch(1);');
       	$quick_search->setImageValue(true);
       	$this->addElement($quick_search);
		
	}
	
	protected function buildCat1Element()
	{
       	$cat1 = new Zend_Form_Element_Radio('cat1');
       	$cat1->setLabel($this->_business->getCat1Name());
       	 
       	$cat1->setMultiOptions($this->_business->getCat1Array());
       	//$cat1->setValue($this->_business->getFirstCat1());
       	//logfire('key',$this->_business->getFirstCat1());
       	$cat1->setValue($this->_business->getFirstCat1());
       	$cat1->setAttrib('class','refineformselect');
       	$this->addElement($cat1);
	}
	
	protected function buildCat2Element()
	{
		/*
		$cat2 = new Zend_Form_Element_Select('cat2');
       	$cat2->setLabel($this->_business->getCat2Name());
       	$cat2->addMultiOptions($this->_business->getCat2Array());
       	$cat2->setValue($this->_business->getFirstCat2());
       	$cat2->setAttrib('class','refineformselect');
       	$cat2->setAttrib('onchange','changeCat2(this.id,this.options[this.selectedIndex].value)');
       	$this->addElement($cat2);
		*/
		return null;
	}
	
	protected function buildCat3Element()
	{
		/*
       	$cat3 = new Zend_Form_Element_Select('cat3');
       	$cat3->setLabel($this->_business->getCat3Name());
       	$cat3->setAttrib('class','refineformselect');
       	$cat2selected = $this->cat2->getValue();
       	$cat3->addMultiOptions($this->_business->getCat3Array($cat2selected));
       	$this->addElement($cat3);
		*/
		return null;
	}
	
	protected function buildCat4Element()
	{
		/*
       	$cat4 = new Zend_Form_Element_Select('cat4');
       	$cat4->setLabel($this->_business->getCat4Name());
       	$cat4->setAttrib('class','refineformselect');
       	$cat4->setAttrib('onchange','changeState("cat5",this.options[this.selectedIndex].value)');
       	$cat4->addMultiOptions($this->_business->getCat4Array());
       	$this->addElement($cat4);
       	*/
		return null;		
	}
	
	protected function buildCat5Element()
	{
		/*
       	$cat5 = new Zend_Form_Element_Select('cat5');
       	$cat5->setLabel($this->_business->getCat5Name());
       	$cat5->setAttrib('class','refineformselect');
       	$cat4selected = $this->_business->getFirstCat4();
       	$cat5->addMultiOptions($this->_business->getCat5Array($cat4selected));
       	$this->addElement($cat5);
       	*/
		return null;		
	}
	
	
	protected function  buildExtraElements()
	{
		return null;
	}
	
	public function printExtraElements()
	{
		return null;
	}
		
	protected function buildLocationElements()
	{
		//$location = $this->_business->getLocation();
		$location = $this->_location;
    	
		// the rule number such 1,2 ,3,4
		$searchRule = $location->getSearchRule();
		
		// the rule Row include city, state,...
    	$searchRules = $location->getSearchRules();
    	
		// Some locaiton only has state.
    	if (!empty($searchRules->state))
    	{
	      	$state = new Zend_Form_Element_Select('stateid');
	       	$state->setLabel('State');
	       	$state->setAttrib('class','refineformselect');
	       	$state->addMultiOptions($location->getStateOptionsBycountryId());
	       	$state->setValue($location->getStateId());
	       	if (!empty($searchRules->city))
	       	{
	       		$state->setAttrib('onchange',"changeLocation('cityid',this.options[this.selectedIndex].value, '/ajax/location/changestate/')");
	       	}
	       	$this->addElement($state);    	
	       		
    	}
		
    	
		if (!empty($searchRules->city))
		{
	      	$city = new Zend_Form_Element_Select('cityid');
	       	$city->setLabel('City');
	       	$city->setAttrib('class','refineformselect');
	       	if ($searchRule == 1)
	       	{
	       		$city->addMultiOptions($location->getCityOptionsByStateId());
	       	}
	       	elseif($searchRule == 2)
	       	{
	       		$city->addMultiOptions($location->getCityOptionsBycountryId());
	       	}
	       	else
	       	{
	       		throw new Exception('Search rule design error for '. $location->getCountry());
	       	}
	       	$city->setValue($location->getCityId());
	       	if (!empty($searchRules->region))
	       	{
	       		$city->setAttrib('onchange',"changeLocation('regionid',this.options[this.selectedIndex].value, '/ajax/location/changecity/')");
	       	}
	       	
	       	$this->addElement($city);  

	     
		}

		
		
		// Some locaiton only has state.
    	if (!empty($searchRules->region))
    	{
	      	$region = new Zend_Form_Element_Select('regionid');
	       	$region->setLabel('Region');
	       	$region->setAttrib('class','refineformselect');
	       	$region->addMultiOptions($location->getRegionOptionsByCityId());
	       	$region->setValue($location->getRegionId());
	       	//$region->setValue($location->getState());
    		if (!empty($searchRules->suburb))
	       	{
	       		$region->setAttrib('onchange',"changeLocation('suburbid',this.options[this.selectedIndex].value, '/ajax/location/changeregion/')");
	       	}	       	
	       	$this->addElement($region);    		
    	}
		
		// Some locaiton only has state.
    	if (!empty($searchRules->suburb))
    	{
	      	$suburb = new Zend_Form_Element_Select('suburbid');
	       	$suburb->setLabel('Suburb');
	       	$suburb->setAttrib('class','refineformselect');
	       	$suburb->addMultiOptions($location->getSuburbOptionsByRegionId());
	       	$suburb->setValue($location->getSuburbId());
	       	$this->addElement($suburb);    		
    	}
    	
	}
	
	/*
	public function printLocationElements()
	{
		echo 
		
		echo $this->city;
	    echo $this->state;
		echo $this->country;
		echo $this->region;

	}
	*/	
	/**
	 * build Listing Form
	 * @see library/CrFramework/CrFramework_Form#init()
	 */
	public function init()
	{
		logfire('dsfsdf','sdfsdfdsfs');
		$this->setMethod('post');
		$this->setName('refineform');

				
		$this->buildQuickSearchElements();

		$this->buildCat1Element();
		
		$this->buildCat2Element();
		
		$this->buildCat3Element();
		
		$this->buildCat4Element();
		
		$this->buildCat5Element();
		
		$this->buildExtraElements();
       	
       	$this->buildLocationElements();
       	
       	$this->addElement(Common::createHiddenElement('searchtype', ''));
       	$this->addElement(Common::createHiddenElement('locationid', $this->_location->getLocationId()));
       
       	$this->setAction('/refine/'.strtolower($this->_business->getBusinessType()));
       	
       	
       	/*
       	$cat4 = new Zend_Form_Element_Select('cat4');
       	$cat4->setLabel($this->_cat4Name);
       	
       	$cat3->addMultiOptions($this->_business->getCat3Options($cat1selectArray[0]));
       	$this->addElement($cat3);
       	
       	$cat3 = new Zend_Form_Element_Select('cat5');
       	$cat3->setLabel($this->_cat3Name);
       	
       	$cat1selectArray = explode('|', $this->_business->getFirstCat2Option());
       	$cat3->addMultiOptions($this->_business->getCat3Options($cat1selectArray[0]));
       	$this->addElement($cat3);
       	*/
       	
       			// Quick search btn
        $submit = new Zend_Form_Element_Image('submit');
       	$submit->setImage('/images/sitetemplate/find-2-80.png');
       	$submit->setAttribs(array(
        	'rows' => 22,
        	'cols' => 80
    	));
    	$submit->setAttrib('onclick', 'return setsearch(2);'); 
       	$submit->setImageValue(true);
       	$this->addElement($submit);
       	
       	
        
 		
        //$this->addAttribs(array('onsubmit'=>'beforeSubmit()'));
		// use view script to render form
		$this->setDecorators(array(
			'FormElements',
			array('ViewScript', array(
    		'viewScript' => 'forms/_refineform.phtml',
    		'class'      => 'hotspotform',
			'placement' => false
				)),
			'Form'
		));
        
	}
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#populate()
	 */
	public function populate(array $values)
	{
		/*
		// Job specifically.
		if ( (!array_key_exists('cat4',$values) || empty($values['cat4'])) && array_key_exists('state',$values) && !empty($values['state']) )
		{
			$values['cat4'] = Location::getStateIdByName($values['state']);
		}

		// Job specifically.
		//	if ( (!array_key_exists('cat5',$values) || empty($values['cat5'])) && array_key_exists('city',$values) && !empty($values['city']) )
		// In case it comes from the links on the header.
		if ( array_key_exists('city',$values) && !empty($values['city']) )
		{
			$values['cat5'] = Location::getCityIdByName($values['city']);
			
		}
		
		
		if(array_key_exists('cat2',$values) && !empty($values['cat2']))
		{
			$this->cat3->setMultiOptions($this->_business->getCat3Array($values['cat2']));
		}
			
		if(array_key_exists('cat4',$values) && !empty($values['cat4']))
		{
			$this->cat5->setMultiOptions($this->_business->getCat5Array($values['cat4']));
		}
*/
		if(array_key_exists('cat1',$values) && empty($values['cat1']))
		{
			unset($values['cat1']);
		}

		if(array_key_exists('cat2',$values) && empty($values['cat2']))
		{
			unset($values['cat2']);
		}

		if(array_key_exists('cat3',$values) && empty($values['cat3']))
		{
			unset($values['cat3']);
		}
			
		if(array_key_exists('cat4',$values) && empty($values['cat4']))
		{
			unset($values['cat4']);
		}

		if(array_key_exists('cat5',$values) && empty($values['cat5']))
		{
			unset($values['cat5']);
		}		
		
		
		// Call the father's render function.
		return parent::populate($values);
	}
	
	public function getSearchResultsWrap($hintResult)
	{
		$retstr = '<div class="searchresult">';
		$retstr .= 'Below shows the <span class="emphasis">lastest</span> postings for ';
		
		
		$location = '';
		$searchRules = $this->_location->getSearchRules();
		
		//if (!empty())
		
		
	//	logfire('search resutl searchrule', $searchRule);
		
		$suburb = $this->_location->getSuburb();
		if (!empty($searchRules->suburb) || !empty($suburb))
		{

			$location = $suburb;
		}
		
		$region = $this->_location->getRegion();
		if (!empty($searchRules->region) || !empty($region))
		{
			if (empty($location))
			{
				$location = $region;
			}
			else
			{
				$location .= ', ' .$region;
			}
		}
		
		$city = $this->_location->getCity();
		if (!empty($searchRules->city) || !empty($city))
		{
			if (empty($location))
			{
				$location = $city;
			}
			else
			{
				$location .= ', ' . $city;
			}
		}
		
		$state = $this->_location->getState();
		if (!empty($searchRules->state) || !empty($state))
		{
			if (empty($location))
			{
				$location = $state;
			}
			else
			{
				$location .= ', ' . $state;
			}
		}

		$country = $this->_location->getCountry();
		if (!empty($country))
		{
			if (empty($location))
			{
				$location = $country;
			}
			else
			{
				$location .= ', ' . $country;
			}
		}		
		
		$retstr .= '<span class="emphasis">' . $hintResult  . '</span> ';
		$retstr .= 'in <span class="emphasis">' . $location .'</span>. ';
		$retstr .= '</div>';	
		
		return $retstr;
		
	}
	
	public function getSearchResults($categoty, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null)
	{
				
		$findstr = $this->_getSearchHint($categoty, $cat1, $cat2, $cat3, $cat4, $cat5);
		
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
		
		return $this->getSearchResultsWrap($findstr);
	}
	
	protected function _getSearchHint($category, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $Cat5 = null)
	{
		if (empty($cat1))
		{
			return 'ALL ' .  $category;
		}  
		else
		{
			return  $this->_business->getCat1NameById($cat1) . ' ' . $category;	
		}		
	}

}
