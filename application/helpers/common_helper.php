<?php

function format_content($str){
    $str = str_replace("<br /><br />","<p class='p_line'></p>",$str);
    return $str; 
}

function printr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

/**
 * Split new line from text enter break
 * @param text
 * @return array
 */
function splitNewLine($text) {
    $code = preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n",$text)));
    return explode("\n",$code);
}

/** Filter content before parse
 * @param html
 * @param skip (skip url if you want not insert) 
**/
function filter_content($html, $skip="congnghe123.net"){
    //Insert nofollow in link
    return preg_replace_callback(
        "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
            return (
                !($skip && strpos($mach[1], $skip) !== false) &&
                strpos($mach[1], 'rel=') === false
            ) ? $mach[1] . 'target="_blank" rel="nofollow">' : $mach[0];
        },
        $html
    );
}

function insert_target_blank($str){
    if(strpos($str, "target = ") === false && strpos($str, "target= ") === false)
        $str = str_replace("<a href=","<a target='_blank' href=", $str);
    return $str;        
}

function clean_url($url){
    $url = trim($url);
    $url = str_replace(array("'","`","“","”","!"),array("","","","",""),$url);
    return $url;
}


/**
 * Upper firsh string
 * @param string ntson1009
 * @return string Ntson1009
 **/
function upper_first_string($str){
    $exp = explode(" ",trim($str));
    $exp[0] = ucwords($exp[0]);
    //upper vietnamese
    $char = substr($exp[0],0,2);
    $arr_find = array("đ","ê","ô","â","ă");
    $arr_replace = array("Đ","Ê","Ô","Â","Ă");
    $char = str_replace($arr_find,$arr_replace,$char);
    $exp[0] = $char.substr($exp[0],2);
    return implode(" ",$exp);
}

/**
 * Check url exist
 * code == 200 yes - else no exist
 * @param url
 **/
function check_url_exist($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
    return $code;
}

/**
 * Check curl function
 * @return true | false
 **/
function check_curl(){
    if(function_exists('curl_version'))
      return true;
    else
      return false;
}

function check_url_valid($url){
    $regex  = "/^((http|ftp|https):\/\/)?([\w-]+(\.[\w-]+)+)([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?$/i";
    if(!preg_match( $regex, $url, $matches ) )
        return false;
    else
        return true;
}


/**
 * Khoang cach giua 2 ngay
 * @param timestamp1
 * @param timestamp2
 * timestamp2 - timestamp1
 **/
function minus_day($timestamp1, $timestamp2){
    $conlai = $timestamp2 - $timestamp1;
    $day = ceil($conlai / 86400);
    return $day;
}

function getTimeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s'){
	return dateDiff(date('Y-m-d', $timestamp), time());
}

// Time format is UNIX timestamp or
// PHP strtotime compatible strings
function dateDiff($time1, $time2, $precision = 6) {

	// Set timezone
	date_default_timezone_set("UTC");

	// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
	  $time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
	  $time2 = strtotime($time2);
	}

	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
	  $ttime = $time1;
	  $time1 = $time2;
	  $time2 = $ttime;
	}

	// Set up intervals and diffs arrays
	$intervals = array('year','month','day');//,'hour','minute','second'
	$diffs = array();

	// Loop thru all intervals
	foreach ($intervals as $interval) {
	  // Set default diff to 0
	  $diffs[$interval] = 0;
	  // Create temp time from time1 and interval
	  $ttime = strtotime("+1 " . $interval, $time1);
	  // Loop until temp time is smaller than time2
	  while ($time2 >= $ttime) {
		$time1 = $ttime;
		$diffs[$interval]++;
		// Create new temp time from time1 and interval
		$ttime = strtotime("+1 " . $interval, $time1);
	  }
	}

	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
	  // Break if we have needed precission
	  if ($count >= $precision) {
		break;
	  }
	  // Add value and interval
	  // if value is bigger than 0
	  if ($value > 0) {
		// Add s if value is not 1
		if ($value != 1) {
		  $interval .= "s";
		}
		// Add value and interval to times array
		$times[] = $value . " " . $interval;
		$count++;
	  }
	}
	// Return string with times
	return implode(", ", $times);
}


