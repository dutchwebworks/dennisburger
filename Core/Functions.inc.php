<?php
// ------- BEGIN PRESETS
$nl_maanden = array('01' => 'januari', '02' => 'februari', '03' => 'maart', '04' => 'april' , '05' => 'mei' , '06' => 'juni' , '07' => 'juli' , '08' => 'augustus' , '09' => 'september', '10' => 'oktober' , '11' => 'november' , '12' => 'december');
$nl_dagen = array('0' => 'Zondag' , '1' => 'Maandag' , '2' => 'Dinsdag' , '3' => 'Woensdag' , '4' => 'Donderdag' , '5' => 'Vrijdag' , '6' => 'Zaterdag');

// ------- BEGIN FUNCTIONS

// Check for file excistence
function check_file($file_to_check, $path)
{
	$dir_handle = @opendir($path);
	while ($file = readdir($dir_handle)) {
		if($file_to_check == $file){
			return true;
			break;
		}
	}
	closedir($dir_handle);
}

// Sort array value's, asc or desc
function sort_array($array, $order = 'asc') // default is ascending
{ 
	if($order == 'asc'){
		asort($array); // acending
	} elseif($order == "desc"){
		arsort($array); // decending
	}
	return $array;
}

// image dimension
function getImgDimension($img, $dim)
{
	$img_dim = getimagesize($img);
	
	$open_window['width'] = $img_dim[0]+50;
	$open_window['height'] = $img_dim[1]+50;	
	
	return $open_window[$dim];
}


// dir. to array and sort
function dir_to_array($path, $key, $asc=true)
{
	$filetypes = array(
		'txt' => 'Text',
		'pdf' => 'Pdf',
		'doc' => 'MS Word document',
		'xls' => 'MS Excel sheet',
		'zip' => 'Zip archive',
		'jpg' => 'Afbeelding',
		'JPG' => 'Afbeelding',
		'png' => 'Afbeelding',
		'PNG' => 'Afbeelding',
		'gif' => 'Afbeelding',
		'GIF' => 'Afbeelding'
	);

	$i = 0;	
	$dir_handle = @opendir($path);
	while ($file = readdir($dir_handle)) {
		if($file{0} != '.' && $file{0} != '/' && $file{0} != '_'){
			$dir[$i]['name'] = $file;
			
			$extensie = substr($file, -3);
			if ($filetypes[$extensie]){
				$type = $filetypes[$extensie];
			} else{
				$type = $extensie."-file";			
			}			
			$dir[$i]['type'] = $type;
			
			$dir[$i]['size'] = filesize($path.$file);
			$dir[$i]['date'] = filemtime($path.$file);
			
			$i++;
		}
	}
	closedir($dir_handle);
	
	return multi_sort($dir, $key, $asc); // sort according to class
}

// return human readable file size
function get_filesize($file)
{
	if ($file >= 1073741824){
		$file = number_format($file / 1073741824, 2);
		$unit = 'Gb';
	} elseif ($file >= 1048576) {
		$file = number_format($file / 1048576, 2);
		$unit = 'Mb';
	} elseif ($file >= 1024) {
		$file = number_format($file / 1024);
		$unit = 'Kb';
	} else {
		$file = number_format($file);
		$unit = 'bytes';
	}
	return $file.' '.$unit;
}

// sort class, works with 'dir_to_array' method
class array_sorter
{
   var $skey = false;
   var $sarray = false;
   var $sasc = true;

   function __construct(&$array, $key, $asc=true)
   {
       $this->sarray = $array;
       $this->skey = $key;
       $this->sasc = $asc;
   }

   function sortit($remap=true)
   {
       $array = &$this->sarray;
       uksort($array, array($this, '_as_cmp'));
       if ($remap)
       {
           $tmp = array();
           while (list($id, $data) = each($array))
               $tmp[] = $data;
           return $tmp;
       }
       return $array;
   }

   function _as_cmp($a, $b)
   {
       //since uksort will pass here only indexes get real values from our array
       if (!is_array($a) && !is_array($b))
       {
           $a = $this->sarray[$a][$this->skey];
           $b = $this->sarray[$b][$this->skey];
       }

       //if string - use string comparision
       if (!ctype_digit($a) && !ctype_digit($b))
       {
           if ($this->sasc)
               return strcasecmp($a, $b);
           else
               return strcasecmp($b, $a);
       }
       else
       {
       
		if ($a == $b)
		   return 0;
		if ($this->sasc)
		   return ($a > $b) ? 1 : -1;
		else
		   return ($a > $b) ? -1 : 1;       

       }
   }

}

