		<div id="homepage_search_form">
				<form action="/search" method="post">
			  		<div id="q_location">
			  			<label class="where">Location</label>
			  			<select id="select_location" class="formselect"  name="qloc">
							<?php echo TemplatingManager::getLocationOption(null, TemplatingManager::HTMLTEMPLATE);?>
						</select>
			   		</div>
					<div id="q_category">
			  			<label class="what">Category</label>
			  			<select id="select_category" class="formselect"  name="qcategory">
							<!-- <option value="All"  selected="selected">All</option> -->
							<option value="Jobs">Jobs</option>
							<option value="Real Estate">Real Estate</option>
							<option value="Restaurants">Restaurants</option>
							<option value="Activities">Activities</option>
							<option value="Classifieds">Classifieds</option>
							<option value="Cars">Cars</option>
							<option value="Health & Fitness">Health & Fitness</option>
						</select>
					</div>
					<div id="q_btn">
						<label class="btn">&nbsp;</label>
						<input type="image" name="search" src="/images/sitetemplate/find.png"  class="search_btn" accesskey="enter" alt="Search now">
					</div>
					<div class="clear"></div>
				</form>
		</div>
