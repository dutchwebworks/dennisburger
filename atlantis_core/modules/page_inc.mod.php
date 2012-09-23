<?PHP
// Place template file like Server Side Includes
class page_inc{	
	function page_inc($page){
		global $settings;
		$file = $page.".tmp";
		$path = $settings['site_root'].$settings['includes'];
		
		if(check_file($file, $path)){
			include($path.$file);
		} else{
			print("<p class=\"attention\">Specified page: \"".$file."\" does not excists!</p>");
		}	
	}
}
?>