function multi_sort(&$array, $key, $asc=true)
{
   $sorter = new array_sorter($array, $key, $asc);
   return $sorter->sortit();
}
// ------- END CLASSES

// write file
function writeFile($contents, $file, $dir = false)
{
	@unlink($dir.$file); // remove file
	@mkdir($dir); // create dir.
	@chmod($dir, 0777); // permissions
	
	if($file_handle = fopen($dir.$file,'a')) { // open file 
		if(fwrite($file_handle, $contents)) { // write file 
			fclose($file_handle); // close dir.
			chmod($dir.$file, 0777); // permissions
			return $file;
		}
	}
}

// validate email adres
function validateEmail($email) 
{
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
		return true;
	}
}

// validate url
function validateUrl($url) 
{
	if(preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}'.'((:[0-9]{1,5})?\/.*)?$/i' ,$url)){
		return true;
	}
}

// number format
function nrFormaat($input)
{
	return number_format($input, 2, ',', '.');
}

// time diff. between 2 mysql timestamps
function timediff($higher_time, $lower_time)
{
	$time_1['year'] = substr($higher_time, 0, 4);
	$time_1['month'] = substr($higher_time, 4, 2);
	$time_1['day'] = substr($higher_time, 6, 2);
	$time_1['hour'] = substr($higher_time, 8, 2);
	$time_1['minute'] = substr($higher_time, 10, 2);
	$time_1['sec'] = substr($higher_time, 12, 2);
	
	$time_2['year'] = substr($lower_time, 0, 4);
	$time_2['month'] = substr($lower_time, 4, 2);
	$time_2['day'] = substr($lower_time, 6, 2);
	$time_2['hour'] = substr($lower_time, 8, 2);
	$time_2['minute'] = substr($lower_time, 10, 2);
	$time_2['sec'] = substr($lower_time, 12, 2);	

	$epoch_1 = mktime($time_1['hour'],$time_1['minute'],$time_1['sec'],$time_1['month'],$time_1['day'],$time_1['year']);
	$epoch_2 = mktime($time_2['hour'],$time_2['minute'],$time_2['sec'],$time_2['month'],$time_2['day'],$time_2['year']);	
	$diff_seconds = $epoch_1 - $epoch_2;
	
	$diff['weeks'] = floor($diff_seconds/604800);
	$diff['year'] = $time_1['year'] - $time_2['year'];
	$diff['seconds'] -= $diff_weeks * 604800;
	$diff['days'] = floor($diff_seconds/86400);
	$diff['seconds'] -= $diff_days * 86400;
	$diff['hours'] = floor($diff_seconds/3600);
	$diff['seconds'] -= $diff_hours * 3600;
	$diff['minutes'] = floor($diff_seconds/60);
	$diff['seconds'] -= $diff_minutes * 60;
	$diff['seconds'] = $diff_seconds;
	
	$diff['epoch1'] = $epoch_1;
	$diff['epoch2'] = $epoch_2;
	
	return $diff;
}


// generate password
function generatePassword($length = 8)
{
  $password = '';  // start with a blank password
  $possible = '0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // define possible characters
  $i = 0; // set up a counter
    while ($i < $length) { // add random characters to $password until $length is reached
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);// pick a random character from the possible ones
    if (!strstr($password, $char)) { // we don't want this character if it's already in the password
      $password .= $char;
      $i++;
    }
  }
  return $password;
}

// highlight HTML string with span class
function highlight($highlight, $string, $class_name = 'highlight')
{
	return preg_replace( '/\b('.$highlight.')\b/i', '<span class=\''.$class_name.'\'>\\1</span>', $string );
}

