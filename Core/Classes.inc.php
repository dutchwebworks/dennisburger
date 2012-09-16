<?php
// mass replace placeholder for dynamic data
class htmlBlock 
{
	function __construct($array, $clean_block)
	{	
		foreach($array as $key => $value) {
			$current_row = $clean_block;
			
			if(is_array($value)) {
				foreach($value as $inner_key => $inner_value) {
					$current_row = str_replace('{'.$inner_key.'}', $inner_value, $current_row);
				}
			} else {
				$current_row = str_replace('{'.$key.'}', $value, $current_row);
			}
			$block_end .= $current_row;
		}
		$this->html_stuk = $block_end;
	}
	
	function parse()
	{
		return $this->html_stuk;
	}
}

// create html table from 2d array
class array2table
{
	var $array;
	var $border = 0;
	var $cellspacing = '0';
	var $cellpadding = '0';
	var $tr_valign = 'top';
	var $width;
	var $height;
	var $class = 'design';
	var $row_odd = 'odd';
	var $row_even = 'even';	
	var $null = '&nbsp;';
	var $recursive;	
	
	function create_table()
	{
		// sanity check
		if (empty($this->array) || !is_array($this->array)) return false; 
		if (!isset($this->array[0]) || !is_array($this->array[0])) $array = array($this->array);
 
		// start the table
		$table = '<table';
		
		$table .= ' cellspacing=\''.$this->cellspacing.'\'';
		$table .= ' cellpadding=\''.$this->cellpadding.'\'';		
		
		if($this->cellspacing) $table .= ' cellspacing=\''.$this->cellspacing.'\'';
		if($this->cellpadding) $table .= ' cellpadding=\''.$this->cellpadding.'\'';
		if($this->width) $table .= ' width=\''.$this->width.'\'';
		if($this->height) $table .= ' height=\''.$this->height.'\'';
		if($this->border) $table .= ' border=\''.$this->border.'\'';
		if($this->class) $table .= ' class=\''.$this->class.'\'';
		
		$table .= '>\n<tr>\n'; // the header		
		foreach (array_keys($this->array[0]) as $heading) if(!is_int($heading)) $table .= '\t<th>'.strtoupper(substr($heading, 0, 1)).substr($heading, 1).'</th>\n'; // Take the keys from the first row as the headings and capitilize the first letter
		$table .= '</tr>\n';	 
	
		// the body
		foreach ($this->array as $row) {
			$row_class++;
			$table .= '<tr valign=\''.$this->tr_valign.'\' class=\''.($row_class % 2 ? $this->row_odd : $this->row_even).'\'>\n' ;
			foreach ($row as $key_cell => $cell) {
				if(!is_int($key_cell)) {
					$table .= '\t<td>';
					// cast objects	
					if (is_object($cell)) $cell = (array) $cell;
					if ($this->recursive === true && is_array($cell) && !empty($cell)) {
						$table .= $this->create_table($cell, true, true) . '\n'; // recursive mode
					} else {
						$table .= (strlen($cell) > 0) ?	htmlspecialchars((string) $cell) : $this->null;
					} 
					$table .= '</td>\n';
				}
			}	 
			$table .= '</tr>\n';
		}
	 	$table .= '</table>'; // End the table
		return $table;
	}
}

// browseable table
class browse_table extends array2table
{
	var $start_row;							// record position to begin reading from
	var $limit = 10; 						// default amount of records to show
	var $jump_name = 'page_list';			// javascript jump menu name
	var $button_class = false;				// css class name of <p> the page buttons
	var $next_link_name = 'next page';		// name of the next page 'link'
	var $prev_link_name = 'previous page';	// name of the next page 'link'
	
	// formulate additional $_GET string
	function form_get_string($array)
	{
		if(is_array($array)) {
			foreach($array as $key => $value) {
				if($key != 'start_row') {
					$this->addition_get_string .= '&'.$key.'='.$value;
				}
			}
		}
	}	

