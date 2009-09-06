<form action="/search" method="post">
  		<select class="shortselect"  name="qloc" onchange="submit();">
			<?php echo TemplatingManager::getLocationOption($this->location->getCity() . '|' . $this->location->getState() . '|' . $this->location->getCountry(), TemplatingManager::HTMLTEMPLATE);?>
		</select>
		<input type="hidden" name="qcategory" value="<?=$this->category?>">
</form>