/** get some element random **/
function array_random($arr, $num = 1) {
    shuffle($arr);

    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}

/** format number
 * @param number 1000 => 1.000
 **/
function format_number($number){
    return number_format($number,0,".",".");
}

function text_2_link($text){
$reg_exUrl = "/((((http|https|ftp|ftps)\:\/\/)|www\.)?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?)/";
$text = preg_replace( $reg_exUrl, "<a href=\"$1\" target='_blank' class='alink'>$1</a>", $text);
return $text;
}


function upper($str) {
    $lower = '
    a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z
    |á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ
    |đ
    |é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ
    |í|ì|ỉ|ĩ|ị
    |ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ
    |ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự
    |ý|ỳ|ỷ|ỹ|ỵ';
    $upper = '
    A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z
    |Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ
    |Đ
    |É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ
    |Í|Ì|Ỉ|Ĩ|Ị
    |Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ
    |Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự
    |Ý|Ỳ|Ỷ|Ỹ|Ỵ';
    $arrayUpper = explode('|',str_replace("/\n|\t|\r/","",$upper));
    $arrayLower = explode('|',str_replace("/\n|\t|\r/","",$lower));
    return str_replace($arrayLower,$arrayUpper,$str);
    //return str_replace($arrayUpper,$arrayLower,$str);
}
/** Cut 1 string vietnamese **/
function cut_string($value, $length)
{
    if($value!=''){
    if(is_array($value)) list($string, $match_to) = $value;
    else { $string = $value; $match_to = $value[0]; } // đổi lại khi làm xong $value{0};
    $match_start = stristr($string, $match_to);
    $match_compute = strlen($string) - strlen($match_start);
    if (strlen($string) > $length)
    {
        if ($match_compute < ($length - strlen($match_to)))
        {
            $pre_string = substr($string, 0, $length);
            $pos_end = strrpos($pre_string, " ");
            if($pos_end === false) $string = $pre_string."...";
            else $string = substr($pre_string, 0, $pos_end)."...";
        }
        else if ($match_compute > (strlen($string) - ($length - strlen($match_to))))
        {
            $pre_string = substr($string, (strlen($string) - ($length - strlen($match_to))));
            $pos_start = strpos($pre_string, " ");
            $string = "...".substr($pre_string, $pos_start);
            if($pos_start === false) $string = "...".$pre_string;
            else $string = "...".substr($pre_string, $pos_start);
        }
        else
        {
            $pre_string = substr($string, ($match_compute - round(($length / 3))), $length);
            $pos_start = strpos($pre_string, " "); $pos_end = strrpos($pre_string, " ");
            $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
            if($pos_start === false && $pos_end === false) $string = "...".$pre_string."...";
            else $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
        }
        $match_start = stristr($string, $match_to);
        $match_compute = strlen($string) - strlen($match_start);
    }
    return $string;
    }else{
        return $string ='';
    }
}

function string_2_slug($str){
    return strtolower(url_title(removesign($str)));
}


function removesign($str)
{
    $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
    ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
    "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
    ,"ờ","ớ","ợ","ở","ỡ",
    "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
    "ỳ","ý","ỵ","ỷ","ỹ",
    "đ",
    "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
    ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
    "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
    "Ì","Í","Ị","Ỉ","Ĩ",
    "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
    ,"Ờ","Ớ","Ợ","Ở","Ỡ",
    "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
    "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
    "Đ","ê","ù","à");
    $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
    ,"a","a","a","a","a","a",
    "e","e","e","e","e","e","e","e","e","e","e",
    "i","i","i","i","i",
    "o","o","o","o","o","o","o","o","o","o","o","o"
    ,"o","o","o","o","o",
    "u","u","u","u","u","u","u","u","u","u","u",
    "y","y","y","y","y",
    "d",
    "A","A","A","A","A","A","A","A","A","A","A","A"
    ,"A","A","A","A","A",
    "E","E","E","E","E","E","E","E","E","E","E",
    "I","I","I","I","I",
    "O","O","O","O","O","O","O","O","O","O","O","O"
    ,"O","O","O","O","O",
    "U","U","U","U","U","U","U","U","U","U","U",
    "Y","Y","Y","Y","Y",
    "D","e","u","a");
    return str_replace($coDau,$khongDau,$str);
}

