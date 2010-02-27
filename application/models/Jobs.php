<?php
class Jobs extends Business
{

	protected $_busTypeId = 5;

	protected $_cat1All = 11;
	protected $_cat1Name = 'Select:';

	protected $_cat2Name = 'Job Type';

	protected $_cat3Name = 'Job Sub-Type';

	protected $_cat4Name = 'State';

	protected $_cat5Name = 'City';



	public function getBusinessType()
	{
		return 'Jobs';
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
		return $this->_cat3 = $refcat3->getAllCat3OfSpecificCat2($cat2);

	}



	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{

		$orginalCat1 = $cat1;

		if ($cat1 == $this->_cat1All)
		{
			$cat1 = null;
		}

		$select = parent::search($location, $limit, $offset, $query, $cat1, $cat2, $cat3, $cat4, $cat5, $addtionalData);

		if ($orginalCat1 == $this->_cat1All)
		{
			logfire('sdfsdfsdfdsfdsfs',sizeof($this->getCat1Array()));
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

		logfire('job select', $select);
		return $select;

	}

	public function getResultTable($posting, $location = null)
	{

		echo '<table class="resultheader" id="jobs" cellspacing=0>';
			echo '<tr>';
				echo '<th class="jobtype">';
					echo 'Job<br />Type';
				echo '</th>';
				echo '<th class="jobcategory1">';
					echo 'Prim<br />Category';
				echo '</th>';
				echo '<th class="jobcategory2">';
					echo 'Second<br />Category';
				echo '</th>';
				echo '<th class="title">';
					echo 'Short<br />Description';
				echo '</th>';
				echo '<th class="price">';
					echo 'Salary <br />('. $location->getCurrencyAndSymbol() .')';
				echo '</th>';
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
				echo '<tr class="postingrow">';
				echo '<td><a href="/posting/' .$value->postingid .'">' . self::JobTypeShortFormat($value->cat1) . '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">' . $value->cat2name . '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">' . $value->cat3name . '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">' . $value->title . '</a></td>' . "\n";
				echo '<td><a href="/posting/' .$value->postingid .'">' . $value->priceDisplay . '</a></td>' . "\n";
				echo '</tr>';
		}

		echo '</table>';
		return parent::getResultTable($posting);
	}


	Public static function JobTypeShortFormat($cat1)
	{
		switch($cat1)
		{
			case 11: return 'ALL';
			case 12: return 'FT';
			case 13: return 'PT';
			case 14: return 'Cas';
			case 15: return 'Tem';
			case 16: return 'Grd';
			case 17: return 'Vol';
		}
	}
}
?>
