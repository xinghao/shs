<?php
class Classifieds extends Business
{

	protected $_busTypeId = 6;

	protected $_cat2Name = 'Category';






	public function getBusinessType()
	{
		return 'Classifieds';
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





	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{
		logfire('restaurant cat2', $cat2);
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
					echo 'Category';
				echo '</th>';
				echo '<th class="location">';
					echo 'Suburb';
				echo '</th>';
				echo '<th class="title">';
					echo 'Title';
				echo '</th>';
				echo '<th class="title">';
					echo 'Photo';
				echo '</th>';
				echo '<th class="price">';
					echo 'Price <br />('. $location->getCurrencyAndSymbol() .')';
				echo '</th>';
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
			echo '<tr class="postingrow">';
				echo '<td>';
					echo '<a href="/posting/' .$value->postingid .'">' . $value->cat2name . '</a> ';
				echo '</td>';
				echo '<td>';
				     echo '<a href="/posting/' .$value->postingid .'">' . $value->suburb . '</a> ';
				echo '</td>';
				echo '<td>';
					echo '<a href="/posting/' .$value->postingid .'">' . $value->title . '</a> ';
				echo '</td>';
				echo '<td>';
					echo '<a href="/posting/' .$value->postingid .'">' ;
					if (Pstposting::photoExists($value->photo))
					{
						echo "Yes";
					}
					else
					{
						echo "No";
					}

					echo '</a> ';
				echo '</td>';
				echo '<td>';
					echo '<a href="/posting/' .$value->postingid .'">' . $value->priceDisplay . '</a> ';
				echo '</td>';
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
