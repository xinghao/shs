<?php
class JobDetailTab extends  DetailTab
{
	protected $_tabCollection = array('General','About', 'Apply', 'Photo');

	public function setCategory()
	{
		$pstJobTables = new Pstjob();
		$this->_pstCategory = $pstJobTables->getPstJob($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Classification:',
							'value' => $this->getCatsString(),
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
							'value' => $this->_pstCategory->priceInfo,
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

		$this->printTable($contentArray);
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
							'value' => $this->_pstCategory->qualifications,
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
							'head' => 'Contact Phone:',
							'value' => $this->_pstCategory->contactPhone,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Contact Email:',
							'value' => $this->_pstCategory->contactEmail,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Contact Name:',
							'value' => $this->_pstCategory->contactName,
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