	// create broweable table
	function create_browse_table($query)
	{
		// format query with limits
		$limit_query = $query.' LIMIT ';
		if($this->start_row) $limit_query .= $this->start_row.', ';
		if($this->limit) $limit_query .= $this->limit;		
		//echo($limit_query);
		
		// create the table
		$db = new Core_Database();
		$this->array = $db->db_array($limit_query);
		$table = $this->create_table();
		
		// previous button
		$pos_back= $this->start_row - $this->limit;
		if($pos_back < 0) {
			$link_previous = false;
		} else {
			$link_previous = '<a href=\'?start_row='.$pos_back.$this->addition_get_string.'\'>'.$this->prev_link_name.'</a>'; 
		}
		
		// page button css class
		if($this->button_class) {
			$table .= '\n<p class=\''.$this->button_class.'\'>'.$link_previous;
		} else {
			$table .= '\n<p>'.$link_previous;
		}
						
		// page pulldown list ------- !!! Don't forget to put the Javascript in the head!!
		$table .= '\n<select name=\"'.$this->jump_name.'\" onchange=\"MM_jumpMenu("parent",this,0)\'>\n';
		$records = $db->db_num_rows($query); // Tellen hoeveel er totaal zijn
		$aantal = $records / $this->limit;
		for($i=0; $i < $aantal ;$i++) {
			$list = $i+1;
			if($i==0) { 
				if($pos_new == $this->start_row) {
					$page_list .=	'\t<option>'.$list.'</option>\n';
				} else {
					$page_list .=	'\t<option value=\'?start_row='.$pos_new.$this->addition_get_string.'\'>'.$list.'</option>\n ';
				}
			} else {
				$pos_new = $i * $this->limit;
				if($pos_new == $this->start_row) {
					$page_list .= '\t<option selected=\'selected\'>'.$list.'</option>\n';
				} else {
					$page_list .= '\t<option value=\'?start_row='.$pos_new.$this->addition_get_string.'\'>'.$list.'</option>\n ';
				}
			}
		}
		$table .= $page_list.'</select>\n';
		
		// next button
		$pos_forward = $this->start_row + $this->limit;
		if($pos_forward >= $records) { 
			$link_next = false; 
		} else {
			$link_next='<a href=\'?start_row='.$pos_forward.$this->addition_get_string.'\'>'.$this->next_link_name.'</a>\n'; 
		}
		return $table .= $link_next.'</p>';
	}
}

// Create Excel spreadsheet form SQL query
class ExcelSpreadsheet
{
	var $query;
	function create($filename)
	{	
		if($this->query) {
			$db = new Core_Database();
			
			$export = $db->db_query($this->query);
			$fields = mysql_num_fields($export); 
			
			for ($i = 0; $i < $fields; $i++) { 
				$header .= mysql_field_name($export, $i) . '\t'; 
			} 
			
			while($row = mysql_fetch_row($export)) { 
				$line = ''; 
				foreach($row as $value) {
					if ((!isset($value)) OR ($value == '')) { 
						$value = '\t'; 
					} else { 
						$value = str_replace('', '""', $value); 
						$value = '"' . $value . '"' . '\t'; 
					} 
					$line .= $value; 
				} 
				$data .= trim($line).'\n'; 
			} 
			$data = str_replace('\r','',$data); 
			
			if ($data == '') { 
				$data = '\n(0) Records Found!\n';                         
			} 
			
			header('Content-type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$filename); 
			header('Pragma: no-cache'); 
			header('Expires: 0'); 
			die($header.'\n'.$data);			
		} else {
			return 'No query';
		}	
	}
}


// authenticate using base file password
class mod_auth_base 
{
	// parameters
	var $username;
	var $password;
	var $template = 'std_auth_base.tmp';
	var $redirect;
	
	var $message = 'Login';

	// login using config password
	function login()
	{
		global $settings;
		if($this->username == $settings['admin_username'] && md5($this->password) == $settings['admin_password']) {
			$_SESSION['acces'] = true; 
			return true;
		} else {
			$this->message = 'Login failed';
		}	
	}
	
	// logout proces
	function logout()
	{
		$_SESSION['acces'] = false;
		session_destroy();
		header('location: index.php', false);
	}
	
	function parse()
	{
		global $settings;
		$template = new Core_Template($settings['module_template_dir'].$this->template);
		$template->placeholder('{message}', $this->message);
		$finished = $template->return_as_string();
		print($finished);
	}

}

// mail class - made by AtlatisDesign
class atlantisStmpHtml
{
	var $force_headers = false; 				// the '-f' paramter
	var $post_attachement = array(); 			// post attachement
	var $subject = '[No subject specified]';	// default subject
	
	// formulate mail string & adresses
	function format_mail_string($array)
	{
		if(is_array($array)) {
			foreach($array as $naam => $email) {
				$string .= '\''.$naam.'\'<'.$email.'>,';
			}	
			return substr($string,0, -1);
		}
	}
	
