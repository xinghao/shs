<?php
class DetailTab
{
	protected $_businessType;
	protected $_posting;
	protected $_pstCategory;
	protected $_tabCollection = array();
	protected $_hasPhotoTab = false;

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


		echo '</div>';
	}

	public function printTable($contentArray, $hasPhoto = false)
	{
		echo "\n" . '<table>';

		if ($hasPhoto && $this->photoExist())
		{
			$icount = 1;
			foreach($contentArray as $entry)
			{
				if ($icount > 3)
				{
					break;
				}
				if($icount == 1)
				{
					echo '<tr>';
					echo '<th class=" ' .$entry['cssClass'] . '">'.$entry['head'].' </th>';
					echo '<td class=" ' .$entry['cssClass'] . '">'.$entry['value'].' </td>';
					echo '<td class="imagetd" rowspan = "3" align="left" valign="middle"><a class="imgurl" href="" onclick="return showPhotoTab()">';
					echo  $this->printPhotoextract() . "</a>";
					echo  '<a href="" onclick="return showPhotoTab()">';

					if ($this->photoAmount() > 1)
					{
						echo 'View more photos';
					}
					else
					{
						echo '&nbsp;View big photo&nbsp;';
					}
					echo  '</a></td>';

					echo '</tr>' . "\n";

				}
				else
				{
					echo '<tr>';
					echo '<th class=" ' .$entry['cssClass'] . '">'.$entry['head'].' </th>';
					echo '<td class=" ' .$entry['cssClass'] . '">'.$entry['value'].' </td>';
					echo '</tr>'. "\n";
				}
				$icount++;
			}

			$icount = 1;
			foreach($contentArray as $entry)
			{
				if ($icount <= 3)
				{
					$icount++;
					continue;
				}
				echo '<tr>';
				echo '<th class=" ' .$entry['cssClass'] . '">'.$entry['head'].' </th>';
				echo '<td class=" ' .$entry['cssClass'] . '" colspan=2>'.$entry['value'].' </td>';
				echo '</tr>'. "\n";


			}

		}
		else
		{
			foreach($contentArray as $entry)
			{
				echo '<tr>';
				echo '<th class=" ' .$entry['cssClass'] . '">'.$entry['head'].' </th>';
				echo '<td class=" ' .$entry['cssClass'] . '">'.$entry['value'].' </td>';
				echo '</tr>'. "\n";

			}
		}
		echo '</table>' . "\n";

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

	}

		public function getTab4()
	{
		echo '<div id="tab4" class="tab_content">';
		echo '<div id="container">';
			$this->getTab4Content();
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

	}

	public function printTabs()
	{
		echo '<div class="tabwrap">';
			echo '<div class="tabs">';
				echo '<ul class="tabs">';
				$icount = 1;
				foreach($this->_tabCollection as $tab)
				{
					if (strtolower($tab) != 'photo' || $this->photoExist() )
					{
						if (strtolower($tab) == 'photo')
						{
							$photoTab = 'tabname = "photo"';
						}
						else
						{
							$photoTab = '';
						}
						echo '<li ' . $photoTab .'><a href="#tab' . $icount .'" >' . $tab . '</a></li>';
						$icount++;
					}
				}
				echo '</ul>';
				echo '<div class="clear"></div>';
			echo '</div>';
			echo '<div class="tab_container">';
				$this->getTab1();
				$this->getTab2();
				$this->getTab3();
				$this->getTab4();
				$this->getTab5();
				echo '<div class="clear"></div>';
			echo '</div>';
		echo '</div>';
	}

	public function photoExist()
	{
		if (!$this->_hasPhotoTab)
		{
			return false;
		}

		$retArray  = array();
		$photos = intval($this->_posting->photo);

		if (empty($photos))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function photoAmount()
	{
		if (!$this->_hasPhotoTab)
		{
			return false;
		}

		$retArray  = array();
		$photos = $this->_getPhotosList();
		return sizeof($photos);
	}

	public function printPhotoextract()
	{
		$photos = $this->_getPhotosList();
		//print_r($photos);

		if (empty($photos))
		{
			return;
		}

		foreach($photos as $photo)
		{
			echo '<img src="/images/publicimages/a/' . $this->_posting->id . 'a' . $photo . '.jpg"  dest ="/images/publicimages/b/' . $this->_posting->id . 'b' . $photo . '.jpg" class="imageextract"/>';

			break;
		}


	}

	public function printPhotoTab()
	{
		$photos = $this->_getPhotosList();
		//print_r($photos);

		if (empty($photos))
		{
			return;
		}
		echo '<center>';

		echo '<div class="largeimagewrap">'. "\n";
		echo '<span><img /></span>';
		echo '</div>';
		echo '<div class="smallimagewrap"><ul class="gallery">';
		$icount = 1;

		foreach($photos as $photo)
		{
			if ($icount == 1)
			{
				$cssClass="currentimg";
			}
			else
			{
				$cssClass="transparent_class";
			}
			$icount++;
			echo '<li><span>';
			echo '<img src="/images/publicimages/a/' . $this->_posting->id . 'a' . $photo . '.jpg"  dest ="/images/publicimages/b/' . $this->_posting->id . 'b' . $photo . '.jpg" class="' . $cssClass . '"/>';
			echo '</span></li>';
		}
		echo '</ul><div class="clear"></div></div></center>';


	}


	/**
	 * return the array of photos such as (1,3,5) for 10101.
	 * and empty array for no photos.
	 * @return unknown_type
	 */
	protected function _getPhotosList()
	{
		$retArray  = array();
		$photos = intval($this->_posting->photo);
		logFire('photo gallery', $photos);
		if (empty($photos))
		{
			return $retArray;
		}

		if ( $photos >= 10000)
		{
			$retArray[] = 1;
		}
		if ( ($photos % 10000) >= 1000)
		{
			$retArray[] = 2;
		}
		if ( ($photos % 1000) >= 100)
		{
			$retArray[] = 3;
		}
		if ( ($photos % 100) >= 10)
		{
			$retArray[] = 4;
		}
		if ( ($photos % 10) >= 1)
		{
			$retArray[] = 5;
		}

		return $retArray;

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
