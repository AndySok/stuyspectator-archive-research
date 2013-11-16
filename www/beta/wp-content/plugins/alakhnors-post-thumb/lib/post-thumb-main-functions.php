<?php
/***********************************************************************************/
/* Post Thumb Revisited Main functions
/*
/* 	function get_thumb ($arg='')
/*		Loop function. Returns the formatted thumbnail of the current post
/*
/*	function get_single_thumb ($settings, $post, $arg='')
/*		Anywhere function. Returns the formatted thumbnail of a post
/*
/*	function get_recent_thumbs ($arg='')
/*		Anywhere function. Returns thumbnails of the most recent posts
/*
/*	function get_random_thumb ($arg='')
/*		Anywhere function. Returns thumbnail(s) from random post(s)
/*
/*	function pt_the_excerpt($length=40, $title_after= false, $arg='')
/*		Loop function. Returns Thumbnail (+ Title) + Excerpt

	To format display, go to style_hs.css and change the following styles:

		a.highslide img             { margin: 5px; padding: 0; border: 0px solid; }
		.highslide img              { margin: 5px; padding: 0; border: 0px solid; }
		.highslide:hover img        { margin: 5px; padding: 0; border: 0px solid; }

/***********************************************************************************/


/***********************************************************************************/
/* Get thumbnail. Loop function.
/***********************************************************************************/
function the_thumb ($arg='') {

	echo get_thumb($arg);
}
/***********************************************************************************/
/* Get thumbnail. Loop function.
/***********************************************************************************/
function get_thumb ($arg='') {

	global $PTRevisited;
		return $PTRevisited->GetThumb($arg);
}
/***********************************************************************************/
/* Get post image url. Loop function.
/***********************************************************************************/
function get_thumb_url () {

	global $PTRevisited, $post;

		setup_postdata($post);
		$array =  $PTRevisited->GetPostData($post->id);
		if ($array !='') return $array['image_url'];
		return '';
	
}
/***********************************************************************************/
/* Display recent posts
/***********************************************************************************/
function get_recent_thumbs ($arg='', $beforeli='', $afterli='', $before='', $after='') {

	global $PTRevisited;
		return $PTRevisited->GetTheRecentThumbs($arg, $beforeli, $afterli, $before, $after);
}
/***********************************************************************************/
/* Display recent posts
/***********************************************************************************/
function the_recent_thumbs ($arg='', $beforeli='', $afterli='', $before='', $after='') {

	echo get_recent_thumbs($arg, $beforeli, $afterli, $before, $after);

}
/***********************************************************************************/
/* Return random thumbnails.
/*
/* LIMIT: number of thumbnail to display. Default is 1.
/***********************************************************************************/
function get_random_thumb ($arg='', $beforeli='', $afterli='', $before='', $after='') {

	global $PTRevisited;
		return $PTRevisited->GetRandomThumb($arg, $beforeli, $afterli, $before, $after);

}
/***********************************************************************************/
/* Return random thumbnails.
/*
/* LIMIT: number of thumbnail to display. Default is 1.
/***********************************************************************************/
function the_random_thumb ($arg='', $beforeli='', $afterli='', $before='', $after='') {

	echo get_random_thumb($arg, $beforeli, $afterli, $before, $after);

}
/****************************************************************/
/* Returns displayable post content
/****************************************************************/
function pt_the_excerpt($length=40, $title_after= false, $arg='') {

	global $PTRevisited;
		return $PTRevisited->TheExcerpt($length, $title_after, $arg);

}
/***********************************************************************************/
/* Display recent posts
/***********************************************************************************/
function get_recent_medias ($arg='', $beforeli='', $afterli='', $before='', $after='') {

	global $PTRevisited;
		echo $PTRevisited->GetTheRecentThumbs($arg.'&media=1', $beforeli, $afterli, $before, $after);

}
/***********************************************************************************/
/* Get wordTube Playlist.
/***********************************************************************************/
function get_WTMedia ($vid, $arg='', $play_width=0, $play_height=0) {

	global $PTRLibrary;
		return $PTRLibrary->GetWTMedia($vid, $arg, $play_width, $play_height);
}
/***********************************************************************************/
/* Get wordTube Playlist.
/***********************************************************************************/
function get_WTPlaylist ($pid, $arg='', $play_width=0, $play_height=0, $mp3=false, $flv=false) {

	global $PTRLibrary;
		return $PTRLibrary->GetWTPlaylist($pid, $arg, $play_width, $play_height, $mp3, $flv);
}
/***********************************************************************************/
/* Get 
/***********************************************************************************/
function get_wordTubeTag ($content='') {

	global $PTRLibrary;
		return $PTRLibrary->ReplaceWordTubeMedia($content);
}
/***********************************************************************************/
/* Get 
/***********************************************************************************/
function get_Youtube ($id, $title, $thumb) {

	global $PTRLibrary;
		return $PTRLibrary->GetYoutube($id, $title, $thumb);
}
/***********************************************************************************/
/* Get thumbnail for a given post
/***********************************************************************************/
function get_single_thumb ($settings, $post, $arg='') {

	global $PTRevisited;
		return $PTRevisited->GetSingleThumb($post, $arg);

}
/****************************************************************/
/* Includes features in header
/****************************************************************/
function pt_include_header() {

	global $PTRevisited;
		return $PTRevisited->include_header();

}
/***********************************************************************************/
/* Get Post-Thumb Revisited options.
/***********************************************************************************/
function get_pt_options($option) {

	global $PTRevisited;
		return $PTRevisited->settings[$option];
}
/***********************************************************************************/
/* Get Post-Thumb Revisited options.
/***********************************************************************************/
function get_pt_options_all() {

	global $PTRevisited;
		return $PTRevisited->settings;
}
/***********************************************************************************/
/* Get wordtube options.
/***********************************************************************************/
function get_wt_options() {

	global $PTRevisited;
		return $PTRevisited->wordtube_options;
}
/***********************************************************************************/
/* Get wordtube playertype.
/***********************************************************************************/
function get_wt_playertype() {

	global $PTRevisited;
		return $PTRevisited->playertype;
}

