<?php
class RealestateDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General','About', 'Photo', 'Contact');
	protected $_businessType = "Real estates";
	public $formTabSeq = 4;

	public function setCategory()
	{
		$pstHomeTables = new Psthome();
		$this->_pstCategory = $pstHomeTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();


		$location = new Location($this->_posting->locId);


		$contentArray[] = array(
							'head' => 'Location:',
							'value' => $location->getLocationString(),
							'cssClass' =>''
							);



		$categoryTable =new Refcategory();
		$contentArray[] = array(
							'head' => 'Property Type:',
							'value' => $categoryTable->getCatNameById($this->_posting->cat3),
							'cssClass' =>''
							);


		$contentArray[] = array(
							'head' => 'Bedrooms:',
							'value' => Tag::getUnitsAmount($this->_pstCategory->rooms),
							'cssClass' =>''
							);
		$contentArray[] = array(
							'head' => 'Bathrooms:',
							'value' => Tag::getUnitsAmount($this->_pstCategory->baths),
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Parking:',
							'value' => Tag::getUnitsAmount($this->_pstCategory->parking),
							'cssClass' =>''
							);


		if (!empty($this->_pstCategory->buildingArea))
		{
		$contentArray[] = array(
							'head' => 'Building Area:',
							'value' => $this->_pstCategory->buildingArea. 'm&sup2',
							'cssClass' =>''
							);
		}

		if (!empty($this->_pstCategory->landArea))
		{
			$contentArray[] = array(
							'head' => 'Land Area:',
							'value' => $this->_pstCategory->landArea . 'm&sup2',
							'cssClass' =>''
							);
		}
		$contentArray[] = array(
							'head' => 'Property Age:',
							'value' => Tag::getAges($this->_pstCategory->age),
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Morning Sun Dir:',
							'value' => $this->_pstCategory->sunDirection,
							'cssClass' =>''
							);
		$contentArray[] = array(
							'head' => 'Views of:',
							'value' => $this->_pstCategory->views,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Levels in Building:',
							'value' => $this->_pstCategory->buildingLevel,
							'cssClass' =>''
							);
		$contentArray[] = array(
							'head' => 'Property is on floor:',
							'value' => $this->_pstCategory->level,
							'cssClass' =>''
							);

		if (!empty($this->_pstCategory->strataRate))
		{
		$contentArray[] = array(
							'head' => 'Strata Rate:',
							'value' => $location->getCurrencySymbol() . $this->_pstCategory->strataRate .  ' per quarter',
							'cssClass' =>''
							);
		}

		if (!empty($this->_pstCategory->councilRate))
		{

		$contentArray[] = array(
							'head' => 'Council Rate:',
							'value' => $location->getCurrencySymbol() . $this->_pstCategory->councilRate.  ' per quarter',
							'cssClass' =>''
							);
		}

		if (!empty($this->_pstCategory->waterRate))
		{

							$contentArray[] = array(
							'head' => 'Water Rate:',
							'value' => $location->getCurrencySymbol() . $this->_pstCategory->waterRate.  ' per quarter',
							'cssClass' =>''
							);
		}

		$contentArray[] = array(
							'head' => 'Best Features:',
							'value' =>  $this->_pstCategory->bestFeatures,
							'cssClass' =>''
							);




		$this->printTable($contentArray, true);
		/*
		echo '<table>';

		echo '<tr>';
		echo '<th> </th>';
		echo '<td>' . $this->getCatsString() . '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<th>Location: </th>';


		echo '<td>' . $location->getLocationString() . '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<th>Salary Info: </th>';
		echo '<td>' . $this->_pstCategory->priceInfo . '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<th>Requried Skills: </th>';
		echo '<td>' . $this->_pstCategory->skills . '</td>';
		echo '</tr>';

		echo '</table>';
		*/
	}

	public function getTab2Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Short Description:',
							'value' => $this->_pstCategory->shortDescription,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Property Description:',
							'value' => $this->_pstCategory->fullDescription,
							'cssClass' => ''
							);

		if (!empty($this->_pstCategory->features))
		{
			$reffeatures = new Reffeature();
			$features = $reffeatures->getFeatures($this->_pstCategory->features, $this->_posting->typeID);

			if (!empty($features))
			{
				$featureArray = array();
				foreach($features as $feature)
				{
					$featureArray[] = '-  ' . $feature->feature;
				}

				$contentArray[] = array(
									'head' => 'Features:',
									'value' => Tag::simpleTable($featureArray, 3, 'featurelist', true),
									'cssClass' => ''
									);
			}
		}

		$this->printTable($contentArray);
	}

	public function getTab4Content()
	{
		$contentArray = array();


		$contentArray[] = array(
							'head' => 'Real Estate:',
							'value' => '',
							'cssClass' => ''
							);



		$contentArray[] = array(
							'head' => 'Contact 1:',
							'value' => $this->strAdd($this->_pstCategory->contactName1 , $this->_pstCategory->contactPhone1),
							'cssClass' => ''
							);
/*
		$contentArray[] = array(
							'head' => 'Contact 1 Phone:',
							'value' => $this->_pstCategory->contactPhone1,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Contact 1 Email:',
							'value' => $this->_pstCategory->contactEmail1,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '',
							'value' => '',
							'cssClass' => ''
							);
*/
		$contentArray[] = array(
							'head' => 'Contact 2:',
							'value' => $this->strAdd($this->_pstCategory->contactName2 , $this->_pstCategory->contactPhone2),
							'cssClass' => ''
							);
/*
		$contentArray[] = array(
							'head' => 'Contact 2 Phone:',
							'value' => $this->_pstCategory->contactPhone2,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Contact 2 Email:',
							'value' => $this->_pstCategory->contactEmail2,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => '',
							'value' => '',
							'cssClass' => ''
							);
*/

		$contentArray[] = array(
							'head' => 'Contact Info:',
							'value' => $this->_pstCategory->contactInfo,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Auction Date:',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->auctionDate),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Auction Address:',
							'value' => $this->_pstCategory->auctionLocation,
							'cssClass' => ''
							);

		if (!empty($this->_pstCategory->inspection1Date) && !empty($this->_pstCategory->inspection1StartTime) && !empty($this->_pstCategory->inspection1EndTime))
		{
			$contentArray[] = array(
								'head' => 'Inspection Info:',
								'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection1Date) . ': ' . Tag::getHourMinute($this->_pstCategory->inspection1StartTime) . ' ~ ' . Tag::getHourMinute($this->_pstCategory->inspection1EndTime),
								'cssClass' => ''
								);
		}

		if (!empty($this->_pstCategory->inspection2Date) && !empty($this->_pstCategory->inspection2StartTime) && !empty($this->_pstCategory->inspection2EndTime))
		{

		$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection2Date) . ': ' . Tag::getHourMinute($this->_pstCategory->inspection2StartTime) . ' ~ ' . Tag::getHourMinute($this->_pstCategory->inspection2EndTime),
							'cssClass' => ''
							);
		}

		if (!empty($this->_pstCategory->inspection3Date) && !empty($this->_pstCategory->inspection3StartTime) && !empty($this->_pstCategory->inspection3EndTime))
		{
			$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection3Date) . ': ' . Tag::getHourMinute($this->_pstCategory->inspection3StartTime) . ' ~ ' . Tag::getHourMinute($this->_pstCategory->inspection3EndTime),
							'cssClass' => ''
							);
		}

		if (!empty($this->_pstCategory->inspection4Date) && !empty($this->_pstCategory->inspection4StartTime) && !empty($this->_pstCategory->inspection4EndTime))
		{
		$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection4Date). ': ' . Tag::getHourMinute($this->_pstCategory->inspection3StartTime) . ' ~ ' . Tag::getHourMinute($this->_pstCategory->inspection4EndTime),
							'cssClass' => ''
							);
		}
		if (!empty($this->_pstCategory->inspection5Date) && !empty($this->_pstCategory->inspection5StartTime) && !empty($this->_pstCategory->inspection5EndTime))
		{
			$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection5Date) . ': ' . Tag::getHourMinute($this->_pstCategory->inspection3StartTime) . ' ~ ' . Tag::getHourMinute($this->_pstCategory->inspection5EndTime),
							'cssClass' => ''
							);
		}

		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' => ''
							);
		$this->printTable($contentArray);
		$this->printForm();
	}

	public function getTab3Content()
	{
		$this->printPhotoTab();
	}


	public function getTitle()
	{
		$title=$this->_pstCategory->address;

		$location = new Location($this->_posting->locId);
		$suburb = $location->getSuburb();
        if (!empty($suburb))
        {
			$title .= ' <span class="titleend">(' .  $suburb . ')</span>';
        }


		if ($this->_posting->cat2 == 630)
			{
				$type = 'For Sale';
			}
			else if ($this->_posting->cat2 == 638)
			{
				$type = 'For Lease';
			}
			else if ($this->_posting->cat2 == 645)
			{
       			$type = 'For Share';
			}
			$title .= '<br /><span class="titlesecond">' . $type ;
			$cat1Table =new Refcat1();
			$title .=  ' by ' . $cat1Table->getCatNameById($this->_posting->cat1) . ' - ' . $this->_posting->priceDisplay . ' -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' Bed: ' . Tag::getUnitsAmount($this->_pstCategory->rooms) .', Bath: '.Tag::getUnitsAmount($this->_pstCategory->baths) .', Cars: '. Tag::getUnitsAmount($this->_pstCategory->parking) ."</span>";

		return $title;
	}

	public function getForm()
	{
		$this->_form = new JobContactForm();
		$this->_form->setHint('Post comment to the property owner:');
		$this->_form->setAction('/forms/contact');
		$this->_form->setPostingId($this->_posting->id);
		return parent::getForm();
	}

	public function getPostingDataForContactForm()
	{
		try{


		$postingData = array();
		$postingData["firstname"] = empty($this->_pstCategory->contactName1)? "Sir" : $this->_pstCategory->contactName1;
		$postingData["businesstype"] = $this->_businessType;
		$postingData["title"] = $this->_posting->getTitle();
		$postingData["cat"] = $this->getCatsString();
		$postingData["price"] = $this->_posting->priceDisplay;
		$postingData["id"] = $this->_posting->id;
		$postingData["questionlabel"] = "Comment";
		$postingData["email_to"] =$this->_pstCategory->contactEmail1;
		return $postingData;
		}catch(Excpetion $e)
		{
			echo $e;
		}
	}
}
?>
