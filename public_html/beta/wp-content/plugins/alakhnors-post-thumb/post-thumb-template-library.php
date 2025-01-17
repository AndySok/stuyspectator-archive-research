<?php
/*
Plugin Name: Post thumb revisited template library
Description: Library for post-thumb revisited
Version: 2.0
Author:  Alakhnor
Author URI: http://www.alakhnor.com/post-thumb

	Copyright (c) 2006 Victor Chang (http://theblemish.com) for post thumb
	Copyright (c) 2007 Alakhnor (http://www.alakhnor.info) for post thumb revisited
	Post Thumbs is released under the GNU General Public License (GPL)
	http://www.gnu.org/licenses/gpl.txt

	This is a WordPress 2 plugin (http://wordpress.org).
        Highslide JS is licensed under a Creative Commons Attribution-NonCommercial 2.5 License: http://creativecommons.org/licenses/by-nc/2.5/
*/
/********************************************************************************************************/
/* List of functions for Post-thumb revisited
/*
/*        function pt_tag_show			: Display a list of thumbnails from a tag (using SimpleTagging) 
/*        function pt_slideshow			: Displays a simple slideshow
/*        function pt_RSS_Import		: display rss
/*        function pt_list_categories		: wp_list_categories with hs effect
/*        function pt_list_bookmarks		: wp_list_bookmarks with hs effect
/*        function pt_previous_post_link	: previous_post_link with inframe tag added
/*        function pt_next_post_link		: next_post_link with inframe tag added
/*
/********************************************************************************************************/