function strip_tags_content($text, $tags = '', $invert = FALSE) {
  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
  $tags = array_unique($tags[1]);
  if(is_array($tags) AND count($tags) > 0) {
    if($invert == FALSE) {
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    else {
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
  }
  elseif($invert == FALSE) {
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
  }
  return $text;
}

/** remove html code => return text **/
function remove_html($text){
	$text = preg_replace(
		array(
			// Remove invisible content
			'@<head[^>]*?>.*?</head>@siu',
			'@<style[^>]*?>.*?</style>@siu',
			'@<script[^>]*?.*?</script>@siu',
			'@<object[^>]*?.*?</object>@siu',
			'@<embed[^>]*?.*?</embed>@siu',
			'@<applet[^>]*?.*?</applet>@siu',
			'@<noframes[^>]*?.*?</noframes>@siu',
			'@<noscript[^>]*?.*?</noscript>@siu',
			'@<noembed[^>]*?.*?</noembed>@siu',
			// Add line breaks before & after blocks
			'@<((br)|(hr))@iu',
			'@</?((address)|(blockquote)|(center)|(del))@iu',
			'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
			'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
			'@</?((table)|(th)|(td)|(caption))@iu',
			'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
			'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
			'@</?((frameset)|(frame)|(iframe))@iu',
		),
		array(
			' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
			"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
			"\n\$0", "\n\$0",
		),
		$text );
	return strip_tags( $text );
}


/**
 * Make random character
 * @param length
 **/
function randLetter($length){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen( $chars );
	$str = "";
    for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
}


/**
 * Make day array from start - end time
 * @param startDate : timestamp
 * @param endDate : timestamp
 * @return array date
 **/
function makeDayArray($startDate,$endDate){
 // New Variables
  $currDate  = $startDate;
  $dayArray  = array();
 // Loop until we have the Array
  do{
    $dayArray[] = date('d-m-Y', $currDate );
    $currDate = strtotime( '+1 day' , $currDate );
  } while( $currDate<=$endDate );
 // Return the Array
  return $dayArray;
}

/**
 * Send email
 * @param to email
 * @param to name
 * @param subject
 * @param content
 * @param cc array value
 **/
function sendMail($to_email, $to_name, $subject, $body, $cc="")
{
    include("includes/phpmailer/class.phpmailer.php");
    $mail = new phpmailer();
    $mail->Host     = "localhost";
    //$mail->IsSendmail();
    $mail->IsHTML(true);
    $mail->SMTPDebug  = 1;

    $mail->CharSet	  =	"utf8";
    $mail->SetFrom("noreply@tkweb.textlink.vn", "Textlink - Tkweb");

    $mail->ClearReplyTos();
    $mail->AddReplyTo("support@tkweb.textlink.vn", "tkweb.textlink.vn Support");

    $signature= '';
	$mail->Subject= $subject;
	$mail->Body= $body;

	$mail->ClearAddresses();
	$mail->AddAddress($to_email, $to_name);
    //Cc
    if($cc){
        foreach($cc as $c){
            $mail->AddCC($c);    
        }            
    }    
    //Send
	if(!$mail->Send())
		return false;
	else
		return true;
}


function objectToArray($d) {
    if (is_object($d))
        $d = get_object_vars($d);
    if (is_array($d))
        return array_map(__FUNCTION__, $d);
    else
        return $d;
}

function array_to_object($array){
  return (is_array($array)) ? (object) array_map(__FUNCTION__, $array) : $array;
}

/**
 * sub two day
 * @param day1 Y-m-d H:i:s
 * @param day2 Y-m-d H:i:s
 * @return number day : day2 - day1
 **/
function sub_time($day1,$day2=null){
    $day1 = explode(" ",$day1);
    $time1 = strtotime($day1[0]);
    if($day2 == null)
        $time2 = time();
    else{
        $day2 = explode(" ",$day2);
        $time2 = strtotime($day2[0]);
    }
    $time = $time2 - $time1;
    $days = floor($time/86400);
    return $days;
}


/**
 * Sort array in key
 * @param array value
 * @param key
 * @param sort_type
 *
**/
function sort_array_by_key(&$array, $subkey="id", $sort_descending=false, $keep_keys_in_sub = false) {
    $temp_array = $array;

    foreach ($temp_array as $key => &$value) {

      $sort = array();
      foreach ($value as $index => $val) {
          $sort[$index] = $val[$subkey];
      }

      asort($sort);
      $keys = array_keys($sort);
      $newValue = array();
      foreach ($keys as $index) {
        if($keep_keys_in_sub)
            $newValue[$index] = $value[$index];
          else
            $newValue[] = $value[$index];
      }

      if($sort_descending)
        $value = array_reverse($newValue, $keep_keys_in_sub);
      else
        $value = $newValue;
    }

    return $temp_array;
}

/** Get data from curl via url
 * @param url
 * @param time connect
 * @param time out
**/
function get_data($url,$time_conn=10, $time_out=30) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_POST, TRUE);             // Use POST method
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=1&var2=2&var3=3");  // Define POST data values
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $time_conn); //time connect
    curl_setopt($ch, CURLOPT_TIMEOUT, $time_out); //Time get data
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * encrypt string
 * @param key
 * @return string encrypt
 **/
