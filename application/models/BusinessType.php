<?php
class BusinessType
{
	public static function getBusinessType($businessId)
	{
		switch($businessId)
		{
			case 5: return "Jobs";
			default: return "Jobs";
		}
	}

	public static function getBusiness($businessId)
	{
		switch($businessId)
		{
			case 5: return new Jobs();
			default: return new Jobs();
		}
	}


	public static function getBusinessForm($businessId, $business, $location)
	{
		switch($businessId)
		{
			case 5: return new JobsRefineForm($business, $location);
			default: return new JobsRefineForm($business, $location);
		}
	}
}
?>
