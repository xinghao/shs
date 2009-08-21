		<div id="contendheaderwrapper">
			<div id="firstline">
				<div id="resultpagelogo" class="smalllogo">
				</div>
				<div class="resultlocation">
					<?php echo $this->location->getCity() . ' ' . $this->location->getState() . ', ' . $this->location->getCountry()?>
				</div>
				<div class="locationswrap">
					<ul id="locationnav">
						<li><a href="<?=$this->requestUri() . '/' . Tag::myUrlEncode('City Center')?>" <?php if ($this->location->getRegion() == 'City Center') echo 'class="menu_on"'?>>City Center</a></li>
						<li><a href="<?=$this->requestUri() . '/' . Tag::myUrlEncode('North')?>" <?php if ($this->location->getRegion() == 'North') echo 'class="menu_on"'?>>North</a></li>
						<li><a href="<?=$this->requestUri() . '/' . Tag::myUrlEncode('South')?>" <?php if ($this->location->getRegion() == 'South') echo 'class="menu_on"'?>>South</a></li>
						<li><a href="<?=$this->requestUri() . '/' . Tag::myUrlEncode('East')?>" <?php if ($this->location->getRegion() == 'East') echo 'class="menu_on"'?>>East</a></li>
						<li><a href="<?=$this->requestUri() . '/' . Tag::myUrlEncode('West')?>" <?php if ($this->location->getRegion() == 'West') echo 'class="menu_on"'?>>West</a></li>
						<li><a href="<?=$this->requestUri() . '/'?>" <?php if ($this->location->getRegion() == $this->location->getCity()) echo 'class="menu_on"'?>><?=$this->location->getCity()?></a></li>
						<li><a href="<?=$this->requestUri() . '/' . Tag::myUrlEncode('Other')?>" <?php if ($this->location->getRegion() == 'Other') echo 'class="menu_on"'?>>Other</a></li>
					</ul>
					<div class="clear"></div>
				</div>
			</div>
			<div id="secondline">
					<ul id="categorynav">
						<li><a href="<?=$this->ReplaceCategoryInUri('Real Estate')?>" <?php if ($this->category == 'Real Estate') echo 'class="menu_on"'?>>Real Estate</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Jobs')?>" <?php if ($this->category == 'Jobs') echo 'class="menu_on"'?>>Jobs</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Classifieds')?>" <?php if ($this->category == 'Classifieds') echo 'class="menu_on"'?>>Classifieds</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Car sale')?>" <?php if ($this->category == 'Car sale') echo 'class="menu_on"'?>>Car sale</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Health & Fitness')?>" <?php if ($this->category == 'Health & Fitness') echo 'class="menu_on"'?>>Health & Fitness</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Events')?>" <?php if ($this->category == 'Events') echo 'class="menu_on"'?>>Events</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Activites')?>" <?php if ($this->category == 'Activites') echo 'class="menu_on"'?>>Activites</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Hotels')?>" <?php if ($this->category == 'Hotels') echo 'class="menu_on"'?>>Hotels</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Restaurants')?>" <?php if ($this->category == 'Restaurants') echo 'class="menu_on"'?>>Restaurants</a></li>
						<li><a href="<?=$this->ReplaceCategoryInUri('Business Listings')?>" <?php if ($this->category == 'Business Listings') echo 'class="menu_on"'?>>Business Listings</a></li>
					</ul>
					<div class="clear"></div>
			</div>
		</div>