function str_encrypt($key){
    $key1 = substr(md5("id"),0,5);
    $key2 = substr(md5("textlinkvn"),0,5);
    return $key1.$key.$key2;
}

/**
 * Decrypt string
 * @param string
 * @return key
 **/
function str_decrypt($string){
    $key1 = substr(md5("id"),0,5);
    $key2 = substr(md5("textlinkvn"),0,5);
    return substr($string,strlen($key1),-(strlen($key2)));
}

#============================ SEO FUNCTION ========================#

/**
 * Get real domain by URL
 **/
function get_real_domain($url){
    $regex  = "/^((http|ftp|https):\/\/)?([\w-]+(\.[\w-]+)+)([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?$/i";
    if ( !preg_match( $regex, $url, $matches ) ) {
      return false;
    }
    $url    = $matches[3];
    $tlds   = array( 'ac', 'ad', 'ae', 'aero', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar', 'arpa', 'as', 'asia', 'at', 'au', 'aw', 'ax', 'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'biz', 'bj', 'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cat', 'cc', 'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'com', 'coop', 'cr', 'cu', 'cv', 'cx', 'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do', 'dz', 'ec', 'edu', 'ee', 'eg', 'er', 'es', 'et', 'eu', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gb', 'gd', 'ge', 'gf', 'gg', 'gh', 'gi', 'gl', 'gm', 'gn', 'gov', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy', 'hk', 'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'info', 'int', 'io', 'iq', 'ir', 'is', 'it', 'je', 'jm', 'jo', 'jobs', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn', 'kp', 'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt', 'lu', 'lv', 'ly', 'ma', 'mc', 'md', 'me', 'mg', 'mh', 'mil', 'mk', 'ml', 'mm', 'mn', 'mo', 'mobi', 'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'museum', 'mv', 'mw', 'mx', 'my', 'mz', 'na', 'name', 'nc', 'ne', 'net', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'org', 'pa', 'pe', 'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'pro', 'ps', 'pt', 'pw', 'py', 'qa', 're', 'ro', 'rs', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'st', 'su', 'sv', 'sy', 'sz', 'tc', 'td', 'tel', 'tf', 'tg', 'th', 'tj', 'tk', 'tl', 'tm', 'tn', 'to', 'tp', 'tr', 'travel', 'tt', 'tv', 'tw', 'tz', 'ua', 'ug', 'uk', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg', 'vi', 'vn', 'vu', 'wf', 'ws', 'ye', 'yt', 'yu', 'za', 'zm', 'zw' );
    $parts  = array_reverse( explode( ".", $url ) );
    $domain = array();

    foreach( $parts as $part ) {
      $domain[] = $part;
      if ( !in_array( strtolower( $part ), $tlds ) ) {
        return implode( ".", array_reverse( $domain ) );
      }
    }
}

