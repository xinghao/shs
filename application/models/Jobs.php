<?php
class Jobs extends Business
{
	
	protected $_busTypeId = 5;
	
	
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
		
		if ($cat1 == 12)
		{
			$cat1 = null;
		}
		
		$select = parent::search($location, $limit, $offset, $query, $cat1, $cat2, $cat3, $cat4, $cat5, $addtionalData);

		if ($orginalCat1 == 12)
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
				echo '<th class="date">';
					echo 'Data';			
				echo '</th>';
				echo '<th class="title">';
					echo 'Title';	
				echo '</th>';
				echo '<th class="category">';
					echo 'Category';			
				echo '</th>';
				echo '<th class="other">';
					echo 'Salary ('. $location->getCurrencyAndSymbol() .')';			
				echo '</th>';				
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
				echo '<tr class="postingrow">';
				echo '<td>' . $value->lastUpdateDate . '</td>' . "\n";
				echo '<td>' . $value->title . '</td>' . "\n";
				echo '<td>' . $value->cat1name . '/'. $value->cat2name. '</td>' . "\n";
				echo '<td>' . $value->priceDisplay . '</td>' . "\n";
				echo '</tr>';
		}
	
		echo '</table>';		
		return parent::getResultTable($posting);
	}
	
}    
?>
