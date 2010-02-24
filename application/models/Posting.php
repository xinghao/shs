<?php
class Posting extends Zend_Db_Table_Row
{

	protected $_title = '';

	public function getTitle()
	{
		if (!empty($this->_title))
		{
			return $this->_title;
		}

		$psttileTable = new Psttitle();
		$this->_title = $psttileTable->getPsttitle($this->id);

		return $this->_title;
	}
}
?>
