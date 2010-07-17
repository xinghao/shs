<?php
class Business
{
	protected $_cat1;

	protected $_cat2;

	protected $_cat3;

	protected $_cat4;

	protected $_cat5;

	protected $_busTypeId;

	protected $_cat1Name;

	protected $_cat2Name;

	protected $_cat3Name;

	protected $_cat4Name;

	protected $_cat5Name;

	protected $_cat3_col_id = 'id';
	protected $_cat3_col_name = 'name';



	/**
	 * Must be override by children
	 * @return string. For example Jobs.
	 */
	public function getBusinessType()
	{
		throw new Exception("Must be override by children");
	}


	public function getBusinessTypeId()
	{
		return $this->_busTypeId;
	}


	public function getCat1Name(){
		return $this->_cat1Name;
	}

	public function getCat1NameById($cat1)
	{
		$refCat1Tables = new Refcat1();
		return $refCat1Tables->getCatNameById($cat1);
	}

	public function getCat2NameById($cat2)
	{
		$refCat2Tables = new Refcategory();
		return $refCat2Tables->getCatNameById($cat2);
	}

	public function getCat3NameById($cat3)
	{
		$refCat3Tables = new Refcategory();
		return $refCat3Tables->getCatNameById($cat3);
	}
	public function getCat2Name(){
		return $this->_cat2Name;
	}

	public function getCat3Name(){
		return $this->_cat3Name;
	}

	public function getCat4Name(){
		return $this->_cat4Name;
	}

	public function getCat5Name(){
		return $this->_cat5Name;
	}

	protected function _getCat1()
	{
		if (empty($this->_cat1))
		{
			$refcat1 = new Refcat1();
			return $this->_cat1 = $refcat1->getAllCat1OfSpecificCategory($this->_busTypeId);
		}
		else
		{
			return $this->_cat1;
		}
	}

	protected function _getCat2($cat1 = null)
	{
		return null;

	}

	protected function _getCat3($cat2 = null)
	{
		return null;
	}

	/**
	 * Get states.
	 * @return unknown_type
	 */
	protected function _getCat4($cat3 = null)
	{
		return null;
	}

	/**
	 * Get all citis in one state.
	 * @return unknown_type
	 */
	protected function _getCat5($cat4 = null)
	{

		return null;
	}





	public function getCat1Array()
	{
		$cat1 = $this->_getCat1();

		$retArray = array();

		if (!empty($cat1))
		{
			foreach($cat1 as $cat1row)
			{
				//$retArray[$cat1row->cat1Id . '|' . $cat1row->catName] = $cat1row->catName;
				$retArray[$cat1row->cat1Id] = $cat1row->catName;
			}
		}

		return $retArray;
	}

	public function getFirstCat1()
	{
		$cat1s = $this->getCat1Array();

		if (empty($cat1s))
		{

			return null;
		}


		foreach($cat1s as $key=>$value)
		{

			return trim($key);
		}
	}

	public function getCat2Array($cat1 = null, $addAll = true)
	{
		$cat2 = $this->_getCat2($cat1);

		$retArray = array();

		if (!empty($cat2))
		{
			if ($addAll)
			{
				$retArray['Any'] = 'Any';
			}
			foreach($cat2 as $cat2row)
			{
				//$retArray[$cat2row->id . '|' . $cat2row->name] = $cat2row->name;
				$retArray[$cat2row->id] = $cat2row->name;
			}
		}

		return $retArray;
	}

	public function getFirstCat2($cat1 = null, $addAll = true)
	{
		$cat2s = $this->getCat2Array($cat1, $addAll);

		if (empty($cat2s))
		{
			return null;
		}


		foreach($cat2s as $key=>$value)
		{
			return $key;
		}
	}


