<?php
class Cars extends Business
{

	protected $_busTypeId = 9;

	protected $_cat1Name = 'TYPE';

	protected $_cat2Name = 'Make';

	protected $_cat3Name = 'Model';




	public function getBusinessType()
	{
		return 'Cars';
	}

	public function getCat1Name(){
		return $this->_cat1Name;
	}


	protected function _getCat2($cat1 = null)
	{
		if (empty($this->_cat2))
		{
			$refcat2 = new Refcategory();
			return $this->_cat2 = $refcat2->getAllCat2OfSpecificCategory($this->_busTypeId);
		}
		else
		{
			return $this->_cat2;
		}

	}

	protected function _getCat3($cat2 = null)
	{
		$refcat3 = new Refcategory();
		$select = $refcat3->select();

		if ($cat2 == 'Any' || $cat2 == 'All')
		{
			$select->where('busPostTypeId = ? and SubPrimCatId is not null', $this->_busTypeId);
		}
		else
		{
			$select->where('SubPrimCatId = (select CONCAT( PrimID, SetID)  from ref_category_en where id = ?)', $cat2);
		}

		logfire('car cat3 ', $select);
		return $this->_cat3 = $refcat3->fetchAll($select);

	}



	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{

		if ($cat1 == 22)
		{
			$cat1 = null;
		}

		logfire('realstatesearch cat2', $cat2);
		if (empty($cat2) || $cat2 == 'Any' || $cat2 == 'ALL')
		{
			$cat2 = null;
		}
		if (empty($cat3) || $cat3 == 'Any' || $cat3 == 'ALL')
		{
			$cat3 = null;
		}

		$select = parent::search($location, $limit, $offset, $query, $cat1, $cat2, $cat3, $cat4, $cat5, $addtionalData);

		// TODO price;
		foreach($addtionalData as $key=>$value)
		{
			logfire($key,$value);
		}
		if (!empty($addtionalData['min']) && $addtionalData['min'] != 'Any' && $addtionalData['min'] != 'ALL')
		{
			$select->where('a.priceCalculate >= ?', $addtionalData['min']);
		}
		if (!empty($addtionalData['max']) && $addtionalData['max'] != 'Any' && $addtionalData['max'] != 'ALL')
		{
			$select->where('a.priceCalculate <= ?', $addtionalData['max']);
		}

		if (empty($cat1))
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

	protected function extraJoin($select)
	{
		$psthomes = new Pstcar();
		$select->joinLeft(array('i' => $psthomes->getTableName()),
		    					'a.id = i.id',
		    					array('makeYear'));
		return $select;
	}


/*
	protected function extraJoin($select)
	{
		$psthomes = new Psthome();
		$select->joinLeft(array('i' => $psthomes->getTableName()),
		    					'a.id = i.id',
		    					array('bed' => 'rooms', 'cars'=>'parking', 'bath'=>'baths'));
		return $select;
	}
	*/
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
					echo 'Type';
				echo '</th>';
				echo '<th class="suburb">';
					echo 'Suburb';
				echo '</th>';
				echo '<th class="title">';
					echo 'Title';
				echo '</th>';

				echo '<th class="makeyear">';
					echo 'Make / Year';
				echo '</th>';
				echo '<th class="model">';
					echo 'Model';
				echo '</th>';
				echo '<th class="photo">';
					echo 'Photo';
				echo '</th>';
				echo '<th class="price">';
					echo 'Price <br />('. $location->getCurrencyAndSymbol() .')';
				echo '</th>';
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
			echo '<tr class="postingrow">';

				echo $this->getPostingInfoLinkHtml($value->cat1name, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->suburb, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->title, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->cat2name . " / " . $value->makeYear, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->cat3name, $value->postingid);


					if (empty($value->photo) || $value->photo == '0000')
					{
						$tmpBool = 'No';
					}
					else
					{
						$tmpBool =  'Yes';
					}


				echo $this->getPostingInfoLinkHtml($tmpBool, $value->postingid);

				echo $this->getPostingInfoLinkHtml($value->priceDisplay, $value->postingid);
			echo '</tr>';
		}

		echo '</table>';
		}catch(Exception $e)
		{
			logError('get results for realestate', $e);
			echo $e;
		}
		return parent::getResultTable($posting);
	}


}
?>
