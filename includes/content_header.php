		<div id="contendheaderwrapper">
			<div id="firstline">
				<a href="/"><div id="resultpagelogo" class="smalllogo"></div></a>
				<div class="resultlocation">
					<?php //echo $this->location->getCity() . '<br />' . $this->location->getState() . ', ' . $this->location->getCountry()
						 include (WEBSITE_ROOT."/includes/location_dropdown.php");
					?>

				</div>
				<div class="locationswrap">
					<ul id="locationnav">				
						<?php 
						// We change regin variable at above so we needs change it back.
						//$this->paramsHolder->region = $this->location->getRegion();
						echo $this->listAllCitiesInState($this->router, $this->paramsHolder);?>
						</ul>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
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
