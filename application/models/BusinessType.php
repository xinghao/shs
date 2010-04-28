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
			case 6: return "Classifieds";
			case 2: return "Activities";
			case 9: return "Car Sale";
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
			case 6: return new Classifieds();
			case 2: return new Activities();
			case 9: return new Cars();
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
			case 6: return new ClassifiedsRefineForm($business, $location);
			case 2: return new ActivitiesRefineForm($business, $location);
			case 9: return new CarsRefineForm($business, $location);
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
			case 6: return new ClassifiedsDetailTab($posting);
			case 2: return new ActivitiesDetailTab($posting);
			case 9: return new CarsDetailTab($posting);
			default: throw new Exception("unknow business type for posting." . $posting->typeID);
		}
	}

	public static function getbasicSearchRouter($categoryName)
	{
		if ($categoryName == 'Car Sale')
		{
			return 'carsbasic';
		}
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
