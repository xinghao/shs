<?php
class Listings extends Business
{

	protected $_busTypeId = 10;

	protected $_cat2Name = 'Business Type';






	public function getBusinessType()
	{
		return 'Business Listings';
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





	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{
		logfire('cat2', $cat2);
		if (empty($cat2) || $cat2 == 'Any' || $cat2 == 'ALL')
		{
			$cat2 = null;
		}


		$select = parent::search($location, $limit, $offset, $query, $cat1, $cat2, $cat3, $cat4, $cat5, $addtionalData);


		if ($cat2 == null)
		{
			$keys = '';
			foreach($this->getCat2Array() as $key=>$value)
			{
				if (empty($keys) && $key != 'Any' && $key != 'ALL')
				{
					$keys = $key;
				}
				elseif($key != 'Any' && $key != 'ALL')
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
					echo 'Business<br />Type';
				echo '</th>';
				echo '<th class="suburb">';
					echo 'Suburb';
				echo '</th>';
				echo '<th class="businessname">';
					echo 'Business Name';
				echo '</th>';
				echo '<th class="rating">';
					echo 'Rating';
				echo '</th>';
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
			echo '<tr class="postingrow">';
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->cat2name;
				echo '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">';
				     echo $value->suburb;
				echo '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo $value->title;
				echo '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">';
					echo Common::Rate($value->rateNum);
				echo '</a></td>' . "\n";
			echo '</tr>';
		}

		echo '</table>';
		}catch(Exception $e)
		{
			logError('get results for classifieds', $e);
			echo $e;
		}
		return parent::getResultTable($posting);
	}


}
?>