function get_tld_from_url($url){
    $domain = get_real_domain($url);
    $tld = strrchr($domain, ".");
    return substr ($tld,1);
}

function get_title_url($url){
	$content = getWebPage(trim($url));
	$dom = new DOMDocument();
	@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
	$title = "";
	$tags = $dom->getElementsByTagName('title');
	foreach ($tags as $tag)	{
		$title = $tag->nodeValue;
        break;
	}
	return $title;
}

/**
 * Get pagerank
 * @param url
 **/
function get_pagerank_master($url) {
	include_once 'includes/SEOstats-master/SEOstats/bootstrap.php';
	try {
		// Get the Google PageRank for the given URL.
		$pagerank = \SEOstats\Services\Google::getPageRank($url);
	}
	catch (\Exception $e) {
		//echo 'Caught SEOstatsException: ' .  $e->getMessage();
		$pagerank = 0;
	}
	if($pagerank < 0 || empty($pagerank) || !is_numeric($pagerank))
		$pagerank = 0;
	return $pagerank;
}

/**
 * Get alexa Rank
 * @param url
 **/
function get_alexa_rank($url){
	$domain= get_real_domain($url);
    $service_url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;
	$content= get_data($service_url);
    $xml = new SimpleXMLElement($content);
    //Get popularity node
    $popularity = $xml->xpath("//POPULARITY");
    //Get the Rank attribute
    $rank = (string)$popularity[0]['TEXT'];
	$rank= (int) $rank;
    return $rank;
}

/** Get domain Age curl from Service Textlink
 * @param domain
 * @return numeric
**/
function get_domain_age($domain){
    $da =  get_data('http://service.textlink.vn/tool/get_domain_age/'.base64_encode($domain), 30, 30);
    if (is_numeric($da))
        return $da;
    else
        echo 0;
}

/**
 * Get domain info
 * @param domain
 * @param info - date, whois
 **/
