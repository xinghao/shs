<?php
class BusinessType
{
	public static function getBusinessType($businessId)
	{
		switch($businessId)
		{
			case 5: return "Jobs";
			case 8: return "Real Estate";
			case 1: return "Restaurants";
			default: throw new Exception("unknow business name for business." . $businessId);
		}
	}

	public static function getBusiness($businessId)
	{
		switch($businessId)
		{
			case 5: return new Jobs();
			case 8: return new Realestate();
			case 1: return new Restaurants();
			default: throw new Exception("unknow business type for business." . $businessId);
		}
	}


	public static function getBusinessForm($businessId, $business, $location)
	{
		switch($businessId)
		{
			case 5: return new JobsRefineForm($business, $location);
			case 8: return new RealestateRefineForm($business, $location);
			case 1: return new RestaurantsRefineForm($business, $location);
			default: throw new Exception("unknow business type for businessform." . $businessId);
		}
	}

	public static function getPostingTabs($posting)
	{
		switch($posting->typeID)
		{
			case 5: return new JobDetailTab($posting);
			case 8: return new RealestateDetailTab($posting);
			case 1: return new RestaurantsDetailTab($posting);
			default: throw new Exception("unknow business type for posting." . $posting->typeID);
		}
	}

	public static function getbasicSearchRouter($categoryName)
	{
		return strtolower(str_replace(' ', '' , $categoryName)) . 'basic';
		/*
		switch($businessId)
		{
			case 5: return "jobsbasic";
			default: throw new Exception("unknow business type for search router." . $businessId);
		}
		*/
	}


}
?>
