<?php
/*
Plugin Name: Post Thumb Revisited
Plugin URI: http://www.alakhnor.com/post-thumb
Description: Thumbnails images from your posts. Useful for listing popular posts, post list, etc.
Version: 2.1.9.1
Author:  Alakhnor
Author URI: http://www.alakhnor.com/post-thumb

	Copyright (c) 2006 Victor Chang (http://theblemish.com) for Post Thumb
	Copyright (c) 2007 Alakhnor (http://www.alakhnor.com/post-thumb) for Post Thumb Revisited
	Post Thumb Revisited is released under the GNU General Public License (GPL)
	http://www.gnu.org/licenses/gpl.txt

	This is a WordPress 2 plugin (http://wordpress.org).
        Highslide JS is licensed under a Creative Commons Attribution-NonCommercial 2.5 License: http://creativecommons.org/licenses/by-nc/2.5/
*/

// Defines path & urls
define('PLUGIN_BASENAME', dirname(plugin_basename(__FILE__)));
define('SITEURL', get_settings('siteurl'));
define('UPLOAD_PATH', get_settings('upload_path'));
define('PT_ABSPATH', ABSPATH.'wp-content/plugins/' . PLUGIN_BASENAME.'/');
define('POSTHUMB_ABSPATH', SITEURL.'/wp-content/plugins/' . PLUGIN_BASENAME.'/');

// calls function & class files
require(PT_ABSPATH . 'lib/post-thumb-functions.php');
require(PT_ABSPATH . 'lib/post-thumb-image-editor.php');
require(PT_ABSPATH . 'lib/post-thumb-main-functions.php');
require(PT_ABSPATH . 'lib/post-thumb-classes.php');

$PTRevisited = new PostThumbRevisited();

// define paths & URLs

################################################################################
########## MAIN CLASS
################################################################################
class PostThumbRevisited {

        var $settings;
        var $post_array = array();
        var $table_pt_post;
        var $LoadPostLimit = 200;
        var $now;
        var $post_nb = 0;

        var $wordtube_options;
        var $playertype;
        var $playertypemp3;
        var $wordtube_abspath;
        var $wt_path = 'wordtube';

	/**
	 * PostThumbRevisited
	 *
	 * Constructor for the PostThumbRevisited class.
	 */
	function PostThumbRevisited () {

          	global $wpdb, $wp_query;

		$this->now = $this->date_expl(gmdate('Y-m-d H:i:59',time()));

		// Insert the menu and options
		add_option('post_thumbnail_settings','','Post Thumb Revisited Options');

		$this->table_pt_post = $wpdb->prefix . "pt_post";
		$this->settings = pt_GetStarterOptions();

		// defines constants
		define('POSTTHUMB_URLPATH', str_replace($this->settings['full_domain_name'], '/',SITEURL).'/wp-content/plugins/' . PLUGIN_BASENAME.'/');
		define('POSTTHUMB_USE_HS', $this->settings['hs_use']=='true');
		define('POSTTHUMB_USE_TB', $this->settings['tb_use']=='true');
		define('POSTTHUMB_USE_SB', $this->settings['sb_use']=='true');

		// call classes
		if (POSTTHUMB_USE_HS) include(PT_ABSPATH . 'lib/post-thumb-highslide.php');
		if (POSTTHUMB_USE_TB) include(PT_ABSPATH . 'lib/post-thumb-thickbox.php');
		if (POSTTHUMB_USE_SB) include(PT_ABSPATH . 'lib/post-thumb-smoothbox.php');

		// Wordtube initialization
		if ($this->settings['hs_wordtube'] == 'true') {
			$wpdb->wordtube	= $wpdb->prefix . 'wordtube';
			$wpdb->wordtube_med2play = $wpdb->prefix . 'wordtube_med2play';
			$this->InitWordTube(); 
		}

		if (is_admin()) {
			include ( PT_ABSPATH  . '/post-thumb-options.php' );
			$PTAdmin = new PostThumbAdmin($this);
		}
		else {
			add_action('wp_head', array(&$this, 'include_header'));
			if (is_feed()) {
				$this->settings['hs_use']='false';
				$this->settings['tb_use']='false';
				$this->settings['hs_post']='true';
			}
			$this->GetPostList();
		}

	}

