<?php
class CarsDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General', 'Contact', 'Photo');
	protected $_businessType = "Car Sales";
	public $formTabSeq = 2;

	public function setCategory()
	{
		$pstJobTables = new Pstcar();
		$this->_pstCategory = $pstJobTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$location = new Location($this->_posting->locId);
		$contentArray[] = array(
							'head' => 'Seller:',
							'value' => $this->getCat1() . "(" . $location->getSuburb() . ")",
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Vehicle:',
							'value' => $this->_pstCategory->makeYear . ',' . $this->getCat2() . ',' . $this->getCat3(),
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Kilometers:',
							'value' => $this->_pstCategory->km . "Km's",
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Body:',
							'value' => $this->_pstCategory->seats . "seats , " .  $this->_pstCategory->bodyType . ' , ' . $this->_pstCategory->drive,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Transimiton:',
							'value' => $this->_pstCategory->transmission . ' , ' . $this->_pstCategory->engin . ' Liters , ' . $this->_pstCategory->power . 'KW',
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Fuel:',
							'value' => $this->_pstCategory->fuel,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Body Color:',
							'value' => $this->_pstCategory->bodyColour,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Interior Color:',
							'value' => $this->_pstCategory->interiorColour,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '#of owners:',
							'value' => $this->_pstCategory->owners,
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

		$contentArray[] = array(
							'head' => '',
							'value' => $this->_pstCategory->shortDescription,
							'cssClass' => ''
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
/*
		$contentArray[] = array(
							'head' => 'Employer Company:',
							'value' => $this->_pstCategory->employerCompany,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Agency Company:',
							'value' => $this->_pstCategory->agencyCompany,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Contact Info:',
							'value' => $this->_pstCategory->contactInfo,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Contact Name:',
							'value' => $this->_pstCategory->contactName,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' => ''
							);

		$this->printTable($contentArray);
		$this->printForm();
*/
$this->printForm();
	}

	public function getTab3Content()
	{
		$this->printPhotoTab();
	}

	public function getTitle()
	{
		$title = "";
		$cat2 = "";
		$cat3 = "";
		$catTables = new Refcategory();
		if (!empty($this->_posting->cat2))
		{
			$cat2 = $catTables->getCatNameById($this->_posting->cat2);
		}

		if (!empty($this->_posting->cat3))
		{
			$cat3 = $catTables->getCatNameById($this->_posting->cat3);
		}


		$title .=  $this->_pstCategory->makeYear
		          .' ' . $cat2
		          .' ' . $cat3;

		$location = new Location($this->_posting->locId);
		$suburb = $location->getSuburb();

			$title .= '<br /><span class="titlesecond grey">' ;
			$cat1Table =new Refcat1();
			$title .=  $cat1Table->getCatNameById($this->_posting->cat1) . ' - ' . $this->_posting->priceDisplay  . "(" .$suburb  .")" .  "</span>";


		return $title;
	}

	public function getForm()
	{
		$this->_form = new JobContactForm();
		$this->_form->setHint('Post a Comment to the seller:');
		$this->_form->setAction('/forms/contact');
		$this->_form->setPostingId($this->_posting->id);
		return parent::getForm();
	}


	public function getPostingDataForContactForm()
	{
		try{


		$postingData = array();
		$postingData["firstname"] = empty($this->_pstCategory->contactName)? "Sir" : $this->_pstCategory->contactName;
		$postingData["businesstype"] = $this->_businessType;
		$postingData["title"] = $this->_posting->getTitle();
		$postingData["cat"] = $this->getCatsString();
		$postingData["price"] = $this->_posting->priceDisplay;
		$postingData["id"] = $this->_posting->id;
		$postingData["questionlabel"] = "Comment";
		$postingData["email_to"] =$this->_pstCategory->contactEmail;
		return $postingData;
		}catch(Excpetion $e)
		{
			echo $e;
		}
	}
}
?>
