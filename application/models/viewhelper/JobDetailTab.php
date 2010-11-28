<?php
class JobDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General','About', 'Contact', 'Photo');
	protected $_businessType = "Jobs";
	public $formTabSeq = 3;

	public function setCategory()
	{
		$pstJobTables = new Pstjob();
		$this->_pstCategory = $pstJobTables->getPstJob($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Employer:',
							'value' => $this->_pstCategory->employerCompany . ', '. $this->getCat1(),
							'cssClass' => 'bold'
							);

		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Job Type:',
							'value' => $this->getCatsString(false),
							'cssClass' => ''
							);

		$location = new Location($this->_posting->locId);
		$contentArray[] = array(
							'head' => 'Location:',
							'value' => $location->getLocationString(),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Salary Info:',
							'value' => $this->strAdd($this->_posting->priceDisplay, $this->_pstCategory->priceInfo),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Short Description:',
							'value' => $this->_pstCategory->shortDescription,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Required Skills:',
							'value' => $this->_pstCategory->skills,
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

		$contentArray[] = array(
							'head' => 'About Job:',
							'value' => $this->_pstCategory->about,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Job Duties:',
							'value' => $this->_pstCategory->duties,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Required Education:',
							'value' => $this->_pstCategory->education,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Required Qualifications:',
							'value' => $this->_pstCategory->qualifications,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Required Experience:',
							'value' => $this->_pstCategory->experience,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Travel Requirements:',
							'value' => $this->_pstCategory->travelRequirements,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Visa Requirements:',
							'value' => $this->_pstCategory->visa,
							'cssClass' => ''
							);

		$this->printTable($contentArray);
	}

	public function getTab3Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Employer Company:',
							'value' => $this->_pstCategory->employerCompany,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Hiring Agency:',
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


	}

	public function getTab4Content()
	{
		$this->printPhotoTab();
	}

	public function getTitle()
	{
		$title = parent::getTitle();
        if (!empty($this->_pstCategory->employerCompany))
        {
			$title .= ' <span class="titleend">(' .  $this->_pstCategory->employerCompany . ', ' .  $this->_posting->priceDisplay . ')</span>';
        }
		return $title;
	}

	public function getForm()
	{
		$this->_form = new JobContactForm();
		$this->_form->setHint('Post a comment to the employer:');
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