/****************************************************************/
/*
/****************************************************************/
function pt_tag_show ($tag, $arg='')
{
	global $wpdb, $table_prefix, $post;
	$settings = get_option('post_thumbnail_settings');
	$table_STP = $table_prefix . "stp_tags";
	$select = "SELECT post_id FROM $table_STP WHERE tag_name = '".$tag."'";
	$post_list = $wpdb->get_results($select);
	$echo_str = '';

	if ($post_list) {

		foreach ($post_list as $post_id) :
			$post = get_post($post_id->post_id);
			$p = new pt_post_thumbnail($settings, $post, $arg);
			$echo_str .= $p->html;
			unset ($p);

		endforeach;

		echo $echo_str;
	}

}
/****************************************************************/
/* Displays a simple slideshow
/* Array:
/*	'post_url'       = post url (permalink)
/*	'server_image'   = absolute path to thumbnail
/*	'image_location' = thumbnail url
/*	'alt_text'       = post title
/*	'post_ID'        = post ID
/*	'the_image'      = image url
/*	'show_title'     = SHOWTITLE result (html code string)
/****************************************************************/
function pt_slideshow ($arg, $random=false) {

	parse_str($arg, $new_args);
	$new_args = array_change_key_case($new_args, CASE_UPPER);

	// Retrieves specific parameters
	if (isset($new_args['WIDTH'])) $width = $new_args['WIDTH']; else $width = 180;
	if (isset($new_args['HEIGHT'])) $height = $new_args['HEIGHT']; else $height = 120;

	/* slideshow includes ============================== */ ?>
	<script type="text/javascript" src="<?php echo POSTHUMB_ABSPATH; ?>js/xfade2.js"></script>
	<link rel="stylesheet" href="<?php echo POSTHUMB_ABSPATH; ?>js/slideshow.css" type="text/css" media="screen" />
	<style type="text/css">
		#rotator { overflow: hidden; position: relative; }
		#rotator, #rotator img { width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; }
	</style>
	<?php

	$html_slideshow = '<div id="rotator">';
	if ($random)
		$html_slideshow .= get_random_thumb($arg);
	else
		$html_slideshow .= get_recent_thumbs($arg);
	$html_slideshow .= '</div>';
	
	echo $html_slideshow;
}
/****************************************************************/
/* Return a cleaned string
/****************************************************************/
function encode_html ($item)
{
	$umlaute = array('€','‚','ƒ','„','…','†','‡','ˆ','‰','Š','‹','Œ','Ž','‘','’','“','”','•','–','—','˜','™','š','›','œ','ž','Ÿ','¡','¢','£','¤','¥','¦','§','¨','©','ª','«','¬','®','¯','°','±','²','³','´','µ','¶','·','¸','¹','º','»','¼','½','¾','¿','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','×','Ø','Ù','Ú','Û','Ü','Ý','Þ','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','÷','ø','ù','ú','û','ü','ý','þ','ÿ',utf8_encode('€'),utf8_encode('‚'),utf8_encode('ƒ'),utf8_encode('„'),utf8_encode('…'),utf8_encode('†'),utf8_encode('‡'),utf8_encode('ˆ'),utf8_encode('‰'),utf8_encode('Š'),utf8_encode('‹'),utf8_encode('Œ'),utf8_encode('Ž'),utf8_encode('‘'),utf8_encode('’'),utf8_encode('“'),utf8_encode('”'),utf8_encode('•'),utf8_encode('–'),utf8_encode('—'),utf8_encode('˜'),utf8_encode('™'),utf8_encode('š'),utf8_encode('›'),utf8_encode('œ'),utf8_encode('ž'),utf8_encode('Ÿ'),utf8_encode('¡'),utf8_encode('¢'),utf8_encode('£'),utf8_encode('¤'),utf8_encode('¥'),utf8_encode('¦'),utf8_encode('§'),utf8_encode('¨'),utf8_encode('©'),utf8_encode('ª'),utf8_encode('«'),utf8_encode('¬'),utf8_encode('®'),utf8_encode('¯'),utf8_encode('°'),utf8_encode('±'),utf8_encode('²'),utf8_encode('³'),utf8_encode('´'),utf8_encode('µ'),utf8_encode('¶'),utf8_encode('·'),utf8_encode('¸'),utf8_encode('¹'),utf8_encode('º'),utf8_encode('»'),utf8_encode('¼'),utf8_encode('½'),utf8_encode('¾'),utf8_encode('¿'),utf8_encode('À'),utf8_encode('Á'),utf8_encode('Â'),utf8_encode('Ã'),utf8_encode('Ä'),utf8_encode('Å'),utf8_encode('Æ'),utf8_encode('Ç'),utf8_encode('È'),utf8_encode('É'),utf8_encode('Ê'),utf8_encode('Ë'),utf8_encode('Ì'),utf8_encode('Í'),utf8_encode('Î'),utf8_encode('Ï'),utf8_encode('Ð'),utf8_encode('Ñ'),utf8_encode('Ò'),utf8_encode('Ó'),utf8_encode('Ô'),utf8_encode('Õ'),utf8_encode('Ö'),utf8_encode('×'),utf8_encode('Ø'),utf8_encode('Ù'),utf8_encode('Ú'),utf8_encode('Û'),utf8_encode('Ü'),utf8_encode('Ý'),utf8_encode('Þ'),utf8_encode('ß'),utf8_encode('à'),utf8_encode('á'),utf8_encode('â'),utf8_encode('ã'),utf8_encode('ä'),utf8_encode('å'),utf8_encode('æ'),utf8_encode('ç'),utf8_encode('è'),utf8_encode('é'),utf8_encode('ê'),utf8_encode('ë'),utf8_encode('ì'),utf8_encode('í'),utf8_encode('î'),utf8_encode('ï'),utf8_encode('ð'),utf8_encode('ñ'),utf8_encode('ò'),utf8_encode('ó'),utf8_encode('ô'),utf8_encode('õ'),utf8_encode('ö'),utf8_encode('÷'),utf8_encode('ø'),utf8_encode('ù'),utf8_encode('ú'),utf8_encode('û'),utf8_encode('ü'),utf8_encode('ý'),utf8_encode('þ'),utf8_encode('ÿ'),chr(128),chr(129),chr(130),chr(131),chr(132),chr(133),chr(134),chr(135),chr(136),chr(137),chr(138),chr(139),chr(140),chr(141),chr(142),chr(143),chr(144),chr(145),chr(146),chr(147),chr(148),chr(149),chr(150),chr(151),chr(152),chr(153),chr(154),chr(155),chr(156),chr(157),chr(158),chr(159),chr(160),chr(161),chr(162),chr(163),chr(164),chr(165),chr(166),chr(167),chr(168),chr(169),chr(170),chr(171),chr(172),chr(173),chr(174),chr(175),chr(176),chr(177),chr(178),chr(179),chr(180),chr(181),chr(182),chr(183),chr(184),chr(185),chr(186),chr(187),chr(188),chr(189),chr(190),chr(191),chr(192),chr(193),chr(194),chr(195),chr(196),chr(197),chr(198),chr(199),chr(200),chr(201),chr(202),chr(203),chr(204),chr(205),chr(206),chr(207),chr(208),chr(209),chr(210),chr(211),chr(212),chr(213),chr(214),chr(215),chr(216),chr(217),chr(218),chr(219),chr(220),chr(221),chr(222),chr(223),chr(224),chr(225),chr(226),chr(227),chr(228),chr(229),chr(230),chr(231),chr(232),chr(233),chr(234),chr(235),chr(236),chr(237),chr(238),chr(239),chr(240),chr(241),chr(242),chr(243),chr(244),chr(245),chr(246),chr(247),chr(248),chr(249),chr(250),chr(251),chr(252),chr(253),chr(254),chr(255),chr(256));
	$htmlcode = array('&euro;','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','&#x017D;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','&#x017E;','&Yuml;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&euro;','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','&#x017D;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','&#x017E;','&Yuml;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&euro;','','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','','&#x017D;','','','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','','&#x017E;','&Yuml;','&nbsp;','&iexcl;','&iexcl;','&iexcl;','&iexcl;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','­&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;');
	$ret = str_replace($umlaute, $htmlcode, $item);
        return $ret;
}
/****************************************************************/
/* Includes WP functions in a PT way
/****************************************************************/
// For function fetch_rss
if(file_exists(ABSPATH . WPINC . '/rss.php')) {
	@require_once (ABSPATH . WPINC . '/rss.php');
	// It's Wordpress 1.5.2 or 2.x. since it has been loaded successfully
} elseif (file_exists(ABSPATH . WPINC . '/rss-functions.php')) {
	@require_once (ABSPATH . WPINC . '/rss-functions.php');
	// In Wordpress 2.1, a new file name is being used
} else {
	die (__('Error in file: ' . __FILE__ . ' on line: ' . __LINE__ . '.<br />The Wordpress file "rss-functions.php" or "rss.php" could not be included.'));
}

