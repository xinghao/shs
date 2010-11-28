<?php
class ActivitiesDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_hasAttachTab = true;
	protected $_tabCollection = array('General', 'Menu', 'Photo');
	protected $_businessType = "Activities";


	public function setCategory()
	{
		$pstJobTables = new Pstactivity();
		$this->_pstCategory = $pstJobTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{

		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Activity:',
							'value' => $this->strAdd($this->getCat1(),$this->getCat2()),
							'cssClass' => ''
							);

	    $opendayTables = new Refopenday();
		$contentArray[] = array(
							'head' => 'Open Day:',
							'value' => $opendayTables->getOpenday($this->_pstCategory->openDay),
							'cssClass' => ''
							);



		$contentArray[] = array(
							'head' => 'Adress:',
							'value' => $this->_pstCategory->address,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Phone#:',
							'value' => $this->_pstCategory->contactPhone,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Website:',
							'value' => Tag::webSites($this->_pstCategory->website),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Average Price:',
							'value' => $this->strAdd($this->_posting->priceDisplay,$this->_pstCategory->priceInfo),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Specials:',
							'value' => $this->_pstCategory->specials,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '',
							'value' => $this->_pstCategory->description,
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
		$this->printPdf();
	}

	public function getTab3Content()
	{
		$this->printPhotoTab();
	}

	public function getTitle()
	{
		$title = parent::getTitle();
		$title .= '<br /><span class="titlesecond">' . $this->getCat2();

		$location = new Location($this->_posting->locId);
		$suburb = $location->getSuburb();
        if (!empty($suburb))
        {
			$title .= ' <span class="titleend">(' .  $suburb . ')</span>';
        }
      	return $title . '</span>';
	}

}
?>
