<?php
class Activities extends Business
{

	protected $_busTypeId = 2;

	protected $_cat2Name = 'Activity';

	protected $_cat3Name = 'Special Feature';

	protected $_cat3_col_id = 'cat1Id';
	protected $_cat3_col_name = 'catName';



	public function getBusinessType()
	{
		return 'Activities';
	}

	public function getCat1Name(){
		return $this->_cat1Name;
	}


	protected function _getCat2($cat1 = null)
	{
		if (empty($this->_cat2))
		{
			$refcat2 = new Refcategory();
			return $this->_cat2 = $refcat2->getAllCatsBySubPrimIdBusinessTypeId($this->_busTypeId, $this->_busTypeId);
		}
		else
		{
			return $this->_cat2;
		}

	}

	protected function _getCat3($cat2 = null)
	{
		if (empty($this->_cat3))
		{
			$refcat3 = new Refcat1();
			return $this->_cat3 = $refcat3->getAllCat1OfSpecificCategory($this->_busTypeId);
		}
		else
		{
			return $this->_cat3;
		}

	}



	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{
		logfire('restaurant cat2', $cat2);
		if (empty($cat2) || $cat2 == 'Any' || $cat2 == 'ALL')
		{
			$cat2 = null;
		}

		if (empty($cat3) || $cat3 == 'Any' || $cat3 == 'ALL' || $cat3 == 26)
		{
			$cat3 = null;
		}

		// cat3 actually is cat1
		$select = parent::search($location, $limit, $offset, $query, $cat3, $cat2, null, $cat4, $cat5, $addtionalData);


		if ($cat3 == null)
		{
			$keys = '';
			foreach($this->getCat1Array() as $key=>$value)
			{
				if (empty($keys))
				{
					$keys = $key;
				}
				else
				{
					$keys .= ','.$key;
				}
			}
			$select->where('cat1 in ('.$keys.')');
		}

		//echo $select;
		return $select;

	}



/*
	public function getResultTableHeader($location = null)
	{
		echo '<div class="resultheader" id="realesate">';
			echo '<span class="date">';
				echo 'Data';
			echo '</span>';
			echo '<span class="photo">';
				echo 'Photo';
			echo '</span>';
			echo '<span class="title">';
				echo 'Title';
			echo '</span>';
			echo '<span class="property">';
				echo 'Property Type';
			echo '</span>';
			echo '<span class="bed">';
				echo 'Bed';
			echo '</span>';
			echo '<span class="cars">';
				echo 'Cars';
			echo '</span>';
			echo '<span class="bath">';
				echo 'Bath';
			echo '</span>';
			echo '<span class="price">';
				echo 'Price ('. iconv("Windows-1252", "UTF-8", $location->getCurrencySymbol()) .')';
			echo '</span>';
		echo '</div>';

		return parent::getResultTableHeader();
	}
*/


	public function getResultTable($posting, $location = null)
	{
		try{
		echo '<table class="resultheader" id="realesate" cellspacing=0>';
			echo '<tr>';
				echo '<th class="cuisine">';
					echo 'Activity';
				echo '</th>';
				echo '<th class="location">';
					echo 'Location';
				echo '</th>';
				echo '<th class="title">';
					echo 'Title';
				echo '</th>';
				echo '<th class="Brochure">';
					echo 'Brochure';
				echo '</th>';
				echo '<th class="rating">';
					echo 'Rating';
				echo '</th>';
				echo '<th class="price">';
					echo 'Price <br />('. $location->getCurrencyAndSymbol() .')';
				echo '</th>';
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
			echo '<tr class="postingrow">';

				echo $this->getPostingInfoLinkHtml($value->cat2name, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->suburb, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->title, $value->postingid);

				echo $this->getPostingInfoLinkHtml(empty($value->attachment)?"No":"Yes", $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->rateNum, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->priceDisplay, $value->postingid);
			echo '</tr>';
		}

		echo '</table>';
		}catch(Exception $e)
		{
			logError('get results for restaurants', $e);
			echo $e;
		}
		return parent::getResultTable($posting);
	}


}
?>