function get_domain_info($domain, $info='date'){
    $domain = get_real_domain($domain);
    $check_vn_domain = strpos($domain, '.vn');
    $arr = NULL;
    if($check_vn_domain === false)
    {
        $username="thuntech";
        $password="thuntech123@";
        $getMode = "DNS_AND_WHOIS";
        $content = get_data("http://www.whoisxmlapi.com/whoisserver/WhoisService?domainName=$domain&username=$username&password=$password");
        if($info=='whois')
            $arr["content"] = $content;
        if($content=="")
            return "Error";
        $dom = new DOMDocument();
        // Parse the inputted HTML into a DOM
        $dom->loadXML($content);
        //Created date
        $createdDateTags = $dom->getElementsByTagName('createdDateNormalized');
        foreach ($createdDateTags as $createdDateTag)
        {
            $createdDate = $createdDateTag->nodeValue;
            break;
        }
        if (isset($createdDate))
        $arr["createdDate"] = trim($createdDate);
        //Update date
        $updatedDateTags = $dom->getElementsByTagName('updatedDateNormalized');
        foreach ($updatedDateTags as $updatedDateTag)
        {
            $updatedDate = $updatedDateTag->nodeValue;
            break;
        }
        if (isset($updatedDate))
            $arr["updatedDate"] = trim($updatedDate);
    }
    else
    {
        /*------------ngắt tạm thời, chuyển sang gọi qua service.textlink.vn -----------*/
        $api		= "http://service.textlink.vn/tool/get_domain_age/" . base64_encode($domain);
        $content 	= get_data($api);
        $arr["createdDate"] = date('Y-m-d H:i:s', trim($content));
        return $arr;
        /*------------ngắt tạm thời, chuyển sang gọi qua service.textlink.vn -----------*/

        $userroot 	= 'ltv';//Truyền vào user root
        $passroot	= '5ea47f252e4e52b1eff8857d45ae7429';//Truyền vào password root
        $username	= 'ltv';//Truyền vào username đại lý (username để đăng nhập vào trang https://daily.pavietnam.vn)
        $api		= "http://daily.pavietnam.vn/interface.php?cmd=check_whois&userroot=$userroot&passroot=$passroot&username=$username&domain=$domain";
        $result 	= get_data($api);

        $vnDomainAge = "";
        if(trim($result) == '0')
        {
            $domain = str_replace("http://","",$domain);
            $domain = str_replace("http://www.","",$domain);
            $api= "http://daily.pavietnam.vn/interface.php?cmd=get_whois&userroot=$userroot&passroot=$passroot&username=$username&domain=$domain";
                    $content= get_data($api);

                    if($info=='whois')
            $arr["content"] = trim(str_replace("<br>+ <br>", "", $content));
                    elseif($info=='avaiable')
            $arr["error"] = "Taken";
                    $vnDomainAge= substr($content, strpos($content, "<td valign='top'>Ngày cấp: </td>"), strpos($content, "<td valign='top'>Ngày hết hạn: </td>")-strpos($content, "<td valign='top'>Ngày cấp: </td>"));
                    $vnDomainAge= trim(str_replace("Ngày cấp:", "", strip_tags($vnDomainAge)));
            }
            elseif(trim($result) == '1')
                $arr["error"] = "Avaiable";
            else
                    $arr["error"] = "ApiError";
            if(!$vnDomainAge)
                    $arr["error"] = "Error";
            else
                $arr["createdDate"] = trim($vnDomainAge);
    }
    return $arr;
}


/**
 * Get Domain Authority
 * @param url
 **/
function get_domain_authority($url){
    /* seomoz */
	$accessID = "member-a54c1b6d4b";
	$secretKey = "f8f5155e55a2c8fe70a1a4a580bae4a0";
	$expires = time() + 300;
	$stringToSign = $accessID."\n".$expires;
	$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
	$urlSafeSignature = urlencode(base64_encode($binarySignature));
	$objectURL = get_real_domain($url);
	$cols = "103079215108"; //http://apiwiki.seomoz.org/url-metrics
	$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
	$options = array(
		CURLOPT_RETURNTRANSFER => true
    );
	$ch = curl_init($requestUrl);
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);
	curl_close($ch);

	$seomoz= json_decode($content);
    return $seomoz->pda;
}

/** Get outlink URL
 * @param url
**/
function get_outlink($url, $protocol='http'){
	$domain_root = get_real_domain($url);
    $dom = new DOMDocument();
    $content = get_data($url);
	// Parse the inputted HTML into a DOM
    libxml_use_internal_errors(true);
	$dom->loadHTML($content);
	/*toan trang nofollow*/
	$tags = $dom->getElementsByTagName('meta');
	foreach ($tags as $tag) {
		if(strtolower($tag->getAttribute('name')) === "robots") {
			if(strtolower($tag->getAttribute('content')) === "nofollow") {
				return -1;
			}
		}
	}
	/*kiem tra tung link*/
	$tags = $dom->getElementsByTagName('a');

    $domain_clean = str_replace("www.","",$domain_root);
    $pattern1 = "//".$domain_clean;
    $pattern2 = "www.".$domain_clean;

	$arr= array(); $i= 0;
	foreach ($tags as $tag) {
		$i++;
		$link= trim($tag->getAttribute('href'));
		if ($link!='' && stripos($link, 'http')!==false && stripos($link, 'http')==0) {
            //ko chap nhan ca subdomain - chi chap nhan co www va ko co www
            if(stripos($link,$pattern1)> 0 || stripos($link,$pattern2)> 0)
			{

			}
			else
			{
				$rel= strtolower($tag->getAttribute('rel'));
				if (stripos($rel, 'nofollow')===false && !in_array($link, $arr)) {
					$arr[]= $link;
				}
			}
		}
	}
	return $arr;
}

