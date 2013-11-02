<?php
/********************************************************************************************************/
/*
/* Utility functions for Post-thumb revisited
/*
/********************************************************************************************************/


/****************************************************************/
/* Parse given attributes of an html string
/****************************************************************/
function pt_parseAtributes($html, $attrList=array ("src", "alt", "title", "align")) {

	$html = trim($html);
	$ListAttr = array();
	
	foreach ($attrList as $attr) :
		$ListAttr[$attr]= pt_parseAttribute($html, $attr);
	endforeach;
	
	return $ListAttr;
}
function pt_parseAttribute($html, $attr) {

	if (($pos=stripos($html, $attr)) === false) return '';
	$html = substr($html, $pos);
	$html = str_replace($attr, '', $html);
	$html = ltrim(str_replace('=', '', $html));
	$html = substr($html, 1);
	if (($pos=stripos($html, '"')) === false) {
		if (($pos=stripos($html, "'")) === false) return '';
	}
	return substr($html, 0, $pos);
}
/***********************************************************************************/
/* extended pathinfo (for php4)
/***********************************************************************************/
function pt_pathinfo($path) {

	$tab = pathinfo($path);
	$tab['filename'] = substr($tab['basename'],0,strlen($tab['basename']) - (strlen($tab['extension']) + 1) );
	return $tab;
}
/***********************************************************************************/
/* Parse arguments
/***********************************************************************************/
function pt_parse_arg ($arg) {

	parse_str($arg, $new_args);
	return array_change_key_case($new_args, CASE_UPPER);

}
/***********************************************************************************/
/* Exclude some REGEX from a content
/***********************************************************************************/
function exclude_regex ($content) {

	$result = $content;
	$reg_coolplayer = '/\[coolplayer](.*?)\[\/coolplayer]/i';
	$reg_youtube = '/\[youtube](.*?)\[\/youtube]/i';
	$reg_dailymotion = '/\[dailymotion](.*?)\[\/dailymotion]/i';
	$reg_googlevideo = '/\[googlevideo](.*?)\[\/googlevideo]/i';
	$reg_wordtube = '/\[MEDIA=(.*?)]/i';
	$reg_extremevideo = '/\[ev(.*?)\[\/ev]/i';

	$pt_youtube = '/\[youtube=\((.*?)\]/i';
 	$pt_dailymotion = '/\[dailymotion=\((.*?)\]/i';

	$content = preg_replace($reg_coolplayer, '...', $content);
	$content = preg_replace($reg_youtube, '...', $content);
	$content = preg_replace($reg_dailymotion, '...', $content);
	$content = preg_replace($reg_googlevideo, '...', $content);
	$content = preg_replace($reg_wordtube, '...', $content);
	$content = preg_replace($reg_extremevideo, '...', $content);
	$content = preg_replace($pt_youtube, '...', $content);
	$content = preg_replace($pt_dailymotion, '...', $content);

	return $content;
}
/****************************************************************
* Test if remote image exists
* @param url to test
* @return true if file exists
****************************************************************/
function remote_file_exists ($uri) {

//	$uri = str_replace(' ', '%20', $uri);
	if (@file_exists($uri)) return true;

	$parsed_url = @parse_url($uri);
	if ( !$parsed_url || !is_array($parsed_url) )
		return false;

	if ( !isset($parsed_url['scheme']) || !in_array($parsed_url['scheme'], array('http','https')) )
		$uri = 'http://' . $uri;

	if ( ini_get('allow_url_fopen') ) {
		if (@fclose(@fopen($uri, 'r')) !== false) return true;
	}

	if ( function_exists('curl_init') ) {

		$timeout = 50;
		$handle = curl_init();
		curl_setopt ($handle, CURLOPT_MUTE, TRUE);
		curl_setopt ($handle, CURLOPT_URL, $uri);
		curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt ($handle, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt ($handle, CURLOPT_TIMEOUT, $timeout);
		$buffer = curl_exec($handle);
		curl_close($handle);
		if ($buffer !== false) return true;
	}

	if ( function_exists('get_headers') ) {

		$AgetHeaders = @get_headers($uri);
		if (preg_match("|200|", $AgetHeaders[0])) return true;

	}

	return @file_exists($uri);

}
/****************************************************************/
/* Return absolute path
/****************************************************************/
function tb_thumb_absolute ($the_image) {

	$test_img = parse_url($the_image);
	if (empty($test_img['scheme']))
		$the_img = clean_url($the_image, array('http', 'https'));
        else
		$the_img = $the_image;
	
	return $the_img;
}
/****************************************************************/
/* Return absolute path
/****************************************************************/
function tb_thumb_absolute2 ($the_image) {

	$test_img = parse_url($the_image);
	if (empty($test_img['scheme']))
		$the_img = canonicalize(str_replace( "\\", "/", SITEURL.str_replace( "//", "/",'/../'.$the_image)));
        else
		$the_img = $the_image;
	return $the_img;
}
/****************************************************************/
/* retourne un chemin canonique a partir d'un chemin contenant des ../
/****************************************************************/
function canonicalize($address) {

	$address = explode('/', $address);
	$keys = array_keys($address, '..');

	foreach($keys AS $keypos => $key)
	{
		array_splice($address, $key - ($keypos * 2 + 1), 2);
	}

	$address = implode('/', $address);
	$address = str_replace('./', '', $address);
	return $address;
}
/****************************************************************/
/*
/****************************************************************/
function pt_clean_text($text, $no_semiologic=false) {

//	$text = apply_filter('pt_clean_text', $text);
	
	$text = strip_tags(stripslashes($text));

	if (function_exists('jLanguage_processTitle'))
		$text = jLanguage_processTitle($text);

	$pattern = '/\[MEDIA=([0-9]+%?)\]/i';
        $text = preg_replace($pattern,'',$text);
	$pattern = '/\[MEDIA=([0-9]+%?)(.*?)\]/i';
        $text = preg_replace($pattern,'',$text);
	$pattern = '/\[PTPLAYLIST=\((.*?)\)(.*?)]/i';
        $text = preg_replace($pattern,'',$text);
	$pattern = '/\[PTPLAYLIST=(.*?)(.*?)]/i';
        $text = preg_replace($pattern,'',$text);
	$pattern = '/\[dailymotion=\((.*?)\)(.*?)\]/i';
        $text = preg_replace($pattern,'',$text);
	$pattern = '/\[youtube=\((.*?)\)(.*?)\]/i';
        $text = preg_replace($pattern,'',$text);

	if ($no_semiologic) {

        	$pattern = '/\[(.*?)\-\>(.*?)\]/i';
        	if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER))
		{
        		foreach ($matches as $match) :
				$text = str_replace($match[0], $match[1], $text);
                        endforeach;
		}
        	$pattern = '/\[(.*?)\-\&gt\;(.*?)\]/i';
        	if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER))
		{
        		foreach ($matches as $match) :
				$text = str_replace($match[0], $match[1], $text);
                        endforeach;
		}
	}

	$text = rtrim($text, "\s\n\t\r\0\x0B");

	return $text;
}
/****************************************************************/
/*
/****************************************************************/
function get_excerpt_revisited($excerpt_length=120, $more_link_text="...", $no_more=false) {

	global $post;
	$ellipsis = 0;
	$output = '';

	if (!empty($post->post_password))  // if there's a password
        { 
		if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) { // and it doesn't match cookie
			if(is_feed()) { // if this runs in a feed
				$output = __('There is no excerpt because this is a protected post.');
			} else {
	            $output = get_the_password_form();
			}
		}
		return $output;
	}

	$text = pt_clean_text($post->post_content);

	if($excerpt_length < 0 || $text=='')
        {
		$output = $text;
	}
        else 
        {
		if(!$no_more && strpos($text, '<!--more-->'))
                {
			$text = explode('<!--more-->', $text, 2);
			$l = count($text[0]);
			$more_link = 1;
		} 
                else
                {
			$text = explode(' ', $text);
			if(count($text) > $excerpt_length) 
                        {
				$l = $excerpt_length;
				$ellipsis = 1;
			} 
                        else 
                        {
				$l = count($text);
				$more_link_text = '';
				$ellipsis = 0;
			}
		}
		for ($i=0; $i<$l; $i++)	$output .= $text[$i] . ' ';
	}

	$output = rtrim($output, "\s\n\t\r\0\x0B");
	$output .= ($ellipsis) ? '...' : '';

	return $output;
}
/****************************************************************/
/*
/****************************************************************/
function get_the_excerpt_revisited($excerpt_length=120, $more_link_text="...", $no_semiologic=false, $showdots=true, $more_tag='div', $no_more=false) {
	global $post;
	$ellipsis = 0;
	$output = '';

	// if there's a password, return there.
	if (!empty($post->post_password)) {

		if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) { // and it doesn't match cookie
			// if this runs in a feed
			if(is_feed())
				$output = __('There is no excerpt because this is a protected post.');
			else
				$output = get_the_password_form();
		}
		return $output;
	}

	$output = excerpt_revisited($post->post_content, $excerpt_length, get_permalink($post->ID), $more_link_text, $no_semiologic, $showdots, $more_tag, $no_more);

	return $output;
}
/****************************************************************/
/*
/****************************************************************/
function excerpt_revisited($content, $excerpt_length=120, $link='#', $more_link_text="...", $no_semiologic=false, $showdots=true, $more_tag='div', $no_more=false) {
	$ellipsis = 0;
	$output = '';

	$text = pt_clean_text($content, $no_semiologic);

	if($excerpt_length < 0 || $text=='') {

		$output = $text;

	} else {
		if(!$no_more && strpos($text, '<!--more-->'))
                {
			$text = explode('<!--more-->', $text, 2);
			$l = count($text[0]);
			$more_link = 1;
		} 
                else
                {
			$text = explode(' ', $text);
			if(count($text) > $excerpt_length) 
                        {
				$l = $excerpt_length;
				$ellipsis = 1;
			}
                        else
                        {
				$l = count($text);
				$more_link_text = '';
				$ellipsis = 0;
			}
		}
		for ($i=0; $i<$l; $i++)	$output .= $text[$i] . ' ';
	}

	switch($more_tag) {
		case('div') :
			$tag = 'div';
		break;
		case('span') :
			$tag = 'span';
		break;
		case('p') :
			$tag = 'p';
		break;
		default :
			$tag = 'span';
	}

	$output = rtrim($output, "\s\n\t\r\0\x0B");
	$output .= ($showdots && $ellipsis) ? '...' : '';

	if ($more_link_text != '')
		$output .= ' <' . $tag . ' class="more-link"><a href="'. $link . '" title="' . $more_link_text . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";

	return $output;
}
/****************************************************************/
/* Return a string cleaned of annoying '\'
/****************************************************************/
function str_clean ($item)
{
	return str_replace(array("\`", "\'", '\"'), array("`", "'", '"'), $item);
}
/****************************************************************/
/* Returns a formatted url for inframe display
/****************************************************************/
function pt_return_get ($url) {

	$look_get = strpos($url,'?');
	$end_char = substr($url, -1, 1);
	if ($end_char == '/') $url_inframe = substr($url, 0, strlen($url)-1); else $url_inframe = $url;
	if ($look_get !== false) $url_inframe .= "&amp;inframe=1"; else $url_inframe .= "?inframe=1";
	return $url_inframe;
}
/*******************************************************************************/
/* Change relative url to absolute
/*******************************************************************************/
function NormalizeURL($url) {
	
	// Test if url is absolute
	if ( stristr( $url, 'http' )) return $url;
	
	// If http not in url, assumes relative address to blog url
	return canonicalize(SITEURL.'/../'.$url);
	
}

