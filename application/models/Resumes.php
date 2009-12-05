<?php
class Resumes extends Jobs
{
	
	protected $_busTypeId = 11;
	protected $_cat1All = 30;
	
	public function getBusinessType()
	{
		return 'Resumes';
	}


	protected function extraJoin($select)
	{
		$psthomes = new Pstresume();
		$select->joinLeft(array('i' => $psthomes->getTableName()),
		    					'a.id = i.id',
		    					array('summaryExperience'));
		return $select;
	}
		
	public function getResultTable($posting, $location = null)
	{
		echo '<table class="resultheader" id="jobs" cellspacing=0>';
			echo '<tr>';
				echo '<th class="jobtype">';
					echo 'Job Type';			
				echo '</th>';
				echo '<th class="jobcategory1">';
					echo 'Category1';			
				echo '</th>';
				echo '<th class="jobcategory2">';
					echo 'Category2';			
				echo '</th>';								
				echo '<th class="title">';
					echo 'Title';	
				echo '</th>';
				echo '<th class="other">';
					echo 'Year <br />Experience';			
				echo '</th>';				
			echo '</tr>';
		foreach($posting as $key=>$value)
		{
				echo '<tr class="postingrow">';
				echo '<td>' . $value->cat1name . '</td>' . "\n";
				echo '<td>' . $value->cat2name . '</td>' . "\n";
				echo '<td>' . $value->cat3name . '</td>' . "\n";
				echo '<td>' . $value->title . '</td>' . "\n";
				echo '<td>' . $value->summaryExperience . '</td>' . "\n";
				echo '</tr>';
		}
	
		echo '</table>';		
		//return parent::getResultTable($posting);
	}
	
}    
?>
