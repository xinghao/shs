<?php
class ListingsDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General');
	protected $_businessType = "Business Listings";

	public function setCategory()
	{
		$pstJobTables = new Pstlisting();
		$this->_pstCategory = $pstJobTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => '',
							'value' => $this->_pstCategory->shortDescription,
							'cssClass' => 'bold'
							);

		$contentArray[] = array(
							'head' => '&nbsp;',
							'value' => '&nbsp;',
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Address:',
							'value' => $this->_pstCategory->address,
							'cssClass' => ''
							);

		$opendayTables = new Refopenday();

		$contentArray[] = array(
							'head' => 'Open Days:',
							'value' => $opendayTables->getOpenday($this->_pstCategory->openDay),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Phone 1:',
							'value' => $this->_pstCategory->phoneNumber,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Phone 2:',
							'value' => $this->_pstCategory->phoneNumber2,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Website:',
							'value' => $this->_pstCategory->website,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => $this->_pstCategory->description,
							'value' => 'dummy',
							'cssClass' => 'black'
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


	public function getTitle()
	{
		$title = parent::getTitle();

		$cat2 = $this->getCat2();
		$location = new Location($this->_posting->locId);
		$secondLing = $this->strAdd($cat2,$location->getLocationString(), '  -  ');
		if (!empty($secondLing))
		{
			$secondLing = '<span class="titlesecond">' . $secondLing . '</span>';
		}
		return $this->strAdd($title,$secondLing, '<br />');
	}

	public function getForm()
	{
		$this->_form = new JobContactForm();
		$this->_form->setHint('Post a Comment to the employer company:');
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
