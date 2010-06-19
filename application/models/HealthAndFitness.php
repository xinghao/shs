<?php
class HealthAndFitness extends Business
{

	protected $_busTypeId = 7;

	protected $_cat2Name = 'Health Category';

	protected $_cat3Name = 'Sub Category';




	public function getBusinessType()
	{
		return 'Healthandfitness';
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



		if (empty($cat2))
		{
			$keys = '';
			foreach($this->getCat2Array(null,false) as $key=>$value)
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
			$select->where('cat2 in ('.$keys.')');
		}


		//echo $select;
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
					echo 'Category';
				echo '</th>';
				echo '<th class="suburb">';
					echo 'Suburb';
				echo '</th>';
				echo '<th class="title">';
					echo 'Business<br />Name';
				echo '</th>';
				echo '<th class="Rating">';
					echo 'Rating';
				echo '</th>';

			echo '</tr>';
		foreach($posting as $key=>$value)
		{
			echo '<tr class="postingrow">';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->cat1name . '<br />' . $value->cat2name;
				echo '</a></td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->suburb;
				echo '</a></td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->title;
				echo '</a></td>';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo Common::Rate($value->rateNum);
				echo '</a></td>';
			echo '</tr>';
		}

		echo '</table>';
		}catch(Exception $e)
		{
			logError('get results for health and fitness', $e);
			echo $e;
		}
		return parent::getResultTable($posting);
	}


}
?>