	public function getCat3Array($cat2 = null, $addAll = true)
	{
		$cat3 = $this->_getCat3($cat2);

		$retArray = array();

//		logfire('cat3 add any', $addAll);
		if ($addAll)
		{
			$retArray['Any'] = 'Any';
		}

		if (!empty($cat3))
		{
			foreach($cat3 as $cat3row)
			{
				$col_id = $this->_cat3_col_id;
				$col_name = $this->_cat3_col_name;
				// $retArray[$cat3row->id . '|' . $cat3row->name] = $cat3row->name;
				$retArray[$cat3row->$col_id] = $cat3row->$col_name;
			}
		}

		return $retArray;
	}

	public function getFirstCat3($cat2 = null, $addAll = true)
	{
		$cat3s = $this->getCat3Array($cat2, $addAll);

		if (empty($cat3s))
		{
			return null;
		}


		foreach($cat3s as $key=>$value)
		{
			return $key;
		}
	}
	public function getCat4Array($cat3 = null, $addAll = true)
	{
		$cat4 = $this->_getCat4($cat3);

		$retArray = array();

		if (!empty($cat4))
		{
			if ($addAll)
			{
				$retArray['Any'] = 'Any';
			}

			foreach($cat4 as $cat4row)
			{
				$retArray[$cat4row->stateid] = $cat4row->state;
			}

		}

		return $retArray;
	}

	public function getFirstCat4($cat3 = null, $addAll = true)
	{

		$cat4s = $this->getCat4Array($cat3, $addAll);

		if (empty($cat4s))
		{
			return null;
		}


		foreach($cat4s as $key=>$value)
		{
			return $key;
		}

	}


	public function getCat5Array($cat4 = null, $addAll = true)
	{

		$cat5 = $this->_getCat5($cat4);

		$retArray = array();

		if (!empty($cat5))
		{
			if ($addAll)
			{
				$retArray['ALL'] = 'ALL';
			}

			foreach($cat5 as $cat5row)
			{
				// $retArray[$cat3row->id . '|' . $cat3row->name] = $cat3row->name;
				$retArray[$cat5row->cityid] = $cat5row->city;
			}
		}

		return $retArray;

	}

	public function getFirstCat5($cat4 = null, $addAll = true)
	{
		$cat5s = $this->getCat5Array($cat4, $addAll);

		if (empty($cat5s))
		{
			return null;
		}


		foreach($cat5s as $key=>$value)
		{
			return $key;
		}
	}


	public function search($location, $limit, $offset = 0, $query = null, $cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, $addtionalData = null)
	{


		$countryid = null;
		$stateid = null;
		$cityid = null;
		$regionid = null;
		$suburbid = null;

		$suburbid = $location->getSuburbId();
		if (empty($suburbid))
		{
			$regionid = $location->getRegionId();
			if (empty($regionid))
			{
				$cityid = $location->getCityId();
				if (empty($cityid))
				{
					$stateid = $location->getStateId();
					if (empty($statid))
					{
						$countryid = $location->getCountryId();
					}
				}
			}
		}

		return $this->getSearchSelect($limit, $offset = 0, $countryid, $stateid, $cityid, $regionid, $suburbid, $query, $cat1, $cat2, $cat3, $cat4, $cat5, $addtionalData);
	}