	// $_POST attachement
	function add_attachment($post_attachment)
	{
		if($post_attachment) {
			// Obtain file upload vars
			$file      = $post_attachment['tmp_name'];
			$file_type = $post_attachment['type'];
			$file_name = $post_attachment['name'];
		
			$fd = fopen($file, 'rb');
			$data = fread($fd, filesize($file));
			fclose($fd);
			
			if($data) {
				$this->attachments .= '\n--528954287349image\n';
				$data = chunk_split(base64_encode($data));
				$this->attachments .= 'Content-Type: '.$file_type.'; name=\''.$file_name.'\';\n'.				
					'Content-Transfer-Encoding: base64\n'.
					'Content-Disposition: inline;\n\n'.
					$data . '\n\n';
			}
		}			
	}
	
	// formulate email and send
	function send_mail()
	{

		// headers
		$headers  = 'MIME-Version: 1.0\n';
		$headers .= 'Content-type: multipart/related; type=\'multipart/alternative\'; boundary=528954287349image\n';
		$headers .= 'To: '.$this->format_mail_string($this->to).'\n';
		$headers .= 'From: '.$this->format_mail_string($this->from).'\n';
		if($this->cc) $headers .= 'Cc: '.$this->format_mail_string($this->cc).'\n';
		if($this->bcc) $headers .= 'Bcc: '.$this->format_mail_string($this->bcc).'\n';
		if($this->reply_to) $headers .= 'Reply-To: '.$this->format_mail_string($this->reply_to).'\n';
	
		$mail_body .= '\n--528954287349image\n';
		$mail_body .= 'Content-Type: multipart/alternative; boundary=\'528954287349text\'\n';
		$mail_body .= '\n--528954287349text\n';
		$mail_body .= 'Content-type: text/plain\n\n';
		
		// plain text alternative
		if($this->text) {
			$mail_body .= $this->text;
		} else {
			$mail_body .= strip_tags($this->html);
		}
		
		//$mail_body .= 'Content-type: text/plain\n\n';
		$mail_body .= '\n--528954287349text\n';
		$mail_body .= 'Content-type: text/html\n\n';
		
		$mail_body .= wordwrap($this->html, 70); // html template
	
		$mail_body .= '\n--528954287349text--\n\n';			
		
		// Check for attachements
		if($this->attachments)	$mail_body .= $this->attachments;	
		
		// send the email
		if($this->to && $this->subject) {
			if($this->force_headers) {
				if(mail($this->format_mail_string($this->to), $this->subject, $mail_body, $headers, '-f'.$this->format_mail_string($this->to))) return true;			
			} else {
				if(mail($this->format_mail_string($this->to), $this->subject, $mail_body, $headers)) return true;			
			}
		}
		//print('<pre>'.$headers.$mail_body.'</pre>');
	}
}

// create unorderd lists of a koppel tabel
class AtlantisNav 
{
	var $koppel_tabel = 'nav';		// default tabel waar de pagina/nav koppelingen in staan
	var $pages_tabel = 'pages';		// default tabel waar de pagina's in staan
	var $show_head_subs = true; 	// go into creating sub-page nested <ul> lists from headlist?
	var $show_subs_subs = true; 	// go into creating sub-sub-page nested <ul> lists?
	var $nav_path_divider = '>';	// dividing the nav-path items horizontally
	var $head_id = 'head_nav';		// css id for head <ul> list
	var $sub_class = 'sub_nav';		// css class for sub <ul> list
	var $current_class = 'current';	// css class of current viewed item
	var $link_page;					// page to link menu items to: blank is 'itself'
		
	function headNav($koppel_id = false) // head-nav
	{ 
		$db = new Core_Database();	
		$head_nav_query = '
		SELECT '.$this->koppel_tabel.'.nav_id, '.$this->koppel_tabel.'.nav_koppel_id, '.$this->koppel_tabel.'.nav_page_id, '.$this->koppel_tabel.'.nav_link, '.$this->pages_tabel.'.page_heading
		FROM '.$this->koppel_tabel.', '.$this->pages_tabel.'
		WHERE '.$this->pages_tabel.'.page_id = '.$this->koppel_tabel.'.nav_page_id
		AND '.$this->koppel_tabel.'.nav_koppel_id = 0 
		ORDER BY '.$this->koppel_tabel.'.nav_order';
		
		if($menu = $db->db_array($head_nav_query)) { // head-nav 
			if($this->head_id) { // add css id
				$head_nav = '<ul id=\''.$this->head_id.'\'>\n';		
			} else {
				$head_nav = '<ul>\n';
			}
			
			foreach($menu as $row)  { // create list items
				if($row['nav_link']) {
					$head_nav .= '\t\t<li><a href=\''.$row['nav_link'].'\'>'.$row['page_heading'].'</a></li>\n';
				} elseif($row['nav_id'] == $koppel_id) {
					$head_nav .= '\t\t<li><a class=\''.$this->current_class.'\' href=\''.$this->link_page.'?id='.$row['nav_id'].'\'>'.$row['page_heading'].'</a></li>\n';
				} else {
					$head_nav .= '\t\t<li><a href=\''.$this->link_page.'?id='.$row['nav_id'].'\'>'.$row['page_heading'].'</a></li>\n';
				}
				if($this->show_head_subs) $head_nav .= $this->subNav($row['nav_id'], $koppel_id); // create sub-pages
			}
			return $head_nav.'</ul>\n';
		}
	}
	