	/***********************************************************************************/
	/* Retrieve posts informations
	/***********************************************************************************/
	function GetPostList () {

		global $wpdb;

		if($wpdb->get_var("show tables like '$this->table_pt_post'") == $this->table_pt_post) {
//			$dbresults = $wpdb->get_results(" SELECT * FROM ".$this->table_pt_post." ORDER BY post_id DESC LIMIT ".$this->LoadPostLimit);
			$dbresults = $wpdb->get_results(" SELECT * FROM ".$this->table_pt_post." ORDER BY post_id DESC");

			if ($dbresults) {
	        		foreach ($dbresults as $dbresult) :
	        			$temp = stripslashes($dbresult->body);
	        			$unser_temp=unserialize($temp);
	        			if ($this->is_published($unser_temp['date'])) $this->post_array[$dbresult->post_id] = $temp;
	        		endforeach;
			}
			$this->post_nb = count($this->post_array);
			unset($dbresults);
			unset($unser_temp);
			unset($temp);
		}
	}
	/***********************************************************************************/
	/* Returns true if post date before now
	/***********************************************************************************/
	function date_expl($date) {
		$date = str_replace('-', '', $date);
		$date = str_replace(':', '', $date);
		return explode(' ', $date);
	}
	/***********************************************************************************/
	/* Returns true if post date before now
	/***********************************************************************************/
	function is_published ($date) {

		$date = $this->date_expl(mysql2date('Y-m-d H:i:59', $date));
		if ($date[0] > $this->now[0]) return false;
		if (($date[0] == $this->now[0]) && ($date[1] > $this->now[1])) return false;
		return true;
	}
	/***********************************************************************************/
	/* Get thumbnail. Loop function.
	/***********************************************************************************/
	function GetPostData ($key) {
		if (array_key_exists($key, $this->post_array))
			return unserialize($this->post_array[$key]);
		else return '';
	}
	/***********************************************************************************/
	/* Get thumbnail. Loop function.
	/***********************************************************************************/
	function GetThumb ($arg='') {
		global $post;

		setup_postdata($post);
		return $this->GetSingleThumb ($post, $arg, $beforeli, $afterli, $this->GetPostData($post->ID));

	}
	/***********************************************************************************/
	/* Prepares thumbnail for display.
	/***********************************************************************************/
	function GetSingleThumb ($post, $arg='', $before='', $after='', $post_array='') {

		$path = pathinfo($post_array['media_url']);

                if ($post_array['media_url'] != '' || $post_array['image_url'] != '') {

			$p = new pt_post_thumbnail(	$this->settings, 
							$post, 
							$arg, 
							$post_array['image_url'],
							$post_array['media_url'], 
							$post_array['permalink'], 
							$post_array['title'], 
							$post_array['date'], 
							$post_array['author'],
							$post_array['link'], 
							true);
			$post_link = $p->GetImgHTML();
			unset ($p);
		}

		else {
			$p = new pt_post_thumbnail($this->settings, $post, $arg);
			$post_link = $p->GetImgHTML();
			unset ($p);
		}

		if ( !empty($post_link) )
	          	return $before.$post_link.$after;
		else
			return '';
	}

