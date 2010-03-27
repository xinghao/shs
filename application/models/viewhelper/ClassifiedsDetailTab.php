<?php
class ClassifiedsDetailTab extends  DetailTab
{
	protected $_hasPhotoTab = true;
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

	}

	public function getTab3Content()
	{
		$this->printPhotoTab();
	}

}
?>
