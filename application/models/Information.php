<?php
class Information extends Business
{

	protected $_busTypeId = 99;

	protected $_cat1All = 11;
	protected $_cat1Name = 'Select:';

	protected $_cat2Name = 'Job Type';

	protected $_cat3Name = 'Job Sub-Type';

	protected $_cat4Name = 'State';

	protected $_cat5Name = 'City';



	public function getBusinessType()
	{
		return 'Information';
	}



	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{

		return null;

	}

	public function getResultTable($posting, $location = null)
	{
		return null;
	}



	public function getHeadings()
	{
		$pst_info_parents = new Pstinfoparents();
		return $pst_info_parents->getAllHeadings();
	}

	public function getHeadings2($headingid)
	{
		$pst_info_child = new Pstinfochildren();
		return $pst_info_child->getAllHeading2($headingid);
	}

	public function getHeadingById($headingid)
	{
		$pst_info_parents = new Pstinfoparents();
		return $pst_info_parents->getHeadingById($headingid);
	}

}
?>
