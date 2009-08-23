		<div id="contendheaderwrapper">
			<div id="firstline">
				<a href="/"><div id="resultpagelogo" class="smalllogo"></div></a>
				<div class="resultlocation">
					<?php echo $this->location->getCity() . ' ' . $this->location->getState() . ', ' . $this->location->getCountry()?>
				</div>
				<div class="locationswrap">
					<ul id="locationnav">
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, 'City Center', $this->location->getRegion())?><li>
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, 'North', $this->location->getRegion())?><li>
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, 'South', $this->location->getRegion())?><li>
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, 'East', $this->location->getRegion())?><li>
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, 'West', $this->location->getRegion())?><li>
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, $this->location->getCity(), $this->location->getRegion())?><li>
						<li><?php echo $this->replaceRegionInUri($this->router, $this->paramsHolder, 'Other', $this->location->getRegion())?><li>
						</ul>
					<div class="clear"></div>
				</div>
			</div>
			<div id="secondline">
					<ul id="categorynav">
						<li><?php echo $this->basicCategoryUri('Real Estate', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Jobs', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Classifieds', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Car sale', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Health & Fitness', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Events', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Activities', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Hotels', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Restaurants', $this->paramsHolder,  $this->category);?><li>
						<li><?php echo $this->basicCategoryUri('Business Listings', $this->paramsHolder,  $this->category);?><li>
					</ul>
					<div class="clear"></div>
			</div>
			<div class="headbotline"></div>
		</div>
