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

		if ($this->typeID == 8)
		{
			if ($this->cat2 == 630)
			{
				$type = 'For Sale';
			}
			else if ($this->cat2 == 638)
			{
				$type = 'For Lease';
			}
			else if ($this->cat2 == 645)
			{
       			$type = 'For Share';
			}
			$this->_title .= ' - ' . $type .'<br/>';
			$cat1Table =new Refcat1();
			$this->_title .= $this->priceDisplay . ' - ' . $cat1Table->getCatNameById($this->cat1);
		}

		return $this->_title;
	}

	public function setTitle($title)
	{
		$this->_title = $title;
	}
}
?>