/****************************************************************/
/* Includes rss feed import in a PT way
/****************************************************************/
function pt_RSS_Import ($display=0,$feedurl,$word=100, $hs_style='beveled', $hs_width=800, $hs_height=500) 
{
	if ($feedurl)
        {
		$rss = fetch_rss($feedurl);
		if ($display == 0) return $rss;
		else
		{
			foreach ($rss->items as $item) :
				if ($display == 0) break;

                     			$altcount = $display%2;
                     			$href = $item['link'];
                     			$desc = trim($item['description']);
                     			$item['fulltitle']=$item['title'];
                     			// Do you have problems with special characters, then comment the follow four lines
    					$umlaute = array('€','‚','ƒ','„','…','†','‡','ˆ','‰','Š','‹','Œ','Ž','‘','’','“','”','•','–','—','˜','™','š','›','œ','ž','Ÿ','¡','¢','£','¤','¥','¦','§','¨','©','ª','«','¬','®','¯','°','±','²','³','´','µ','¶','·','¸','¹','º','»','¼','½','¾','¿','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','×','Ø','Ù','Ú','Û','Ü','Ý','Þ','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','÷','ø','ù','ú','û','ü','ý','þ','ÿ',utf8_encode('€'),utf8_encode('‚'),utf8_encode('ƒ'),utf8_encode('„'),utf8_encode('…'),utf8_encode('†'),utf8_encode('‡'),utf8_encode('ˆ'),utf8_encode('‰'),utf8_encode('Š'),utf8_encode('‹'),utf8_encode('Œ'),utf8_encode('Ž'),utf8_encode('‘'),utf8_encode('’'),utf8_encode('“'),utf8_encode('”'),utf8_encode('•'),utf8_encode('–'),utf8_encode('—'),utf8_encode('˜'),utf8_encode('™'),utf8_encode('š'),utf8_encode('›'),utf8_encode('œ'),utf8_encode('ž'),utf8_encode('Ÿ'),utf8_encode('¡'),utf8_encode('¢'),utf8_encode('£'),utf8_encode('¤'),utf8_encode('¥'),utf8_encode('¦'),utf8_encode('§'),utf8_encode('¨'),utf8_encode('©'),utf8_encode('ª'),utf8_encode('«'),utf8_encode('¬'),utf8_encode('®'),utf8_encode('¯'),utf8_encode('°'),utf8_encode('±'),utf8_encode('²'),utf8_encode('³'),utf8_encode('´'),utf8_encode('µ'),utf8_encode('¶'),utf8_encode('·'),utf8_encode('¸'),utf8_encode('¹'),utf8_encode('º'),utf8_encode('»'),utf8_encode('¼'),utf8_encode('½'),utf8_encode('¾'),utf8_encode('¿'),utf8_encode('À'),utf8_encode('Á'),utf8_encode('Â'),utf8_encode('Ã'),utf8_encode('Ä'),utf8_encode('Å'),utf8_encode('Æ'),utf8_encode('Ç'),utf8_encode('È'),utf8_encode('É'),utf8_encode('Ê'),utf8_encode('Ë'),utf8_encode('Ì'),utf8_encode('Í'),utf8_encode('Î'),utf8_encode('Ï'),utf8_encode('Ð'),utf8_encode('Ñ'),utf8_encode('Ò'),utf8_encode('Ó'),utf8_encode('Ô'),utf8_encode('Õ'),utf8_encode('Ö'),utf8_encode('×'),utf8_encode('Ø'),utf8_encode('Ù'),utf8_encode('Ú'),utf8_encode('Û'),utf8_encode('Ü'),utf8_encode('Ý'),utf8_encode('Þ'),utf8_encode('ß'),utf8_encode('à'),utf8_encode('á'),utf8_encode('â'),utf8_encode('ã'),utf8_encode('ä'),utf8_encode('å'),utf8_encode('æ'),utf8_encode('ç'),utf8_encode('è'),utf8_encode('é'),utf8_encode('ê'),utf8_encode('ë'),utf8_encode('ì'),utf8_encode('í'),utf8_encode('î'),utf8_encode('ï'),utf8_encode('ð'),utf8_encode('ñ'),utf8_encode('ò'),utf8_encode('ó'),utf8_encode('ô'),utf8_encode('õ'),utf8_encode('ö'),utf8_encode('÷'),utf8_encode('ø'),utf8_encode('ù'),utf8_encode('ú'),utf8_encode('û'),utf8_encode('ü'),utf8_encode('ý'),utf8_encode('þ'),utf8_encode('ÿ'),chr(128),chr(129),chr(130),chr(131),chr(132),chr(133),chr(134),chr(135),chr(136),chr(137),chr(138),chr(139),chr(140),chr(141),chr(142),chr(143),chr(144),chr(145),chr(146),chr(147),chr(148),chr(149),chr(150),chr(151),chr(152),chr(153),chr(154),chr(155),chr(156),chr(157),chr(158),chr(159),chr(160),chr(161),chr(162),chr(163),chr(164),chr(165),chr(166),chr(167),chr(168),chr(169),chr(170),chr(171),chr(172),chr(173),chr(174),chr(175),chr(176),chr(177),chr(178),chr(179),chr(180),chr(181),chr(182),chr(183),chr(184),chr(185),chr(186),chr(187),chr(188),chr(189),chr(190),chr(191),chr(192),chr(193),chr(194),chr(195),chr(196),chr(197),chr(198),chr(199),chr(200),chr(201),chr(202),chr(203),chr(204),chr(205),chr(206),chr(207),chr(208),chr(209),chr(210),chr(211),chr(212),chr(213),chr(214),chr(215),chr(216),chr(217),chr(218),chr(219),chr(220),chr(221),chr(222),chr(223),chr(224),chr(225),chr(226),chr(227),chr(228),chr(229),chr(230),chr(231),chr(232),chr(233),chr(234),chr(235),chr(236),chr(237),chr(238),chr(239),chr(240),chr(241),chr(242),chr(243),chr(244),chr(245),chr(246),chr(247),chr(248),chr(249),chr(250),chr(251),chr(252),chr(253),chr(254),chr(255),chr(256));
    					$htmlcode = array('&euro;','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','&#x017D;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','&#x017E;','&Yuml;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&euro;','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','&#x017D;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','&#x017E;','&Yuml;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&euro;','','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','','&#x017D;','','','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','','&#x017E;','&Yuml;','&nbsp;','&iexcl;','&iexcl;','&iexcl;','&iexcl;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','­&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;');
    					$item = str_replace($umlaute, $htmlcode, $item);
    					$desc = str_replace($umlaute, $htmlcode, $desc);
                     			if(strlen($item['description'])>$word)
                     			{
                         			$item['description']=substr($item['description'],0,$word).' ... ';
                     			}
                     			if ($altcount==0)
                     			{
                         			echo '<li><h5>'.pt_get_effect ('hs_link', $hs_style, $href, $hs_width, $hs_height, $display, $item['description'], '', '', '', '', '', $desc).'</h5></li>';
                     			}
                     			else
                     			{
                         			echo '<li><h6>'.pt_get_effect ('hs_link', $hs_style, $href, $hs_width, $hs_height, $display, $item['description'], '', '', '', '', '', $desc).'</h6></li>';
                        		// Descriptions and more-Link
                     			}
                     		$display--;
            		endforeach;
            	}
    	}
}
/****************************************************************/
/* Redefine Walker_Category
/****************************************************************/
if (get_bloginfo('version')>='2.1')
{
class pt_Walker_Category extends Walker
{
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'category_parent', 'id' => 'cat_ID'); //TODO: decouple this

	function start_lvl($output, $depth, $args) 
        {
		if ( 'list' != $args['style'] )
			return $output;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
		return $output;
	}

	function end_lvl($output, $depth, $args) 
        {
		if ( 'list' != $args['style'] )
			return $output;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
		return $output;
	}

	function start_el($output, $category, $depth, $args, $c_width, $c_height) 
        {
		extract($args);

		$cat_name = attribute_escape( $category->cat_name);
		$hs_link = get_category_link( $category->cat_ID );

		$link2 = '<a href="' . get_category_link( $category->cat_ID ) . '" ';

		if ( $use_desc_for_title == 0 || empty($category->category_description) )
		{
			$hs_text = sprintf(__( 'View all posts filed under %s' ), $cat_name);
			$link2 .= 'title="' . sprintf(__( 'View all posts filed under %s' ), $cat_name) . '"';
		}
		else
		{
			$link2 .= 'title="' . attribute_escape( apply_filters( 'category_description', $category->category_description, $category )) . '"';
		}

		$link2 .= '>';
		$link2 .= apply_filters( 'list_cats', $category->cat_name, $category ).'</a>';

	        // Change for Highslide
	        $ping = POSTHUMB_ABSPATH.'images/pong.png';

                $hs_link = pt_get_effect ('hs_newwindow', 'rounded-white', $hs_link, $c_width, $c_height, $category->cat_ID, $hs_text, $ping, '', '', '', __('Category', 'post-thumb').' '.$cat_name);

                $link = $hs_link.' '.$link2;

		if ( (! empty($feed_image)) || (! empty($feed)) ) 
                {
			$link .= ' ';

			if ( empty($feed_image) )
				$link .= '(';

	 		$link .= '<a href="' . get_category_rss_link( 0, $category->cat_ID, $category->category_nicename ) . '" ';

			if ( empty($feed) )
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}

			$link .= '>';

			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';
			        $link .= '</a>';
			if ( empty($feed_image) )
				$link .= ')';
		}

		if ( isset($show_count) && $show_count )
			$link .= ' (' . intval($category->category_count) . ')';

		if ( isset($show_date) && $show_date )
                {
			$link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
		}

		if ( $current_category )
			$_current_category = get_category( $current_category );

		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			if ( $current_category && ($category->cat_ID == $current_category) )
				$output .=  ' class="current-cat"';
			elseif ( $_current_category && ($category->cat_ID == $_current_category->category_parent) )
				$output .=  ' class="current-cat-parent"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}

		return $output;
	}

	function end_el($output, $page, $depth, $args) 
        {
		if ( 'list' != $args['style'] )
			return $output;

		$output .= "</li>\n";
		return $output;
	}
}
/****************************************************************/
/* Redefines walk_category_tree
/****************************************************************/
function pt_walk_category_tree()
{
	$walker = new pt_Walker_Category;
	$args = func_get_args();
	return call_user_func_array(array(&$walker, 'walk'), $args);
}
/****************************************************************/
/* Redefines wp_list_categories
/****************************************************************/
function pt_list_categories ($args = '')
{
	if ( is_array($args) ) $r = &$args;
        else parse_str($args, $r);

	$defaults = array('show_option_all' => '', 'orderby' => 'name',
		          'order' => 'ASC', 'show_last_update' => 0, 'style' => 'list',
		          'show_count' => 0, 'hide_empty' => 1, 'use_desc_for_title' => 1,
		          'child_of' => 0, 'feed' => '', 'feed_image' => '', 'exclude' => '',
	                  'hierarchical' => true, 'title_li' => __('Categories'), 'width' => '800', 'height' => '500');

	$r = array_merge($defaults, $r);
	if ( !isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical'] ) $r['pad_counts'] = true;
	if ( isset($r['show_date']) ) $r['include_last_update_time'] = $r['show_date'];
	extract($r);

	$categories = get_categories($r);

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="categories">' . $r['title_li'] . '<ul>';

	if ( empty($categories) ) {
		if ( 'list' == $style )
			$output .= '<li>' . __("No categories") . '</li>';
		else
			$output .= __("No categories");
	} else {
		global $wp_query;

		if ( is_category() )
			$r['current_category'] = $wp_query->get_queried_object_id();

		if ( $hierarchical )
			$depth = 0;  // Walk the full depth.
		else
			$depth = -1; // Flat.

		$output .= pt_walk_category_tree($categories, $depth, $r, $r['width'], $r['height']);
	}

	if ( $title_li && 'list' == $style )
		$output .= '</ul></li>';

	echo apply_filters('wp_list_categories', $output);
}
/****************************************************************/
/* Redefines _walk_bookmarks
/****************************************************************/
function pt_walk_bookmarks($bookmarks, $args = '' ) 
{
	if ( is_array($args) )
		$b_r = &$args;
	else
		parse_str($args, $r);

   $position = "'center'";
   $outlineType = "'rounded-white'";

	$defaults = array('show_updated' => 0, 'show_description' => 0, 'show_images' => 1, 'before' => '<li>',
		'after' => '</li>', 'between' => "\n");
	$b_r = array_merge($defaults, $b_r);
	extract($b_r);

	foreach ( (array) $bookmarks as $bookmark ) {
		if ( !isset($bookmark->recently_updated) )
			$bookmark->recently_updated = false;
		$output .= $before;
		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_prepend');

		$the_link = '#';
		if ( !empty($bookmark->link_url) )
			$the_link = wp_specialchars($bookmark->link_url);

		$rel = $bookmark->link_rel;
		$ID = $bookmark->link_id;
		if ( '' != $rel )
			$rel = ' rel="' . $rel . '"';

		$desc = attribute_escape($bookmark->link_description);
		$name = attribute_escape($bookmark->link_name);
		$title = $desc;

		if ( $show_updated )
			if ( '00' != substr($bookmark->link_updated_f, 0, 2) ) {
				$title .= ' ';
				$title .= sprintf(__('Last updated: %s'), date(get_option('links_updated_date_format'), $bookmark->link_updated_f + (get_option('gmt_offset') * 3600)));
				$title .= ')';
			}

		if ( '' != $title ) $title = ' title="' . $title . '"';
		if ( '' != $alt ) $alt = ' alt="' . $name . '"';

		$target = $bookmark->link_target;
		if ( '' != $target )
			$target = ' target="' . $target . '"';

		$output .= '<a href="' . $the_link . '"' . $title . $target.
                           ' onclick="return hs.htmlExpand(this, { contentId: '."'highslide-bookmark".$ID."'".', objectType: '.
                           "'iframe'".', outlineType: '.$outlineType.', align: '.$position.', objectWidth: '.$b_r['width'].', objectHeight: '.$b_r['height'].', objectLoadTime: '."'after'".'} )" class="highslide">';

		if ( $bookmark->link_image != null && $show_images ) {
			if ( strpos($bookmark->link_image, 'http') !== false )
				$output .= "<img src=\"$bookmark->link_image\" $alt $title />";
			else // If it's a relative path
				$output .= "<img src=\"" . get_option('siteurl') . "$bookmark->link_image\" $alt $title />";
		} else {
			$output .= $name;
		}

		$output .= '</a>'.
                           '<div class="highslide-html-content" id="highslide-bookmark'.$ID.'" style="width: '.$b_r['width'].'px">'.
	                      '<div class="highslide-move" style="background-color: white; border: 0; height: 18px; padding: 2px; cursor: default">'.
	                         '<a href="#" onclick="return hs.close(this)" class="control">Close</a>'.
	                      '</div>'.
                              '<div class="highslide-body"></div>'.
                              '<div style="text-align: center; background-color: white; border-top: 1px solid silver; padding: 5px 0">'.
		                 '<small>Boomarks Powered by <i>Highslide JS</i></small>'.
			      '</div>'.
			   '</div>';

		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_append');

		if ( $show_description && '' != $desc )
			$output .= $between . $desc;
		$output .= "$after\n";
	} // end foreach

	return $output;
}
/****************************************************************/
/* Redefines wp_list_bookmarks
/****************************************************************/
function pt_list_bookmarks($args = '') {
	if ( is_array($args) )
		$b_r = &$args;
	else
		parse_str($args, $b_r);

	$defaults = array('orderby' => 'name', 'order' => 'ASC', 'limit' => -1, 'category' => '',
		'category_name' => '', 'hide_invisible' => 1, 'show_updated' => 0, 'echo' => 1,
		'categorize' => 1, 'title_li' => __('Bookmarks'), 'title_before' => '<h2>', 'title_after' => '</h2>',
		'category_orderby' => 'name', 'category_order' => 'ASC', 'class' => 'linkcat',
		'category_before' => '<li id="%id" class="%class">', 'category_after' => '</li>', 'width' => '800', 'height' => '500');
	$b_r = array_merge($defaults, $b_r);
	extract($b_r);

	$output = '';

	if ( $categorize ) {
		//Split the bookmarks into ul's for each category
		$cats = get_categories("type=link&category_name=$category_name&include=$category&orderby=$category_orderby&order=$category_order&hierarchical=0");

		foreach ( (array) $cats as $cat ) {
			$bookmarks = get_bookmarks("limit=$limit&category={$cat->cat_ID}&show_updated=$show_updated&orderby=$orderby&order=$order&hide_invisible=$hide_invisible&show_updated=$show_updated");
			if ( empty($bookmarks) )
				continue;
			$output .= str_replace(array('%id', '%class'), array("linkcat-$cat->cat_ID", $class), $category_before);
			$output .= "$title_before$cat->cat_name$title_after\n\t<ul>\n";
			$output .= pt_walk_bookmarks($bookmarks, $b_r);
			$output .= "\n\t</ul>\n$category_after\n";
		}
	} else {
		//output one single list using title_li for the title
		$bookmarks = get_bookmarks("limit=$limit&category=$category&show_updated=$show_updated&orderby=$orderby&order=$order&hide_invisible=$hide_invisible&show_updated=$show_updated");
		
		if ( !empty($bookmarks) ) {
			$output .= str_replace(array('%id', '%class'), array("linkuncat", $class), $category_before);
			$output .= "$title_before$title_li$title_after\n\t<ul>\n";
			$output .= pt_walk_bookmarks($bookmarks, $b_r);
			$output .= "\n\t</ul>\n$category_after\n";
		}
	}

	if ( !$echo )
		return $output;
	echo $output;
}
/****************************************************************/
/* End of excluded functions for WP version before 2.1
/****************************************************************/
}
else
{
/****************************************************************/
/* Begins inclusion of functions for WP version before 2.1
/****************************************************************/
// out of the WordPress loop
function pt_list_categories($args = '') {
	parse_str($args, $r);
	if ( !isset($r['optionall']))
		$r['optionall'] = 0;
	if ( !isset($r['all']))
		$r['all'] = 'All';
	if ( !isset($r['sort_column']) )
		$r['sort_column'] = 'ID';
	if ( !isset($r['sort_order']) )
		$r['sort_order'] = 'asc';
	if ( !isset($r['file']) )
		$r['file'] = '';
	if ( !isset($r['list']) )
		$r['list'] = true;
	if ( !isset($r['optiondates']) )
		$r['optiondates'] = 0;
	if ( !isset($r['optioncount']) )
		$r['optioncount'] = 0;
	if ( !isset($r['hide_empty']) )
		$r['hide_empty'] = 1;
	if ( !isset($r['use_desc_for_title']) )
		$r['use_desc_for_title'] = 1;
	if ( !isset($r['children']) )
		$r['children'] = true;
	if ( !isset($r['child_of']) )
		$r['child_of'] = 0;
	if ( !isset($r['categories']) )
		$r['categories'] = 0;
	if ( !isset($r['recurse']) )
		$r['recurse'] = 0;
	if ( !isset($r['feed']) )
		$r['feed'] = '';
	if ( !isset($r['feed_image']) )
		$r['feed_image'] = '';
	if ( !isset($r['exclude']) )
		$r['exclude'] = '';
	if ( !isset($r['hierarchical']) )
		$r['hierarchical'] = true;
	if ( !isset($r['width']) )
		$r['width'] = 700;
	if ( !isset($r['height']) )
		$r['height'] = 500;

	return pt_list_cats($r['optionall'], $r['all'], $r['sort_column'], $r['sort_order'], $r['file'],
        			$r['list'], $r['optiondates'], $r['optioncount'], $r['hide_empty'], $r['use_desc_for_title'], 
                                $r['children'], $r['child_of'], $r['categories'], $r['recurse'], $r['feed'], $r['feed_image'], 
                                $r['exclude'], $r['hierarchical'], $r['width'], $r['height']);
}

function pt_list_cats($optionall = 1, $all = 'All', $sort_column = 'ID', $sort_order = 'asc', $file = '', $list = true, $optiondates = 0, $optioncount = 0, $hide_empty = 1, $use_desc_for_title = 1, $children=FALSE, $child_of=0, $categories=0, $recurse=0, $feed = '', $feed_image = '', $exclude = '', $hierarchical=FALSE, $width=700, $height=500) {
	global $wpdb, $wp_query;
	// Optiondates now works
	if ( '' == $file )
		$file = get_settings('home') . '/';

	$exclusions = '';
	if ( !empty($exclude) ) {
		$excats = preg_split('/[\s,]+/',$exclude);
		if ( count($excats) ) {
			foreach ( $excats as $excat ) {
				$exclusions .= ' AND cat_ID <> ' . intval($excat) . ' ';
			}
		}
	}

	$exclusions = apply_filters('list_cats_exclusions', $exclusions );

	if ( intval($categories) == 0 ) {
		$sort_column = 'cat_'.$sort_column;

		$query = "
			SELECT cat_ID, cat_name, category_nicename, category_description, category_parent, category_count
			FROM $wpdb->categories
			WHERE cat_ID > 0 $exclusions
			ORDER BY $sort_column $sort_order";

		$categories = $wpdb->get_results($query);
	}

	if ( $optiondates ) {
		$cat_dates = $wpdb->get_results("	SELECT category_id,
		UNIX_TIMESTAMP( MAX(post_date) ) AS ts
		FROM $wpdb->posts, $wpdb->post2cat, $wpdb->categories
		WHERE post_status = 'publish' AND post_id = ID $exclusions
		GROUP BY category_id");
		foreach ( $cat_dates as $cat_date ) {
			$category_timestamp["$cat_date->category_id"] = $cat_date->ts;
		}
	}

	$num_found=0;
	$thelist = "";

	foreach ( (array) $categories as $category ) {
		if ( ( intval($hide_empty) == 0 || $category->category_count) && (!$hierarchical || $category->category_parent == $child_of) ) {
			$num_found++;
			$link = '<a href="'.get_category_link($category->cat_ID).'" ';
			if ( $use_desc_for_title == 0 || empty($category->category_description) )
				$link .= 'title="'. sprintf(__("View all posts filed under %s"), attribute_escape($category->cat_name)) . '"';
			else
				$link .= 'title="' . attribute_escape(apply_filters('category_description',$category->category_description,$category)) . '"';
			$link .= '>';
			$link .= apply_filters('list_cats', $category->cat_name, $category).'</a>';

			if ( (! empty($feed_image)) || (! empty($feed)) ) {

				$link .= ' ';

				if ( empty($feed_image) )
					$link .= '(';

				$link .= '<a href="' . get_category_rss_link(0, $category->cat_ID, $category->category_nicename) . '"';

				if ( !empty($feed) ) {
					$title = ' title="' . $feed . '"';
					$alt = ' alt="' . $feed . '"';
					$name = $feed;
					$link .= $title;
				}

				$link .= '>';

				if ( !empty($feed_image) )
					$link .= "<img src='$feed_image' $alt$title" . ' />';
				else
					$link .= $name;

				$link .= '</a>';

				if (empty($feed_image))
					$link .= ')';
			}

			if ( intval($optioncount) == 1 )
				$link .= ' ('.intval($category->category_count).')';

			if ( $optiondates ) {
				if ( $optiondates == 1 )
					$optiondates = 'Y-m-d';
				$link .= ' ' . gmdate($optiondates, $category_timestamp["$category->cat_ID"]);
			}

			if ( $list ) {
				$thelist .= "\t<li";
				if (($category->cat_ID == $wp_query->get_queried_object_id()) && is_category()) {
					$thelist .=  ' class="current-cat"';
				}
				$thelist .= ">$link\n";
			} else {
				$thelist .= "\t$link<br />\n";
			}

			if ($hierarchical && $children)
				$thelist .= list_cats($optionall, $all, $sort_column, $sort_order, $file, $list, $optiondates, $optioncount, $hide_empty, $use_desc_for_title, $hierarchical, $category->cat_ID, $categories, 1, $feed, $feed_image, $exclude, $hierarchical);
			if ($list)
				$thelist .= "</li>\n";
		}
	}
	if ( !$num_found && !$child_of ) {
		if ( $list ) {
			$before = '<li>';
			$after = '</li>';
		}
		echo $before . __("No categories") . $after . "\n";
		return;
	}
	if ( $list && $child_of && $num_found && $recurse ) {
		$pre = "\t\t<ul class='children'>";
		$post = "\t\t</ul>\n";
	} else {
		$pre = $post = '';
	}
	$thelist = $pre . $thelist . $post;
	if ( $recurse )
		return $thelist;
	echo apply_filters('list_cats', $thelist);
}
}
/****************************************************************/
/* Redefines previous_post_link
/****************************************************************/
function pt_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {

	if (is_attachment())
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_previous_post($in_same_cat, $excluded_categories);

	if (!$post) return;

        $hs_url = get_permalink($post->ID);
        $url_inframe = pt_return_get($hs_url);
	$title = apply_filters('the_title', $post->post_title, $post);
	$string = '<a href="'.$url_inframe.'">';
	$link = str_replace('%title', $title, $link);
	$link = $pre . $string . $link . '</a>';

	$format = str_replace('%link', $link, $format);

	echo $format;
}
/****************************************************************/
/* Redefines next_post_link
/****************************************************************/
function pt_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '') {

	$post = get_next_post($in_same_cat, $excluded_categories);

	if (!$post) return;

        $hs_url = get_permalink($post->ID);
        $url_inframe = pt_return_get($hs_url);
	$title = apply_filters('the_title', $post->post_title, $post);
	$string = '<a href="'.$url_inframe.'">';
	$link = str_replace('%title', $title, $link);
	$link = $string . $link . '</a>';
	$format = str_replace('%link', $link, $format);

	echo $format;
}

?>