// universal date format
function datum_formaat($mysql_timestamp, $unix_timestamp = false, $kind = 'nl_full')
{
	if($mysql_timestamp){
		if(strlen($mysql_timestamp) == 14){	// MySQL 4.0.x timestamp style
			$year = substr($mysql_timestamp, 0, 4);
			$month = substr($mysql_timestamp, 4, 2);
			$day = substr($mysql_timestamp, 6, 2);
			$hour = substr($mysql_timestamp, 8, 2);
			$minute = substr($mysql_timestamp, 10, 2);
			$sec = substr($mysql_timestamp, 12, 2);				
		} else{	// MySQL 4.1.x timestamp style						
			//$mysql_timestamp = preg_replace("([ \f\\t\n\v]|[[:punct:]])", "\0", $mysql_timestamp);

			$year = substr($mysql_timestamp, 0, 4);
			$month = substr($mysql_timestamp, 5, 2);
			$day = substr($mysql_timestamp, 8, 2);
			$hour = substr($mysql_timestamp, 11, 2);
			$minute = substr($mysql_timestamp, 14, 2);
			$sec = substr($mysql_timestamp, 17, 2);
		}
		
		$unix_timestamp = mktime($hour, $minute, $sec, $month, $day, $year);
	} else{
		$year = date('Y', $unix_timestamp);
		$month = date('m', $unix_timestamp);
		$day = date('d', $unix_timestamp);	
		$hour = date('G', $unix_timestamp);
		$minute = date('i', $unix_timestamp);
		$sec = date('s', $unix_timestamp);
		
		$mysql_timestamp = $year.$month.$day.$hour.$minute.$sec;
	}
	
	// dutch format
	global $nl_maanden; 
	global $nl_dagen;
	$nl_dag = date('w', $unix_timestamp); // day number of the week
	$nl_maand = date('m', $unix_timestamp); // month number
	
	// timestamp array
	$timestamp['mysql'] = $mysql_timestamp; // MySQL timestamp
	$timestamp['mysql_full'] = $year.'-'.$nl_maand.'-'.$day.' '.$hour.':'.$minute.':'.$sec; // numbers
	$timestamp['unix'] = $unix_timestamp; // Unix timestamp
	$timestamp['uk_full'] = date('l j F Y H:i', $unix_timestamp); // UK time
	$timestamp['nl_full'] = $nl_dagen[$nl_dag].' '.$day.' '.$nl_maanden[$nl_maand].' '.$year.' '.$hour.':'.$minute; // dutch time
	$timestamp['day'] = $nl_dagen[$nl_dag].' '.$day.' '.$nl_maanden[$nl_maand].' '.$year; // just days
	
	// complete return => used in pulldowndowns
	$timestamp['complete']['year'] = $year;
	$timestamp['complete']['month'] = intval($month);
	$timestamp['complete']['day'] = intval($day);
	$timestamp['complete']['hour'] = intval($hour);
	$timestamp['complete']['minute'] = intval($minute);
	$timestamp['complete']['sec'] = intval($sec);
	
	return $timestamp[$kind];
}

// CVS file to array
function cvs2array($delimiter, $input)
{
	$input = implode('', file($input));
	return explode($delimiter, stripslashes($input));
}

// upload file
function upload_file($file_to_upload, $upload_dir, $max_width = 100)
{
	if($file_to_upload) {
		if(!check_file($file_to_upload, $upload_dir)){ // file must not exist
			if($imageInfo = getimagesize($file_to_upload)){ // scale
				if($imageInfo[2] == 1){// gif
					$inputImg = imagecreatefromgif($file_to_upload);
				} elseif($imageInfo[2] == 2){//is jpg
					$inputImg = imagecreatefromjpeg($file_to_upload);
				} elseif($imageInfo[2] == 3){//png
					$inputImg = imagecreatefrompng($file_to_upload);
				} elseif($imageInfo[2] == 6){//bmp
					$inputImg = imagecreatefromwbmp($file_to_upload);
				}
				
				$srcX = imagesx($inputImg);
				$srcY = imagesy($inputImg);
				$dstY = 100;
				// $dstX = 100; // max width
				$dstX = $max_width ; // max width
				
				// scale image or move if smaller
				if($dstX < $srcX){ 
					$ratio = ($srcX / $dstX);
					$dstY  = ($srcY / $ratio);
					$outputImg = ImageCreateTrueColor($dstX, $dstY);
					imagefill($outputImg, 0, 0, imagecolorallocate($outputImg, 255, 255, 255));
					imagecopyresampled($outputImg, $inputImg,
								(($dstY - $dstY) / 2),0,0,0,
								$dstX, $dstY,
								$srcX, $srcY);
					imagedestroy($inputImg);					
					imagejpeg($outputImg, $upload_dir.$_FILES['file']['name'], 60); // move to upload dir
				} else{
					move_uploaded_file($file_to_upload, $upload_dir.$_FILES['file']['name']); // move or. to upload dir.
				}
				@chmod($upload_dir.$_FILES['file']['name'], 0777);
				$status = 'Image uploaded';
				
				$file_specs['name'] =  $_FILES['file']['name'];
				return $file_specs;
			}
		}
	}	
}