/**
 * Get IP client
 * @return IP address
 **/
function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * Get domain root
 * @param domain, url
 **/
function get_domain_root($url) {

	$domain= trim($url);
	$obj= parse_url($domain);

	if(isset($obj['path']))
	{
		if($obj['path']!=$domain)
		{
			$domain= $obj['host'];
		}
	}
	else
	{
		$domain= $obj['host'];
	}
	//$domain= str_replace("www.", "", $domain);

	$arr= explode(".", $domain);
	$ext= $arr[count($arr)-1];

	//echo $domain;

	//check if $domain is subdomain

	//sub domain 3+
	$ext3= array(
			"com.vn",
			"net.vn",
			"name.vn",
			"info.vn",
			"org.vn",
			"edu.vn",
			"pro.vn",
			"health.vn",
			"int.vn",
			"name.vn",
			"gov.vn",
			"biz.vn",
			"ac.vn",
	);

	/*sub domain 2+*/
	$ext2= array(
			"com",
			"net",
			"info",
			"org",
			"edu",
			"eu",
			"us",
			"vn",
	);

	if(count($arr)==3 && in_array($arr[count($arr)-2].".".$arr[count($arr)-1], $ext3))
	{
	}
	else if(count($arr)>3 && in_array($arr[count($arr)-2].".".$arr[count($arr)-1], $ext3))
	{
		return $domain;
	}
	else if(count($arr)>2 && in_array($arr[count($arr)-1], $ext2))
	{
		return $domain;
	}
	return $domain;
}

/*
* Using check domain authority & page authority
* @param url
*/

function get_info_authority($url)
{
    /* seomoz */
    $accessID = "member-a54c1b6d4b";
    $secretKey = "f8f5155e55a2c8fe70a1a4a580bae4a0";
    $expires = time() + 300;
    $stringToSign = $accessID."\n".$expires;
    $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
    $urlSafeSignature = urlencode(base64_encode($binarySignature));
    if(strpos($url, "http://") === false)
        $url = 'http://'.$url;
    $cols = "103079215108"; //http://apiwiki.seomoz.org/url-metrics
    $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($url)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
    $options = array(
        CURLOPT_RETURNTRANSFER => true
    );
    $ch = curl_init($requestUrl);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
    #$seomoz= json_decode($content);
    #return $seomoz->pda; //domain_authority
    #return $seomoz->upa; //page_authority
}


function break_text($text){
    $array = array();
    $average = 36;
    $draf = "";
    $arr = explode(".",$text);
    if(count($arr) < 2)
        $arr = explode(",",$text);
    if(count($arr) < 2)
        array_push($array, substr($text,0,$average*2));
    for($i=0; $i<count($arr); $i++){
        if($arr[$i] == "" || $arr[$i] == null)
            break;
        if(!isset($arr[$i+1]))
            $draf = substr($arr[$i],-$average);
        elseif(strlen($arr[$i]) < $average && isset($arr[$i+1])) {
            $draf = $arr[$i].".".substr($arr[$i+1],0,$average + ($average - strlen($arr[$i])));
        }elseif(strlen($arr[$i]) >= $average && (isset($arr[$i+1]) && strlen($arr[$i+1]) >= $average)) {
            $draf = substr($arr[$i], -$average) . "." . substr($arr[$i + 1], 0, $average);
        }elseif(strlen($arr[$i]) >= $average && (isset($arr[$i+1]) && strlen($arr[$i+1]) < $average)){
            $draf = substr($arr[$i],-($average + ($average - strlen($arr[$i+1])))).".".$arr[$i+1];
        }
        //cut space begin - end of string
        $exp = explode(" ", $draf);
        unset($exp[0]);
        unset($exp[count($exp)]);
        array_push($array, implode(" ",$exp));
    }
    return $array;
}
