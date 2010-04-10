<?php
class RestaurantsDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_hasAttachTab = true;
	protected $_tabCollection = array('General','About', 'Menu', 'Photo');

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
							'value' => $this->_pstCategory->address,
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
							'value' => '<a target="blank" href="' . $this->_pstCategory->website .'">' .  $this->_pstCategory->website . '</a>',
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Open Days:',
							'value' => $this->_pstCategory->openDays,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Price:',
							'value' => $this->_pstCategory->priceInfo,
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
							'head' => $this->_pstCategory->about,
							'value' => 'dummy',
							'cssClass' => 'black'
							);




		$this->printTable($contentArray);
	}

	public function getTab3Content()
	{

		$this->printPdf();
	}

	public function getTab4Content()
	{
		$this->printPhotoTab();
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
