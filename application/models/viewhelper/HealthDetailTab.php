<?php
class HealthDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General', 'Photo',  'Brochure', 'Contact');
	protected $_businessType = "Health and Fitness";
	public $formTabSeq = 4;

	public function setCategory()
	{
		$pstJobTables = new Psthealth();
		$this->_pstCategory = $pstJobTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Address:',
							'value' => $this->_pstCategory->address,
							'cssClass' => ''
							);

		$opendayTables = new Refopenday();
		$contentArray[] = array(
							'head' => 'Open Days:',
							'value' => $opendayTables->getOpenday($this->_pstCategory->openDays),
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Website:',
							'value' => Tag::webSites($this->_pstCategory->website),
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Business Number:',
							'value' => $this->_pstCategory->businessNumber,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Short Description:',
							'value' => $this->_pstCategory->shortDescription,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Qualification:',
							'value' => $this->_pstCategory->qualification,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Specialty',
							'value' => $this->_pstCategory->specialty,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Experience:',
							'value' => $this->_pstCategory->experience,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Specials',
							'value' => $this->_pstCategory->specials,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Price Information:',
							'value' => $this->_pstCategory->priceInfo,
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

	public function getTab3Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Phone #:',
							'value' => $this->_pstCategory->contactNumber,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Phone2 #:',
							'value' => $this->_pstCategory->contactNumber2,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Website:',
							'value' => Tag::webSites($this->_pstCategory->website),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Address:',
							'value' => $this->_pstCategory->address,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '&nbsp;',
							'value' => '&nbsp;',
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '&nbsp;',
							'value' => '&nbsp;',
							'cssClass' => ''
							);



		$this->printTable($contentArray);
		$this->printForm();

	}

	public function getTab2Content()
	{
		$this->printPhotoTab();
	}

	public function getTab4Content()
	{
		$this->printPdf();
	}


	public function getTitle()
	{
		$title = parent::getTitle();
		$title .= '<br /><span class="titlesecond">';
		$other = $this->strAdd($this->getCat3(), $this->getCat2(), ' - ');

		$location = new Location($this->_posting->locId);
		$suburb = $location->getSuburb();
	    if (!empty($suburb))
        {
			$title .= $other . ' <span class="titleend">(' .  $suburb . ')</span>';
        }
		//$title .= $this->strAdd( $other , $suburb, ' : ');

		return $title;
	}

	public function getForm()
	{
		$this->_form = new JobContactForm();
		$this->_form->setHint('Post a message to business owner:');
		$this->_form->setAction('/forms/contact');
		$this->_form->setPostingId($this->_posting->id);
		$this->_form->setQuestionlabel('Your Question:');
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
		$postingData["questionlabel"] = "Your Question";
		$postingData["email_to"] =$this->_pstCategory->contactEmail;
		return $postingData;
		}catch(Excpetion $e)
		{
			echo $e;
		}
	}
}
?>
