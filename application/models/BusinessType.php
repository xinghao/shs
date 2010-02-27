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
			default: throw new Exception("unknow business type for business." . $businessId);
		}
	}


	public static function getBusinessForm($businessId, $business, $location)
	{
		switch($businessId)
		{
			case 5: return new JobsRefineForm($business, $location);
			default: throw new Exception("unknow business type for businessform." . $businessId);
		}
	}

	public static function getPostingTabs($posting)
	{
		switch($posting->typeID)
		{
			case 5: return new JobDetailTab($posting);
			default: throw new Exception("unknow business type for posting." . $posting->typeID);
		}
	}


}
?>
