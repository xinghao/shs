<?php
class DetailTab
{
	protected $_businessType;
	protected $_posting;
	protected $_pstCategory;
	protected $_tabCollection = array();

	public static function DetailTabFactory($posting)
	{
		$detailTab = BusinessType::getPostingTabs($posting);
		$detailTab->setPosting($posting);
		$detailTab->setCategory();
		return $detailTab;
	}

	public function setPosting($posting)
	{
		$this->_posting = $posting;
	}

	public function setCategory()
	{

	}

	public function getTab1Content()
	{

	}

	public function getTab2Content()
	{

	}

	public function getTab3Content()
	{

	}

	public function getTab4Content()
	{

	}

	public function getTab5Content()
	{

	}

	public function getTab1Image()
	{

	}

	public function getTab1()
	{
		echo '<div id="tab1" class="tab_content">';
		echo '<div class="leftcontent">';
			$this->getTab1Content();
		echo '</div>';

		echo '<div class="rightcontent">';
			$this->getTab1Image();
		echo '</div>';

		echo '</div>';
	}

	public function printTable($contentArray)
	{
		echo '<table>';

		foreach($contentArray as $entry)
		{
			echo '<tr>';
			echo '<th class=" ' .$entry['cssClass'] . '">'.$entry['head'].' </th>';
			echo '<td class=" ' .$entry['cssClass'] . '">'.$entry['value'].' </th>';
			echo '</tr>';

		}
		echo '</table>';

	}

	public function getTab2()
	{
		echo '<div id="tab2" class="tab_content">';
		echo '<div class="leftcontent">';
			$this->getTab2Content();
		echo '</div>';

		echo '<div class="rightcontent">';
		echo '</div>';
		echo '</div>';
	}

	public function getTab3()
	{
		echo '<div id="tab3" class="tab_content">';
		echo '<div class="leftcontent">';
			$this->getTab3Content();
		echo '</div>';

		echo '<div class="rightcontent">';
		echo '</div>';
		echo '</div>';
		echo '</div>';

	}

		public function getTab4()
	{
		echo '<div id="tab4" class="tab_content">';
		echo '<div class="leftcontent">';
			$this->getTab4Content();
		echo '</div>';

		echo '<div class="rightcontent">';
		echo '</div>';
		echo '</div>';
		echo '</div>';

	}

	public function getTab5()
	{
		echo '<div id="tab5" class="tab_content">';
		echo '<div class="leftcontent">';
			$this->getTab5Content();
		echo '</div>';

		echo '<div class="rightcontent">';
		echo '</div>';
		echo '</div>';
		echo '</div>';

	}

	public function printTabs()
	{
		echo '<div class="tabwrap">';
			echo '<div class="tabs">';
				echo '<ul class="tabs">';
				$icount = 1;
				foreach($this->_tabCollection as $tab)
				{
					echo '<li><a href="#tab' . $icount .'" >' . $tab . '</a></li>';
					$icount++;
				}
				echo '</ul>';
				echo '<div class="clear"></div>';
			echo '</div>';
			echo '<div class="tab_container">';
				$this->getTab1();
				$this->getTab2();
				$this->getTab3();
				echo '<div class="clear"></div>';
			echo '</div>';
		echo '</div>';
	}

	public function getCatsString()
	{
		$retString = '';

		if (!empty($this->_posting->cat1))
		{
			$refcat1 = new Refcat1();
			$retString = $refcat1->getCatNameById($this->_posting->cat1);
		}

		if (!empty($this->_posting->cat2))
		{
			$refcat = new Refcategory();
			$cat = $refcat->getCatNameById($this->_posting->cat2);
			if (empty($retString))
			{
				$retString = $cat;
			}
			else
			{
				$retString .= ', ' . $cat;
			}
		}

			if (!empty($this->_posting->cat3))
		{
			$refcat = new Refcategory();
			$cat = $refcat->getCatNameById($this->_posting->cat3);
			if (empty($retString))
			{
				$retString = $cat;
			}
			else
			{
				$retString .= ', ' . $cat;
			}
		}

			if (!empty($this->_posting->cat4))
		{
			$refcat = new Refcategory();
			$cat = $refcat->getCatNameById($this->_posting->cat4);
			if (empty($retString))
			{
				$retString = $cat;
			}
			else
			{
				$retString .= ', ' . $cat;
			}
		}

		if (!empty($this->_posting->cat5))
		{
			$refcat = new Refcategory();
			$cat = $refcat->getCatNameById($this->_posting->cat5);
			if (empty($retString))
			{
				$retString = $cat;
			}
			else
			{
				$retString .= ', ' . $cat;
			}
		}

		return $retString;
	}
}
?>