	function subNav($nav_id, $koppel_id = false) // create list items// check for sub-pages
	{ 
		$query = '
		SELECT '.$this->koppel_tabel.'.nav_id, '.$this->pages_tabel.'.page_id, '.$this->koppel_tabel.'.nav_link, '.$this->pages_tabel.'.page_heading
		FROM '.$this->koppel_tabel.'
		LEFT JOIN '.$this->pages_tabel.' ON '.$this->pages_tabel.'.page_id = '.$this->koppel_tabel.'.nav_page_id
		WHERE '.$this->koppel_tabel.'.nav_koppel_id = '.$nav_id.' 
		ORDER BY '.$this->koppel_tabel.'.nav_order, '.$this->pages_tabel.'.page_heading';
		$db = new Core_Database();
		
		if($menu = $db->db_array($query)) { // sub-nav 
			if($this->sub_class) { // add css class 
				$sub_nav = '\t<ul class=\''.$this->sub_class.'\'>\n';
			} else {
				$sub_nav = '\t<ul>\n';
			}			
			foreach($menu as $row) { // create list items 
				if($row['nav_link']) {
					$sub_nav .= '\t\t<li><a href=\''.$row['nav_link'].'\'>'.$row['page_heading'].'</a></li>\n';
				} elseif($row['nav_id'] == $koppel_id) {
					$sub_nav .= '\t\t<li><a class=\''.$this->current_class.'\' href=\''.$this->link_page.'?id='.$row['nav_id'].'\'>'.$row['page_heading'].'</a></li>\n';
				} else {
					$sub_nav .= '\t\t<li><a href=\''.$this->link_page.'?id='.$row['nav_id'].'\'>'.$row['page_heading'].'</a></li>\n';
				}
				if($this->show_subs_subs) $sub_nav .= $this->subNav($row['nav_id'], $koppel_id); // re-check create sub-pages
			}
			return $sub_nav .= '\t</ul>\n';
		}		
	}
	
	function navPath($id, $string = '') // create navigation path selector 
	{
		global $string;
		$query = '
		SELECT '.$this->koppel_tabel.'.nav_id, '.$this->koppel_tabel.'.nav_koppel_id, '.$this->pages_tabel.'.page_heading
		FROM '.$this->pages_tabel.', '.$this->koppel_tabel.'
		WHERE '.$this->koppel_tabel.'.nav_page_id = '.$this->pages_tabel.'.page_id AND '.$this->koppel_tabel.'.nav_id = '.$id.'
		LIMIT 1';
		$db = new Core_Database();
		if($row = $db->db_row($query)) {
			$string[] = ($string[0])?'<a href="?id="'.$row['nav_id'].'">'.$row['page_heading'].'</a>':$row['page_heading'];
			if($row['nav_koppel_id']!=0) $this->navPath($row['nav_koppel_id'],$string);
			return $string;
		}
	}	
	
	function parse_headNav($id = false) // output the head-nav list
	{
		if($nav_list = $this->headNav($id)) {
			print($nav_list);
		} else {
			print('Head-navigation table not specified or empty');
		}
	}
	
	function parse_subNav($id) // output only the sub-nav list of a given head-nav-id
	{
		if($id) if($sub_nav = $this->subNav($id)) print($sub_nav);
	}
	
	function parse_navPath($id) // print navigation path
	{
		if($id) {
			if($nav_menu_array = $this->navPath($id)) {
				$nav_menu_array = array_reverse($nav_menu_array);
				foreach($nav_menu_array as $item) {
					$nav_menu_items .= $item.' '.$this->nav_path_divider.' ';
				}
				print $nav_menu_items = rtrim($nav_menu_items,' '.$this->nav_path_divider.' ');
			} else {
				print('Cannot create navigation path');
			}
		}
	}	
}