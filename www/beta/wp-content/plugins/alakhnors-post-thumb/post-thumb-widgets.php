<?php
/*
Plugin Name: Post thumb widget
Description: Adds sidebar widgets to display post-thumb revisited features
Version: 2.1
Author: Alakhnor
Author URI: http://www.alakhnor.com/post-thumb
*/

/**********************************************************************************
Widget functions:
	- pt-wordtube
	- pt-random
	- pt-recent
	- pt-recent-video
	- pt-recent-youtube
	- pt-categories
	- pt-slideshow
	- pt-news
	- pt-last-youtube
**********************************************************************************/

function post_thumb_widget()
{
	if ( !function_exists('register_sidebars')) return;
/*********************************************************************************/
/* wordTube widget
/*********************************************************************************/
if (function_exists('pt_replacevideo')) {
	function web_wordtube($args)
	{
		extract($args);

		// Each widget can store its own options. We keep strings here.
		$options = get_option('web_wordtube');
		$title = $options['title'];
		$mediaid = $options['mediaid'];
		$content = '[MEDIA='.$mediaid.']';

		// These lines generate our output.
		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		echo pt_replacevideo($mediaid, $content);
		echo $after_widget;

	}
	/*********************************************************************************/
	/* wordTube widget control
	/*********************************************************************************/
	function web_wordtube_control()
	{
		global $wpdb;
		$options = get_option('web_wordtube');
		if ( !is_array($options) )
			$options = array('title'=>'', 'mediaid'=>'0');

		if ( $_POST['wordtube-submit'] )
	        {
	        	$options['title'] = strip_tags(stripslashes($_POST['wordtube-title']));
			$options['mediaid'] = $_POST['wordtube-mediaid'];
			update_option('web_wordtube', $options);
		}

		$title = htmlspecialchars($options['title'], ENT_QUOTES);

		// The Box content
		echo '<p style="text-align:right;"><label for="wordtube-title">' . __('Title:') . ' <input style="width: 200px;" id="wordtube-title" name="wordtube-title" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="wordtube-mediaid">' . __('Select Media:', 'wpTube'). ' </label>';
		echo '<select size="1" name="wordtube-mediaid" id="wordtube-mediaid">';

		$tables = $wpdb->get_results("SELECT * FROM $wpdb->wordtube ORDER BY 'vid' ASC ");
		if($tables)
	        {
			foreach($tables as $table) {
				echo '<option value="'.$table->vid.'" ';
				if ($table->vid == $options['mediaid']) echo "selected='selected' ";
				echo '>'.$table->name.'</option>'."\n\t";
				}
			}
		echo '</select></p>';
		echo '<input type="hidden" id="wordtube-submit" name="wordtube-submit" value="1" />';
	}

	register_sidebar_widget ( 'pt-wordTube', 'web_wordTube', 'wid-wordtube');
	register_widget_control ( 'pt-wordTube', 'web_wordtube_control', 300, 100);

}
/*********************************************************************************/
/* Simple forum widget
/*********************************************************************************/
if (function_exists('sf_recent_posts_tag')) {
	function web_forum($args)
	{
		extract($args);
		$options = get_option('web_forum');
		$title = empty($options['title']) ? __('Forum', 'post-thumb') : $options['title'];

		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<?php sf_recent_posts_tag (); ?>
			</ul>
		<?php echo $after_widget;

	}
}
/*********************************************************************************/
/* Random post widget
/*********************************************************************************/
function web_random($args)
{
	extract($args);
	$options = get_option('web_random');
	$k = $options['keepratio'] ? '1' : '0';
	$w = $options['width'];
	$h = $options['height'];
	$l = $options['limit'];
	$c = $options['category'];
	$st = $options['showtitle'];
	$link = 'i';
	if ($options['showpost']) $link ='p';
	if ($options['showlink']) $link ='u';
	
	$lb = $options['LBeffect'] ? '1' : '0';
	$bn = $options['basename'] ? '1' : '0';
	if ($options['html'] =='') $html='li'; else $html = $options['html'];
	if ($options['class'] =='') $class=''; else $class = ' class="'.$options['class'].'"';
	$title = empty($options['title']) ? __('Random', 'post-thumb') : $options['title'];

	?>
	<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title; ?>
		<ul>
			<?php the_random_thumb ('subfolder=random&altappend=random_&link='.$link.'&width='.$w.'&height='.$h.'&limit='.$l.'&category='.$c.'&keepratio='.$k.'&showtitle='.$st.'&LB_effect='.$lb.'&basename='.$bn, '<li>', '</li>', '', ''); ?>
		</ul>
	<?php echo $after_widget; ?>
	<?php echo '<'.$html.$class.'></'.$html.'>'; ?>
        <?php
}
/*********************************************************************************/
/* Random post widget control
/*********************************************************************************/
function web_random_control() {

	$options = $newoptions = get_option('web_random');
	if ( $_POST['web-random-submit'] ) {
		$newoptions['keepratio'] 	= isset($_POST['web-random-keepratio']);
		$newoptions['width'] 		= strip_tags(stripslashes($_POST['web-random-width']));
		$newoptions['height'] 		= strip_tags(stripslashes($_POST['web-random-height']));
		$newoptions['limit'] 		= strip_tags(stripslashes($_POST['web-random-limit']));
		$newoptions['showtitle'] 	= strip_tags(stripslashes($_POST['web-random-showtitle']));
		$newoptions['category'] 	= strip_tags(stripslashes($_POST['web-random-category']));
		$newoptions['showpost'] 	= isset($_POST['web-random-showpost']);
		$newoptions['showlink'] 	= isset($_POST['web-random-showlink']);
		$newoptions['LBeffect'] 	= isset($_POST['web-random-LBeffect']);
		$newoptions['class'] 		= strip_tags(stripslashes($_POST['web-random-class']));
		$newoptions['html'] 		= strip_tags(stripslashes($_POST['web-random-html']));
		$newoptions['title'] 		= strip_tags(stripslashes($_POST['web-random-title']));
		$newoptions['basename']		= isset($_POST['web-random-basename']);
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('web_random', $options);
	}
	$title = wp_specialchars($options['title']);
	if (wp_specialchars($options['html']) =='') $html='li'; else $html = $options['html'];
	$class = wp_specialchars($options['class']);
	$category = wp_specialchars($options['category']);
	$keepratio = $options['keepratio'] ? 'checked="checked"' : '';
	$basename = $options['basename'] ? 'checked="checked"' : '';
	if (wp_specialchars($options['width']=='')) $width = '240'; else $width = wp_specialchars($options['width']);
	if (wp_specialchars($options['height']=='')) $height = '200'; else $height = wp_specialchars($options['height']);
	if (wp_specialchars($options['limit']=='')) $limit = '5'; else $limit = wp_specialchars($options['limit']);
	$showtitle = wp_specialchars($options['showtitle']);
	$LBeffect = $options['LBeffect'] ? 'checked="checked"' : '';
	$showpost = $options['showpost'] ? 'checked="checked"' : '';
	$showlink = $options['showlink'] ? 'checked="checked"' : '';
?>
	<p><label for="web-random-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-random-title" name="web-random-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-keepratio"><?php _e('Keep ratio', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $keepratio; ?> id="web-random-keepratio" name="web-random-keepratio" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-width" style="text-align:right;"><?php _e('Width', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-random-width" name="web-random-width" value="<?php echo $width; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-height" style="text-align:right;"><?php _e('Height', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-random-height" name="web-random-height" value="<?php echo $height; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-limit" style="text-align:right;"><?php _e('Show count', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-random-limit" name="web-random-limit" value="<?php echo $limit; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-showtitle" style="text-align:right;"><?php _e('Show title', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-random-showtitle" name="web-random-showtitle" value="<?php echo $showtitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-showpost" style="text-align:right;"><?php _e('Link to post', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showpost; ?> id="web-random-showpost" name="web-random-showpost" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-showlink" style="text-align:right;"><?php _e('Link to url', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showlink; ?> id="web-random-showlink" name="web-random-showlink" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-category" style="text-align:right;"><?php _e('Category filter', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $category; ?>" id="web-random-category" name="web-random-category" /></label></p>
	<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-random-LBeffect"><?php _e('HS effect', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $LBeffect; ?> id="web-random-LBeffect" name="web-random-LBeffect" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-html"><?php _e('Closing html:'); ?> <input style="width: 100px;" id="web-random-html" name="web-random-html" type="text" value="<?php echo $html; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-class"><?php _e('Closing class:'); ?> <input style="width: 100px;" id="web-random-class" name="web-random-class" type="text" value="<?php echo $class; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-random-basename"><?php _e('Force name to unique', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $basename; ?> id="web-random-basename" name="web-random-basename" /></label></p>
	<input type="hidden" id="web-random-submit" name="web-random-submit" value="1" />
<?php
}

register_sidebar_widget ( 'pt-random', 'web_random', 'wid_random' );
register_widget_control ( 'pt-random', 'web_random_control', 300, 440);

/*********************************************************************************/
/* Slideshow widget
/*********************************************************************************/
if (function_exists('pt_slideshow')) {
	function web_slideshow($args) {
	
		extract($args);
		$options = get_option('web_slideshow');
		$k = $options['keepratio'] ? '1' : '0';
		$r = $options['random'];
		$w = $options['width'];
		$h = $options['height'];
		$c = $options['category'];
		$lb = $options['LBeffect'] ? '1' : '0';
		if ($options['showpost']) $link ='p';
		if ($options['showlink']) $link ='u';
		$l = $options['limit'];
		$bn = $options['basename'] ? '1' : '0';
		$title = empty($options['title']) ? __('Slideshow', 'post-thumb') : $options['title'];
		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul >
				<?php pt_slideshow('subfolder=slideshow&media=0&category='.$c.'&altappend=slide_&width='.$w.'&height='.$h.'&keepratio='.$k.'&limit='.$l.'&LB_effect='.$lb.'&link='.$link.'&basename='.$bn, $r); ?>
	  		</ul>
		<?php echo $after_widget; ?>
	        <?php
	}
	/*********************************************************************************/
	/* Slideshow widget control
	/*********************************************************************************/
	function web_slideshow_control() {
	
		$options = $newoptions = get_option('web_slideshow');
		if ( $_POST['web-slideshow-submit'] ) {
		
			$newoptions['width'] 	= strip_tags(stripslashes($_POST['web-slideshow-width']));
			$newoptions['height'] 	= strip_tags(stripslashes($_POST['web-slideshow-height']));
			$newoptions['random']	= isset($_POST['web-slideshow-random']);
			$newoptions['keepratio']= isset($_POST['web-slideshow-keepratio']);
			$newoptions['category'] = strip_tags(stripslashes($_POST['web-slideshow-category']));
			$newoptions['title'] 	= strip_tags(stripslashes($_POST['web-slideshow-title']));
			$newoptions['showpost'] = isset($_POST['web-slideshow-showpost']);
			$newoptions['showlink'] = isset($_POST['web-slideshow-showlink']);
			$newoptions['LBeffect'] = isset($_POST['web-slideshow-LBeffect']);
			$newoptions['limit']	= strip_tags(stripslashes($_POST['web-slideshow-limit']));
			$newoptions['basename']= isset($_POST['web-slideshow-basename']);
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('web_slideshow', $options);
		}
		$title = wp_specialchars($options['title']);
		$category = wp_specialchars($options['category']);
		$random = $options['random'] ? 'checked="checked"' : '';
		$keepratio = $options['keepratio'] ? 'checked="checked"' : '';
		$basename = $options['basename'] ? 'checked="checked"' : '';
		if (wp_specialchars($options['limit']=='')) $limit = '10'; else $limit = wp_specialchars($options['limit']);
		if (wp_specialchars($options['width']=='')) $width = '240'; else $width = wp_specialchars($options['width']);
		if (wp_specialchars($options['height']=='')) $height = '200'; else $height = wp_specialchars($options['height']);
		$showpost = $options['showpost'] ? 'checked="checked"' : '';
		$showlink = $options['showlink'] ? 'checked="checked"' : '';
		$LBeffect = $options['LBeffect'] ? 'checked="checked"' : '';
		
		?>
		<p><label for="web-slideshow-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-slideshow-title" name="web-slideshow-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-keepratio"><?php _e('Keep ratio', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $keepratio; ?> id="web-slideshow-keepratio" name="web-slideshow-keepratio" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-category" style="text-align:right;"><?php _e('Category filter', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $category; ?>" id="web-slideshow-category" name="web-slideshow-category" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-width" style="text-align:right;"><?php _e('Width', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-slideshow-width" name="web-slideshow-width" value="<?php echo $width; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-height" style="text-align:right;"><?php _e('Height', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-slideshow-height" name="web-slideshow-height" value="<?php echo $height; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-limit" style="text-align:right;"><?php _e('Number of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-slideshow-limit" name="web-slideshow-limit" value="<?php echo $limit; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-slideshow-showpost"><?php _e('Link to post', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showpost; ?> id="web-slideshow-showpost" name="web-slideshow-showpost" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-showlink" style="text-align:right;"><?php _e('Link to url', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showlink; ?> id="web-slideshow-showlink" name="web-slideshow-showlink" /></label></p>
		<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-slideshow-LBeffect"><?php _e('HS effect', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $LBeffect; ?> id="web-slideshow-LBeffect" name="web-slideshow-LBeffect" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-random"><?php _e('Randomize images?', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $random; ?> id="web-slideshow-random" name="web-slideshow-random" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-slideshow-basename"><?php _e('Force name to unique', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $basename; ?> id="web-slideshow-basename" name="web-slideshow-basename" /></label></p>
		<input type="hidden" id="web-slideshow-submit" name="web-slideshow-submit" value="1" />
		<?php
		
	}

	register_widget_control ( 'pt-slideshow', 'web_slideshow_control', 300, 400);
	register_sidebar_widget ( 'pt-slideshow', 'web_slideshow', 'wid-slideshow' );

}
/*********************************************************************************/
/* Get recent posts widget
/*********************************************************************************/
function web_recent($args) {

	extract($args);
	$options = get_option('web_recent');
	$k 	= $options['keepratio'] ? '1' : '0';
	$w 	= $options['width'];
	$h 	= $options['height'];
	$lb 	= $options['LBeffect'] ? '1' : '0';
	$l 	= $options['limit'];
	$o 	= $options['offset'];
	if ($options['showpost']) $link ='p';
	if ($options['showlink']) $link ='u';
	if ($options['showtitle'] =='') $st=''; else $st = '&showtitle='.$options['showtitle'];
	$tt 	= $options['thetitle'];
	$c 	= $options['category'];
	if ($options['html'] =='') $html='li'; else $html = $options['html'];
	if ($options['class'] =='') $class=''; else $class = ' class="'.$options['class'].'"';
	$title 	= empty($options['title']) ? __('Recent Posts', 'post-thumb') : $options['title'];
	?>
	<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title; ?>
		<ul>
			<?php the_recent_thumbs('altappend=recent&category='.$c.'&width='.$w.'&height='.$h.'&keepratio='.$k.'&limit='.$l.'&LB_effect='.$lb.'&link='.$link.$st.'&offset='.$o.'&title='.$tt, '<li>', '</li>', '', '');	?>
		</ul>
	<?php echo $after_widget; ?>
	<?php echo '<'.$html.$class.'></'.$html.'>'; ?>
        <?php
}
/*********************************************************************************/
/* Get recent posts widget control
/*********************************************************************************/
function web_recent_control() {

	$options = $newoptions = get_option('web_recent');
	if ( $_POST['web-recent-submit'] ) 
        {
		$newoptions['width'] 	= strip_tags(stripslashes($_POST['web-recent-width']));
		$newoptions['height'] 	= strip_tags(stripslashes($_POST['web-recent-height']));
		$newoptions['keepratio']= isset($_POST['web-recent-keepratio']);
		$newoptions['limit']	= strip_tags(stripslashes($_POST['web-recent-limit']));
		$newoptions['offset'] 	= strip_tags(stripslashes($_POST['web-recent-offset']));
		$newoptions['category'] = strip_tags(stripslashes($_POST['web-recent-category']));
		$newoptions['showtitle']= strip_tags(stripslashes($_POST['web-recent-showtitle']));
		$newoptions['thetitle'] = strip_tags(stripslashes($_POST['web-recent-thetitle']));
		$newoptions['media'] 	= isset($_POST['web-recent-media']);
		$newoptions['showpost'] = isset($_POST['web-recent-showpost']);
		$newoptions['showlink'] = isset($_POST['web-recent-showlink']);
		$newoptions['LBeffect'] = isset($_POST['web-recent-LBeffect']);
		$newoptions['class'] 	= strip_tags(stripslashes($_POST['web-recent-class']));
		$newoptions['html'] 	= strip_tags(stripslashes($_POST['web-recent-html']));
		$newoptions['title'] 	= strip_tags(stripslashes($_POST['web-recent-title']));
	}
	
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('web_recent', $options);
	}

	if (wp_specialchars($options['width'])=='') $width = '60'; else $width = wp_specialchars($options['width']);
	if (wp_specialchars($options['height'])=='') $height = '60'; else $height = wp_specialchars($options['height']);
	if (wp_specialchars($options['html']) =='') $html='li'; else $html = $options['html'];
	$class = wp_specialchars($options['class']);
	$title = wp_specialchars($options['title']);
	$keepratio = $options['keepratio'] ? 'checked="checked"' : '';
	if (wp_specialchars($options['limit']=='')) $limit = '10'; else $limit = wp_specialchars($options['limit']);
	if (wp_specialchars($options['offset']=='')) $offset = '0'; else $offset = wp_specialchars($options['offset']);
	$category = wp_specialchars($options['category']);
	$showtitle = wp_specialchars($options['showtitle']);
	$thetitle = wp_specialchars($options['thetitle']);
	$media = $options['media'] ? 'checked="checked"' : '';
	$showpost = $options['showpost'] ? 'checked="checked"' : '';
	$showlink = $options['showlink'] ? 'checked="checked"' : '';
	$LBeffect = $options['LBeffect'] ? 'checked="checked"' : '';
?>
	<p><label for="web-recent-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-recent-title" name="web-recent-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-keepratio"><?php _e('Keep ratio', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $keepratio; ?> id="web-recent-keepratio" name="web-recent-keepratio" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-width" style="text-align:right;"><?php _e('Width', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-width" name="web-recent-width" value="<?php echo $width; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-height" style="text-align:right;"><?php _e('Height', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-height" name="web-recent-height" value="<?php echo $height; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-limit" style="text-align:right;"><?php _e('Number of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-limit" name="web-recent-limit" value="<?php echo $limit; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-offset" style="text-align:right;"><?php _e('Offset of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-offset" name="web-recent-offset" value="<?php echo $offset; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-category" style="text-align:right;"><?php _e('Category filter', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $category; ?>" id="web-recent-category" name="web-recent-category" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-showtitle" style="text-align:right;"><?php _e('Show title', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-showtitle" name="web-recent-showtitle" value="<?php echo $showtitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-thetitle" style="text-align:right;"><?php _e('Choose title (T/C/E)', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-thetitle" name="web-recent-thetitle" value="<?php echo $thetitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-recent-showpost"><?php _e('Link to post', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showpost; ?> id="web-recent-showpost" name="web-recent-showpost" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-showlink" style="text-align:right;"><?php _e('Link to url', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showlink; ?> id="web-recent-showlink" name="web-recent-showlink" /></label></p>
	<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-recent-LBeffect"><?php _e('HS effect', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $LBeffect; ?> id="web-recent-LBeffect" name="web-recent-LBeffect" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-html"><?php _e('Closing html:'); ?> <input style="width: 100px;" id="web-recent-html" name="web-recent-html" type="text" value="<?php echo $html; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-class"><?php _e('Closing class:'); ?> <input style="width: 100px;" id="web-recent-class" name="web-recent-class" type="text" value="<?php echo $class; ?>" /></label></p>
	<input type="hidden" id="web-recent-submit" name="web-recent-submit" value="1" />
<?php
}

register_sidebar_widget ( 'pt-recent', 'web_recent', 'wid_recent' );
register_widget_control ( 'pt-recent', 'web_recent_control', 300, 470);


/*********************************************************************************/
/* Get recent posts widget
/*********************************************************************************/
function web_recent_image($args) {

	extract($args);
	$options = get_option('web_recent_image');
	$k 	= $options['keepratio'] ? '1' : '0';
	$w 	= $options['width'];
	$h 	= $options['height'];
	$lb 	= $options['LBeffect'] ? '1' : '0';
	$l 	= $options['limit'];
	$o 	= $options['offset'];
	$sp 	= $options['showpost'];
	if ($options['showtitle'] =='') $st=''; else $st = '&showtitle='.$options['showtitle'];
	$tt 	= $options['thetitle'];
	$c 	= $options['category'];
	if ($options['html'] =='') $html='li'; else $html = $options['html'];
	if ($options['class'] =='') $class=''; else $class = ' class="'.$options['class'].'"';
	$title 	= empty($options['title']) ? __('Recent Images', 'post-thumb') : $options['title'];
	?>
	<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title; ?>
		<ul>
			<?php the_recent_thumbs('media=0&altappend=recent&category='.$c.'&width='.$w.'&height='.$h.'&keepratio='.$k.'&limit='.$l.'&LB_effect='.$lb.'&showpost='.$sp.$st.'&offset='.$o.'&title='.$tt, '<li>', '</li>', '', '');	?>
		</ul>
	<?php echo $after_widget; ?>
	<?php echo '<'.$html.$class.'></'.$html.'>'; ?>
        <?php
}
/*********************************************************************************/
/* Get recent posts widget control
/*********************************************************************************/
function web_recent_image_control() {

	$options = $newoptions = get_option('web_recent_image');
	if ( $_POST['web-recent-submit'] ) 
        {
		$newoptions['width'] 	= strip_tags(stripslashes($_POST['web-recent-image-width']));
		$newoptions['height'] 	= strip_tags(stripslashes($_POST['web-recent-image-height']));
		$newoptions['keepratio']= isset($_POST['web-recent-image-keepratio']);
		$newoptions['limit']	= strip_tags(stripslashes($_POST['web-recent-image-limit']));
		$newoptions['offset'] 	= strip_tags(stripslashes($_POST['web-recent-image-offset']));
		$newoptions['category'] = strip_tags(stripslashes($_POST['web-recent-image-category']));
		$newoptions['showtitle']= strip_tags(stripslashes($_POST['web-recent-image-showtitle']));
		$newoptions['thetitle'] = strip_tags(stripslashes($_POST['web-recent-image-thetitle']));
		$newoptions['media'] 	= isset($_POST['web-recent-image-media']);
		$newoptions['showpost'] = isset($_POST['web-recent-image-showpost']);
		$newoptions['LBeffect'] = isset($_POST['web-recent-image-LBeffect']);
		$newoptions['class'] 	= strip_tags(stripslashes($_POST['web-recent-image-class']));
		$newoptions['html'] 	= strip_tags(stripslashes($_POST['web-recent-image-html']));
		$newoptions['title'] 	= strip_tags(stripslashes($_POST['web-recent-image-title']));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('web_recent_image', $options);
	}

	if (wp_specialchars($options['width']=='')) $width = '60'; else $width = wp_specialchars($options['width']);
	if (wp_specialchars($options['height']=='')) $height = '60'; else $height = wp_specialchars($options['height']);
	if (wp_specialchars($options['html']) =='') $html='li'; else $html = $options['html'];
	$class = wp_specialchars($options['class']);
	$title = wp_specialchars($options['title']);
	$keepratio = $options['keepratio'] ? 'checked="checked"' : '';
	if (wp_specialchars($options['limit']=='')) $limit = '10'; else $limit = wp_specialchars($options['limit']);
	if (wp_specialchars($options['offset']=='')) $offset = '0'; else $offset = wp_specialchars($options['offset']);
	$category = wp_specialchars($options['category']);
	$showtitle = wp_specialchars($options['showtitle']);
	$thetitle = wp_specialchars($options['thetitle']);
	$media = $options['media'] ? 'checked="checked"' : '';
	$showpost = $options['showpost'] ? 'checked="checked"' : '';
	$LBeffect = $options['LBeffect'] ? 'checked="checked"' : '';
?>
	<p><label for="web-recent-image-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-recent-image-title" name="web-recent-image-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-keepratio"><?php _e('Keep ratio', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $keepratio; ?> id="web-recent-image-keepratio" name="web-recent-image-keepratio" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-width" style="text-align:right;"><?php _e('Width', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-image-width" name="web-recent-image-width" value="<?php echo $width; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-height" style="text-align:right;"><?php _e('Height', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-image-height" name="web-recent-image-height" value="<?php echo $height; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-limit" style="text-align:right;"><?php _e('Number of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-image-limit" name="web-recent-image-limit" value="<?php echo $limit; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-offset" style="text-align:right;"><?php _e('Offset of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-image-offset" name="web-recent-image-offset" value="<?php echo $offset; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-category" style="text-align:right;"><?php _e('Category filter', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $category; ?>" id="web-recent-image-category" name="web-recent-image-category" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-showtitle" style="text-align:right;"><?php _e('Show title', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-image-showtitle" name="web-recent-image-showtitle" value="<?php echo $showtitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-thetitle" style="text-align:right;"><?php _e('Choose title (T/C/E)', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-image-thetitle" name="web-recent-image-thetitle" value="<?php echo $thetitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-recent-image-showpost"><?php _e('Link to post', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $showpost; ?> id="web-recent-image-showpost" name="web-recent-image-showpost" /></label></p>
	<p style="text-align:right;margin-right:20px;margin-bottom:20px;"><label for="web-recent-image-LBeffect"><?php _e('HS effect', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $LBeffect; ?> id="web-recent-image-LBeffect" name="web-recent-image-LBeffect" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-html"><?php _e('Closing html:'); ?> <input style="width: 100px;" id="web-recent-image-html" name="web-recent-image-html" type="text" value="<?php echo $html; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-image-class"><?php _e('Closing class:'); ?> <input style="width: 100px;" id="web-recent-image-class" name="web-recent-image-class" type="text" value="<?php echo $class; ?>" /></label></p>
	<input type="hidden" id="web-recent-image-submit" name="web-recent-image-submit" value="1" />
<?php
}
	register_sidebar_widget ( 'pt-recent-image', 'web_recent_image', 'wid_recent_image' );
	register_widget_control ( 'pt-recent-image', 'web_recent_image_control', 300, 420);
	
/*********************************************************************************/
/* Get recent posts widget
/*********************************************************************************/
function web_recent_video($args) {

	extract($args);
	$options = get_option('web_recent_video');
	$k 	= $options['keepratio'] ? '1' : '0';
	$w 	= $options['width'];
	$h 	= $options['height'];
	$l 	= $options['limit'];
	$o 	= $options['offset'];
	if ($options['showtitle'] =='') $st=''; else $st = '&showtitle='.$options['showtitle'];
	$tt 	= $options['thetitle'];
	$c 	= $options['category'];
	if ($options['html'] =='') $html='li'; else $html = $options['html'];
	if ($options['class'] =='') $class=''; else $class = ' class="'.$options['class'].'"';
	$title 	= empty($options['title']) ? __('Recent videos', 'post-thumb') : $options['title'];
	?>
	<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title; ?>
		<ul>
			<?php the_recent_thumbs('altappend=video&media=1'.$m.'&category='.$c.'&width='.$w.'&height='.$h.'&keepratio='.$k.'&limit='.$l.'&LB_effect=1'.$st.'&offset='.$o.'&title='.$tt.'&myclassimg=li_thumb', '<li>', '</li>', '', ''); ?>
		</ul>
	<?php echo $after_widget; ?>
	<?php echo '<'.$html.$class.'></'.$html.'>'; ?>
        <?php
}
/*********************************************************************************/
/* Get recent posts widget control
/*********************************************************************************/
function web_recent_video_control() 
{
	$options = $newoptions = get_option('web_recent_video');
	if ( $_POST['web-recent-video-submit'] ) 
        {
		$newoptions['width'] 	= strip_tags(stripslashes($_POST['web-recent-video-width']));
		$newoptions['height'] 	= strip_tags(stripslashes($_POST['web-recent-video-height']));
		$newoptions['keepratio']= isset($_POST['web-recent-video-keepratio']);
		$newoptions['limit']	= strip_tags(stripslashes($_POST['web-recent-video-limit']));
		$newoptions['offset'] 	= strip_tags(stripslashes($_POST['web-recent-video-offset']));
		$newoptions['category'] = strip_tags(stripslashes($_POST['web-recent-video-category']));
		$newoptions['showtitle']= strip_tags(stripslashes($_POST['web-recent-video-showtitle']));
		$newoptions['thetitle'] = strip_tags(stripslashes($_POST['web-recent-video-thetitle']));
		$newoptions['class'] 	= strip_tags(stripslashes($_POST['web-recent-video-class']));
		$newoptions['html'] 	= strip_tags(stripslashes($_POST['web-recent-video-html']));
		$newoptions['title'] 	= strip_tags(stripslashes($_POST['web-recent-video-title']));
	}
	if ( $options != $newoptions ) 
        {
		$options = $newoptions;
		update_option('web_recent_video', $options);
	}

	if (wp_specialchars($options['width']=='')) $width = '80'; else $width = wp_specialchars($options['width']);
	if (wp_specialchars($options['height']=='')) $height = '60'; else $height = wp_specialchars($options['height']);
	if (wp_specialchars($options['html']) =='') $html='li'; else $html = $options['html'];
	$class = wp_specialchars($options['class']);
	$title = wp_specialchars($options['title']);
	$keepratio = $options['keepratio'] ? 'checked="checked"' : '';
	if (wp_specialchars($options['limit']=='')) $limit = '10'; else $limit = wp_specialchars($options['limit']);
	if (wp_specialchars($options['offset']=='')) $offset = '0'; else $offset = wp_specialchars($options['offset']);
	$category = wp_specialchars($options['category']);
	$showtitle = wp_specialchars($options['showtitle']);
	$thetitle = wp_specialchars($options['thetitle']);
	$media = $options['media'] ? 'checked="checked"' : '';
	$showpost = $options['showpost'] ? 'checked="checked"' : '';
	$LBeffect = $options['LBeffect'] ? 'checked="checked"' : '';

?>
	<p><label for="web-recent-video-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-recent-video-title" name="web-recent-video-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-keepratio"><?php _e('Keep ratio', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $keepratio; ?> id="web-recent-video-keepratio" name="web-recent-video-keepratio" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-width" style="text-align:right;"><?php _e('Width', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-video-width" name="web-recent-video-width" value="<?php echo $width; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-height" style="text-align:right;"><?php _e('Height', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-video-height" name="web-recent-video-height" value="<?php echo $height; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-limit" style="text-align:right;"><?php _e('Number of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-video-limit" name="web-recent-video-limit" value="<?php echo $limit; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-offset" style="text-align:right;"><?php _e('Offset of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-video-offset" name="web-recent-video-offset" value="<?php echo $offset; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-category" style="text-align:right;"><?php _e('Category filter', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $category; ?>" id="web-recent-video-category" name="web-recent-video-category" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-showtitle" style="text-align:right;"><?php _e('Show title', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-video-showtitle" name="web-recent-video-showtitle" value="<?php echo $showtitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-thetitle" style="text-align:right;"><?php _e('Choose title (T/C/E)', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-video-thetitle" name="web-recent-video-thetitle" value="<?php echo $thetitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-html"><?php _e('Closing html:'); ?> <input style="width: 100px;" id="web-recent-video-html" name="web-recent-video-html" type="text" value="<?php echo $html; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-video-class"><?php _e('Closing class:'); ?> <input style="width: 100px;" id="web-recent-video-class" name="web-recent-video-class" type="text" value="<?php echo $class; ?>" /></label></p>
	<input type="hidden" id="web-recent-video-submit" name="web-recent-video-submit" value="1" />
<?php

}

register_sidebar_widget ( 'pt-recent-video', 'web_recent_video', 'wid_recent_video' );
register_widget_control ( 'pt-recent-video', 	'web_recent_video_control', 	300, 360);

/*********************************************************************************/
/* Get recent posts widget
/*********************************************************************************/
function web_recent_youtube($args) {
	
	extract($args);
	$options = get_option('web_recent_youtube');
	$k 	= $options['keepratio'] ? '1' : '0';
	$w 	= $options['width'];
	$h 	= $options['height'];
	$l 	= $options['limit'];
	$o 	= $options['offset'];
	if ($options['showtitle'] =='') $st=''; else $st = '&showtitle='.$options['showtitle'];
	$tt 	= $options['thetitle'];
	$c 	= $options['category'];
	if ($options['html'] =='') $html='li'; else $html = $options['html'];
	if ($options['class'] =='') $class=''; else $class = ' class="'.$options['class'].'"';
	$title 	= empty($options['title']) ? __('Recent youtube', 'post-thumb') : $options['title'];
	?>
	<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title; ?>
		<ul>
			<?php the_recent_thumbs('altappend=video&media=2'.$m.'&category='.$c.'&width='.$w.'&height='.$h.'&keepratio='.$k.'&limit='.$l.'&LB_effect=1'.$st.'&offset='.$o.'&title='.$tt.'&myclassimg=li_thumb', '<li>', '</li>', '', '');	?>
		</ul>
	<?php echo $after_widget; ?>
	<?php echo '<'.$html.$class.'></'.$html.'>'; ?>
	<?php
}
/*********************************************************************************/
/* Get recent posts widget control
/*********************************************************************************/
function web_recent_youtube_control() {

	$options = $newoptions = get_option('web_recent_youtube');
	if ( $_POST['web-recent-youtube-submit'] )
        {
		$newoptions['width'] 	= strip_tags(stripslashes($_POST['web-recent-youtube-width']));
		$newoptions['height'] 	= strip_tags(stripslashes($_POST['web-recent-youtube-height']));
		$newoptions['keepratio']= isset($_POST['web-recent-youtube-keepratio']);
		$newoptions['limit']	= strip_tags(stripslashes($_POST['web-recent-youtube-limit']));
		$newoptions['offset'] 	= strip_tags(stripslashes($_POST['web-recent-youtube-offset']));
		$newoptions['category'] = strip_tags(stripslashes($_POST['web-recent-youtube-category']));
		$newoptions['showtitle']= strip_tags(stripslashes($_POST['web-recent-youtube-showtitle']));
		$newoptions['thetitle'] = strip_tags(stripslashes($_POST['web-recent-youtube-thetitle']));
		$newoptions['class'] 	= strip_tags(stripslashes($_POST['web-recent-youtube-class']));
		$newoptions['html'] 	= strip_tags(stripslashes($_POST['web-recent-youtube-html']));
		$newoptions['title'] 	= strip_tags(stripslashes($_POST['web-recent-youtube-title']));
	}
	if ( $options != $newoptions ) 
        {
		$options = $newoptions;
		update_option('web_recent_youtube', $options);
	}

	if (wp_specialchars($options['width']=='')) $width = '80'; else $width = wp_specialchars($options['width']);
	if (wp_specialchars($options['height']=='')) $height = '60'; else $height = wp_specialchars($options['height']);
	if (wp_specialchars($options['html']) =='') $html='li'; else $html = $options['html'];
	$class = wp_specialchars($options['class']);
	$title = wp_specialchars($options['title']);
	$keepratio = $options['keepratio'] ? 'checked="checked"' : '';
	if (wp_specialchars($options['limit']=='')) $limit = '10'; else $limit = wp_specialchars($options['limit']);
	if (wp_specialchars($options['offset']=='')) $offset = '0'; else $offset = wp_specialchars($options['offset']);
	$category = wp_specialchars($options['category']);
	$showtitle = wp_specialchars($options['showtitle']);
	$thetitle = wp_specialchars($options['thetitle']);
	$media = $options['media'] ? 'checked="checked"' : '';
	$showpost = $options['showpost'] ? 'checked="checked"' : '';
	$LBeffect = $options['LBeffect'] ? 'checked="checked"' : '';

	?>
	<p><label for="web-recent-youtube-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-recent-youtube-title" name="web-recent-youtube-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-keepratio"><?php _e('Keep ratio', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $keepratio; ?> id="web-recent-youtube-keepratio" name="web-recent-youtube-keepratio" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-width" style="text-align:right;"><?php _e('Width', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-youtube-width" name="web-recent-youtube-width" value="<?php echo $width; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-height" style="text-align:right;"><?php _e('Height', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-youtube-height" name="web-recent-youtube-height" value="<?php echo $height; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-limit" style="text-align:right;"><?php _e('Number of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-youtube-limit" name="web-recent-youtube-limit" value="<?php echo $limit; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-offset" style="text-align:right;"><?php _e('Offset of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-youtube-offset" name="web-recent-youtube-offset" value="<?php echo $offset; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-category" style="text-align:right;"><?php _e('Category filter', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $category; ?>" id="web-recent-youtube-category" name="web-recent-youtube-category" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-showtitle" style="text-align:right;"><?php _e('Show title', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-youtube-showtitle" name="web-recent-youtube-showtitle" value="<?php echo $showtitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-thetitle" style="text-align:right;"><?php _e('Choose title (T/C/E)', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-recent-youtube-thetitle" name="web-recent-youtube-thetitle" value="<?php echo $thetitle; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-html"><?php _e('Closing html:'); ?> <input style="width: 100px;" id="web-recent-youtube-html" name="web-recent-youtube-html" type="text" value="<?php echo $html; ?>" /></label></p>
	<p style="text-align:right;margin-right:20px;"><label for="web-recent-youtube-class"><?php _e('Closing class:'); ?> <input style="width: 100px;" id="web-recent-youtube-class" name="web-recent-youtube-class" type="text" value="<?php echo $class; ?>" /></label></p>
	<input type="hidden" id="web-recent-youtube-submit" name="web-recent-youtube-submit" value="1" />
	<?php

}

register_sidebar_widget ( 'pt-recent-youtube', 'web_recent_youtube', 'wid_recent_youtube' );
register_widget_control ( 'pt-recent-youtube', 	'web_recent_youtube_control', 	300, 360);

/*********************************************************************************/
/* pt-categories widget
/*********************************************************************************/
if (function_exists('pt_list_categories')) {
	function web_categories($args)
	{
		extract($args);
		$options = get_option('web_categories');
		$c = $options['count'] ? '1' : '0';
		$h = $options['hierarchical'] ? '1' : '0';
		$title = empty($options['title']) ? __('Categories') : $options['title'];

		echo $before_widget;
			echo $before_title . $title . $after_title; ?>
			<ul>
				<?php pt_list_categories("sort_column=name&title_li=&show_count=$c&hierarchical=$h"); ?>
			</ul>
		<?php echo $after_widget;

	}
	/*********************************************************************************/
	/* pt-categories widget control
	/*********************************************************************************/
	function web_categories_control()
	{
		$options = $newoptions = get_option('web_categories');
		if ( $_POST['categories-submit'] )
	        {
			$newoptions['count'] = isset($_POST['categories-count']);
			$newoptions['hierarchical'] = isset($_POST['categories-hierarchical']);
			$newoptions['title'] = strip_tags(stripslashes($_POST['categories-title']));
		}
		if ( $options != $newoptions )
	        {
			$options = $newoptions;
			update_option('web_categories', $options);
		}
		$count = $options['count'] ? 'checked="checked"' : '';
		$hierarchical = $options['hierarchical'] ? 'checked="checked"' : '';
		$title = wp_specialchars($options['title']);
	?>
		<p><label for="categories-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="categories-title" name="categories-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p style="text-align:right;margin-right:40px;"><label for="categories-count"><?php _e('Show post counts', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $count; ?> id="categories-count" name="categories-count" /></label></p>
		<p style="text-align:right;margin-right:40px;"><label for="categories-hierarchical" style="text-align:right;"><?php _e('Show hierarchy', 'post-thumb'); ?> <input class="checkbox" type="checkbox" <?php echo $hierarchical; ?> id="categories-hierarchical" name="categories-hierarchical" /></label></p>
		<input type="hidden" id="categories-submit" name="categories-submit" value="1" />
	<?php
	}

	register_sidebar_widget ( 'pt-categories', 'web_categories', 'wid-categories' );
	register_widget_control ( 'pt-categories', 'web_categories_control', 300, 130);

}
/*********************************************************************************/
/* pt-bookmarks widget
/*********************************************************************************/
if (function_exists('pt_list_bookmarks')) {
	function web_bookmarks($args)
	{
		extract($args);
		$options = get_option('web_bookmarks');
		$b = empty($options['html_title_before']) ? __('<h4>') : $options['html_title_before'];
		$a = empty($options['html_title_after']) ? __('</h4>') : $options['html_title_after'];
		$title = empty($options['title']) ? __('Blogroll') : $options['title'];

		if (is_home()) {
			echo $before_widget;
				echo $before_title . $title . $after_title;
				echo '<ul>';
					pt_list_bookmarks('title_before='.$b.'&title_after='.$a);
				echo '</ul>';
			echo $after_widget;
		}
	}
	/*********************************************************************************/
	/* pt-bookmarks widget control
	/*********************************************************************************/
	function web_bookmarks_control()
	{
		$options = $newoptions = get_option('web_bookmarks');
		if ( $_POST['bookmarks-submit'] )
	        {
			$newoptions['title'] = strip_tags(stripslashes($_POST['bookmarks-title']));
			$newoptions['html_title_before'] = stripslashes($_POST['bookmarks-before']);
			$newoptions['html_title_after'] = stripslashes($_POST['bookmarks-after']);
		}
		if ( $options != $newoptions )
	        {
			$options = $newoptions;
			update_option('web_bookmarks', $options);
		}
		$title = wp_specialchars($options['title']);
		$html_title_before = wp_specialchars($options['html_title_before']);
		$html_title_after = $options['html_title_after'];
	?>
		<p><label for="bookmarks-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="bookmarks-title" name="bookmarks-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="bookmarks-before" style="text-align:right;"><?php _e('html before title', 'post-thumb'); ?> <input style="width: 200px;" id="bookmarks-before" name="bookmarks-before" type="text" value="<?php echo $html_title_before; ?>"  /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="bookmarks-after" style="text-align:right;"><?php _e('html after title', 'post-thumb'); ?> <input style="width: 200px;" id="bookmarks-after" name="bookmarks-after" type="text" value="<?php echo $html_title_after; ?>" /></label></p>
		<input type="hidden" id="bookmarks-submit" name="bookmarks-submit" value="1" />
	<?php
	}

	register_sidebar_widget ( 'pt-bookmarks', 'web_bookmarks', 'wid-latest' );
	register_widget_control ( 'pt-bookmarks', 'web_bookmarks_control', 300, 150);

}
/*********************************************************************************/
/* News from rss feed widget
/*********************************************************************************/
if (function_exists('pt_RSS_Import')) {
	function web_news($args)
	{
		extract($args);
		$options = get_option('web_news');
		$l = $options['limit'];
		$f1 = $options['feed1'];
		$f2 = $options['feed2'];
		$w = $options['words'];
		$title = empty($options['title']) ? __('News', 'post-thumb') : $options['title'];
		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<?php if ($f1 != '') { ?>
				<div class="startseite">
					<div class="jd_news_scroll" id="elm1">
						<ul>
							<?php pt_RSS_Import ($l,$f1,$w);  ?>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if ($f2 != '') { ?>
			<?php } ?>
		<?php echo $after_widget; ?>
	<?php
	}
	/*********************************************************************************/
	/* News from rss feed widget control
	/*********************************************************************************/
	function web_news_control()
	{
		$options = $newoptions = get_option('web_news');
		if ( $_POST['web-news-submit'] )
	        {
			$newoptions['limit'] = 		strip_tags(stripslashes($_POST['web-news-limit']));
			$newoptions['feed1'] = 		strip_tags(stripslashes($_POST['web-news-feed1']));
			$newoptions['feed2'] = 		strip_tags(stripslashes($_POST['web-news-feed2']));
			$newoptions['words'] = 		strip_tags(stripslashes($_POST['web-news-words']));
			$newoptions['title'] = 		strip_tags(stripslashes($_POST['web-news-title']));
		}
		if ( $options != $newoptions )
	        {
			$options = $newoptions;
			update_option('web_news', $options);
		}
		$title = wp_specialchars($options['title']);
		if (wp_specialchars($options['limit']=='')) $limit = '5'; else $limit = wp_specialchars($options['limit']);
		$feed1 = wp_specialchars($options['feed1']);
		$feed2 = wp_specialchars($options['feed2']);
		if (wp_specialchars($options['words']=='')) $words = '40'; else $words = wp_specialchars($options['words']);
	?>
		<p><label for="web-news-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-news-title" name="web-news-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-news-limit" style="text-align:right;"><?php _e('Number of posts', 'post-thumb'); ?> <input style="width: 40px;" type="text" id="web-news-limit" name="web-news-limit" value="<?php echo $limit; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-news-feed1" style="text-align:right;"><?php _e('Feed 1', 'post-thumb'); ?> <input style="width: 280px;" type="text" value="<?php echo $feed1; ?>" id="web-news-feed1" name="web-news-feed1" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-news-feed2" style="text-align:right;"><?php _e('Feed 2', 'post-thumb'); ?> <input style="width: 280px;" type="text" value="<?php echo $feed2; ?>" id="web-news-feed2" name="web-news-feed2" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-news-words" style="text-align:right;"><?php _e('Number of words', 'post-thumb'); ?> <input style="width: 40px;" type="text" value="<?php echo $words; ?>" id="web-news-words" name="web-news-words" /></label></p>
		<input type="hidden" id="web-news-submit" name="web-news-submit" value="1" />
	<?php
	}

	register_sidebar_widget ( 'pt-news', 'web_news', 'wid-news' );
	register_widget_control ( 'pt-news', 'web_news_control', 400, 210);

}
if (class_exists('PostThumbLibrary')) {
	/*********************************************************************************/
	/* Get recent posts widget
	/*********************************************************************************/
	function web_last_youtube($args) {
	
		extract($args);
		$options = get_option('web_last_youtube');
		$author_id 	= $options['id'];
		$title 	= empty($options['title']) ? __('Last youtube', 'post-thumb') : $options['title'];
		$dev_id = '5m2D7hpBwPo';
		$url = 'http://www.youtube.com/api2_rest?method=youtube.videos.list_by_user&dev_id='.$dev_id.'&user='.$author_id.'&page=1&per_page=1';
		$allXML = ParseYoutubeVideos(GetYoutubePage($url));
	
		foreach ($allXML as $XML) :
			$id = $XML['id'];
			$ytitle = $XML['title'];
			$ythumb = $XML['thumbnail_url'];
		endforeach;
	
		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li>
				<?php echo get_Youtube($id, $ytitle, $ythumb);	?>
				</li>
			</ul>
		<?php echo $after_widget; ?>
		<li class="clear"></li>
	        <?php
	}
	/*********************************************************************************/
	/* Get recent posts widget control
	/*********************************************************************************/
	function web_last_youtube_control() {
	
		$options = $newoptions = get_option('web_last_youtube');
		if ( $_POST['web-last-youtube-submit'] ) {
		
			$newoptions['id'] 	= strip_tags(stripslashes($_POST['web-last-youtube-id']));
			$newoptions['title'] 	= strip_tags(stripslashes($_POST['web-last-youtube-title']));
		}
		if ( $options != $newoptions ) {
		
			$options = $newoptions;
			update_option('web_last_youtube', $options);
		}

		$title = wp_specialchars($options['title']);
		$id = wp_specialchars($options['id']);

	?>
		<p><label for="web-last-youtube-title"><?php _e('Title:'); ?> <input style="width: 240px;" id="web-last-youtube-title" name="web-last-youtube-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p style="text-align:right;margin-right:20px;"><label for="web-last-youtube-id" style="text-align:right;"><?php _e('User id', 'post-thumb'); ?> <input style="width: 250px;" type="text" id="web-last-youtube-id" name="web-last-youtube-id" value="<?php echo $id; ?>" /></label></p>
		<input type="hidden" id="web-last-youtube-submit" name="web-last-youtube-submit" value="1" />
	<?php

	}
	register_sidebar_widget ( 'pt-last-youtube', 'web_last_youtube', 'wid_last_youtube' );
	register_widget_control ( 'pt-last-youtube', 'web_last_youtube_control', 300, 120);
}
/*********************************************************************************/
/* Register widgets and widget controls
/*********************************************************************************/
	register_sidebar_widget ( 'pt-forum', 'web_forum', 'wid_forum' );

}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'post_thumb_widget');

?>
