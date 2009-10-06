<form action="/search" method="post">
  		<select class="shortselect"  name="qloc" onchange="submit();">
			<?php echo TemplatingManager::getLocationOption($this->location, TemplatingManager::HTMLTEMPLATE);?>
		</select>
		<input type="hidden" name="qcategory" value="<?=$this->category?>">
</form>
