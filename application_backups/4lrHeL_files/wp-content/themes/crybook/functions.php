<?php

// Theme Name: CryBook
// Edit this file on your own risk!

add_action('admin_menu', 'crybook_options'); // Theme Menu "Brightness Settings"
add_action('wp_head', 'crybook_feed');

function crybook_feed() {
	$last_update = intval(get_option('crybook_feed_lastupdate'));
	$enable = get_option('crybook_feed_enable');
	$now = time();
	if($enable === 'yes' and ($now - $last_update) > (60*60*24)) :
		//get cool feedburner count
		$feed = get_option('crybook_feed_uri');
		$whaturl="http://api.feedburner.com/awareness/1.0/GetFeedData?uri=$feed";
		
		//Initialize the Curl session
		$ch = curl_init();
		
		//Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//Set the URL
		curl_setopt($ch, CURLOPT_URL, $whaturl);
		//Execute the fetch
		$data = curl_exec($ch);
		//Close the connection
		curl_close($ch);
	
		$xml = new SimpleXMLElement($data);
		$fb = $xml->feed->entry['circulation'];
		if(!$fb) :
			$fb = 0;
		endif;
		$id = $xml->feed['id'];
		
		update_option("crybook_feed_count", "<strong>" .$fb." reader".($fb > 1 ? "s</strong>" : ""));
		update_option('crybook_feed_id', $id."");
		//end get cool feedburner count
		
		update_option("crybook_feed_lastupdate", $now."");
	endif;
}

function crybook() {
	
	if(isset($_POST['submitted']) and $_POST['submitted'] == 'yes') :
		update_option("crybook_feed_uri", stripslashes($_POST['feed_uri']));
		update_option("crybook_aside_cat", stripslashes($_POST['aside_cat']));
		update_option("crybook_about_site", stripslashes($_POST['about_site']));
		
		if(isset($_POST['feed_update']) and $_POST['feed_update'] == 'yes') :
			update_option("crybook_feed_lastupdate", "0");
		endif;
		
		if(isset($_POST['feed_enable']) and $_POST['feed_enable'] == 'yes') :
			update_option("crybook_feed_enable", "yes");
		else :
			update_option("crybook_feed_enable", "no");
		endif;
		
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
	endif; 
	
	$data = array(
		'feed' => array(
			'uri' => get_option('crybook_feed_uri'),
			'id' => get_option('crybook_feed_id'),
			'enable' => get_option('crybook_feed_enable')
		),
		'aside' => get_option('crybook_aside_cat'),
		'about' => get_option('crybook_about_site')
	);
?>
<!-- Our Community Settings Update Form -->
<div class="wrap">	
	<form method="post" name="update_form" target="_self">	
    	<h2>CryBook Settings</h2>
        <h3>Site About</h3>
		<p>Display at the upper sidebar of your site</p>
		<table class="form-table my">
			<tr>
				<th>
					Description:
				</th>
				<td>
					<textarea name="about_site" rows="10" style="width:95%"><?php echo $data['about']; ?></textarea>
				</td>
			</tr>
		</table>
        <h3>Feedburner</h3>
		<p>Key in your Feedburner data</p>
		<table class="form-table my">
			<tr>
				<th>
					FeedURI:
				</th>
				<td>
					http://feeds.feedburner.com/<input type="text" name="feed_uri" value="<?php echo $data['feed']['uri']; ?>" size="35" />
                    <br />Check to enable feed count (text) <input type="checkbox" name="feed_enable" <?php echo ($data['feed']['enable'] == 'yes' ? 'checked="checked"' : ''); ?> value="yes" /> 
				</td>
			</tr>
            <tr>
				<th>
					FeedID:
				</th>
				<td>
					http://www.feedburner.com/fb/a/emailverifySubmit?feedId=<strong><?php echo $data['feed']['id']; ?></strong>&amp;loc=en_US<br />Use to allow visitor to subscribe feed using e-mail.
				</td>
			</tr>
            <tr>
				<th>
					Flush Reader Count:
				</th>
				<td>
					Last update: <strong><?php echo date('Y-m-d H:i:s', get_option('crybook_feed_lastupdate')); ?></strong><br /><input type="checkbox" name="feed_update" value="yes" /> Check to reset reader count.
				</td>
			</tr>
		</table>
        <p class="submit">
			<input name="submitted" type="hidden" value="yes" />
			<input type="submit" name="Submit" value="Update &raquo;" />
		</p>
	</form>
     	<h3>Themetation</h3>
		<p>thank you for using our WordPress Themes. If you need any support, feel free to post it up in our <a href="http://themetation.com/forum">fourm</a> you can get some wordpress tips at <a href="http://themetation.com">themetation.com</a>.</p>
</div>
<?php
}

function crybook_options() { // Adds Dashboard Menu Item
	add_menu_page('CryBook Settings', 'CryBook Settings', 'edit_themes', __FILE__, 'crybook');
}

if(function_exists('register_sidebar')) :
    register_sidebar(array(
        'name' => 'sidebar-left',
		'before_widget' => '<div class="box">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	register_sidebar(array(
        'name' => 'sidebar-right',
		'before_widget' => '<div class="box">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
endif;

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
     <div id="div-comment-<?php comment_ID(); ?>" class="c">
      <div class="comment-author vcard">
         <?php echo get_avatar( $comment, 60 ); ?>
         <small><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?> <?php edit_comment_link(__('(Edit)'),'  ','') ?></small><br />
         <?php printf(__('<em>%s</em>'), get_comment_author_link()) ?>
      </div>
     
      <div class="comment-meta commentmetadata">
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>      
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
	
      <?php comment_text() ?>


      </div>
     </div>
     <div class="clear"></div>
<?php
        }

?>