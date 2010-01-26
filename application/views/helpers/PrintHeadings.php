<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_PrintHeadings {
    function printHeadings($headings, $currentHeadingId, $value){
		echo '<ul class="headingsul">';

		foreach($headings as $heading)
		{
			$cssClass = "";

			if ($heading->id == $currentHeadingId)
			{
				$cssClass = 'class="menuon"';
			}

			$value->headingid = $heading->id;


			echo '<li ' . $cssClass . '><span class="liststyle">-</span><span> ' . Tag::link('informationbasic', $value, $heading->heading) . '</span></li>';
		}

		echo '</ul>';
    }
}