/***********************************************************************************/
/* Deprecated functions
/*
/* the following functions have no real use except to ensure compatibility with
/* with previous versions of post-thumb revisited:
/* 	function LB_effect
/* 	function pt_get_effect
/* 	function pt_LB_effect
/* 	function get_thumb_array
/***********************************************************************************/

/***********************************************************************************/
/* Display thumbnail with HS effect.
/***********************************************************************************/
function LB_effect ($hs_function='hs_html', $style='rounded-white', $width='700', $height='500', $arg_array, $html_content='', $tag='')
{

	$post_url = $arg_array['post_url'];
	$site_image = $arg_array['image_location'];
	if (function_exists('jLanguage_processTitle'))
		$arg_array['alt_text'] = jLanguage_processTitle($arg_array['alt_text']);
	$alt_text = $arg_array['alt_text'];
	$id_ID = $arg_array['post_ID'].$tag;
	$show_title = $arg_array['show_title'];
	$html_body = __($html_content);
	$img_url = $arg_array['the_image'];
	if (empty($arg_array['title'])) $title = $arg_array['alt_text']; else $title=$arg_array['title'];

	$position = "align: 'center'";
	$outlineType = "outlineType: '".$style."'";

	if ($show_title == '') $slasha = '';
	else
	{
		$slasha = '<br /><a href="'.$post_url.'" title="'.$alt_text.'"><span>'.$show_title.'</span></a>';
	}

	return pt_get_effect ($hs_function, $style, $post_url, $width, $height, $id_ID, $alt_text, $site_image, $img_url, $slasha, $html_body, '', $title);

}
/***********************************************************************************/
/***********************************************************************************/
function pt_get_effect ($hs_function, $hs_style, $hs_url, $hs_width, $hs_height, $hs_ID, $hs_text, $hs_image='', $hs_img_url='', $hs_slasha='', $hs_content='', $hs_caption='', $hs_title='')
{

        $url_inframe = pt_return_get($hs_url);
        if ($hs_caption=='') $hs_caption = __('Direct Link', 'post-thumb');
        if ($hs_title=='') $hs_title = $hs_text;

	switch ($hs_function) :

 		case 'hs_iframe' :
		case 'hs_newwindow' :
			$h = new pt_highslide ($hs_url, $hs_image, $hs_text);
			$h->set_borders ($hs_style);
			$h->set_title ($hs_title);
			$h->set_size($hs_width, $hs_height);
			$h->set_colors('white');
			$h->set_href_text();
			$hs_output = 'iframe';
			$h->set_bottom ($hs_caption);
			break;
		case 'hs_overlay' :
			$h = new pt_highslide ($hs_img_url, $hs_image, $hs_text);
			$h->set_borders ($hs_style);
			$h->set_title ($hs_title);
			$h->set_size($hs_width, $hs_height);
			$h->set_colors('white');
			$h->set_href_text();
			$h->set_caption();
			$hs_output = 'overlay';
			break;
		case 'hs_link' :
			$h = new pt_highslide ($hs_url, '', $hs_text);
			$h->set_borders ($hs_style);
			$h->set_title ($hs_title);
			$h->set_size($hs_width, $hs_height);
			$h->set_colors('white');
			$h->set_href_text();
			$hs_output = 'iframe';
			$h->set_bottom ($hs_caption);
			break;
		case 'hs_html' :
			$h = new pt_highslide ($hs_url, $hs_image, $hs_text);
			$h->set_borders ($hs_style);
			$h->set_title ($hs_title);
			$h->set_size($hs_width, $hs_height);
			$h->set_colors('white');
			$h->set_href_text();
			$hs_output = 'html';
			$h->set_bottom ();
			$h->set_body ($hs_content);
			break;
		case 'hs_ajax' :
			$h = new pt_highslide ($hs_url, $hs_image, $hs_text);
			$h->set_borders ($hs_style);
			$h->set_title ($hs_title);
			$h->set_size($hs_width, $hs_height);
			$h->set_colors('white');
			$h->set_href_text();
			$hs_output = 'ajax';
			$h->set_bottom ();
			break;
		case 'hs_htmllink' :
			$h = new pt_highslide ($hs_url, '', $hs_text);
			$h->set_borders ($hs_style);
			$h->set_title ($hs_title);
			$h->set_size($hs_width, $hs_height);
			$h->set_colors('white');
			$h->set_href_text();
			$hs_output = 'html';
			$h->set_bottom ();
			$h->set_body ($hs_content);
			break;

	endswitch;

	$post_link = $h->highslide_link($hs_output);
	unset ($h);

	return $post_link;

}
/****************************************************************/
/* Return LB_effect for current post
/****************************************************************/
function pt_LB_effect ($arg='', $hs_function='hs_link', $hs_style='beveled', $hs_width=700, $hs_height=500)
{
	global $post;

	$html_body = $post->post_content;
	$post_link = get_thumb_array ($arg);

	echo LB_effect ($hs_function, $hs_style, $hs_width, $hs_height, $post_link, $html_body);

}
/***********************************************************************************/
/* Get thumbs with default options - return array
/***********************************************************************************/
function get_thumb_array ($arg='')
{
        global $post;
	$settings = get_option('post_thumbnail_settings');

	$p = new pt_post_thumbnail($settings, $post, $arg);

	$thumb_array['post_url']       	= $p->post_url;
	$thumb_array['server_image']   	= $p->thumb_path;
	$thumb_array['image_location'] 	= $p->thumb_url;
	$thumb_array['alt_text']       	= $p->alt_text;
	$thumb_array['post_ID']        	= $p->post->ID;
	$thumb_array['the_image']      	= $p->the_image;
	$thumb_array['show_title']     	= $p->show_title;
	$thumb_array['title']     	= $p->img_title;
	
	unset($p);

        return $thumb_array;
}


?>