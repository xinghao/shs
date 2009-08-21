<?php


/**
 * An exception raised if image resizing fails.
 */
class ImageResizingException extends Exception
{
	// TODO: [taz] Move this to an Exceptions/ folder, and use autoloading.
}




/**
 * Image resizing utility object.
 * 
 * [Xinghao] Change log:
 * We do not want to stretch images when the original size of image is less than our medium size/ large size standard.
 * So we use 'widthxheight>' to do resiez. 
 * 'widthxheight>' means: Change as per widthxheight but only if an image dimension exceeds a specified dimension.widthxheight< 	 
 * Details:http://www.imagemagick.org/script/command-line-processing.php#geometry
 * 
 * Requires the ImageMagick command line utility "convert" to be installed in PATH.
 * 
 * @author		Tasman Hayes <tasman.hayes@gmail.com>
 * @version		$Rev: 5231 $ $xinghao $Id: CanonicalLink.php  $Date: 2009-06-02 15:34:13 +1000 (Tue, 02 Jun 2009) $
 * @package		YPEX
 * @subpackage	Controllers
 * @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 *
 */
class CrFramework_Image_Resizer {
	
	/**
	 * Resize the image in $src_file path to the maximum dimensions $max_height, $max_width, putting the result in $dest_file path.
	 *
	 * @param string $src_file
	 * @param string $dest_file
	 * @param number $max_width
	 * @param number $max_height
	 */
	static function resize($src_file, $dest_file, $max_width, $max_height)
	{
		// [taz] Build the command and arguments to resize the image.
		// [xinghao] Using use 'widthxheight>' to do resiez.
		// We do want to lost the quality of images. 
		// So if the original size of image is less than our small/medium/large size, we do not stretch the image.

		$convertCmd = "convert " . $src_file . " -resize '" . $max_width . "x" . $max_height . ">' " . $dest_file;
		
		// [taz] Execute the command, saving the return value in case there were problems.
		exec($convertCmd, $convertOutputText, $convertReturnVal);
		
        // [taz] If the return code was non-zero, we were not successful.	
		if ($convertReturnVal) {
			
			$errorMsg = 'Image resizing failed.'
				. ' exec("' . $convertCmd . '") = ' . $convertReturnVal . '.';
			
			if ($convertReturnVal == 127) {
				// [taz] On CentOS, Ubuntu & Mac, this is the return code we get if the command can't be found.
				$errorMsg = 'convert is not installed or not in PHP\'s PATH. ' . $errorMsg;
				
			} elseif ($convertReturnVal == 126) {
				// [taz] On CentOS, Ubuntu & Mac, this is the return code we get if the command exists, but can't be executed.
				$errorMsg = 'convert exists, but can\'t execute it. Possible permissions issue. ' . $errorMsg;
				
			} else {
				// [taz] Otherwise, we have a unknown error (e.g. convert could understand the image format).
				true;
			}
			
			throw new ImageResizingException($errorMsg);
		}
	}
}