/****************************************************************/
/* Youtube functions
/* From Vaam Yob's myTube plugin
/* URI: http://www.xyooj.com/blog/plink/technical/27/wordpress-youtube-video-gallery-plugin/
/****************************************************************/

/****************************************************************/
/* Returns xml of a youtube API url
/****************************************************************/
function GetYoutubePage($url) {

	if (function_exists('curl_init')) {
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec ($ch);
		curl_close ($ch);
	}
	else $xml = ''; 
	
	return $xml;
}
/****************************************************************/
/* Parse xml from Youtube
/****************************************************************/
function ParseYoutubeVideos($ytVideoXML) {

	$yt_xml_parser = xml_parser_create();
	xml_parse_into_struct($yt_xml_parser, $ytVideoXML, $yt_vals);
	xml_parser_free($yt_xml_parser);
	$yt_videos = array();
	$yt_video = null;
	
	foreach ($yt_vals as $yt_elem) :
	
		if ($yt_elem['tag'] == 'VIDEO' && $yt_elem['type'] == 'open') {
			$yt_video = array();
    		} else if ($yt_elem['tag'] == 'VIDEO' && $yt_elem['type'] == 'close') {
      			if ($yt_video != null) {
        			$yt_videos[$yt_video['id']] = $yt_video;
      			}
      			$yt_video = null; 
    		} else if ($yt_elem['tag'] == 'ID') {
      			$yt_video['id'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'THUMBNAIL_URL') {
      			$yt_video['thumbnail_url'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'URL') {
      			$yt_video['url'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'DESCRIPTION') {
      			$yt_video['description'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'TITLE') {
      			$yt_video['title'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'TAGS') {
      			$yt_video['tags'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'UPLOAD_TIME') {
      			$yt_video['upload_time'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'COMMENT_COUNT') {
      			$yt_video['comment_count'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'VIEW_COUNT') {
      			$yt_video['view_count'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'RATING_AVG') {
      			$yt_video['rating_avg'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'RATING_COUNT') {
      			$yt_video['rating_count'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'LENGTH_SECONDS') {
      			$yt_video['length_seconds'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'AUTHOR') {
      			$yt_video['author'] = $yt_elem['value'];
    		} else {
// 		print_r($yt_elem);
    		}
  	endforeach;
  	unset($yt_vals);
  	
	return $yt_videos;

}
/****************************************************************/
/* Parse xml from Youtube
/****************************************************************/
function ParseYoutubeDetails($ytVideoXML) {

	$yt_xml_parser = xml_parser_create();
	xml_parse_into_struct($yt_xml_parser, $ytVideoXML, $yt_vals);
	xml_parser_free($yt_xml_parser);
	$yt_video = array();
	
	foreach ($yt_vals as $yt_elem) :
	
		if ($yt_elem['tag'] == 'VIDEO_DETAILS' && $yt_elem['type'] == 'open') {
			$yt_video = array();
    		} else if ($yt_elem['tag'] == 'VIDEO_DETAILS' && $yt_elem['type'] == 'close') {
			break;
    		} else if ($yt_elem['tag'] == 'THUMBNAIL_URL') {
      			$yt_video['thumbnail_url'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'URL') {
      			$yt_video['url'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'DESCRIPTION') {
      			$yt_video['description'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'TITLE') {
      			$yt_video['title'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'TAGS') {
      			$yt_video['tags'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'UPLOAD_TIME') {
      			$yt_video['upload_time'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'COMMENT_COUNT') {
      			$yt_video['comment_count'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'VIEW_COUNT') {
      			$yt_video['view_count'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'RATING_AVG') {
      			$yt_video['rating_avg'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'RATING_COUNT') {
      			$yt_video['rating_count'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'LENGTH_SECONDS') {
      			$yt_video['length_seconds'] = $yt_elem['value'];
    		} else if ($yt_elem['tag'] == 'AUTHOR') {
      			$yt_video['author'] = $yt_elem['value'];
    		} else {
// 		print_r($yt_elem);
    		}
  	endforeach;
  	unset($yt_vals);
  	
	return $yt_video;

}
/****************************************************************/
/* Gets options. Sets minimum options to operate before first validation.
/****************************************************************/
function pt_GetStarterOptions() {

	// Init parameters
	$up = UPLOAD_PATH;
	$pa = parse_url(SITEURL);
	$path = substr($pa['path'], 1, strlen($pa['path'])-1);
	
	$dn = str_replace($pa['path'],"",SITEURL);
	$bp = str_replace($pa['path'],"",str_replace( "\\", "/",ABSPATH));
	$bp = substr($bp, 0, strlen($bp)-1);
	$def = $path.'/wp-content/plugins/'. PLUGIN_BASENAME.'/images/default.png';
	
	$settings = get_option('post_thumbnail_settings');

	if ($settings['append'] == '') 		$settings['append'] = 'false';
	if ($settings['append_text'] == '') 	$settings['append_text'] = 'thumb_';
	if ($settings['base_path'] == '') 	$settings['base_path'] = $bp;
	if ($settings['default_image'] == '') 	$settings['default_image'] = $def;
	if ($settings['folder_name'] == '') 	$settings['folder_name'] = $path.'/'.$up.'/pth';
	if ($settings['full_domain_name'] == '')$settings['full_domain_name'] = str_replace( "\\", "/",$dn);

	if ($settings['tb_use'] == '') 		$settings['tb_use'] = 'false';
	if ($settings['hs_use'] == '') 		$settings['hs_use'] = 'false';

	$settings['jpg_rate'] 			= ptr_test_setting($settings['jpg_rate'], '75', 100);
	if ($settings['keep_ratio'] == '') 	$settings['keep_ratio'] = 'true';
	$settings['png_rate'] 			= ptr_test_setting($settings['png_rate'], '6', 9);

	$settings['resize_width'] 		= ptr_test_setting($settings['resize_width'], '60');
	$settings['resize_height'] 		= ptr_test_setting($settings['resize_height'], '60');

	if ($settings['rounded'] == '') 	$settings['rounded'] = 'false';
	if ($settings['stream_check'] == '') 	$settings['stream_check'] = 'false';

	if ($settings['unsharp'] == '') 	$settings['unsharp'] = 'false';

	if ($settings['use_catname'] == '') 	$settings['use_catname'] = 'false';
	if ($settings['use_meta'] == '') 	$settings['use_meta'] = 'true';
	if ($settings['use_png'] == '') 	$settings['use_png'] = 'false';

	if ($settings['video_default'] == '') 	$settings['video_default'] = $def;
	if ($settings['pt_replace'] == '') 	$settings['pt_replace'] = 'false';

	return $settings;
}
/***********************************************************************************/
/* Check for a new version of Post-thumb Revisited on server. This one is basic
/***********************************************************************************/
function ptr_test_setting($option, $default, $max = 0) {

	$option = trim($option);
	if (!is_numeric($option) || ($option > $max && $max <> 0 ))

		return $default;
	else
		return $option;
}

?>