// for post data, start date pulldown at 0
function datum_add_nummer($nummer)
{
	if($nummer <= 9){
		return '0'.$nummer;
	} else{
		return $nummer;
	}
}


// date select pulldowns
function date_pulldown($mysql_timestamp = false){
	if(!$mysql_timestamp){
		$timestamp = datum_formaat(false, mktime(), 'complete'); // standard is current time
	} else{
		$timestamp = datum_formaat($mysql_timestamp, false, 'complete');
	}
	
	// year
	for ($y=substr($mysql_timestamp, 0, 4)-5; $y<=date('Y')+10; $y++) { // start form argument date minus 50 years
	//for ($y=substr($mysql_timestamp, 0, 4); $y<=date('Y')+10; $y++) { // start from argument year
	//for ($y=date('Y'); $y<=date('Y')+10; $y++) { // start from current year
		if($y == $timestamp['year']) {
			$year .= '<option value=\''.$y.'\' selected=\'selected\'>'.$y.'</option>\n';
		} else {
			$year .= '<option value=\''.$y.'\'>'.$y.'</option>\n';
		}		
	}
	$pulldown['year'] = $year;		
	

	// month
	global $nl_maanden; 
	global $nl_dagen;
	
	for ($m=1; $m<=12; $m++) {
		$maand_naam = $nl_maanden[datum_add_nummer($m)];
		if($m == $timestamp['month']){
			$month .= "<option value=\"".datum_add_nummer($m)."\" selected=\"selected\">".datum_add_nummer($m)." ".$maand_naam."</option>\n";
		} else {
			$month .= "<option value=\"".datum_add_nummer($m)."\">".datum_add_nummer($m)." ".$maand_naam."</option>\n";
		}		
	}
	$pulldown['month'] = $month;	
	
	// day
	for ($d=1; $d<=31; $d++) {
		if($d == $timestamp['day']){
			$day .= "<option value=\"".datum_add_nummer($d)."\" selected=\"selected\">".datum_add_nummer($d)."</option>\n";
		} else {
			$day .= "<option value=\"".datum_add_nummer($d)."\">".datum_add_nummer($d)."</option>\n";
		}		
	}
	$pulldown['days'] = $day;
	
	// hour
	for ($h=0; $h<=23; $h++) {
		if($h == $timestamp['hour']){
			$hour .= "<option value=\"".datum_add_nummer($h)."\" selected=\"selected\">".datum_add_nummer($h)."</option>\n";
		} else {
			$hour .= "<option value=\"".datum_add_nummer($h)."\">".datum_add_nummer($h)."</option>\n";
		}		
	}
	$pulldown['hour'] = $hour;	
	
	// minutes
	for ($min=0; $min<=59; $min++) {
		if($min == $timestamp['minute']){
			$minutes .= "<option value=\"".datum_add_nummer($min)."\" selected=\"selected\">".datum_add_nummer($min)."</option>\n";
		} else {
			$minutes .= "<option value=\"".datum_add_nummer($min)."\">".datum_add_nummer($min)."</option>\n";
		}		
	}
	$pulldown['minutes'] = $minutes;		
	
	// seconds
	for ($sec=0; $sec<=59; $sec++) {
		if($sec == $timestamp['sec']){
			$seconds .= "<option value=\"".datum_add_nummer($sec)."\" selected=\"selected\">".datum_add_nummer($sec)."</option>\n";
		} else {
			$seconds .= "<option value=\"".datum_add_nummer($sec)."\">".datum_add_nummer($sec)."</option>\n";
		}		
	}
	$pulldown['seconds'] = $seconds;		
	//$pulldown['datum'] = datum_formaat($mysql_timestamp);
	return $pulldown;
}