	/***********************************************************************************/
	/* Returns recent posts
	/***********************************************************************************/
	function GetTheRecentThumbs ($arg='', $beforeli='', $afterli='', $before='', $after='') {

		// Create a query object to retrieve posts
		$my_query = new WP_Query();
		
		$new_args = pt_parse_arg($arg);

		// Retrieves specific parameters
		if (isset($new_args['MEDIA'])) $media = $new_args['MEDIA']; else $media = 'all';
		if (isset($new_args['LIMIT'])) { $limit = $new_args['LIMIT']; settype($limit,"integer"); } else $limit = 8;
		if (isset($new_args['OFFSET'])) { $offset = $new_args['OFFSET']; settype($offset,"integer"); } else $offset = 0;
		if (isset($new_args['CATEGORY'])) { $cat_ID = $new_args['CATEGORY'];$catid = explode(',', $cat_ID);$cat_arg = '&cat='.$cat_ID;	} else {$cat_arg = '';$cat_ID='';$catid=array();}

		$content = $before;
		$l = $limit+$offset;
		
		// Retrieve only images
		if ($media == '0') {

			$i = 1;
			foreach ($this->post_array as $key => $post_arrayS) :

				$post_array = $this->GetPostData($key);
				if ($i > $l) break;
	                	if ($i > $offset) {
					if ($post_array['media_url'] == '' && $this->in_category($post_array, $catid)) {
						$content .= $this->GetSingleThumb ('', $arg, $beforeli, $afterli, $post_array);
						$i++;
					}
				}
				else {
					if ($post_array['media_url'] == '' && $this->in_category($post_array, $cat_ID)) $i++;
				}

			endforeach;

		}
		// Retrieve non-youtube media
		elseif ($media == '1') {

			$i = 1;
			foreach ($this->post_array as $key => $post_arrayS) :

				$post_array = $this->GetPostData($key);
				if ($i > $l) break;
	                	if ($i > $offset) {
					if ($post_array['media_url'] != '' && $this->in_category($post_array, $catid)) {
						$path = pathinfo($post_array['media_url']);
						if ($path['extension'] != '') {
							$content .= $this->GetSingleThumb ('', $arg, $beforeli, $afterli, $post_array);
							$i++;
						}
					}
				}
				else {
					if ($post_array['media_url'] != '' && $this->in_category($post_array, $catid)) {
						$path = pathinfo($post_array['media_url']);
						if ($path['extension'] != '') {
							$i++;
						}
					}
				}

			endforeach;

		}
		// Retrieve youtube media
		elseif ($media == '2') {

			$i = 1;
			foreach ($this->post_array as $key => $post_arrayS) :

				$post_array = $this->GetPostData($key);
				if ($i > $l) break;
	                	if ($i > $offset) {
					if ($post_array['media_url'] != '' && $this->in_category($post_array, $catid)) {
						$path = pathinfo($post_array['media_url']);
						if ($path['extension'] == '') {
							$content .= $this->GetSingleThumb ('', $arg, $beforeli, $afterli, $post_array);
							$i++;
						}
					}
				}
				else {
					if ($post_array['media_url'] != '' && $this->in_category($post_array, $catid)) {
						$path = pathinfo($post_array['media_url']);
						if ($path['extension'] == '') $i++;
					}
				}

			endforeach;

		}
		// Retrieve all-media
		elseif ($media == '3') {

			$i = 1;
			foreach ($this->post_array as $key => $post_arrayS) :

				$post_array = $this->GetPostData($key);
				if ($i > $l) break;
	                	if ($i > $offset) { 
					if ($post_array['media_url'] != '' && $this->in_category($post_array, $catid)) {
						$content .= $this->GetSingleThumb ('', $arg, $beforeli, $afterli, $post_array);
						$i++;
					}
				}
				else {
					if ($post_array['media_url'] != '' && $this->in_category($post_array, $catid)) $i++;
				}

			endforeach;

		}
		else {

			$posts = $my_query->query('showposts='.$limit.'&offset='.$offset.$cat_arg);
			foreach ($posts as $post) :
				$post_array = $this->GetPostData($post->ID);
				$content .= $this->GetSingleThumb ($post, $arg, $beforeli, $afterli, $post_array);
			endforeach;
			unset ($my_query);
			unset ($posts);

		}
	        $content .= $after;
		return $content;
	}
	/****************************************************************/
	/* Returns true if post is in category id
	/****************************************************************/
	function in_category($post_array, $catid='') {
	
		if ($catid[0] == '') return true;
		if ($catid[0] < 0) { 
			$catid= explode('-', implode('', $catid));
			return (count(array_intersect($catid, unserialize($post_array['categories']))) == 0); 
		}
		else return (count(array_intersect($catid, unserialize($post_array['categories']))) != 0);
	}
	/***********************************************************************************/
	/* Return random thumbnails.
	/*
	/* LIMIT: number of thumbnail to display. Default is 1.
	/***********************************************************************************/
	function GetRandomThumb ($arg='', $beforeli='', $afterli='', $before='', $after='') {

		$new_args = pt_parse_arg($arg);

		// Retrieves specific parameters
		if (isset($new_args['LIMIT'])) { $limit = $new_args['LIMIT']; settype($limit,"integer"); } else $limit = 1;
		if (isset($new_args['CATEGORY'])) $catid = explode(',', $new_args['CATEGORY']); else $catid =array();
		if (isset($new_args['ALTAPPEND'])) $altappend = $new_args['ALTAPPEND']; else $altappend = 'azerty123456789';
		if (isset($new_args['BASENAME'])) $basename = ($new_args['BASENAME'] == 1); else $basename = false;

		$posts = $this->RandomId($limit, $catid);
		$random_str = $before;
		if (count($posts) == 1)
			$random_str = $this->GetSingleThumb ('', $arg.'&ALTAPPEND='.$altappend, $beforeli, $afterli, $this->GetPostData($posts));
		else {
			$i = 1;
			foreach ($posts as $post) :
			
				if ($basename) $add = $i; else $add = '';
				$random_str .= $this->GetSingleThumb ('', $arg.'&ALTAPPEND='.$altappend.$add, $beforeli, $afterli, $this->GetPostData($post));
				$i++;

			endforeach;
		}
		$random_str .= $after;
		
		return $random_str;
	}
	/****************************************************************/
	/* Returns displayable post content
	/****************************************************************/
	function RandomId($limit=1, $catid='') {

		if ($catid[0] == '') {
			if ($this->post_nb < $limit) $limit = $this->post_nb;
			$ret = array_rand ($this->post_array, $limit);
		}
		else {
			$rand = array();
			$i = 0;
			foreach ($this->post_array as $key => $post_arrayS) :

				$post_array = $this->GetPostData($key);
				if ($this->in_category($post_array, $catid)) {
					$rand[$key]=$post_array;
					$i++;
				}
			endforeach;
			if ($i < $limit) $limit = $i;
			$ret = array_rand ($rand, $limit);
			unset($rand);
		}

		return $ret;
	}
	/****************************************************************/
	/* Returns displayable post content
	/****************************************************************/
	function TheExcerpt($length=40, $title_after= false, $arg='') {

		global $post;
		setup_postdata($post);

		$p = new pt_post_thumbnail($this->settings, $post, $arg);
		$post_link = $p->GetImgHTML();
		unset ($p);

		$post->post_content = exclude_regex($post->post_content);
		$excerpt = get_excerpt_revisited($length);
		if ($title_after)
			$title = '<h2><a href="'.get_permalink().'" rel="bookmark" title="Permanent Link to '.get_the_title().'">'.get_the_title().'</a></h2>';
		else $title = '';

		// Display everything
		echo $post_link;
		echo $title;
		echo $excerpt;

	}
	/****************************************************************/
	/* test if a call is in a frame
	/****************************************************************/
	function is_inframe() {

		if (isset($_GET['inframe']))
			$inframe = $_GET['inframe'];
		else
			$inframe = 0;

		define('POSTHUMB_INFRAME', $inframe);

	}
	/****************************************************************/
	/* Includes features in header
	/****************************************************************/
	function include_header() {

		if (POSTTHUMB_USE_HS) {

			/* highslide includes ============================== */ 
			echo '<!-- Start Of Script Generated By Post-Thumb Revisited -->'."\n";
			wp_enqueue_script('highslide', POSTHUMB_ABSPATH.'js/highslide/highslide.js', false, '3.2.5');
			wp_enqueue_script('highslide-html', POSTHUMB_ABSPATH.'js/highslide/highslide-html.js', array('highslide'), '3.2.5');
			wp_enqueue_script('swfobject', POSTHUMB_ABSPATH.'js/highslide/swfobject.js', false, '1.44');
          		wp_print_scripts(array('highslide', 'highslide-html', 'swfobject'));
			echo '<!-- End Of Script Generated By Post-Thumb Revisited -->'."\n";
			?>
			<link rel="stylesheet" href="<?php echo POSTHUMB_ABSPATH; ?>js/style_hs.css" type="text/css" media="screen" />

			<script type="text/javascript">
				hs.graphicsDir = "<?php echo POSTHUMB_ABSPATH; ?>js/highslide/graphics/";
				hs.outlineType = "drop-shadow";
				hs.outlineWhileAnimating = false;
				hs.allowSizeReduction = true;
				hs.spaceForCaption = 30;
				hs.fullExpandTitle = "<?php _e('Expand to actual size', 'post-thumb'); ?>";
				hs.restoreTitle = "<?php _e('Click to close image, click and drag to move. Use arrow keys for next and previous.', 'post-thumb'); ?>";
				hs.focusTitle = "<?php _e('Click to bring to front', 'post-thumb'); ?>";
				hs.loadingText = "<?php _e('Loading...', 'post-thumb'); ?>";
				hs.loadingTitle = "<?php _e('Click to cancel', 'post-thumb'); ?>";
				hs.showCredits = false;
				hs.creditsText = '<?php _e("Powered by Highslide JS", "post-thumb"); ?>';
				hs.creditsHref = "<?php _e('http://vikjavev.no/highslide/', 'post-thumb'); ?>";
				hs.creditsTitle = "<?php _e('Go to the Highslide JS homepage', 'post-thumb'); ?>";
				hs.hideThumbOnExpand = false;
			</script>

			<?php
			$this->is_inframe();
		}
		if (POSTTHUMB_USE_TB) {

			/* thickbox includes ============================== */ 
			echo '<!-- Start Of Script Generated By Post-Thumb Revisited -->'."\n";
			wp_enqueue_script('jquery', POSTHUMB_ABSPATH.'js/jquery.js', false);
			wp_enqueue_script('thickbox', POSTHUMB_ABSPATH.'js/thickbox/thickbox.js', array('jquery'), '3.1');
			wp_enqueue_script('swfobject', POSTHUMB_ABSPATH.'js/highslide/swfobject.js', false, '1.44');
          		wp_print_scripts(array('jquery', 'thickbox', 'swfobject'));
			echo '<!-- End Of Script Generated By Post-Thumb Revisited -->'."\n";
			?>
			<script type="text/javascript">
				var tb_pathToImage = "<?php echo POSTHUMB_ABSPATH; ?>js/thickbox/loadingAnimation.gif";
			</script>
			<link rel="stylesheet" href="<?php echo POSTHUMB_ABSPATH; ?>js/thickbox/thickbox.css" type="text/css" media="screen" />
			<?php
		}
		if (POSTTHUMB_USE_SB) {

			/* smoothbox includes ============================== */ ?>
			<script type="text/javascript">
				var tb_pathToImage = "<?php echo POSTHUMB_ABSPATH; ?>js/thickbox/loadingAnimation.gif";
			</script>
			<script type="text/javascript" src="<?php echo POSTHUMB_ABSPATH; ?>js/mootools.js"></script>
			<script type="text/javascript" src="<?php echo POSTHUMB_ABSPATH; ?>js/smoothbox/smoothbox.js"></script>
			<script type="text/javascript" src="<?php echo POSTHUMB_ABSPATH; ?>js/highslide/swfobject.js"></script>
			<link rel="stylesheet" href="<?php echo POSTHUMB_ABSPATH; ?>js/smoothbox/smoothbox.css" type="text/css" media="screen" />

			<?php
		}
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
}
// End of main class

/****************************************************************/
/* Includes library if required.
/****************************************************************/
if (get_pt_options('hs_post') == 'true') {
	require(PT_ABSPATH . 'lib/post-thumb-library.php');
}
/****************************************************************/
/* Loads language file at init
/****************************************************************/
function post_thumb_init () {

	// Load language file
	$locale = get_locale();
	if ( !empty($locale) )
		load_textdomain('post-thumb', PT_ABSPATH.'languages/' . 'post-thumb'.$locale.'.mo');
}
add_action('init', 'post_thumb_init');
/****************************************************************/
/* Get category image
/****************************************************************/
function SetWordTubeMedia ($file, $image, $play_width, $play_height, $ID, $extension, $playertype, $wordtube_options='', $use_tb=false, $vid='') {

	// Init parameters
	$settings = '';
	if ($wordtube_options == '') $wordtube_options = get_option('wordtube_options'); 
	$hs_width = $play_width+20;

        $body = '<a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see the wordTube Media Player.';
	
	// Prepare the script settings string
	if ($extension == "mp3" && $wordtube_options['showeq']) {
			$settings .= "\n\t".'so'.$ID.'.addVariable("showeq", "true");';
			$play_height = 70; // fixed for equalizer
	}
	elseif ($extension == "mp3") $play_height = 20;

		
	$settings .= "\n\t".'so'.$ID.'.addVariable("autostart", "true");';
	if ($vid != '') $settings .= "\n\t".'so'.$ID.'.addVariable("id", "'.$vid.'");';
	if ($wordtube_options['usewatermark']) $settings .= "\n\t".'so'.$ID.'.addVariable("logo", "'.$wordtube_options['watermarkurl'].'");';
	if ($wordtube_options['repeat']) $settings .= "\n\t".'so'.$ID.'.addVariable("repeat", "true");';
	if ($wordtube_options['overstretch']) $settings .= "\n\t".'so'.$ID.'.addVariable("overstretch", "'.$wordtube_options['overstretch'].'");';
	if ($wordtube_options['showdigits']) $settings .= "\n\t".'so'.$ID.'.addVariable("showdigits", "true");';
	if ($wordtube_options['showfsbutton']) $settings .= "\n\t".'so'.$ID.'.addVariable("showfsbutton", "true");';
	if ($wordtube_options['statistic']) $settings .= "\n\t".'so'.$ID.'.addVariable("callback", "'.WORDTUBE_URLPATH.'wordtube-statistics.php");';
			
	$settings .= "\n\t".'so'.$ID.'.addVariable("backcolor", "0x'.$wordtube_options['backcolor'].'");';
	$settings .= "\n\t".'so'.$ID.'.addVariable("frontcolor", "0x'.$wordtube_options['frontcolor'].'");';
	$settings .= "\n\t".'so'.$ID.'.addVariable("lightcolor", "0x'.$wordtube_options['lightcolor'].'");';
	$settings .= "\n\t".'so'.$ID.'.addVariable("volume", "'.$wordtube_options['volume'].'");';
	$settings .= "\n\t".'so'.$ID.'.addVariable("bufferlength", "'.$wordtube_options['bufferlength'].'");';

	// neeeded for IE problems
	$settings .= "\n\t".'so'.$ID.'.addVariable("width", "'.$play_width.'");';
	$settings .= "\n\t".'so'.$ID.'.addVariable("height", "'.$play_height.'");';

	if ($wordtube_options['showfsbutton']) {
		$settings .= "\n\t".'so'.$ID.'.addParam("allowfullscreen", "true");';
	} else {
		// transparent didn't work with fullscreen mode
		$settings .= "\n\t".'so'.$ID.'.addVariable("showfsbutton", "false");';
		$settings .= "\n\t".'so'.$ID.'.addParam("wmode", "transparent");';
	}

	// Starts build the final string wrapped in <script>
    	$replace = "\n\t".'<script type="text/javascript">';
	if ($wordtube_options['xhtmlvalid']) $replace .= "\n\t".'<!--';
	if ($wordtube_options['xhtmlvalid']) $replace .= "\n\t".'//<![CDATA[';
	$replace .= "\n\t".'var so'.$ID.' = new SWFObject("'.WORDTUBE_URLPATH.$playertype.'", "1", "'.$play_width.'", "'.$play_height.'", "7", "#FFFFFF");';
	$replace .= "\n\t".'so'.$ID.'.addVariable("file", "'.$file.'");';
//	if ($extension != 'mp3') $replace .= "\n\t".'so'.$ID.'.addVariable("image", "'.$image.'");';
	
	$replace .= $settings;
	if ($use_tb) $replace .= "\n\t".'so'.$ID.'.write("myBody'.$ID.'");';

	if ($wordtube_options['xhtmlvalid']) $replace .= "\n\t".'//]]>'; // Wordpress change the CDATA end tag
	if ($wordtube_options['xhtmlvalid']) $replace .= "\n\t".'// -->';
	$replace .= "\n\t".'</script>'."\n";

	return $replace;

}
/****************************************************************/
/* Get category image
/****************************************************************/
function SetYoutubeVideo ($ytb_ID, $title='', $thumb, $settings, $add_arg='') {

	$ID = 'y'.rand();
	$url = 'http://youtube.com/watch?v='.$ytb_ID;
	if ($title == '') $title = 'Youtube video';
	$replacement = "\n".'<script type="text/javascript">';
	$replacement .= "\n\t".'var so'.$ID.'y = new SWFObject("http://youtube.com/v/'.$ytb_ID.'&amp;autoplay=1"';
	$replacement .= ', "1", "'.$settings['youtube_pwidth'].'", "'.$settings['youtube_pheight'].'", "7", "'.$settings['bgcolor'].'");';
	if (class_exists('pt_thickbox')) $replacement .= "\n\t".'so'.$ID.'y.write("myBody'.$ID.'");';
	$replacement .= "\n".'</script>'."\n";

	if (class_exists('pt_highslide')) {
	
		$h = new pt_highslide($url, $thumb, $title);
		$h->set_colors($settings['bgcolor']);
		$h->set_borders($settings['hsframe'], $settings['ovtopframe']);
		$h->set_href_text($title, $add_arg);
		$h->set_bottom(__('Direct link to: ', 'post-thumb').$title, $url);
		$h->set_size($settings['youtube_pwidth']+20, $settings['youtube_pheight']+20);
		$replacement .= $h->highslide_link('swfObject', 'so'.$ID.'y');
	
		unset($h);
	}
	elseif (class_exists('pt_thickbox')) {
	
		$h = new pt_thickbox($url, $thumb, $title);
		$h->set_size($settings['youtube_pwidth']+5, $settings['youtube_pheight']+10);
		$h->set_href_text($title);
		$h->set_body($replacement);
		$replacement = $h->thickbox_link('swfObject', $ID);
	
		unset($h);
	} 
	else {
		$replacement = "\n".'<object data="http://youtube.com/v/'.$ytb_ID.'" type="application/x-shockwave-flash" width="'.$settings['youtube_pwidth'].'" height="'.$settings['youtube_pheight'].'">';
	  	$replacement .=	"\n\t".'<param name="movie" value="http://youtube.com/v/'.$ytb_ID.'" />';
		$replacement .=	"\n".'</object>';
	}


	return $replacement;
}

?>