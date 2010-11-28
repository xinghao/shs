<?php
class RestaurantsDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_hasAttachTab = true;
	protected $_tabCollection = array('General', 'Menu', 'Photo');

	public function setCategory()
	{
		$pstfoodTables = new Pstfood();
		$this->_pstCategory = $pstfoodTables->getPst($this->_posting->id);
	}

	public function getTab1Content()
	{
		$contentArray = array();

		$contentArray[] = array(
							'head' => 'Cuisine:',
							'value' => $this->getCatsString(false),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Special Feature:',
							'value' => $this->getCat1(),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Adress:',
							'value' => $this->_pstCategory->address + "&nbsp;&nbsp;&nbsp;"+Common::GetGoogleMap($this->_pstCategory->address),
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
							'head' => 'Website:',
							'value' => Tag::webSites($this->_pstCategory->website),
							'cssClass' => ''
							);

		$opendayTables = new Refopenday();

		$contentArray[] = array(
							'head' => 'Open Days:',
							'value' => $opendayTables->getOpenday($this->_pstCategory->openDays),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Price:',
							'value' => $this->strAdd($this->_posting->priceDisplay,$this->_pstCategory->priceInfo),
							'cssClass' => ''
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
					'head' => $this->_pstCategory->shortDescription,
					'value' => 'dummy',
					'cssClass' => 'black'
					);

		$contentArray[] = array(
					'head' => $this->_pstCategory->about,
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

		//$title = $this->getCat2();

		$location = new Location($this->_posting->locId);
		$suburb = $location->getSuburb();
        if (!empty($suburb))
        {
			$title .= ' <span class="titleend">(' .  $suburb . ')</span>';
        }
      	return $title. '</span>';
	}

}
?>
