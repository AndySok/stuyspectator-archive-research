<?php

################################################################################
########## Administration class
################################################################################
class PostThumbAdmin {

	// Version and path to check version
	var $PTRVERSION = '2.2';
	var $PTRURL = 'http://www.alakhnor.com/post-thumb/ptrversion.htm';

	var $settings;
	var $pt_table;
	var $ptObject;
	var $tablestruct = " (post_id int(10) unsigned NOT NULL, body longtext NOT NULL )";
	var $tablequery = " post_id, body ";
	var $update_error = false;
	var $error_msg = '';

	
	/****************************************************************/
	/****************************************************************/
	function PostThumbAdmin($ptObject) {
	
		$this->ptObject = $ptObject;
		unset($ptObject);
		$this->settings = $this->ptObject->settings;
		
		// add WP actions - not limited to is_admin() to be applied also in case of xmlrpc posts by external blogging application
		add_action('publish_post',		array(&$this, 'savePostImage'));
		add_action('edit_post',			array(&$this, 'savePostImage'));
		add_action('save_post',			array(&$this, 'savePostImage'));
		add_action('wp_insert_post',		array(&$this, 'savePostImage'));
		add_action('wp_insert_post',		array(&$this, 'savePostImage'));
		add_action('private_to_published',	array(&$this, 'savePostImage'));
		add_action('delete_post', 		array(&$this, 'deletePostImage'));

		// Plugin activation
		add_action('activate_post-thumb/post-thumb.php', array(&$this, 'pt_activate'));

		// add option screen menu
		if (is_admin()) {
			add_action('admin_menu', array(&$this, 'pt_options'));
		
			// check if we need to upgrade
			if ( $this->settings['version'] < $this->PTRVERSION  ) {
				// Execute installation
				$this->pt_install();
				
				// Update version number in the options
				$this->settings['version'] = $this->PTRVERSION;
//				$this->UpdateOptions();
			}
		}

	}
	/****************************************************************/
	/* Plugin activation
	/****************************************************************/
	function pt_activate() {
		$this->pt_install(false);
	}
	/****************************************************************/
	/* Add post-thumb option
	/****************************************************************/
	function pt_options() {

		if (function_exists('add_options_page')) 
			add_options_page('Post Thumb Revisited', 'Post Thumb', 8, basename(__FILE__), array(&$this, 'pt_MenuOptions'));

	}
	/****************************************************************/
	/****************************************************************/
	function pt_install($show_results=true) {

		global $wpdb;

		/* create tags table if it doesn't exist */
		$tablename = $this->ptObject->table_pt_post;
        	$found = false;
        	foreach ($wpdb->get_results("SHOW TABLES;", ARRAY_N) as $row) {
        	
            		if ($row[0] == $tablename) {
                	$found = true;
                	break;
            		}
            		
        	}
        	
		if ($found && $this->settings['version'] < '2.1.4') {
       				$res = $wpdb->query(" DROP TABLE ".$tablename);
       				$found = false;
		}
		
		if (!$found) {
		
            		$res = $wpdb->get_results("CREATE TABLE $tablename " . $this->tablestruct);
	                $ptr2_options = pt_get_default_options();
			$ptr2_options['version'] = $this->PTRVERSION;
			update_option('post_thumbnail_settings', $ptr2_options);

			$count_posts = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->posts);
			$this->UpdatePostDB(0, $count_posts, $show_results);

		}
    	}

	/****************************************************************/
	/* Creates all record in DB
	/****************************************************************/
	function UpdatePostDB($llimit, $hlimit, $show_results=true) {

		global $wpdb;
		if ($show_results) echo '<p class="info">'.__('Posts: ', 'post-thumb').$llimit.' - '.$hlimit.' '.__('updated', 'post-thumb').'</p>';
		$lines = $hlimit-$llimit;

		$dbresults = $wpdb->get_results(" SELECT * FROM ".$wpdb->posts." LIMIT ".$llimit.",".$lines);
		foreach ($dbresults as $dbresult) :

			// Saves post data
			$this->StorePostData($dbresult);
 	
		endforeach;
		unset($dbresults);

	}
	/****************************************************************/
	/* save new list of post tags to database
	/****************************************************************/
	function savePostImage($id) {
	
		
		// authorization
		if ( !current_user_can('edit_post', $id) )
			return $id;

        	// clear old values first
		$this->deletePostImage($id);

		// Retrieve post content as list
		$post = &get_post($id);

		// skip drafts
		if ( !($post->post_status == 'publish' OR $post->post_status == 'static' OR $post->post_status == 'future'))
			return $id;

		// Saves post data
		$this->StorePostData($post);
		
	}

	/*******************************************************************************/
	/* Deletes a post record
	/*******************************************************************************/
	function GetMetacontent($id) {
	
		// finds an attachement to the post
       		if ($this->settings['use_meta'] == 'true') 
       			$metaContent = get_post_meta($id, 'pt_meta_thumb', true);
		else 
			$metaContent = '';
			
		return $metaContent;

	}
	/*******************************************************************************/
	/* Deletes a post record
	/*******************************************************************************/
	function StorePostData($post) {

        	global $wpdb;

 		$p = new postThumb($post);
		$metaContent = $this->GetMetacontent($p->post_id);
		$post->post_content = $this->apply_filters($post->post_content);
		
		if ($metaContent != '') 
			$p->image = tb_thumb_absolute($metaContent);

        	// finds an image from the post content
		elseif (preg_match('/<img(.*?)src=["'."']".'(.*?)["'."']".'(.*?)\/\>/i', $post->post_content, $matches)) {

			// put matches into recognizable vars
			$p->image = tb_thumb_absolute($matches[2]);

			$img_src = str_replace('/', '\/', $matches[2]);

			// detects if the image is already linked to a thumbnail
			$pattern = '/<a(.*?)href=["'."']".'(.*?).(bmp|jpg|jpeg|gif|png)["'."']".'(.*?)>(.*?)<img(.*?)src=["'."']".$img_src.'["'."']".'(.*?)>/i';
			if (preg_match($pattern,$post->post_content,$matches)) 
				$p->image = tb_thumb_absolute($matches[2].'.'.$matches[3]);

			// detects if the image is linked to an url
			$pattern = '/<a(.*?)href=[\'|"](.*?)[\'|"](.*?)><img(.*?)src=["'."']".$img_src.'["'."']".'(.*?)><\/a>/i';
			if (preg_match($pattern,$post->post_content,$matches))
				$p->link = $matches[2];

		}

		// Search for wordTube MEDIA. Hope it won't change after that. Needs to be refreshed if it does.
		if ($this->settings['hs_wordtube'] == 'true') {
			$pattern = '/\[MEDIA=([0-9]+%?)\]/i';
			if (preg_match($pattern, $post->post_content, $match)) {
				
				$media = $wpdb->get_row("SELECT * FROM $wpdb->wordtube WHERE vid = $match[1] ");
				$p->image = $media->image;
				$p->media = $media->file;
			}
		}
		 
		// Search for Youtube video.
		if ($this->settings['hs_youtube'] == 'true') {

			$pattern1 = '/\[youtube=\((.*?)\)(.*?)\]/i';
			$pattern2 = '/\<a(.*?)href="http:\/\/www\.youtube\.com\/watch\?v\=(.*?)"(.*?)\<\/a>/i';
			$pattern3 = '/\<object(.*?)value="http:\/\/www.youtube.com\/v\/(.*?)"\>(.*?)\<\/object>/is';
			if (preg_match($pattern1, $post->post_content, $match)) {

				$p->image = 'http://img.youtube.com/vi/'.$match[1].'/0.jpg';
                                $p->media = $match[1];

			} elseif (preg_match($pattern2, $post->post_content, $match)) {

				$p->image = 'http://img.youtube.com/vi/'.$match[2].'/0.jpg';
                                $p->media = $match[2];

			} elseif (preg_match($pattern3, $post->post_content, $match)) {

				$p->image = 'http://img.youtube.com/vi/'.$match[2].'/0.jpg';
                                $p->media = $match[2];
			}
		}

		if ($p->image != '') {
			// Retrieve categories. Again, this needs to be refreshed if categories change.
			$p->categories = $this->retrieveCategories($p->post_id);
			$this->savePost($p);
		}
		
		unset ($p);
		
	}
	/*******************************************************************************/
	/* Applies filters from other plugins
	/*******************************************************************************/
	function apply_filters($content) {

		if (function_exists('searchnggallerytags')) $content = searchnggallerytags($content);
		if (function_exists('pta_replace_tag')) $content = pta_replace_tag($content);
		if (function_exists('g2_imagebyidinpost')) $content = g2_imagebyidinpost($content);
		if (function_exists('g2_imagebypathinpost')) $content = g2_imagebypathinpost($content);

		return $content;

	}
	/*******************************************************************************/
	/* Deletes a post record
	/*******************************************************************************/
	function deletePostImage($postid) {
		
		global $wpdb;

		if ( is_numeric($postid) || $postid > 0 ) { 
			$wpdb->query("DELETE FROM {$this->ptObject->table_pt_post} WHERE post_id='$postid'");
			return true;
		} else {
			return false;
		}

	}
	/*******************************************************************************/
	/* Saves a post with its image
	/*******************************************************************************/
	function retrieveCategories($postid) {
	
		$catList = array();
		$categories = get_the_category($postid);
		foreach ($categories as $cat) :
			$catList[] = $cat->cat_ID;
		endforeach;
		$SerCatList = serialize($catList);
		
		return $SerCatList;
		
	}
	/*******************************************************************************/
	/* Saves a post with its image
	/*******************************************************************************/
	function savePost($p) {
	
		global $wpdb;
		
		$p_array = Array();
		$p_array['image_url'] 	= $p->image;
		$p_array['media_url'] 	= $p->media;
		$p_array['categories'] 	= $p->categories;
		$p_array['title'] 	= $p->title;
		$p_array['date'] 	= $p->date;
		$p_array['permalink'] 	= $p->permalink;
		$p_array['author'] 	= $p->author;
		$p_array['link'] 	= $p->link;
		
		$pObject = addslashes(serialize($p_array));
		
		$wpdb->query(" INSERT IGNORE INTO {$this->ptObject->table_pt_post} ($this->tablequery) 
				VALUES ( '$p->post_id', '$pObject' )");

	}
	/*******************************************************************************/
	/* Option panel
	/*******************************************************************************/
	function pt_MenuOptions() {
	
		global $wpdb;

		// Init parameters
		$count_posts = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->posts);
		if ($count_posts < 20) 
			$post_slice = 20; 
		else 
			$post_slice = ceil($count_posts/100)*10;
		$max_count = ceil($count_posts/$post_slice);
	
		$su = SITEURL;
		$up = UPLOAD_PATH;
		$pa = parse_url($su);
		$dn = str_replace($pa['path'],"",$su);
		$bp = str_replace($pa['path'],"",str_replace( "\\", "/",ABSPATH));
		$bp = substr($bp, 0, strlen($bp)-1);
		$pa['path'] = substr($pa['path'], 1, strlen($pa['path'])-1);

		// Detects wordTube
		$se = get_option('wordtube_options');
		if ($se == '') {
	        	$re='';
	                $wdet='';
		} else {
			$re = "MEDIA=";
	                $wdet='Wordtube detected';
		}

		$this->pt_admin_include_header();
		$new_options = pt_get_default_options();

		if (isset($_POST['info_update'])) {
		
		  	$_POST['use_meta'] 	= pt_GetBooleanOption ($_POST['use_meta']);
		  	$_POST['use_catname'] 	= pt_GetBooleanOption ($_POST['use_catname']);
		  	$_POST['stream_check'] 	= pt_GetBooleanOption ($_POST['stream_check']);
		  	$_POST['rounded'] 	= pt_GetBooleanOption ($_POST['rounded']);
		  	$_POST['use_png'] 	= pt_GetBooleanOption ($_POST['use_png']);
		  	$_POST['append'] 	= pt_GetBooleanOption ($_POST['append']);
		  	$_POST['keep_ratio'] 	= pt_GetBooleanOption ($_POST['keep_ratio']);
		  	$_POST['caption'] 	= pt_GetBooleanOption ($_POST['caption']);
		  	$_POST['unsharp'] 	= pt_GetBooleanOption ($_POST['unsharp']);
		  	$_POST['sb_use'] 	= pt_GetBooleanOption ($_POST['sb_use']);
		  	$_POST['tb_use'] 	= pt_GetBooleanOption ($_POST['tb_use']);
		  	$_POST['hs_use'] 	= pt_GetBooleanOption ($_POST['hs_use']);
		  	$_POST['hs_post'] 	= pt_GetBooleanOption ($_POST['hs_post']);
		  	$_POST['hs_wordtube'] 	= pt_GetBooleanOption ($_POST['hs_wordtube']);
		  	$_POST['wt_media'] 	= pt_GetBooleanOption ($_POST['wt_media']);
		  	$_POST['wt_playlist'] 	= pt_GetBooleanOption ($_POST['wt_playlist']);
		  	$_POST['ytb_media'] 	= pt_GetBooleanOption ($_POST['ytb_media']);
		  	$_POST['wt_append'] 	= pt_GetBooleanOption ($_POST['append']);
		  	$_POST['yt_append'] 	= pt_GetBooleanOption ($_POST['append']);
		  	$_POST['hs_youtube'] 	= pt_GetBooleanOption ($_POST['hs_youtube']);
		  	$_POST['pt_replace'] 	= pt_GetBooleanOption ($_POST['pt_replace']);
		  	$_POST['p_rounded'] 	= pt_GetBooleanOption ($_POST['p_rounded']);
		  	$_POST['p_keep_ratio'] 	= pt_GetBooleanOption ($_POST['p_keep_ratio']);
		  	$_POST['p_use_png'] 	= pt_GetBooleanOption ($_POST['p_use_png']);
		  	$_POST['p_unsharp'] 	= pt_GetBooleanOption ($_POST['p_unsharp']);
		  	$_POST['p_caption'] 	= pt_GetBooleanOption ($_POST['p_caption']);

			
			for ($i=1;$i<=$max_count;$i++) :
			
			  	$_POST['db_refresh'.$i]	= pt_GetBooleanOption ($_POST['db_refresh'.$i]);
				$llimit = ($i-1)*$post_slice;
				if ($i==$max_count) $hlimit = $count_posts; else $hlimit = $i*$post_slice;
				if ($_POST['db_refresh'.$i] == 'true') {
// echo 'TTTT'.$llimit.'RR'.$hlimit;
					$lines = $hlimit-$llimit;
					$array_posts = $wpdb->get_col(" SELECT ID FROM ".$wpdb->posts." LIMIT ".$llimit.",".$lines);
					$array_posts = '( '.implode(',', $array_posts).' )';
// print_r($array_posts);					
					$wpdb->query(" DELETE FROM ".$this->ptObject->table_pt_post." WHERE post_id IN ".$array_posts);
					$this->UpdatePostDB($llimit, $hlimit);
				}
			endfor;

		  	if (get_magic_quotes_gpc()) $_POST['video_regex'] = stripslashes($_POST['video_regex']);
		  	if (ini_get('safe_mode')) $safe_mode = 'true'; else $safe_mode = 'false';

		  	$new_options = array( 	'version'	=> $this->PTRVERSION,
			  			'default_image' => $this->noLeadSlash($this->noTrailSlash($_POST['default_image'])),
					 	'full_domain_name' => $this->noTrailSlash($_POST['full_domain_name']),
						'base_path' 	=> $this->noTrailSlash($_POST['base_path']),
						'folder_name' 	=> $this->noLeadSlash($this->noTrailSlash($_POST['folder_name'])),
						'rounded' 	=> $_POST['rounded'],
						'append' 	=> $_POST['append'],
						'use_meta' 	=> $_POST['use_meta'],
						'use_png' 	=> $_POST['use_png'],
						'append_text' 	=> $_POST['append_text'],
						'resize_width' 	=> $_POST['resize_width'],
						'resize_height' => $_POST['resize_height'],
						'keep_ratio' 	=> $_POST['keep_ratio'],
						'caption' 	=> $_POST['caption'],
						'phpversion' 	=> phpversion(),
						'tb_use' 	=> $_POST['tb_use'],
						'sb_use' 	=> $_POST['sb_use'],
						'hs_use' 	=> $_POST['hs_use'],
						'hs_post' 	=> $_POST['hs_post'],
						'hs_wordtube' 	=> $_POST['hs_wordtube'],
						'wt_media' 	=> $_POST['wt_media'],
						'wt_playlist' 	=> $_POST['wt_playlist'],
						'ytb_media' 	=> $_POST['ytb_media'],
						'wordtube_width' => $_POST['wordtube_width'],
						'wordtube_height' => $_POST['wordtube_height'],
						'wordtube_pwidth' => $_POST['wordtube_pwidth'],
						'wordtube_pheight' => $_POST['wordtube_pheight'],
						'wordtube_text' => $_POST['wordtube_text'],
						'wordtube_vtext' => $_POST['wordtube_vtext'],
						'wordtube_mtext' => $_POST['wordtube_mtext'],
						'hs_youtube' 	=> $_POST['hs_youtube'],
						'ovframe' 	=> $_POST['ovframe'],
						'hsframe' 	=> $_POST['hsframe'],
						'ovtopframe' 	=> $_POST['ovtopframe'],
						'unsharp' 	=> $_POST['unsharp'],
						'unsharp_amount' => $_POST['unsharp_amount'],
						'unsharp_radius' => $_POST['unsharp_radius'],
						'unsharp_threshold' => $_POST['unsharp_threshold'],
						'corner_ratio' 	=> $_POST['corner_ratio'],
						'youtube_width' => $_POST['youtube_width'],
						'youtube_height' => $_POST['youtube_height'],
						'youtube_pwidth' => $_POST['youtube_pwidth'],
						'youtube_pheight' => $_POST['youtube_pheight'],
						'jpg_rate' 	=> $_POST['jpg_rate'],
						'png_rate' 	=> $_POST['png_rate'],
						'use_catname' 	=> $_POST['use_catname'],
						'stream_check' 	=> $_POST['stream_check'],
						'video_regex' 	=> $_POST['video_regex'],
						'video_default' => $this->noLeadSlash($this->noTrailSlash($_POST['video_default'])),
						'bgcolor' 	=> $_POST['bgcolor'],
	
						'pt_replace' 	=> $_POST['pt_replace'],
						'p_rounded' 	=> $_POST['p_rounded'],
						'p_append_text' => $_POST['p_append_text'],
						'p_use_png' 	=> $_POST['p_use_png'],
						'p_resize_width' => $_POST['p_width'],
						'p_resize_height' => $_POST['p_height'],
						'p_keep_ratio' 	=> $_POST['p_keep_ratio'],
						'p_caption' 	=> $_POST['p_caption'],
						'p_unsharp' 	=> $_POST['p_unsharp'],
						'safe_mode'	=> $safe_mode
						);
	
			update_option('post_thumbnail_settings',$new_options);
		}

		// Validates options & displays error message
		$this->pt_ValidateOptions($new_options);
		?>
	        <div class="updated">
	    		<?php if ($this->update_error) : ?>
	    			<strong><?php _e('Update error:', 'post-thumb'); ?></strong> <?php echo $this->error_msg; ?>
	    		<?php else : ?>
	    			<strong><?php _e('Settings saved', 'post-thumb'); ?></strong>
	    		<?php endif; ?>
	    	</div>
		<?php
		
		$count_pt = $wpdb->get_var("SELECT COUNT(*) FROM ".$this->ptObject->table_pt_post);
		$post_thumbnail_settings = pt_get_default_options('post_thumbnail_settings');
		update_option('post_thumbnail_settings',$post_thumbnail_settings);

		?>
		<div class=wrap>
			<form method="post">
        	
				<h2><?php _e('Post Thumb Revisited Options', 'post-thumb'); ?></h2>
				<fieldset name="options">
        	
					<?php if ($this->ptr_version_check()) { ?>
						<p class="info"><?php _e('New Version available: ', 'post-thumb'); ?>
						<?php _e('The server reports that a new Post-Thumb Revisited Version is now available. Please visit the plugin homepage for more information.', 'post-thumb'); ?></p>
		                        <?php } else ?><?php _e('Version number: ', 'post-thumb');echo $this->PTRVERSION; ?>
					<br />

					<p class="info"><?php _e("Leave default settings if you're unsure of what to set.", 'post-thumb'); ?></p>
					<br />
        	
					<div style="width: 70%; float: left;">
						<p id="basicoptions" title="<?php _e('Click to view basic options only.', 'post-thumb'); ?>"><?php _e('Basic options', 'post-thumb'); ?></p>
						&nbsp;&nbsp;&nbsp;
						<p id="advancedoptions" title="<?php _e('Click to view advanced options.', 'post-thumb'); ?>"><?php _e('Advanced options', 'post-thumb'); ?></p>
					</div>
					
					<div class="submit" style="float:right;"><input style="align: right;width: 100px;" type="submit" name="info_update" value="<?php _e('Update', 'post-thumb'); ?>" /></div>
					<br />
		
				</fieldset>
        	
                               <p class="title showhide"><?php _e('Post Table settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">

					<p class="tabs"><?php _e('Posts viewed by Post-Thumb: ', 'post-thumb');echo $count_pt; ?></p><br />
					<p class="tabs"><?php _e('Posts in database: ', 'post-thumb');echo $count_posts; ?></p>
<?php           
					for ($i=1;$i<=$max_count;$i++) :
						$llimit = ($i-1)*$post_slice;
						if ($i==$max_count) $hlimit = $count_posts; else $hlimit = $i*$post_slice;
						echo '<input type="checkbox" name="db_refresh'.$i.'" />&nbsp;'.$llimit.'-'.$hlimit.'&nbsp;';
					endfor;
?>		
					<br />
					<p class="info"><?php _e('Check this to refresh Post database. You may need to do it  after changes on categories. If random_thumb or recent_thumbs functions does not work properly, refreshing Post-Thumb table may help.', 'post-thumb'); ?></p>

				</fieldset>
        	
                               <p class="title showhide"><?php _e('Location settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">
        	
					<p class="tabs"><?php _e('Base path', 'post-thumb'); ?></p>
					<input type="text" name="base_path" value="<?php echo $post_thumbnail_settings['base_path']; ?>" size="60" /><br />
 					<p class="tabsi"><?php _e('Initial default value: ', 'post-thumb'); ?></p><?php echo $bp; ?><br />
					<p class="info"><?php _e("Absolute path to website. For example, /httpdocs or /yourdomain.com. Used to find location of thumbnails on server. http://yourdomain.com/images/pth/thumb_picture.jpg would actually be /httpdocs/images/pth/thumb_picture.jpg.", 'post-thumb');echo ' ';_e("No trailing '/'", 'post-thumb'); ?>
        	                        <br />
        	                        
					<p class="tabs"><?php _e('Full domain name', 'post-thumb'); ?></p>
					<input type="text" name="full_domain_name" value="<?php echo $post_thumbnail_settings['full_domain_name']; ?>" size="60" /><br />
					<p class="tabsi"><?php _e('Initial default value: ', 'post-thumb'); ?></p><?php echo str_replace( "\\", "/",$dn); ?><br />
					<p class="info"><?php _e("Full domain name. Includes the http://.", 'post-thumb');echo ' ';_e("No trailing '/'", 'post-thumb'); ?><br />
        	                        <br />
        	                        
					<p class="tabs"><?php _e('Folder name', 'post-thumb'); ?></p>
					<input type="text" name="folder_name" value="<?php echo $post_thumbnail_settings['folder_name']; ?>" size="60" /><br />
					<p class="info"><?php _e('Set the relative path to thumbs. Make sure directory exists and is writable.', 'post-thumb');echo ' ';_e("No trailing '/'", 'post-thumb'); ?><br />
        	                        <br />
        	                        
					<div class="ptadvanced">
					<p class="tabs"><?php _e('Default image', 'post-thumb'); ?></p>
					<input type="text" name="default_image" value="<?php echo $post_thumbnail_settings['default_image']; ?>" size="60" /><br />
					<p class="info"><?php _e('The location of the default image to use if no picture can be found. Enter in the relative url, eg. images/default.jpg', 'post-thumb'); ?><br />
					<p class="info"><?php _e('If category names are used, this will override Default Image and Default Image for Videos', 'post-thumb'); ?><br />
        	                        <br />
        	                        
					<p class="tabs"><?php _e('Use meta data?', 'post-thumb'); ?></p>
					<input type="checkbox" name="use_meta" <?php if ($post_thumbnail_settings['use_meta'] == 'true') echo 'checked'; ?> /><br />
        	                        
					<p class="tabs"><?php _e('Use Category Names?', 'post-thumb'); ?></p>
					<input type="checkbox" name="use_catname" <?php if ($post_thumbnail_settings['use_catname'] == 'true') echo 'checked'; ?> /><br />
					</div>
        	
				</fieldset>

				<div class="ptadvanced">
				<p class="title showhide"><?php _e('System check', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">
        	
					<p class="tabs"><?php _e('PHP version', 'post-thumb'); ?></p>
					<?php echo $post_thumbnail_settings['phpversion']; ?><br />
        	
					<p class="tabs"><?php _e('Remote files', 'post-thumb'); ?></p>
					<?php if (ini_get('allow_url_fopen')) _e('Retrieve remote file is OK', 'post-thumb'); elseif (function_exists('curl_init'))_e('Retrieve remote file is OK using cURL', 'post-thumb'); else _e('Retrieve remote file not allowed on this server.', 'post-thumb'); ?><br />
					<p class="info"><?php _e('Dealing with remote file also requires php 4.3.0 or later', 'post-thumb'); ?></p><br />
        	
					<p class="tabs"><?php _e('GD version', 'post-thumb'); ?></p>
					<?php echo $post_thumbnail_settings['gdversion']; ?><br />
			
					<p class="tabs"><?php _e('Safe mode', 'post-thumb'); ?></p>
					<?php if ($post_thumbnail_settings['safe_mode']=='true') _e('Safe mode on', 'post-thumb'); else _e('Safe mode off', 'post-thumb'); ?><br />
			
					<p class="tabs"><?php _e('Memory limit', 'post-thumb'); ?></p>
					<?php if ($ml = ini_get('memory_limit')) echo $ml; else _e('Cannot Retrieve memory limit', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('Memory usage', 'post-thumb'); ?></p>
					<?php if (function_exists('memory_get_usage')) _e('Function memory_get_usage available', 'post-thumb'); else _e('Function memory_get_usage not available', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('Set Memory limit', 'post-thumb'); ?></p>
					<?php $ms = ini_set('memory_limit', $ml); if (empty($ms)) _e('Memory cannot be set', 'post-thumb'); else _e('Memory can be set', 'post-thumb'); ?><br />
        	
				</fieldset>
				</div>
		
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('Filename settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">
		
					<p class="tabs"><?php _e('Append / Prepend text', 'post-thumb'); ?></p>
					<input type="text" name="append_text" value="<?php echo $post_thumbnail_settings['append_text']; ?>" size="60" /><br />
					<p class="info"><?php _e('Choose text to append or prepend image with.', 'post-thumb'); ?>

					<p class="tabs"><?php _e('Append', 'post-thumb'); ?></p>
					<input type="checkbox" name="append" <?php if ($post_thumbnail_settings['append'] == 'true') echo 'checked'; ?> /><br />
					<p class="info"><?php _e('Choose to put text before image name or after. Unchecking will put text before.', 'post-thumb'); ?></p>
        	
					<?php _e(' Example: ', 'post-thumb');if ($post_thumbnail_settings['append']=='true') echo 'yourimage'.$post_thumbnail_settings['append_text'].'.jpg'; else echo $post_thumbnail_settings['append_text'].'yourimage'.'.jpg';?></p>
        	
				</fieldset>
				</div>
		
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('Video image settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">
				
					<p class="tabs"><?php _e('Video regex:', 'post-thumb'); ?></p>
					<input type="text" name="video_regex" value="<?php echo htmlentities($post_thumbnail_settings['video_regex']); ?>" size="60" /><br />
 					<p class="info"><?php _e('If you want to scan a post for a video and use a default image. Uses regex to scan for video.', 'post-thumb'); ?></p>
        	
					<p class="tabs"><?php _e('Video default image:', 'post-thumb'); ?></p>
					<input type="text" name="video_default" value="<?php echo $post_thumbnail_settings['video_default']; ?>" size="60" /><br />
        	
				</fieldset>
				</div>
		
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('Stream Video image settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">
        	
					<p class="tabs"><?php _e('Stream Check:', 'post-thumb'); ?></p>
					<input type="checkbox" name="stream_check" <?php if ($post_thumbnail_settings['stream_check'] == 'true') echo 'checked'; ?> /><br />
        	
					<p class="info"><?php _e('If you want to scan a post for a stream video. Supports Youtube, Gvideo and Dailymotion. Will display a thumb for each specific source.', 'post-thumb'); ?></p>
		
				</fieldset>
				</div>
		
				<p class="title showhide"><?php _e('Image settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">
        	
					<p class="tabs"><?php _e('Resize width x height', 'post-thumb'); ?></p>
					<input type="text" name="resize_width" value="<?php echo $post_thumbnail_settings['resize_width']; ?>" size="10" />
					x
					<input type="text" name="resize_height" value="<?php echo $post_thumbnail_settings['resize_height']; ?>" size="10" /><br />
					
					<?php $this->getSliderValue ($post_thumbnail_settings['jpg_rate'] * (2 - 16 / 100), '.slider1'); ?>
					<p class="tabs"><?php _e('Quality for jpeg', 'post-thumb'); ?></p>
					<input type="text" name="jpg_rate" id="jpg_rate" value="<?php echo $post_thumbnail_settings['jpg_rate']; ?>" size="3" />
					<?php _e('From 0 to 100 (best quality, highest size). Default: 75', 'post-thumb'); ?>
					<div class="wrapper"><div class="slider1"><div class="indicator1" id="indicator11"></div></div></div>
					<br />
		
					<?php if (version_compare_replacement(phpversion(), '5.1.2', '>=')) { ?>
        	
						<?php $this->getSliderValue ($post_thumbnail_settings['png_rate'] * (200/9 - 16 / 9), '.slider2'); ?>
						<p class="tabs"><?php _e('Compression for png', 'post-thumb'); ?></p>
						<input type="text" name="png_rate" id="png_rate" value="<?php echo $post_thumbnail_settings['png_rate']; ?>" size="3" />
						<?php _e('From 0 (no compression, best quality) to 9. Default: 6', 'post-thumb'); ?>
						<div class="wrapper"><div class="slider2"><div class="indicator2" id="indicator22"></div></div></div>
						<br />
        	
					<?php } ?>

					<p class="tabs"><?php _e('Keep ratio?', 'post-thumb'); ?></p>
					<input type="checkbox" name="keep_ratio" <?php if ($post_thumbnail_settings['keep_ratio'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to apply original picture ratio to thumbnails.', 'post-thumb'); ?><br />
					<p class="info"><?php _e('Choose your resize width and height. Will resize in proportion to original width and height. If you do not care about proportions, uncheck keep ratio.', 'post-thumb'); ?></p>
					<br />
        	
					<div class="ptadvanced">
					<p class="tabs"><?php echo __('Use rounded corner?', 'post-thumb').' '; ?></p>
					<input type="checkbox" name="rounded" <?php if ($post_thumbnail_settings['rounded'] == 'true') echo 'checked'; ?> />
					&nbsp;&nbsp;&nbsp;
					<?php _e('Corner ratio', 'post-thumb'); ?>
					<input type="text" name="corner_ratio" value="<?php echo $post_thumbnail_settings['corner_ratio']; ?>" size="10" />&nbsp;<?php _e('From 0 to 1. Typical: 0.15', 'post-thumb'); ?><br />
					<br />
        	
					<p class="tabs"><?php _e('Use png?', 'post-thumb'); ?></p>
					<input type="checkbox" name="use_png" <?php if ($post_thumbnail_settings['use_png'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to save thumbnails in .png format.', 'post-thumb'); ?><br />
					<p class="info"><?php _e('Checking this option will increase thumbnail size but is required with if rounded corners is checked.', 'post-thumb'); ?></p>
					<br />
        	
					<p class="tabs"><?php _e('Use unsharp mask', 'post-thumb'); ?></p>
					<input type="checkbox" name="unsharp" <?php if ($post_thumbnail_settings['unsharp'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to apply a sharpness mask to thumbnails.', 'post-thumb'); ?><br />
					<p class="info"><?php _e('WARNING: checking this option slows down the thumbnail creation.', 'post-thumb'); ?></p>
					<br />
        	
					<p class="tabs"><?php _e('Unsharp amount', 'post-thumb'); ?></p>
					<input type="text" name="unsharp_amount" value="<?php echo $post_thumbnail_settings['unsharp_amount']; ?>" size="3" />
					<?php _e('From 0 to 100. Typical: 80', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('Unsharp radius', 'post-thumb'); ?></p>
					<input type="text" name="unsharp_radius" value="<?php echo $post_thumbnail_settings['unsharp_radius']; ?>" size="3" />
					<?php _e('From 0 to 1. Typical: 0.5', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('Unsharp threshold', 'post-thumb'); ?></p>
					<input type="text" name="unsharp_threshold" value="<?php echo $post_thumbnail_settings['unsharp_threshold']; ?>" size="3" />
					<?php _e('From 0 to 5. Typical: 3', 'post-thumb'); ?><br />
					</div>
        	
				</fieldset>
		
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('Javascript settings (Highslide, Thickbox)', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">

 					<p class="tabs"><?php _e('Use Highslide?', 'post-thumb'); ?></p>
					<input type="checkbox" name="hs_use" <?php if ($post_thumbnail_settings['hs_use'] == 'true') echo 'checked'; ?> />
					<?php _e('Unckecking this will disable all Highslide effects', 'post-thumb'); ?><br />
        	

					<p class="tabs"><?php _e('Add caption to images?', 'post-thumb'); ?></p>
					<input type="checkbox" name="caption" <?php if ($post_thumbnail_settings['caption'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to add a caption to each image (available with Highslide).', 'post-thumb'); ?><br />
					<br />
        	
					<p class="tabs"><?php _e('Use Thickbox?', 'post-thumb'); ?></p>
					<?php if (true) { ?>
						<input type="checkbox" name="tb_use" <?php if ($post_thumbnail_settings['tb_use'] == 'true') echo 'checked'; ?> />
					<?php } ?>
					<?php _e('Unckecking this will disable all Thickbox effects', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('Use Smoothbox?', 'post-thumb'); ?></p>
					<?php if (false) { ?>
						<input type="checkbox" name="sb_use" <?php if ($post_thumbnail_settings['sb_use'] == 'true') echo 'checked'; ?> />
					<?php } ?>
					<?php _e('Unckecking this will disable all Smoothbox effects', 'post-thumb'); ?><br />
        	
					<p class="info"><?php _e('WARNING: it is not recommanded to use more than one library at a time.', 'post-thumb'); ?></p>

					<p class="tabs"><?php _e('Picture frame border style', 'post-thumb'); ?></p>
		        		<select size="1" name="ovframe" style="width:140px">
						<option value="rounded-black" <?php if ($post_thumbnail_settings['ovframe'] == 'rounded-black') echo 'selected="selected"'?>>rounded-black</option>
						<option value="rounded-white" <?php if ($post_thumbnail_settings['ovframe'] == 'rounded-white') echo 'selected="selected"'?>>rounded-white</option>
						<option value="outer-glow" <?php if ($post_thumbnail_settings['ovframe'] == 'outer-glow') echo 'selected="selected"'?>>outer-glow</option>
						<option value="drop-shadow" <?php if ($post_thumbnail_settings['ovframe'] == 'drop-shadow') echo 'selected="selected"'?>>drop-shadow</option>
						<option value="beveled" <?php if ($post_thumbnail_settings['ovframe'] == 'beveled') echo 'selected="selected"'?>>beveled</option>
						<option value="windows" <?php if ($post_thumbnail_settings['ovframe'] == 'windows') echo 'selected="selected"'?>>windows</option>
					</select>
					<br />
        	                                        
					<p class="tabs"><?php _e('Other frame border style', 'post-thumb'); ?></p>
       					<select size="1" name="hsframe" style="width:140px">
						<option value="rounded-black" <?php if ($post_thumbnail_settings['ovframe'] == 'rounded-black') echo 'selected="selected"'?>>rounded-black</option>
						<option value="rounded-white" <?php if ($post_thumbnail_settings['hsframe'] == 'rounded-white') echo 'selected="selected"'?>>rounded-white</option>
						<option value="outer-glow" <?php if ($post_thumbnail_settings['hsframe'] == 'outer-glow') echo 'selected="selected"'?>>outer-glow</option>
						<option value="drop-shadow" <?php if ($post_thumbnail_settings['hsframe'] == 'drop-shadow') echo 'selected="selected"'?>>drop-shadow</option>
						<option value="beveled" <?php if ($post_thumbnail_settings['hsframe'] == 'beveled') echo 'selected="selected"'?>>beveled</option>
						<option value="windows" <?php if ($post_thumbnail_settings['hsframe'] == 'windows') echo 'selected="selected"'?>>windows</option>
					</select>
					<br />
        	
					<p class="tabs"><?php _e('Frame top style', 'post-thumb'); ?></p>
		        		<select size="1" name="ovtopframe" style="width:140px">
						<option value="default" <?php if ($post_thumbnail_settings['ovtopframe'] == 'default') echo 'selected="selected"'?>>default</option>
						<option value="windows" <?php if ($post_thumbnail_settings['ovtopframe'] == 'windows') echo 'selected="selected"'?>>windows</option>
					</select>
					<br />
        	                                        
					<p class="tabs"><?php _e('Frame color?', 'post-thumb'); ?></p>
					<input type="text" name="bgcolor" value="<?php echo $post_thumbnail_settings['bgcolor']; ?>" size="8" /><br />
        	
					<p class="tabs"><?php _e('Activate wordTube functions?', 'post-thumb'); ?></p>
					<input type="checkbox" name="hs_wordtube" <?php if ($post_thumbnail_settings['hs_wordtube'] == 'true') echo 'checked'; ?> /><br />

				</fieldset>
		
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('WordTube settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">

					<p class="tabs"><?php _e('wordTube display size', 'post-thumb'); ?></p>
					<input type="text" name="wordtube_width" value="<?php echo $post_thumbnail_settings['wordtube_width']; ?>" size="10" />
					x
					<input type="text" name="wordtube_height" value="<?php echo $post_thumbnail_settings['wordtube_height']; ?>" size="10" />
					<?php _e('Wordtube thumbnail size.', 'post-thumb'); ?>
					<?php _e(' (width x height)', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs"><?php _e('wordTube play size', 'post-thumb'); ?></p>
					<input type="text" name="wordtube_pwidth" value="<?php echo $post_thumbnail_settings['wordtube_pwidth']; ?>" size="10" />
					x
					<input type="text" name="wordtube_pheight" value="<?php echo $post_thumbnail_settings['wordtube_pheight']; ?>" size="10" />
					<?php _e('Size of the frame to play wordTube video.', 'post-thumb'); ?>
					<?php _e(' (width x height)', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs"><?php _e('video display text', 'post-thumb'); ?></p>
					<input type="text" name="wordtube_vtext" value="<?php echo $post_thumbnail_settings['wordtube_vtext']; ?>" size="20" />
					<?php _e('Text shown in wordTube video thumbnails.', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('mp3 display text', 'post-thumb'); ?></p>
					<input type="text" name="wordtube_mtext" value="<?php echo $post_thumbnail_settings['wordtube_mtext']; ?>" size="20" />
					<?php _e('Text shown in wordTube mp3 thumbnails.', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('wordTube thumbnail text', 'post-thumb'); ?></p>
					<input type="text" name="wordtube_text" value="<?php echo $post_thumbnail_settings['wordtube_text']; ?>" size="20" />
					<?php _e('Text to append/prepend to wordtube thumbnail name.', 'post-thumb'); ?><br />

					<p class="tabs"><?php _e('Append', 'post-thumb'); ?></p>
					<input type="checkbox" name="wt_append" <?php if ($post_thumbnail_settings['append'] == 'true') echo 'checked'; ?> /><br />
					<p class="info"><?php _e('Choose to put text before image name or after. Unchecking will put text before.', 'post-thumb'); ?></p>
        	
				</fieldset>
		
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('Youtube settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">

					<p class="tabs"><?php _e('Detect Youtube video?', 'post-thumb'); ?></p>
					<input type="checkbox" name="hs_youtube" <?php if ($post_thumbnail_settings['hs_youtube'] == 'true') echo 'checked'; ?> /><br />
        	
					<p class="tabs"><?php _e('Youtube display size', 'post-thumb'); ?></p>
					<input type="text" name="youtube_width" value="<?php echo $post_thumbnail_settings['youtube_width']; ?>" size="10" />
					x
					<input type="text" name="youtube_height" value="<?php echo $post_thumbnail_settings['youtube_height']; ?>" size="10" />
					<?php _e('Youtube thumbnail size.', 'post-thumb'); ?>
					<?php _e(' (width x height)', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs"><?php _e('Youtube play size', 'post-thumb'); ?></p>
					<input type="text" name="youtube_pwidth" value="<?php echo $post_thumbnail_settings['youtube_pwidth']; ?>" size="10" />
					x
					<input type="text" name="youtube_pheight" value="<?php echo $post_thumbnail_settings['youtube_pheight']; ?>" size="10" />
					<?php _e('Size of the frame to play Youtube video.', 'post-thumb'); ?>
					<?php _e(' (width x height)', 'post-thumb'); ?>
					<br />
        	
				</fieldset>
				</div>
        	
				<div class="ptadvanced">
				<p class="title showhide"><?php _e('Post formatting settings', 'post-thumb'); ?></p>
				<fieldset class="options ptswitch">

					<p class="tabs"><?php _e('Use Post-Thumb formatting library in posts?', 'post-thumb'); ?></p>
					<input type="checkbox" name="hs_post" <?php if ($post_thumbnail_settings['hs_post'] == 'true') echo 'checked'; ?> />
        				<?php _e('Check this option will activate post formatting function.', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Resize width x height', 'post-thumb'); ?></p>
					<input type="text" name="p_width" value="<?php echo $post_thumbnail_settings['p_resize_width']; ?>" size="10" />
					x
					<input type="text" name="p_height" value="<?php echo $post_thumbnail_settings['p_resize_height']; ?>" size="10" />
					<br />
		
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Append / Prepend text', 'post-thumb'); ?></p>
					<input type="text" name="p_append_text" value="<?php echo $post_thumbnail_settings['p_append_text']; ?>" size="60" />
					<br />
		
					<p class="info">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Choose text to append or prepend image with.', 'post-thumb'); ?>
					<?php _e(' Example: ', 'post-thumb');if ($post_thumbnail_settings['p_append']=='true') echo 'yourimage'.$post_thumbnail_settings['p_append_text'].'.jpg'; else echo $post_thumbnail_settings['p_append_text'].'yourimage'.'.jpg';?></p>
					<br />
        	
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Keep ratio?', 'post-thumb'); ?></p>
					<input type="checkbox" name="p_keep_ratio" <?php if ($post_thumbnail_settings['p_keep_ratio'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to apply original picture ratio to thumbnails.', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Use rounded corner?', 'post-thumb').' '; ?></p>
					<input type="checkbox" name="p_rounded" <?php if ($post_thumbnail_settings['p_rounded'] == 'true') echo 'checked'; ?> />
					<br />
        	
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Use png?', 'post-thumb'); ?></p>
					<input type="checkbox" name="p_use_png" <?php if ($post_thumbnail_settings['p_use_png'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to save thumbnails in .png format.', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Use unsharp mask', 'post-thumb'); ?></p>
					<input type="checkbox" name="p_unsharp" <?php if ($post_thumbnail_settings['p_unsharp'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to apply a sharpness filter to thumbnails.', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Add caption to images?', 'post-thumb'); ?></p>
					<input type="checkbox" name="p_caption" <?php if ($post_thumbnail_settings['p_caption'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to add a caption to each image (available with Highslide).', 'post-thumb'); ?><br />
					<br />
        	
					<p class="info">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('WARNING: checking this option slows down the thumbnail creation.', 'post-thumb'); ?></p><br />
                               
					<p class="tabs"><?php _e('Add effect to existing thumbnails in posts?', 'post-thumb'); ?></p>
					<input type="checkbox" name="pt_replace" <?php if ($post_thumbnail_settings['pt_replace'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want Post-Thumb to add expand effect to existing thumbnails in posts.', 'post-thumb'); ?>
					<br />
        	
					<p class="tabs"><?php _e('Replace wordTube media in posts?', 'post-thumb'); ?></p>
					<input type="checkbox" name="wt_media" <?php if ($post_thumbnail_settings['wt_media'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to replace wordTube media by thumbnail and popup frame (available with Highslide).', 'post-thumb'); ?><br />

					<p class="tabs"><?php _e('Use PTPLAYLIST?', 'post-thumb'); ?></p>
					<input type="checkbox" name="wt_playlist" <?php if ($post_thumbnail_settings['wt_playlist'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to use PTPLAYLIST tag (available with Highslide).', 'post-thumb'); ?><br />
        	
					<p class="tabs"><?php _e('Replace Youtube in posts?', 'post-thumb'); ?></p>
					<input type="checkbox" name="ytb_media" <?php if ($post_thumbnail_settings['ytb_media'] == 'true') echo 'checked'; ?> />
					<?php _e('Check this option if you want to replace Youtube by thumbnail and popup frame (available with Highslide).', 'post-thumb'); ?><br />

				</fieldset>
				</div>

	         		<div class="submit"><input type="submit" name="info_update" value="<?php _e('Update', 'post-thumb'); ?>" /></div>

			</form>
		</div>
		<?php
	}
	/****************************************************************/
	/* Validates update options
	/****************************************************************/
	function pt_ValidateOptions($new_options) {

	        // Test resize values
		if (!is_numeric($new_options['resize_width'])) {
	
			$this->isError(__("Resize width must be a number"));
			$new_options['resize_width'] = '60';
		}
		elseif (!is_numeric($new_options['resize_height'])) {
			
			$this->isError(__("Resize width must be a number"));
			$new_options['resize_height'] = '60';
		}

	        // Test default image
		$video_exists = file_exists($new_options['base_path'].'/'.$new_options['video_default']);
		if (!$video_exists) $this->isError(__('Video default image not found on server.', 'post-thumb'));

	        // Test default image
		$default_exists = file_exists($new_options['base_path'].'/'.$new_options['default_image']);
		if (!$default_exists) $this->isError(__('Default image not found on server.', 'post-thumb'));

	        // Test folder name
		$this->TestFolder($new_options['base_path'].'/'.$new_options['folder_name']);
	
	}
	/****************************************************************/
	/* Delete leading slash
	/****************************************************************/
	function noLeadSlash ($text) {
		
		if (substr($text, 0, 1) == '/') return substr($text, 1);
		return $text;
	}
	/****************************************************************/
	/* Delete trailing slash
	/****************************************************************/
	function noTrailSlash ($text) {
		
		if (substr($text, -1) == '/') return substr($text, 0, strlen($text)-1);
		return $text;
	}
	/****************************************************************/
	/* Test if a path is writable
	/****************************************************************/
	function isError ($text) {
		
		$this->update_error = true;
		$this->error_msg = $text;
	}
	/****************************************************************/
	/* Test if a path is writable
	/****************************************************************/
	function TestFolder ($is_writable_dir) {

		$rs = PT_ABSPATH . 'lib/index.htm';
		$rt = $is_writable_dir . '/index.htm';

		if (is_dir($is_writable_dir)) {
		
			if (@copy($rs, $rt)===false)

				$this->isError(__('Directory: ', 'post-thumb').$is_writable_dir.' '.__('may not be writeable.', 'post-thumb'));
			else
	                        unlink($rt);
		}
		else 
			$this->isError(__('Directory: ', 'post-thumb').$is_writable_dir.' '.__('does not exist!', 'post-thumb'));

	}
	
	/****************************************************************/
	/* Includes features in header for admin panel
	/****************************************************************/
	function pt_admin_include_header() {

		/* js includes ============================== */ ?>
		<script type="text/javascript" src="<?php echo POSTHUMB_ABSPATH; ?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo POSTHUMB_ABSPATH; ?>js/interface.js"></script>
		<link rel="stylesheet" href="<?php echo POSTHUMB_ABSPATH; ?>js/style_interface.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo POSTHUMB_ABSPATH; ?>lib/ptr_admin.css" type="text/css" media="screen" />

		<script type="text/javascript">
			$(document).ready(function() {

				$('.slider1').Slider({
					accept : '.indicator1',
					fractions : 20,
					onSlide : function( cordx ) { document.getElementById('jpg_rate').value = cordx ; },
					opacity: 0.8,
				});

			});
		</script>

		<script type="text/javascript">
			$(document).ready(function() {

				$('.slider2').Slider({
					accept : '.indicator2',
					fractions : 9,
					onSlide : function( corx ) { document.getElementById('png_rate').value = (corx * 9) /100 ; }
				});
				
			});
		</script>

		<?php $echo = __('Click to hide and show', 'post-thumb'); ?>
		<script type="text/javascript">
			$(document).ready(function() {

				$('#advancedoptions').click(function() {
					$('.ptadvanced').show();
					$(this).css({ color: '#FFFFFF', background: '#0D324F' });;
					$('#basicoptions').css({ color: '#000000', background: '#FFFFFF' });;
					});

				$('#basicoptions').click(function() {
					$('.ptadvanced').hide();
					$(this).css({ color: '#FFFFFF', background: '#0D324F' });;
					$('#advancedoptions').css({ color: '#000000', background: '#FFFFFF' });;
					});

				$('.ptadvanced').css({ display: 'none' });

				$('.showhide').click(function() {$(this).next(".ptswitch").slideToggle();});
				$('.showhide').attr({ title: "<?php echo $echo; ?>" });

			});
		</script>

		<?php
	}
	/****************************************************************/
	/* Script for sliders in options
	/****************************************************************/
	function getSliderValue($value, $class) {
	
		settype($value, 'integer');
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('<?php echo $class; ?>').SliderSetValues(
					[
					[<?php echo $value; ?>,0]
					]
				);
			});
		</script>
		<?php
	}
	/***********************************************************************************/
	/* Check for a new version of Post-thumb Revisited on server. This one is basic
	/***********************************************************************************/
	function ptr_version_check() {

		require_once(ABSPATH . WPINC . '/class-snoopy.php');
	
		// check for a new version
		$check_intervall = get_option( "ptr_next_update" );
	
		if ( ($check_intervall < time() ) or (empty($check_intervall)) ) {
			if (class_exists(snoopy)) {

				$client = new Snoopy();
				$client->_fp_timeout = 10;

				if (@$client->fetch($this->PTRURL) === false)
					return false;

			   	$remote = $client->results;
				$server_version = $remote;

				if ( version_compare($server_version, $this->PTRVERSION, '>'))
			 		return true;

				// come back in 24 hours :-)
				$check_intervall = time() + 86400;
				update_option( "ptr_next_update", $check_intervall );
				return false;
			}
		}

		return false;
	}
} // End of admin class

################################################################################
########## Record class
################################################################################
class postThumb {

	var $post_id;
	var $image_url='';
	var $media_url='';
	var $categories='';
	var $title='';
	var $date='';
	var $permalink='';
	var $author='';
	var $link='';
	
	function postThumb($post='') {
		if ($post != '')
			$this->post_id = $post->ID;
			$this->title = $post->post_title;
			$this->date = $post->post_date_gmt;
			$this->permalink = get_permalink($this->post_id);
			$author = get_author_name($post->post_author);
			$this->author= '<a href="'.get_author_posts_url($post->post_author).'" title="'.
					__('Posts from: ', 'Post-thumb').$author.'">'.$author.'</a>';
	}
}

/****************************************************************/
/* Set checkbox result to boolean
/****************************************************************/
function pt_GetBooleanOption($boolean) {

  	if ($boolean == 'on') 
		$boolean = 'true';
  	else 
	  	$boolean = 'false';
	  	
	return $boolean;
}
/****************************************************************/
/* Validates update options
/****************************************************************/
function pt_get_default_options() {

	// Init parameters
	$su = SITEURL;
	$up = get_settings('upload_path');
	$pa = parse_url(SITEURL);
	$dn = str_replace($pa['path'],"",SITEURL);
	$bp = str_replace($pa['path'],"",str_replace( "\\", "/",ABSPATH));
	$bp = substr($bp, 0, strlen($bp)-1);
	$pa['path'] = substr($pa['path'], 1, strlen($pa['path'])-1);
	$def = $pa['path'].'/wp-content/plugins/'. PLUGIN_BASENAME.'/images/default.png';
	$se = get_option('wordtube_options');
	if ($se=='') {
		$re='';
		$wdet='';
	} else {
		$re = "MEDIA="; 
		$wdet='Wordtube detected';
	}

	$settings = get_option('post_thumbnail_settings');

	if ($settings['append'] == '') 		$settings['append'] = 'false';
	if ($settings['append_text'] == '') 	$settings['append_text'] = 'thumb_';
	if ($settings['base_path'] == '') 	$settings['base_path'] = $bp;
	if ($settings['bgcolor'] == '') 	$settings['bgcolor'] = '#000000';
	$settings['corner_ratio'] 		= ptr_test_setting($settings['corner_ratio'], '0.150', 1);
//	if ($settings['default_image'] == '') 	$settings['default_image'] = $pa['path'].'/'.$up.'/default.jpg';
	if ($settings['default_image'] == '') 	$settings['default_image'] = $def;
	if ($settings['folder_name'] == '') 	$settings['folder_name'] = $pa['path'].'/'.$up.'/pth';
	if ($settings['full_domain_name'] == '')$settings['full_domain_name'] = str_replace( "\\", "/",$dn);
	if ($settings['gdversion'] == '') 	$settings['gdversion'] = gd_version(true);

	if ($settings['sb_use'] == '') 		$settings['sb_use'] = 'false';
	if ($settings['tb_use'] == '') 		$settings['tb_use'] = 'false';
	if ($settings['hs_use'] == '') 		$settings['hs_use'] = 'false';
	if ($settings['caption'] == '') 	$settings['caption'] = 'false';
	if ($settings['hsframe'] == '') 	$settings['hsframe'] = 'drop-shadow';
	if ($settings['hs_post'] == '') 	$settings['hs_post'] = 'false';
	if ($settings['hs_use'] == '') 		$settings['hs_use'] = 'true';
	if ($settings['hs_wordtube'] == '') 	$settings['hs_wordtube'] = 'false';
	if ($settings['hs_youtube'] == '') 	$settings['hs_youtube'] = 'false';

	if ($settings['info_update'] == '') 	$settings['info_update'] = 'Create';
	$settings['jpg_rate'] 			= ptr_test_setting($settings['jpg_rate'], '75', 100);
	if ($settings['keep_ratio'] == '') 	$settings['keep_ratio'] = 'true';
	if ($settings['ovframe'] == '') 	$settings['ovframe'] = 'drop-shadow';
	if ($settings['ovtopframe'] == '') 	$settings['ovtopframe'] = 'default';
	if ($settings['phpversion'] == '') 	$settings['phpversion'] = phpversion();
	$settings['png_rate'] 			= ptr_test_setting($settings['png_rate'], '6', 9);

	$settings['resize_width'] 		= ptr_test_setting($settings['resize_width'], '60');
	$settings['resize_height'] 		= ptr_test_setting($settings['resize_height'], '60');

	if ($settings['rounded'] == '') 	$settings['rounded'] = 'false';
	if ($settings['stream_check'] == '') 	$settings['stream_check'] = 'true';

	if ($settings['unsharp'] == '') 	$settings['unsharp'] = 'false';
	$settings['unsharp_amount'] 		= ptr_test_setting($settings['unsharp_amount'], '80', 100);
	$settings['unsharp_radius'] 		= ptr_test_setting($settings['unsharp_radius'], '0.5', 1);
	$settings['unsharp_threshold'] 		= ptr_test_setting($settings['unsharp_threshold'], '3', 5);

	if ($settings['use_catname'] == '') 	$settings['use_catname'] = 'false';
	if ($settings['use_meta'] == '') 	$settings['use_meta'] = 'true';
	if ($settings['use_png'] == '') 	$settings['use_png'] = 'false';

	if ($settings['video_regex'] == '') 	$settings['video_regex'] = $re;
	if ($settings['video_default'] == '') 	$settings['video_default'] = $def;

	if ($settings['wordtube_text'] == '') 	$settings['wordtube_text'] = 'wtthumb_';
	$settings['wordtube_width'] 		= ptr_test_setting($settings['wordtube_width'], '160');
	$settings['wordtube_height'] 		= ptr_test_setting($settings['wordtube_height'], '120');
	$settings['wordtube_pwidth'] 		= ptr_test_setting($settings['wordtube_pwidth'], '425');
	$settings['wordtube_pheight'] 		= ptr_test_setting($settings['wordtube_pheight'], '350');

	$settings['youtube_width'] 		= ptr_test_setting($settings['youtube_width'], '160');
	$settings['youtube_height'] 		= ptr_test_setting($settings['youtube_height'], '120');
	$settings['youtube_pwidth'] 		= ptr_test_setting($settings['youtube_pwidth'], '425');
	$settings['youtube_pheight'] 		= ptr_test_setting($settings['youtube_pheight'], '350');


	if ($settings['pt_replace'] == '') 	$settings['pt_replace'] = 'false';
	if ($settings['p_append_text'] == '') 	$settings['p_append_text'] = 'pthumb_';
	if ($settings['p_keep_ratio'] == '') 	$settings['p_keep_ratio'] = 'true';
	$settings['p_resize_width'] 		= ptr_test_setting($settings['p_resize_width'], '120');
	$settings['p_resize_height'] 		= ptr_test_setting($settings['p_resize_height'], '120');
	if ($settings['p_rounded'] == '') 	$settings['p_rounded'] = 'false';
	if ($settings['p_unsharp'] == '') 	$settings['p_unsharp'] = 'false';
	if ($settings['p_use_png'] == '') 	$settings['p_use_png'] = 'false';
	if ($settings['p_caption'] == '') 	$settings['p_caption'] = 'false';

	if ($settings['wt_media'] == '') 	$settings['wt_media'] = 'false';
	if ($settings['wt_playlist'] == '') 	$settings['wt_playlist'] = 'false';
	if ($settings['p_caption'] == '') 	$settings['p_caption'] = 'false';
	return $settings;
}

?>