// realm auth. from db user table
function realmAuth($realm_name, $redirect){
	if($_SERVER['PHP_AUTH_USER'] && $_SERVER['PHP_AUTH_PW']){
		$db = new Core_Database();
		if($user = $db->db_row('SELECT id, cat, username, date_insert FROM users WHERE username = "'.$_SERVER['PHP_AUTH_USER'].'" AND password = PASSWORD("'.$_SERVER['PHP_AUTH_PW'].'") AND active = 1')) {
			$db->db_query('UPDATE users SET date_mod = NOW() WHERE username = "'.$_SERVER['PHP_AUTH_USER'].'"');
			$_SESSION['toegang'] = true;
			header('location: '.$redirect, false);
		}
	} else {
		header('WWW-Authenticate: Basic realm=\''.$realm_name.'\'');
		header( 'HTTP/1.0 401 Unauthorized');
	}
}

// simple convert from \n to p-tags
function br2p($input)
{
	$output = '<p>\n'.$input;
	$output = str_replace('\n\r', '</p>\n\n<p>', $output);
	return $output.'\n</p>';
}


// Bulletin board code -> compliant HTML 
// http://nl2.php.net/nl2br
// http://www.isolated-designs.net/core/projects/27/php-bbcode-functions

function bbcode($input) 
{
	// HTML chars converteren
	$output = stripslashes(htmlspecialchars(trim($input)));
	
	// New lines omzetten in HTML p tags
	$output = str_replace('<p></p>', '', '<p>' . preg_replace('#\n|\r#', '</p>$0<p>', $output) . '</p>');	
	
	// BBCode opzoeken
	$patterns = array( 
	'`\[b\](.+?)\[/b\]`is', 
	'`\[i\](.+?)\[/i\]`is', 
	'`\[u\](.+?)\[/u\]`is', 
	'`\[strike\](.+?)\[/strike\]`is', 
	'`\[color=#([0-9]{6})\](.+?)\[/color\]`is', 
	'`\[pre](.+?)\[/pre\]`is', 
	'`\[code](.+?)\[/code\]`is', 
	'`\[attention](.+?)\[/attention\]`is', 
	'`\[email\](.+?)\[/email\]`is', 
	'`\[img\](.+?)\[/img\]`is', 
	'`\[img=(.+?)\](.+?)\[/img\]`is', 
	'`\[url=([a-z0-9]+://)([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*?)?)\](.*?)\[/url\]`si', 
	'`\[url\]([a-z0-9]+?://){1}([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)\[/url\]`si', 
	'`\[url\]((www|ftp)\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*?)?)\[/url\]`si', 
	'`\[flash=([0-9]+),([0-9]+)\](.+?)\[/flash\]`is', 
	'`\[quote\](.+?)\[/quote\]`is', 
	'`\[indent](.+?)\[/indent\]`is', 
	'`<p>\[h([1-6]+)\](.+?)\[/h([1-6]+)\]</p>`is',
	'`<p>\[list\](.+?)\[/list\]</p>`is',
	'`<p>\[\*\](.+?)</p>`is',
	'`<ul></p>`is',
	'`<p></ul>`is',
	'`\[article=(.+?)\](.+?)\[/article\]`is',
	'`\[br\]`is'
	); 
	
	// BBCode vervangen door HTML
	$replaces =  array( 
	'<strong>\\1</strong>', 
	'<em>\\1</em>', 
	'<span style="border-bottom: 1px dotted">\\1</span>', 
	'<strike>\\1</strike>', 
	'<span style="color:#\1;">\2</span>',
	'<pre>\1</pre>',
	'<code>\1</code>', 
	'<span class=\"attention\">\1</span>', 
	'<a href="mailto:\1">\1</a>', 
	'<img src="\1" alt="" />', 
	'<img class="\1" src="\2" alt="" />', 
	'<a href="\1\2">\6</a>', 
	'<a href="\1\2">\1\2</a>', 
	'<a href="http://\1">\1</a>', 
	'<object width="\1" height="\2"><param name="movie" value="\3" /><embed src="\3" width="\1" height="\2"></embed></object>', 
	'<strong>Quote:</strong><div style="margin:0px 10px;padding:5px;background-color:#F7F7F7;border:1px dotted #CCCCCC;width:80%;"><em>\1</em></div>', 
	'<pre>\\1</pre>', 
	'<h\1>\2</h\1>',
	'<ul>\\1</ul>',
	'<li>\\1</li>',
	'<ul>',
	'</ul>',
	'<a href="/artikel\/\1">\2</a>',
	'<br />'
	);
	return preg_replace($patterns, $replaces , $output);
}
