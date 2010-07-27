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
			case 10: return "Business Listings";
			case 7: return "Health & Fitness";
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
			case 10: return new Listings();
			case 7: return new HealthAndFitness();
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
			case 10: return new ListingsRefineForm($business, $location);
			case 7: return new HealthAndFitnessRefineForm($business, $location);
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
			case 10: return new ListingsDetailTab($posting);
			case 7: return new HealthDetailTab($posting);
			default: throw new Exception("unknow business type for posting." . $posting->typeID);
		}
	}

	public static function getbasicSearchRouter($categoryName)
	{
		if ($categoryName == 'Car Sale')
		{
			return 'carsbasic';
		}
		else if ($categoryName == 'Health & Fitness')
		{
			return 'healthandfitnessbasic';
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
