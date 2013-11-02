<?php
/**********************************************************************
	Class: PTR Library
	Description: Library for Post-Thumb Revisited.
	Version: 1.0
	Author:  Alakhnor
**********************************************************************/

$PTRLibrary = new PostThumbLibrary();

################################################################################
########## MAIN CLASS
################################################################################
class PostThumbLibrary {

        var $settings;
        var $post_array = array();
        var $wordtube_options;
        var $playertype;
        var $playertypemp3;
        var $wordtube_abspath;
        var $wt_path = 'wordtube';
        var $table_pt_post;
        var $LoadPostLimit = 200;
        var $now;
        var $post_nb = 0;

	/**
	 * PostThumbRevisited
	 *
	 * Constructor for the PostThumbRevisited class.
	 */
	function PostThumbLibrary () {

          	global $wpdb, $wp_query;

		// Add header data
		add_action('wp_head', array(&$this, 'include_header'));

		// Wordtube initialization
		$wpdb->wordtube	= $wpdb->prefix . 'wordtube';
		$wpdb->wordtube_med2play = $wpdb->prefix . 'wordtube_med2play';

		// Adds filters

		// ReplaceImage is activated with rel="thumb" in the img
		add_filter('the_content', array(&$this, 'ReplaceImage'));

		// Other options can only be available if highslide is activated
		if (((POSTTHUMB_USE_HS || POSTTHUMB_USE_TB))) {

			// ReplaceLinks is activated with rel="ptlink" in the img
			add_filter('the_content', array(&$this, 'ReplaceLinks'));

			// Image with thumbnails filter
			if (get_pt_options('pt_replace') == 'true') {
				add_filter('the_content', array(&$this, 'ReplaceThumbnails'));
			}

			// wordTube filter
			if (get_pt_options('wt_media') == 'true') {
				$this->InitWordTube(); 
				add_filter('the_content', array(&$this, 'ReplaceWTMedia'));
				if (get_pt_options('wt_playlist') == 'true') 
					add_filter('the_content', array(&$this, 'ReplaceWTPlaylist'));
			}

			// Youtube filter
			if (get_pt_options('ytb_media') == 'true') 
				add_filter('the_content', array(&$this, 'ReplaceYoutube'));
		}

		add_filter('the_content_rss', array(&$this, 'ReplaceImage'), 5);
		add_action('rss2_item', array(&$this, 'ReplaceImage'), 5);
	}
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function ReplaceThumbnails($content) {
		$attrList=array ("src", "alt", "title", "align", "width", "height");
		
		if (is_feed()) return $content;

		$r_ID = rand();

		// Replace thumbnail
		$pattern = '/<a([^>]*)href=[\'|"]([^>]*).(bmp|jpg|jpeg|gif|png)[\'|"]([^>]*)><img([^>]*)\/><\/a>/si';
		if (preg_match_all($pattern,$content,$matches, PREG_SET_ORDER)) {
		
			$i=1;
			foreach ($matches as $match) :

				$ID = $r_ID.$i;

				if (POSTTHUMB_USE_HS) {
					$href = '<a href="'.$match[2].'.'.$match[3].'" onclick="return hs.expand(this, {captionId: '."'caption".$r_ID."',"." outlineType: '".get_pt_options('ovframe')."'".'})" id="thumb'.$r_ID.'" class="highslide">';
					$img_src = '<img '.$match[5].'/></a>';
					$caption = '<div class="highslide-caption" id="caption'.$r_ID.'">'.$match[8].'</div>';
				}
				elseif (POSTTHUMB_USE_TB) {
					$href = '<a href="'.$match[2].'.'.$match[3].'" class="thickbox" rel="WP_ptr_gallery" '.$match[4].'>';
					$img_src = '<img '.$match[5].'/></a>';
					$caption = '';
				}
				else continue;

				$replacement = $href.$img_src.$caption;
       				$content = str_replace($match[0], $replacement, $content);
				$i++;
				
			endforeach;
		}

		return $content;

	}
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function ReplaceImage($content) {
		$attrList=array ("src", "alt", "title", "align");	

		if ((stripos($content, 'rel="thumb"') === false)
		and (stripos($content, "rel='thumb'") === false))
		return $content;

		// Thumbnails image and replace
		$pattern = '/<img([^>]*)\/>/si';
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {

			foreach ($matches as $match) :

				if (stripos($match[0], 'rel="thumb"') === false)
					continue;
				else
					$match[1]=str_replace ('rel="thumb"', '', $match[1]);

				$ListAttr = pt_parseAtributes($match[1], $attrList);
                                $ListAttr['src'] = tb_thumb_absolute($ListAttr['src']);
				$ListAttr['ext'] = substr(strrchr($ListAttr['src'], "."), 1);
				$ListAttr['img'] = substr($ListAttr['src'],0,strlen($ListAttr['src']) - (strlen($ListAttr['ext']) + 1) );
				if ($ListAttr['title']=='' || !isset($ListAttr['title'])) $ListAttr['title'] = $ListAttr['alt'];
				$replacement = $this->MakeThumb($ListAttr);
      				$content = str_replace($match[0], $replacement, $content);

			endforeach;
		}

		return $content;
	}
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function MakeThumb($ListAttr) {
	
		// Initialize parameters
		$the_image = NormalizeURL($ListAttr['img'].'.'.$ListAttr['ext']);
		$ListAttr['alt'] = htmlspecialchars($ListAttr['alt']);
		$ListAttr['title'] = htmlspecialchars($ListAttr['title']);
		if ($ListAttr['align'])	$align = 'align="'.$ListAttr['align'].'"';
		else $align="";

		// Set post-thumb additionnal parameter
		if (get_pt_options('p_rounded') == 'true') $p_rounded = 1; else $p_rounded = 0;
		if (get_pt_options('p_keep_ratio') == 'true') $p_keep_ratio = 1; else $p_keep_ratio = 0;
		$has_caption = (get_pt_options('p_caption') == 'true');

		// Prepare parameter for thumbnail
		$arg = 	'ALTAPPEND='.get_pt_options('p_append_text').
			'&WIDTH='.get_pt_options('p_resize_width').
			'&HEIGHT='.get_pt_options('p_resize_height').
			'&ROUNDED='.$p_rounded.
			'&KEEPRATIO='.$p_keep_ratio;

		// Retrieve thumbnail
		$t = new pt_thumbnail (get_pt_options_all(), $the_image, $arg);
		$add_tag = $align;

		// Add thumbnail & highslide expand to image
		if (POSTTHUMB_USE_HS) {
			$h = new pt_highslide ($the_image, $t->thumb_url, $ListAttr['alt']);
			$h->set_borders (get_pt_options('ovframe'));
			$h->set_title ($ListAttr['title']);
			if ($has_caption)
				$h->set_caption ($ListAttr['alt']);
			$h->set_html_size();
			$h->set_href_text('', $add_tag);
			$h_str = $h->highslide_link ();
			unset ($h);
		}
		// Add thumbnail & thickbox/smoothbox class to image
		elseif (POSTTHUMB_USE_TB || POSTTHUMB_USE_SB) {
			$h = new pt_thickbox ($the_image, $t->thumb_url, $ListAttr['alt']);
			$h->set_href_text('', $add_tag);
			$h_str = $h->thickbox_link ();
			unset ($h);
		}
		// Simple replacement by thumbnail linked to image
		else $h_str = '<a href="'.$the_image.'" title="'.$ListAttr['title'].'" ><img src="'.$t->thumb_url.'" alt="'.$ListAttr['alt'].'" '.$align.' /></a>';

		unset ($t);

		return $h_str;
	}
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function ReplaceWTMedia($content) {
	
		if (stripos($content, '[MEDIA=') === false) return $content;

		// Replace wordTube MEDIA with parameters
		$pattern = '@(?:<p>)*\s*\[MEDIA=([0-9]+%?)\]\s*(?:</p>)*@i';
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
			
			$play_width = get_pt_options('wordtube_pwidth');
			$play_height = get_pt_options('wordtube_pheight');
			
			foreach ($matches as $match) :

				$replacement = $this->GetwordTubeMedia($match[1], $play_width, $play_height);
				if ($replacement != '') $content = str_replace($match[0], $replacement, $content);
				$i++;

        		endforeach;
		}
		
