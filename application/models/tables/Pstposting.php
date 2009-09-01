<?php


class Pstposting extends Zend_Db_Table
{
	protected $_name = 'pst_posting';
    protected $_primary = 'id';
    
	 /**
	  * 
	  * @param $limit
	  * @param $offset
	  * @param $title
	  * @param $cat1
	  * @param $cat2
	  * @param $cat3
	  * @param $cat4
	  * @return unknown_type
	  */
    public function search($limit, $offset = 0, $countryid, $stateid, $cityid, $regionid, $suburbid, $title = null, $cat1 = null, $cat2 = null,$cat3 = null ,$cat4 = null)
    {
        try{
	    	$select = $this->select()->setIntegrityCheck(false);

	    	$psttitle = new Psttitle();
	    	$reflocTable = new Refloc();
	    	$refcat1Table = new Refcat1();
	    	$refcategoryTable = new Refcategory();
	    	
	    	$select->from(array('a' => $this->_name))
	    			->join(array('b' => $psttitle->getTableName()),
	             			'a.id = b.id')
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
	    					array('cat5name' => 'name'))	    					
	    			->where('status = ?', 1)
	    			->order('lastUPdateDate Desc');	    			
	    			//->limit($limit,$offset);

	    				    			
	    	if (!empty($title))
	    	{
	    		$select->where('match (title) against(?)', $title);
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
	    	
           	if (!empty($cat1) && $cat1 != 'ALL' )
	    	{
	    		$select->where('cat1 = ?', $cat1);
	    	}

           	if (!empty($cat2)  && $cat2 != 'ALL' )
	    	{
	    		$select->where('cat2 = ?', $cat2);
	    	}

	    	if (!empty($cat3)  && $cat3 != 'ALL' )
	    	{
	    		$select->where('cat3 = ?', $cat3);
	    	}
	    	
	    	if (!empty($cat4)  && $cat4 != 'ALL' )
	    	{
	    		$select->where('cat4 = ?', $cat4);
	    	}
	    	
           	if (!empty($cat5)  && $cat5 != 'ALL' )
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
    
}

