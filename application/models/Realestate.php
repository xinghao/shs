<?php
class Realestate extends Business
{

	protected $_busTypeId = 8;

	protected $_cat2Name = 'Select:';

	protected $_cat3Name = 'Select Property Type';




	public function getBusinessType()
	{
		return 'Real Estate';
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
		$select->where('SubPrimCatId = (select CONCAT( PrimID, SetID)  from ref_category_en where id = ?)', $cat2);
		return $this->_cat3 = $refcat3->fetchAll($select);

	}



	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{
		logfire('realstatesearch cat2', $cat2);
		if (empty($cat2))
		{
			$cat2 = 630;
		}
		if ($cat3 == 631||$cat3 == 639)
		{
			$cat3 = null;
		}

		$select = parent::search($location, $limit, $offset, $query, $cat1, $cat2, $cat3, $cat4, $cat5, $addtionalData);

		// TODO price;
		foreach($addtionalData as $key=>$value)
		{
			logfire($key,$value);
		}
		if (!empty($addtionalData['bed']) && $addtionalData['bed'] != 'Any' && $addtionalData['bed'] != 'ALL')
		{
			$select->where('i.rooms = ?', $addtionalData['bed']);
		}

		if (!empty($addtionalData['cars']) && $addtionalData['cars'] != 'Any' && $addtionalData['cars'] != 'ALL')
		{
			$select->where('i.parking = ?', $addtionalData['cars']);
		}

		if (!empty($addtionalData['bath']) && $addtionalData['bath'] != 'Any' && $addtionalData['bath'] != 'ALL')
		{
			$select->where('i.baths = ?', $addtionalData['bath']);
		}
		if (!empty($addtionalData['min']) && $addtionalData['min'] != 'Any' && $addtionalData['min'] != 'ALL')
		{
			$select->where('a.priceCalculate >= ?', $addtionalData['min']);
		}
		if (!empty($addtionalData['max']) && $addtionalData['max'] != 'Any' && $addtionalData['max'] != 'ALL')
		{
			$select->where('a.priceCalculate <= ?', $addtionalData['max']);
		}
		/*
		if ($cat3 == 631||$cat3 == 639)
		{
			$keys = '';
			foreach($this->getCat3Array($cat2, false) as $key=>$value)
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
			$select->where('cat3 in ('.$keys.')');
		}
		*/

		//echo $select;
		return $select;

	}


	protected function extraJoin($select)
	{
		$psthomes = new Psthome();
		$select->joinLeft(array('i' => $psthomes->getTableName()),
		    					'a.id = i.id',
		    					array('bed' => 'rooms', 'cars'=>'parking', 'bath'=>'baths'));
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
					echo 'Property<br />Type';
				echo '</th>';
				echo '<th class="location">';
					echo 'Location';
				echo '</th>';
				echo '<th class="title">';
					echo 'Title';
				echo '</th>';
				echo '<th class="bed">';
					echo 'Bed';
				echo '</th>';
				echo '<th class="cars">';
					echo 'Cars';
				echo '</th>';
				echo '<th class="bath">';
					echo 'Bath';
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
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->cat3name;
				echo '</td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->state;
				echo '</td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->title;
				echo '</td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->bed;
				echo '</td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->cars;
				echo '</td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->bath;
				echo '</td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					if (empty($value->photo) || $value->photo == '0000')
					{
						echo 'No';
					}
					else
					{
						echo 'Yes';
					}
				echo '</td>';

				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->priceDisplay;
				echo '</td>';
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

	public function getResultTableContent($posting)
	{
		echo '<div class="resultbar">';
		foreach($posting as $key=>$value)
		{
			echo '<div class="postingrow">' . "\n";
				echo '<span class="date">';
					echo $value->lastUpdateDate;
				echo '</span>';
				echo '<span class="photo">';
					echo $value->photo;
				echo '</span>';
				echo '<span class="title">';
					echo $value->title;
				echo '</span>';
				echo '<span class="property">';
					echo $value->cat3name;
				echo '</span>';
				echo '<span class="bed">';
					echo $value->rooms;
				echo '</span>';
				echo '<span class="cars">';
					echo $value->parking;
				echo '</span>';
				echo '<span class="bath">';
					echo $value->baths;
				echo '</span>';
				echo '<span class="price">';
					echo $value->priceDisplay;
				echo '</span>';
			echo '</div>';
		}

		echo '</div>';
		return parent::getResultTableContent($posting);
	}
}
?>
