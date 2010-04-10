<?php
class ClassifiedsDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_formTabName = "tab2";
	protected $_businessType = "Classifieds";
	public $formTabSeq = 2;

	protected $_tabCollection = array('General','Contact Seller', 'Photo');

	public function setCategory()
	{
		$pstTables = new Pstclassifieds();
		$this->_pstCategory = $pstTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Category:',
							'value' => $this->getCatsString(false),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Price:',
							'value' => $this->_pstCategory->priceDescription,
							'cssClass' => ''
							);


		$location = new Location($this->_posting->locId);
		$contentArray[] = array(
							'head' => 'Suburb:',
							'value' => $location->getLocationString(),
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Phone#:',
							'value' => $this->_pstCategory->contactPhone,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => $this->_pstCategory->shortDescription,
							'value' =>'dummy',
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

	public function getTab2Content()
	{

			$this->printForm();
	}


	public function getForm()
	{
		$this->_form = new ContactForm();
		$this->_form->setHint('Post a message to the seller:');
		$this->_form->setAction('/forms/contact');
		$this->_form->setPostingId($this->_posting->id);
		return parent::getForm();
	}

	public function getTab3Content()
	{
		$this->printPhotoTab();
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
		$postingData["questionlabel"] = "Question";
		$postingData["email_to"] =$this->_pstCategory->email;
		return $postingData;
		}catch(Excpetion $e)
		{
			echo $e;
		}
	}


	public function getTitle()
	{
		$title = parent::getTitle();

		$location = new Location($this->_posting->locId);
		$suburb = $location->getSuburb();
        if (!empty($suburb))
        {
			$title .= ' <span class="titleend">(' .  $suburb . ')</span>';
        }
      	return $title;
	}
}
?>
