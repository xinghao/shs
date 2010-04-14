<?php
class ActivitiesDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
	protected $_tabCollection = array('General','About', 'Menu', 'Photo');
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
							'head' => 'Type:',
							'value' => $this->getCat1(),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Feature:',
							'value' => $this->getCat2(),
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Open Day:',
							'value' => $this->_pstCategory->openDay,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Price Description:',
							'value' => $this->_pstCategory->priceInfo,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Adress:',
							'value' => $this->_pstCategory->address,
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => 'Website:',
							'value' => '<a target="blank" href="' . $this->_pstCategory->website .'">' .  $this->_pstCategory->website . '</a>',
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
							'head' => '',
							'value' => $this->_pstCategory->description,
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' => ''
							);

		$contentArray[] = array(
							'head' => '',
							'value' => 'dummy',
							'cssClass' => ''
							);


		$contentArray[] = array(
							'head' => 'Specials:',
							'value' => $this->_pstCategory->specials,
							'cssClass' => ''
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
        if (!empty($this->_pstCategory->employerCompany))
        {
			$title .= ' <span class="titleend">(' .  $this->_pstCategory->employerCompany . ')</span>';
        }
		return $title;
	}

}
?>