		$pattern = '@(?:<p>)*\s*\[MEDIA=([0-9]+%?)(.*?)\]\s*(?:</p>)*@i';
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
		
			foreach ($matches as $match) :

				$str_match = strtoupper($match[0]);
				if (preg_match('/\[(.*?)WIDTH=([0-9]+%?)(.*?)\]/i', $str_match, $foo3))
					$play_width = $foo3[2];
				else 
					$play_width = get_pt_options('wordtube_pwidth');
					
				if (preg_match('/\[(.*?)HEIGHT=([0-9]+%?)(.*?)\]/i', $str_match, $foo4))
					$play_height = $foo4[2];
				else 
					$play_height = get_pt_options('wordtube_pheight');

				$replacement = $this->GetwordTubeMedia($match[1], $play_width, $play_height);
				if ($replacement != '') $content = str_replace($match[0], $replacement, $content);
				$i++;

	        	endforeach;
		}
	
		return $content;
	}
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function ReplaceWTPlaylist($content) {
	
		global $wpdb;
		if (is_feed()) return $content;
		if (stripos($content, '[PTPLAYLIST=') === false) return $content;

		// Replace wordTube post-thumb ptplaylist
		$pattern = '@(?:<p>)*\s*\[PTPLAYLIST=\((.*?)\)(.*?)]\s*(?:</p>)*@i';
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {

			foreach ($matches as $match) :

				$str_match = strtoupper($match[0]);
				$vid_array = explode(",",$match[1]);
				if ($match[1] != '0') $where = "WHERE vid IN ('" . implode("','", $vid_array) . "')";
				$dbresults = $wpdb->get_results("SELECT * FROM $wpdb->wordtube $where");

				if ($dbresults) {
					$replacement = '';
					$mp3 = strpos($str_match, 'MP3');
					$flv = strpos($str_match, 'FLV');
					if (preg_match('/\[(.*?)WIDTH=([0-9]+%?)(.*?)\]/i', $str_match, $foo3))
						$play_width = $foo3[2];
					else 
						$play_width = get_pt_options('wordtube_pwidth');
						
					if (preg_match('/\[(.*?)HEIGHT=([0-9]+%?)(.*?)\]/i', $str_match, $foo4))
						$play_height = $foo4[2];
					else 
						$play_height = get_pt_options('wordtube_pheight');

					foreach ($dbresults as $media) :

						$replacement .= $this->ReturnMediaFromPlaylist($media, $play_width, $play_height, $mp3, $flv);
							
	        			endforeach;
	        			$content = str_replace($match[0], $replacement, $content);
				}
				unset($dbresults);
				$i++;
			endforeach;
		}

		// Replace wordTube ptplaylist
		$pattern = '@(?:<p>)*\s*\[PTPLAYLIST=([0-9]+%?)(.*?)]\s*(?:</p>)*@i';
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {

			foreach ($matches as $match) :

				$str_match = strtoupper($match[0]);

				$dbresults = $this->GetwordTubePlaylist($match[1]);
	
				if ($dbresults) {
				
					$replacement = '';
					$mp3 = stripos($str_match, 'MP3');
					$flv = stripos($str_match, 'FLV');
					if (preg_match('/\[(.*?)WIDTH=([0-9]+%?)(.*?)\]/i', $str_match, $foo3))
						$play_width = $foo3[2];
					else 
						$play_width = get_pt_options('wordtube_pwidth');
						
					if (preg_match('/\[(.*?)HEIGHT=([0-9]+%?)(.*?)\]/i', $str_match, $foo4))
						$play_height = $foo4[2];
					else 
						$play_height = get_pt_options('wordtube_pheight');

					foreach ($dbresults as $media) :

						$replacement .= $this->ReturnMediaFromPlaylist($media, $play_width, $play_height, $mp3, $flv);

	        			endforeach;
	        			$content = str_replace($match[0], $replacement, $content);
				}
				unset($dbresults);

			endforeach;
		}

		return $content;
	}
	/****************************************************************/
	/* Returns wordTube media
	/****************************************************************/
	function ReturnMediaFromPlaylist($media, $play_width, $play_height, $mp3, $flv, $arg='') {

		$replacement = '';
		if ($mp3 || $flv) {
			
			$med_url = pathinfo($media->file);
			if ($mp3) {

				if (strtoupper($med_url['extension']) == 'MP3') {
					$replacement = $this->GetVideo($media->name, $media->file, $media->image, $play_width, $play_height, $arg, $media->vid);
				}
              					}
			if ($flv) {

				if (strtoupper($med_url['extension']) == 'FLV') {
					$replacement = $this->GetVideo($media->name, $media->file, $media->image, $play_width, $play_height, $arg, $media->vid);
				}
			}
		}
		else 
			$replacement = $this->GetVideo($media->name, $media->file, $media->image, $play_width, $play_height, $arg, $media->vid);
		
		return $replacement;
	}
	/****************************************************************/
	/* Returns wordTube media
	/****************************************************************/
	function GetwordTubeMedia($vid, $play_width, $play_height, $arg='') {

        	global $wpdb;

		$select = " SELECT * FROM $wpdb->wordtube WHERE vid = ".$vid;
		$media = $wpdb->get_row($select);
		if ($media)
			return $this->GetVideo($media->name, $media->file, $media->image, $play_width, $play_height, $arg, $vid);
		else
			return '';
	}
	/****************************************************************/
	/* Returns wordTube playlist
	/****************************************************************/
	function GetwordTubePlaylist($pid) {

        	global $wpdb;

		if ($pid == '0') 
			$select = " SELECT * FROM {$wpdb->wordtube} ORDER BY vid DESC";
		else
			$select = " SELECT * FROM {$wpdb->wordtube} w
				INNER JOIN {$wpdb->wordtube_med2play} m
				WHERE (m.playlist_id = '".$pid."' AND m.media_id = w.vid)
				GROUP BY w.vid 
				ORDER BY m.rel_id DESC";
 
		return $wpdb->get_results($select);

	}
	/****************************************************************/
	/* Returns formatted wordTube playlist
	/****************************************************************/
	function GetWTMedia ($vid, $arg='', $play_width=0, $play_height=0) {
	
		if ($play_width == 0) $play_width = get_pt_options('wordtube_pwidth');
		if ($play_height == 0) $play_height = get_pt_options('wordtube_pheight');

		$replacement = $this->GetwordTubeMedia($vid, $play_width, $play_height, $arg);
		
                return $replacement;
	}	
	/****************************************************************/
	/* Returns formatted wordTube playlist
	/****************************************************************/
	function GetWTPlaylist($pid, $arg='', $play_width=0, $play_height=0, $mp3=false, $flv=false) {
	
		if ($play_width == 0) $play_width = get_pt_options('wordtube_pwidth');
		if ($play_height == 0) $play_height = get_pt_options('wordtube_pheight');

		$new_args = pt_parse_arg($arg);

		if (isset($new_args['LIMIT'])) { $limit = $new_args['LIMIT']; settype($limit,"integer"); } else $limit = 5;
		if (isset($new_args['OFFSET'])) { $offset = $new_args['OFFSET']; settype($offset,"integer"); } else $offset = 0;

		$l = $limit+$offset;

		$dbresults = $this->GetwordTubePlaylist($pid);
		if ($dbresults) {

			$replacement = '';
			$i=1;
			foreach ($dbresults as $media) :

				if ($i > $l) break;
	                	if ($i > $offset)
					$replacement .= $this->ReturnMediaFromPlaylist($media, $play_width, $play_height, $mp3, $flv, $arg);
				$i++;

       			endforeach;
		}
		unset ($dbresults);

                return $replacement;
	}	
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function ReplaceLinks($content) {
		$attrList=array ("src", "alt", "title", "align", "width", "height");
	
		if (is_feed()) return $content;
		if ((stripos($content, 'rel="ptlink"') === false)
		and (stripos($content, "rel='ptlink'") === false))
		return $content;

		$r_ID = rand();

		// Replace thumbnail
		$pattern = '/<a(.*?)href=[\'|"](.*?)[\'|"](.*?)><img(.*?)src=["'."|'](.*?)['".'|"](.*?)rel\=[\'|"]ptlink[\'|"](.*?)\/><\/a>/i';
		if (preg_match_all($pattern,$content,$matches, PREG_SET_ORDER)) {
			$i=1;
			foreach ($matches as $match) :

				$ID = $r_ID.$i;
				$main_url = $match[2];
				$thumb_url = $match[5];
				if (POSTTHUMB_USE_HS) {
					$h = new pt_highslide($main_url, $thumb_url, '', $main_url);
					$h->set_borders (get_pt_options('ovframe'));
					$h->set_colors(get_pt_options('bgcolor'));
					if (preg_match('/title=["|'."\'](.*?)['".'|"]/i', $match[3], $hreftitle)) $title = $hreftitle[1];
					$h->set_title ($title);
					$h->set_href_text($match[8]);
					$h->set_bottom($title, $main_url);
					$h->set_size (900, 600);
					$h->set_colors ($bgcolor, $hdcolor='', $ftcolor='');
	
					$replacement = $h->highslide_link('iframe');
					unset($h);
				}
				elseif (POSTTHUMB_USE_TB) {
				}
				
       				$content = str_replace($match[0], $replacement, $content);
				$i++;
				
			endforeach;
		}

		return $content;

	}
	/****************************************************************/
	/* Filter function (if Highslide is activated)
	/****************************************************************/
	function ReplaceYoutube($content) {

		if (is_feed()) return $content;
		
                // Replace Youtube
		$pattern1 = '@(?:<p>)*\s*\[youtube=\((.*?)\)(.*?)\]\s*(?:</p>)*@i';
		$pattern2 = '@\<a(.*?)href=[\'|"]http:\/\/youtube.com/watch\?v=(.*?)[\'|"](.*?)\</a\>@i';
		$pattern3 = '/\<object([^>]*)>([^>]*)\<param([^>]*)value=[\'|"]http:\/\/www.youtube.com\/v\/(.*?)[\'|"]\>\<\/param>([^>]*)\<param(.*?)\<\/object>/is';
		$pat_title = '/(.*?)title=[\'|"](.*?)[\'|"]/i';

//		$pattern3 = '/\<object([^>]*)>([^>]*)\<param([^>]*)value=[\'|"]http:\/\/www.youtube.com\/v\/(.*?)[\'|"]>\<\/param>([^>]*)\<param([^>]*)>([^>]*)\<\/param>([^>]*)\<embed([^>]*)>([^>]*)\<\/embed>([^>]*)\</object>/is';

		if (stripos($content, 'http://youtube.com/watch?v=') !== false) {
		if (preg_match_all($pattern2, $content, $matches, PREG_SET_ORDER)) {

			foreach ($matches as $match) :
				if (preg_match($pat_title, $match[0], $mat_title))
					$title = $mat_title[2];
				else
					$title = '';

				$thumb = 'http://img.youtube.com/vi/'.$match[2].'/0.jpg" width="'.get_pt_options('youtube_width').'" height="'.get_pt_options('youtube_height');
				$replacement = SetYoutubeVideo ($match[2], $title, $thumb, get_pt_options_all());
				$content = str_replace($match[0],$replacement, $content);

			endforeach;
		}
		}

		if (stripos($content, 'http://www.youtube.com/v/') !== false) {
		if (preg_match_all($pattern3, $content, $matches, PREG_SET_ORDER)) {

			foreach ($matches as $match) :

				str_replace ('<p>'.$match[0].'</p>', $match[0], $content);
				if (preg_match($pat_title, $match[0], $mat_title))
					$title = $mat_title[2];
				else
					$title = '';
				
				$ytbID = explode('&', $match[4]);
				$thumb = 'http://img.youtube.com/vi/'.$ytbID[0].'/0.jpg" width="'.get_pt_options('youtube_width').'" height="'.get_pt_options('youtube_height');
				$replacement = SetYoutubeVideo ($ytbID[0], '', $thumb, get_pt_options_all());
				$content = str_replace($match[0],$replacement, $content);

			endforeach;
		}
		}

		if (stripos($content, '[youtube=') !== false) {
		if (preg_match_all($pattern1, $content, $matches, PREG_SET_ORDER)) {

			foreach ($matches as $match) :

				str_replace ('<p>'.$match[0].'</p>', $match[0], $content);
				$thumb = 'http://img.youtube.com/vi/'.$match[1].'/0.jpg" width="'.get_pt_options('youtube_width').'" height="'.get_pt_options('youtube_height');
				if (preg_match($pat_title, $match[0], $mat_title))
					$title = $mat_title[2];
				else
					$title = '';

				$replacement = SetYoutubeVideo ($match[1], $title, $thumb, get_pt_options_all());
				$content = str_replace($match[0],$replacement, $content);

			endforeach;
		}
		}

		return $content;
	}
	/****************************************************************/
	/* Initialize wordtube data
	/****************************************************************/
	function InitWordTube () {
	
		// checks for player type and prefers the mediaplayer
		$wordtube_abspath = ABSPATH.'/wp-content/plugins/' . $this->wt_path.'/';
		if (file_exists($wordtube_abspath.'mediaplayer.swf')) $this->playertype = 'mediaplayer.swf';
		elseif (file_exists($wordtube_abspath.'mp3player.swf')) $this->playertype = 'mp3player.swf';
		elseif (file_exists($wordtube_abspath.'flvplayer.swf')) $this->playertype = 'flvplayer.swf';
		else $this->playertype = false;

		if (file_exists($wordtube_abspath.'mp3player.swf')) $this->playertypemp3 = 'mp3player.swf';
		else $this->playertypemp3 = $this->playertype;

		$this->wordtube_options = get_option('wordtube_options');
	}
	/****************************************************************/
	/* Get category image
	/****************************************************************/
	function GetVideo ($name, $file, $image, $play_width, $play_height, $arg='', $vid) {

		// Init parameters
		$settings = '';
		$path = pathinfo($file);
		$extension = strtolower($path['extension']);
		$hs_width = $play_width+20;
		$ID = 'v'.rand();
		$playertype = $this->playertype;

		// Prepare the script string
		if ($extension == "flv") 
			$text = get_pt_options('wordtube_vtext');
		elseif ($extension == "mp3") { 
			$text = get_pt_options('wordtube_mtext');
			$playertype = $this->playertype;
			if ($this->wordtube_options['showeq']) $play_height=70; else $play_height = 20;
		}
				
		$new_args = pt_parse_arg($arg);

		if (isset($new_args['MYCLASSHREF'])) $myclasshref = $new_args['MYCLASSHREF']; else $myclasshref = '';
		if (isset($new_args['MYCLASSIMG'])) $myclassimg = ' class="'.$new_args['MYCLASSIMG'].'"'; else $myclassimg = '';

		// Get thumbnail
		if ($arg == '')
			$t = new pt_thumbnail(get_pt_options_all(), $image, 'keepratio=0&width='.get_pt_options('wordtube_width').'&height='.get_pt_options('wordtube_height').'&altappend='.get_pt_options('wordtube_text').'&textbox=1&text='.$text);
		else 
			$t = new pt_thumbnail(get_pt_options_all(), $image, $arg);
		$thumb_url = $t->thumb_url;
		unset($t);
		
		// returns custom message for RSS feeds
		if (is_feed()) {

			if (!empty($thumb_url)) $replace = '<br /><a href="'.$image.'"><img src="'.$thumb_url.'" alt="media"></a><br />'."\n"; 
			if ($this->wordtube_options['activaterss']) $replace .= "[".$this->wordtube_options['rssmessage']."]";
			return $replace;

		}
		// Prepare highslide html
		if (POSTTHUMB_USE_HS) {

	                $replace = SetWordTubeMedia ($file, $image, $play_width, $play_height, $ID, $extension, $playertype, $this->wordtube_options, false, $vid);
			$h = new pt_highslide('#', $thumb_url, $name);
			$h->set_colors(get_pt_options('bgcolor'));
			$h->set_borders(get_pt_options('hsframe'), get_pt_options('ovtopframe'));
			$h->set_size($play_width, $play_height);
			$h->set_myclasshref($myclasshref);
			$h->set_href_text($name, $myclassimg);
			$h->set_size($hs_width);
			$highslide = $h->highslide_link('swfObject', 'so'.$ID);
			unset($h);

			$replace .= $highslide;
		}
		elseif (POSTTHUMB_USE_TB || POSTTHUMB_USE_SB) {

       	                $replace = SetWordTubeMedia ($file, $image, $play_width, $play_height, $ID, $extension, $playertype, $this->wordtube_options, true, $vid);
			$h = new pt_thickbox('', $thumb_url, $name);
			$h->set_size($play_width+5, $play_height+10);
			$h->set_href_text($name);
			$h->set_myclasshref($myclasshref);
			$h->set_body($replace);
			$replace = $h->thickbox_link('swfObject', $ID);

			unset($h);
		}

		return $replace;

	}
	/****************************************************************/
	/* Get category image
	/****************************************************************/
	function GetYoutube ($id, $title, $thumb) {
	
		return SetYoutubeVideo ($id, $title, $thumb, get_pt_options_all());
		
	}
	/****************************************************************/
	/* Includes features in header
	/****************************************************************/
	function include_header() {


	}
}

?>