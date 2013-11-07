<?php get_header();
if(have_posts()) : 
while(have_posts()) : the_post();

// Checks to see if there's an image
	$image = get_post_meta($post->ID, 'Image', $single = true);
// Checks for image alt text
	$image_alt = get_post_meta($post->ID, 'Image Alt', $single = true);
// Checks for image class
	$image_class = get_post_meta($post->ID, 'Image Class', $single = true);

if($image == '') { // If there's no "Image"
	$thumb = 'false';
	$feature = 'true';
// Checks for feature image
	$image = get_post_meta($post->ID, 'Feature Image', $single = true);
// Checks for feature image alt text
	$image_alt = get_post_meta($post->ID, 'Feature Image Alt', $single = true);
	}

if($image == '') { // If there's no "Image" or "Feature Image"
	$feature = 'false';
	$thumb = 'true';
// Checks for thumbnail
	$image = get_post_meta($post->ID, 'Thumbnail', $single = true);
// Checks for thumbnail alt text
	$image_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
	}

else { echo ''; }

// Checks to see if there's a video (YouTube, Google Video, etc.) associated with this post
	$video = get_post_meta($post->ID, 'Video', $single=true);
?>

<div id="post-<?php the_ID(); ?>" class="post">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="byline">By 
<span class="author"><?php the_author_posts_link() ?></span> on 
<span class="time"><?php the_time('F jS, Y') ?></span>
<?php edit_post_link('Edit', ' | ', ' '); ?>
</p>
<div class="entry">

<?php  
// If there's an imported video associated with this post
if($video !== '') { ?>
<p class="left">
<object type="application/x-shockwave-flash" data="<?php echo $video; ?>" class="left" style="align: left; width: 275px; height: 230px; border: none; padding: 0; margin: 0;" id="video<?php echo $i; ?>">
	<param name="movie" value="<?php echo $video; ?>" />
	<param name='wmode' value='transparent' />
	<param name="quality" value="best" />
	<param name="bgcolor" value="#FFFFFF" />
	<param name="FlashVars" value="playerMode=embedded" />
</object>
</p>
	<?php } // endif

// If there's any kind of image for this post
elseif($image !== '') { ?>
	<p>
	<img src="<?php echo $image; ?>" 
	alt="<?php if($image_alt !== '') { echo $image_alt; } else { echo the_title(); } ?>"
	class="<?php if($image_class !== '') { echo $image_class; } else { echo 'left'; }
		if($feature == 'true') { echo ' feature'; } elseif($thumb == 'true') { echo ' thumbnail'; } ?>" />
	</p>
<?php } // end elseif 

// If there's no image
else { echo ''; }

the_content(); ?>

<?php wp_link_pages('before=<p><strong>Pages:</strong>&after=</p>'); ?>

<p class="post-meta-data">
	<strong>Categories:</strong> <span class="category"><?php the_category(', ') ?></span>
	<br />
	<?php if(function_exists('the_tags')) { ?>
	<strong>Tags:</strong> <span class="tags"><?php the_tags('', ', ', ''); ?></span>
<?php } ?>
</p>

</div><!-- entry -->
<?php endwhile; ?>
</div><!-- post -->

<?php
	if(function_exists('related_posts')) { ?>
		<div class="related">
		<h3>Related Headlines</h3>
		<ul><?php related_posts(); ?></ul>
		</div>
	<?php } ?>

<div id="comments-template">
<?php comments_template(); ?>
</div>

<div class="navigation">
<span class="previous"><?php previous_post_link('&laquo; %link'); ?></span>
<span class="next"><?php next_post_link(' %link &raquo;'); ?></span>
</div>
<?php endif; get_footer(); ?>