	protected function getSearchSelect($limit, $offset = 0, $countryid, $stateid, $cityid, $regionid, $suburbid, $title = null, $cat1 = null, $cat2 = null,$cat3 = null ,$cat4 = null, $cat5 = null, $addtionalData = null)
	{
		try
		{
			$pstitleTable = new Pstposting();

			$select = $pstitleTable->select()->setIntegrityCheck(false);

		    $psttitle = new Psttitle();
		   	$reflocTable = new Refloc();
		   	$refcat1Table = new Refcat1();
		   	$refcategoryTable = new Refcategory();

		    $select->from(array('a' => $pstitleTable->getTableName()))
		    			->join(array('b' => $psttitle->getTableName()),
		             			'a.id = b.id', array('a.*', 'b.title', 'postingid'=>'b.id'))
		    			->join(array('c' => $reflocTable->getTableName()),
		             			'a.locId = c.id')
		    			->joinLeft(array('d' => $refcat1Table->getTableName()),
		             			'a.cat1 = d.cat1Id',
		    			        array('cat1name' => 'catName'))
		    			->joinLeft(array('e' => $refcategoryTable->getTableName()),
		    					'a.cat2 = e.id',
		    					array('cat2name' => 'name'))
		    			->joinLeft(array('f' => $refcategoryTable->getTableName()),
		    					'a.cat3 = f.id',
		    					array('cat3name' => 'name'))
		    			->joinLeft(array('g' => $refcategoryTable->getTableName()),
		    					'a.cat4 = g.id',
		    					array('cat4name' => 'name'))
		    			->joinLeft(array('h' => $refcategoryTable->getTableName()),
		    					'a.cat5 = h.id',
		    					array('cat5name' => 'name'));

		    $select = $this->extraJoin($select);

		    $select = $select->where('status = ?', 1)
		    			->order('lastUPdateDate Desc');

	    	if (!empty($title))
	    	{
	    		//$select->where('match (title) against(?)', $title);
	    		$title = str_replace(' ', '%', $title);
	    		$select->where('title like ? or a.id = ?', '%' . $title . '%');

	    	}

           	if (!empty($stateid))
	    	{
	    		$select->where('stateid = ?', $stateid);
	    	}

           	if (!empty($cityid))
	    	{
	    		$select->where('cityid = ?', $cityid);
	    	}

           	if (!empty($countryid))
	    	{
	    		$select->where('countryid = ?', $countryid);
	    	}

	    	if (!empty($regionid))
	    	{
	    		$select->where('regionid = ?', $regionid);
	    	}

           	if (!empty($suburbid))
	    	{
	    		$select->where('suburbid = ?', $suburbid);
	    	}

	    	logfire('cat1', $cat1);
           	if (!empty($cat1) && $cat1 != 'ALL' && $cat1 != 'Any')
	    	{
	    		$select->where('cat1 = ?', $cat1);
	    	}

           	if (!empty($cat2)  && $cat2 != 'ALL' && $cat2 != 'Any')
	    	{
	    		$select->where('cat2 = ?', $cat2);
	    	}

	    	if (!empty($cat3)  && $cat3 != 'ALL' && $cat3 != 'Any')
	    	{
	    		$select->where('cat3 = ?', $cat3);
	    	}

	    	if (!empty($cat4)  && $cat4 != 'ALL' && $cat4 != 'Any')
	    	{
	    		$select->where('cat4 = ?', $cat4);
	    	}

           	if (!empty($cat5)  && $cat5 != 'ALL' && $cat5 != 'Any')
	    	{
	    		$select->where('cat5 = ?', $cat5);
	    	}




	    	logfire('searchselect', $select->__toString());

	    	return $select;
	    	/*
	    	$postings = $this->fetchAll($select);

	    	if (empty($postings))
	    	{
	    		return null;
	    	}
	    	else
	    	{
	    		return $postings;
	    	}
	    	*/
    	}catch(Exception $e)
 		{
 			logError('Pst_posting failed!', $e);
 			throw $e;
 		}

	}


	protected function extraJoin($select)
	{
		return $select;
	}




	public function getResultTable($posting, $location = null)
	{
		return null;
	}


	public function getPostingInfoLinkHtml($linkText, $postId, $wrapWithTd = true,  $css='', $tdCss = '')
	{
		$cssClass = '';
		if (!empty($css))
		{
			$cssClass = 'class = "'. $css.'"';
		}

		$retStr = '<a href="/posting/' . base64_encode($postId) .'" ' . $cssClass .'>' .  $linkText . '</a>';

		if ($wrapWithTd)
		{
			$tdCssClass = '';
			if (!empty($tdCss))
			{
				$tdCssClass = 'class = "'. $tdCss.'"';
			}

			$retStr = '<td ' .$tdCssClass . '>' . $retStr . '</td>';
		}

		return $retStr;

	}
}
?>
