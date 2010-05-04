<?php
class DetailTab
{
	protected $_businessType;
	protected $_posting;
	protected $_pstCategory;
	protected $_tabCollection = array();
	protected $_hasPhotoTab = false;
	protected $_hasAttachTab = false;
	protected $_attachTabCollect = array("menu");
	protected $_formData = array();
	protected $_formTabName;
	protected $_tabSequence = 1;
	public $formTabSeq = 1;
	protected $_form;
	protected $_displayForm=true;


	public static function DetailTabFactory($posting)
	{
		$detailTab = BusinessType::getPostingTabs($posting);
		$detailTab->setPosting($posting);
		$detailTab->setCategory();
		return $detailTab;
	}


	public function getForm()
	{
		return $this->_form;
	}
	public function setTabSequence($tabS)
	{
		$this->_tabSequence = $tabS;
	}

	public function getFormTabName()
	{
		return $this->_formTabName;
	}

	public function setFormData($data)
	{
		$this->_formData = $data;
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
		if ($this->_tabSequence == 1)
		{
			$sytle = ' style="display:block;" ';
		}
		else
		{
			$sytle = ' style="display:none;" ';
		}
		echo '<div id="tab1" class="tab_content"' .$sytle .'>';
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
					if (empty($entry['value']))
					{
						continue;
					}
					echo '<tr>';

					if ($entry['value'] == 'dummy')
					{
						$td1colspan = 'colspan ="2"';
					}
					else
					{
						$td1colspan = '';
					}


					echo '<th ' . $td1colspan . ' class="' .$entry['cssClass'] . '">'.$entry['head'].' </th>';

					if ($entry['value'] != 'dummy')
					{
						echo '<td class="' .$entry['cssClass'] . '">';
						echo $entry['value'];
						echo '</td>';
					}

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
					if (empty($entry['value']))
					{
						continue;
					}
					echo '<tr>';

					if ($entry['value'] == 'dummy')
					{
						$td1colspan = 'colspan ="2"';
					}
					else
					{
						$td1colspan = '';
					}
					echo '<th ' . $td1colspan . ' class="' .$entry['cssClass'] . '">'.$entry['head'].' </th>';

					if ($entry['value'] != 'dummy')
					{
						echo '<td class="' .$entry['cssClass'] . '">';
						echo $entry['value'];
						echo '</td>';
					}

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
				if (empty($entry['value']))
				{
						continue;
				}
				echo '<tr>';
				if ($entry['value'] == 'dummy')
					{
						$td1colspan = 'colspan ="3"';
					}
					else
					{
						$td1colspan = '';
					}

					echo '<th ' . $td1colspan . ' class="' .$entry['cssClass'] . '">'.$entry['head'].' </th>';

					if ($entry['value'] != 'dummy')
					{
						echo '<td colspan = "2" class="' .$entry['cssClass'] . '">';
						echo $entry['value'];
						echo '</td>';
					}



				echo '</tr>'. "\n";


			}

		}
		else
		{
			foreach($contentArray as $entry)
			{
				if (empty($entry['value']))
				{
						continue;
				}
				echo '<tr>';
					if ($entry['value'] == 'dummy')
					{
						$td1colspan = 'colspan ="3"';
					}
					else
					{
						$td1colspan = '';
					}
					echo '<th ' . $td1colspan . ' class="' .$entry['cssClass'] . '">'.$entry['head'].' </th>';

					if ($entry['value'] != 'dummy')
					{
						echo '<td colspan = "2" class="' .$entry['cssClass'] . '">';
						echo $entry['value'];
						echo '</td>';
					}

				echo '</tr>'. "\n";

			}
		}
		echo '</table>' . "\n";

	}

	public function getTab2()
	{
			if ($this->_tabSequence == 2)
		{
			$sytle = ' style="display:block;" ';
		}
		else
		{
			$sytle = ' style="display:none;" ';
		}

		echo '<div id="tab2" class="tab_content"' .$sytle .'>';
		echo '<div class="leftcontent">';
			$this->getTab2Content();
		echo '</div>';

		echo '<div class="rightcontent">';
		echo '</div>';
		echo '</div>';
	}

	public function getTab3()
	{
			if ($this->_tabSequence == 3)
		{
			$sytle = ' style="display:block;" ';
		}
		else
		{
			$sytle = ' style="display:none;" ';
		}

		echo '<div id="tab3" class="tab_content"' .$sytle .'>';
		echo '<div class="leftcontent">';
			$this->getTab3Content();
		echo '</div>';

		echo '<div class="rightcontent">';

		echo '</div>';
		echo '</div>';

	}

		public function getTab4()
	{
			if ($this->_tabSequence == 4)
		{
			$sytle = ' style="display:block;" ';
		}
		else
		{
			$sytle = ' style="display:none;" ';
		}
		echo '<div id="tab4" class="tab_content"' .$sytle .'>';
		echo '<div id="container">';
			$this->getTab4Content();
		echo '</div>';
		echo '</div>';

	}

	public function getTab5()
	{
			if ($this->_tabSequence == 5)
		{
			$sytle = ' style="display:block;" ';
		}
		else
		{
			$sytle = ' style="display:none;" ';
		}
		echo '<div id="tab5" class="tab_content"' .$sytle .'>';
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
				logfire('pdf exist', $this->attachmentExist());
				foreach($this->_tabCollection as $tab)
				{
					if ((strtolower($tab) != 'photo' || $this->photoExist() ) && (!in_array(strtolower($tab), $this->_attachTabCollect) || $this->attachmentExist()) )
					{
						if (strtolower($tab) == 'photo')
						{
							$photoTab = 'tabname = "photo"';
						}
						else
						{
							$photoTab = 'tabname = tab' . $icount;
						}

						logfire('$this->_tabSequence', $this->_tabSequence);
						if ($this->_tabSequence == $icount)
						{
							$style = ' class="active" ';
						}
						else
						{
							$style = "";
						}
						echo '<li ' . $photoTab . $style .'><a href="#tab' . $icount .'" >' . $tab . '</a></li>';
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


	public function attachmentExist()
	{

		if ($this->_hasAttachTab && !empty($this->_posting->attachment))
		{
			return true;
		}
		else
		{
			return false;
		}
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


	public function printPdf()
	{
		if (empty($this->_posting->attachment))
		{
			return "";
		}

		echo '<div class="downloadwrap"><center>';
		echo '<a href="/attachments/public/' . $this->_posting->id .'.pdf"><div class="downloadbutton">';
		echo 'Download Menu';
		echo '</div></a></center>';
		echo '</div>';

		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";

		echo '<div class="adobedownloadinstruction">';
		echo '<p>Adobe Acrobat Reader is Required to view PDF files. This is a free program available from the Adobe web site. Follow the download directions on the Adobe web site to get your copy of Adobe Acrobat Reader.</p>';
		echo "<br />";
		echo '<a target="_blank"  href="http://get.adobe.com/reader/?promoid=BUIGO"><img style="border:none" src = "/images/sitetemplate/get_adobe_reader.png"></a>';
		echo '</div>';

	}

	public function getCat1()
	{
		if (!empty($this->_posting->cat1))
		{
			$refcat1 = new Refcat1();
			return $refcat1->getCatNameById($this->_posting->cat1);
		}
		else
		{
			return '';
		}

	}


	public function getCat2()
	{
		if (!empty($this->_posting->cat2))
		{
			$refcat = new Refcategory();
			return  $refcat->getCatNameById($this->_posting->cat2);
		}

		return "";
	}

	public function getCat3()
	{
		if (!empty($this->_posting->cat3))
		{
			$refcat = new Refcategory();
			return  $refcat->getCatNameById($this->_posting->cat3);
		}

		return "";
	}


	public function getCatsString($showCat1 = true)
	{
		$retString = '';

		if (!empty($this->_posting->cat1) && $showCat1)
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


	public function printFormConfirm()
	{
		echo "Your question has been sent. Feel free to ask more questions. <br /> <br />";
	}

	public function printForm()
	{
		if($this->_displayForm)
		{
			$this->getForm();
			echo $this->_form->populate($this->_formData);

		}
		else
		{
			$this->printFormConfirm();
			$this->getForm();
			echo $this->_form->populate($this->_formData);
		}


	}


	public function setDisplayForm($displayForm)
	{
		$this->_displayForm = $displayForm;
	}


	public function getTitle()
	{
		return $this->_posting->getTitle();
	}

	public function getPostingDataForContactForm()
	{
	}


	public function getFeatures($features, $businessType, $column = 3)
	{
		if (!empty($features))
		{
			$reffeatures = new Reffeature();
			$featuresSet = $reffeatures->getFeatures($features, $businessType);

			if (!empty($featuresSet))
			{
				$featureArray = array();
				foreach($featuresSet as $feature)
				{
					$featureArray[] = '-  ' . $feature->feature;
				}

				return Tag::simpleTable($featureArray, $column, 'featurelist', true);
			}
		}

		return '';
	}
}
?>
