<?php
class RealestateDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General','About', 'Apply', 'Photo');

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
					'head' => 'Short Description:',
					'value' => $this->_pstCategory->shortDescription,
					'cssClass' => 'black'
					);

		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' =>''
							);


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
							'head' => 'Number of Bedrooms:',
							'value' => $this->_pstCategory->rooms,
							'cssClass' =>''
							);
		$contentArray[] = array(
							'head' => 'Number of Bathrooms:',
							'value' => $this->_pstCategory->baths,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Number of Parking:',
							'value' => $this->_pstCategory->parking,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Building Area:',
							'value' => $this->_pstCategory->buildingArea,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Land Area:',
							'value' => $this->_pstCategory->landArea,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Property Age:',
							'value' => $this->_pstCategory->age,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Morning Sun Dir:',
							'value' => $this->_pstCategory->sunDirection,
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

		$contentArray[] = array(
							'head' => 'Strata Rate:',
							'value' => $this->_pstCategory->strataRate,
							'cssClass' =>''
							);
		$contentArray[] = array(
							'head' => 'Council Rate:',
							'value' => $this->_pstCategory->buildingLevel,
							'cssClass' =>''
							);
		$contentArray[] = array(
							'head' => 'Water Rate:',
							'value' => $this->_pstCategory->councilRate,
							'cssClass' =>''
							);

		$contentArray[] = array(
							'head' => 'Review:',
							'value' => '',
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

	public function getTab3Content()
	{
		$contentArray = array();


		$contentArray[] = array(
							'head' => 'Real Estate:',
							'value' => '',
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Contact 1 Name:',
							'value' => $this->_pstCategory->contactName1,
							'cssClass' => ''
							);

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

		$contentArray[] = array(
							'head' => 'Contact 2 Name:',
							'value' => $this->_pstCategory->contactName2,
							'cssClass' => ''
							);

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


		$contentArray[] = array(
							'head' => 'Contact Info:',
							'value' => $this->_pstCategory->contactInfo,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Auction Date:',
							'value' => $this->_pstCategory->auctionDate,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Auction Address:',
							'value' => $this->_pstCategory->auctionLocation,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Inspection Info:',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection1Date) . ': ' . $this->_pstCategory->inspection1StartTime . ' ~ ' . $this->_pstCategory->inspection1EndTime,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection2Date) . ': ' . $this->_pstCategory->inspection2StartTime . ' ~ ' . $this->_pstCategory->inspection2EndTime,
							'cssClass' => ''
							);
		$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection3Date) . ': ' . $this->_pstCategory->inspection3StartTime . ' ~ ' . $this->_pstCategory->inspection3EndTime,
							'cssClass' => ''
							);
		$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection4Date). ': ' . $this->_pstCategory->inspection3StartTime . ' ~ ' . $this->_pstCategory->inspection4EndTime,
							'cssClass' => ''
							);
		$contentArray[] = array(
							'head' => '',
							'value' => Tag::getHtmlDateTime($this->_pstCategory->inspection5Date) . ': ' . $this->_pstCategory->inspection3StartTime . ' ~ ' . $this->_pstCategory->inspection5EndTime,
							'cssClass' => ''
							);


		$this->printTable($contentArray);
	}

	public function getTab4Content()
	{
		$this->printPhotoTab();
	}
}
?>