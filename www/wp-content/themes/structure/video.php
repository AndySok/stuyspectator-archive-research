<div class="video">
<div>
<?php
// This file displays the latest video article on the front page
	rewind_posts();
// Query one post from "video" category
	$my_query = new WP_Query('category_name=video&showposts=1');
	while ($my_query->have_posts()) : $my_query->the_post();

	// If you don't want to duplicate this post in other post lists, then uncomment the next line
		// $do_not_duplicate = $post->ID; 
	// Get the "Video" custom field Key as an array (displays single Value in the video block)
		$video = get_post_custom_values($key = 'Video');
	// The next line is old code, but left for future reference (had to be changed to work with widgets)
		// get_post_meta($post->ID, 'Video', $single=true); 
	?>

	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<div class="v<?php echo $i; ?> video">
	<?php 
	// Check to see if custom field "Video" is set and if it has anything in the "Value" field.
		if(isset($video[0]) && strcmp($video[0],'')!= 0)  {
	// Display valid XHTML player for YouTube, Google, MetaCafe, and other video sites
	// "echo $video[0];" displays the first item in the array for the custom field "Video"
	?>
	<object type="application/x-shockwave-flash" data="<?php echo $video[0]; ?>" style="width: 290px; height: 242px; border: none; padding: 0; margin: 0;" id="video-block-<?php echo $i; ?>">
		<param name="movie" value="<?php echo $video[0]; ?>" />
		<param name='wmode' value='transparent' />
		<param name="quality" value="best" />
		<param name="bgcolor" value="transparent" />
		<param name="FlashVars" value="playerMode=embedded" />
	</object>
	<?php 
		} // endif
	// If there is no Value for the custom field Key "Video"
	else {
	// echo error checking, which makes it easier for me to help users that don't know what they're doing
		echo 'Did not add a video URL to the custom field <strong> Key</strong> of "Video"';
		echo '<!-- This is a support question check. -->';
		echo '<!-- This user did not add the video URL to the correct custom field -->'; 
		} // endelse
	?>
	</div> <!-- video -->
	<?php endwhile; ?>
</div>
</div><!-- video -->