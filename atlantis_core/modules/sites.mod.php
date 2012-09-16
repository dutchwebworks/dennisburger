<?PHP

// article list module
class mod_sites{

	// parameters
	var $limit = false;
	var $order_by = "si.si_date DESC, si_title";
	var $template = "std_sites_list.tmp";
		
	// list of articles
	function sites_list(){
		global $settings, $db_table;
		
		$db = new Core_Database();
		
		$template = new Core_Template($settings['module_template_dir'].$this->template);
		$clean_block = $template->getblok("ITEMS");		// clean html

		$query = "SELECT si.si_title title, si.si_img thumb, si.si_url url, si.si_omschrijving omschrijving, si.si_werkzaamheden werkzaamheden, DATE_FORMAT(si.si_date, '%M %Y') datum, bd.bd_title bedrijf FROM  ".$db_table['sites']." si LEFT JOIN ".$db_table['bedrijven']." bd ON bd.bd_id = si.si_bedrijf";
		if($this->order_by) $query .= " ORDER BY ".$this->order_by;
		
		if($result = $db->db_array($query)){
			foreach($result as $db_row){
				$block_row = $clean_block;		// clean html	
				
				$block_row = str_replace("{title}", $db_row['title'], $block_row);
				
				// thumbnail plus link
				$thumbnail = false;
				if($db_row['thumb'] != null) {
					$thumbnail = "<img src=\"".$settings['thumbnail_dir'].$db_row['thumb']."\" class=\"thumb\" alt=\"".$db_row['title']."\" />";
					if ($db_row['url'] != null) {
						$thumbnail = "<a href=\"".$db_row['url']."\">".$thumbnail."</a>"; 
					}
				}
				$block_row = str_replace("{thumb}", $thumbnail ? "<p  class=\"thumb\">".$thumbnail."</p>" : "&nbsp;", $block_row);
				
				$block_row = str_replace("{url}", $db_row['url'] ? "<a href=\"".$db_row['url']."\" target=\"_blank\">".$db_row['url']."</a>" : false, $block_row);
				$block_row = str_replace("{url_img}", $settings['thumbnail_dir'].$db_row['thumb'], $block_row);
				$block_row = str_replace("{omschrijving}", $db_row['omschrijving'], $block_row);	
				$block_row = str_replace("{werkzaamheden}", $this->makeUnorderdList($db_row['werkzaamheden']), $block_row);
				$block_row = str_replace("{bedrijf}", $db_row['bedrijf'], $block_row);
				$block_row = str_replace("{datum}", $db_row['datum'], $block_row);

				@$block_end .= $block_row;
			}
			$template->placeholder("{ITEMS}", $block_end);
			$template->parse();
			return true;
		} else{
			print("<p>No items to display</p>");
		}
	}
	
	function makeUnorderdList($list){
		$arr_list = explode(";", $list);
		for($i = 0;$i < sizeof($arr_list); $i++) {
			@$end_list .= "<li>".$arr_list[$i]."</li>\n";
		}
		return "\n<ul>\n".$end_list."</ul>";
	}	
}
?>