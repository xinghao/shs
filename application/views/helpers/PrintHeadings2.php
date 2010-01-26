<?php
/**
 * @version	$Id: BaseUrl.php 3645 2009-03-24 04:27:32Z timw $
 * @author	Tim Woo <tim@airarena.net>
 */
class Zend_View_Helper_PrintHeadings2 {
    function printHeadings2($headings){
		echo '<ul class="headings2ul">';

		foreach($headings as $heading)
		{
			echo '<li><a target="_blank" href="' . $heading->heading2URL . '">' . $heading->heading2 . '</a></li>';
		}

		echo '</ul>';
    }
}