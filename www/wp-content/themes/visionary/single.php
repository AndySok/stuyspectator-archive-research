<?php get_header(); ?>
<?php
if(have_posts()) : 
while(have_posts()) : the_post(); 

// CHECKS TO SEE IF THERE'S AN ARTICLE IMAGE FOR THIS POST
$image = get_post_meta($post->ID, 'Article Image', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS THUMBNAIL
$image_alt = get_post_meta($post->ID, 'Article Image Alt', $single = true);

if($image == '') {
// CHECKS TO SEE IF THERE'S AN THUMBNAIL FOR THIS POST
$image = get_post_meta($post->ID, 'Thumbnail', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS POST
$image_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
	}

elseif ($image == '') {
// CHECKS TO SEE IF THERE'S AN FEATURE IMAGE FOR THIS POST
$image = get_post_meta($post->ID, 'Article Image', $single = true);
// CHECKS TO SEE IF THERE'S A SET  FEATURE IMAGE ALT TEXT FOR THIS POST
$image_alt = get_post_meta($post->ID, 'Article Image Alt', $single = true);
	}

// Checks to see if there's a video (YouTube, Google Video, etc.) associated with this post
$video = get_post_meta($post->ID, 'Video', $single=true);
// Checks to see if there's a FLV Player (http://www.mac-dev.net/blog/) associated with this post
// For future versions of the theme.  Even though it's currently supported through the use of the Optional Excerpt, don't put anything in a Value for the Key of "FLV Video" or it will mess up your layout!!!
$flash_video = get_post_meta($post->ID, 'FLV Video', $single=true);
?>

<div id="post-<?php the_ID(); ?>" class="post">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="byline">
<span class="author"><?php the_author_posts_link() ?></span>
<span class="time"><?php the_time('F jS, Y') ?></span>
<span class="category"><?php the_category(', ') ?></span>
<?php edit_post_link('Edit', '<span class="edit">', '</span> '); ?>
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

// IF THERE'S AN IMAGE ASSOCIATED WITH THIS POST
elseif($image !== '') { ?>
	<p>
	<img src="<?php echo $image; ?>" 
	alt="<?php if($image_alt !== '') { echo $image_alt; } else { echo the_title(); } ?>"
	class="left thumbnail" />
	</p>
<?php } // end elseif 

// IF THERE'S NOT AN IMAGE
else { echo ''; } ?>

<?php the_content(); ?>

<p class="post-meta-data">
	<span class="category"><?php the_category(', ') ?></span>
	<br />
	<?php if(function_exists('the_tags')) { ?>
	<span class="tags"><?php the_tags('', ', ', ''); ?></span>
</p>
<?php } ?>


</div><!-- entry -->

<?php
	if(function_exists('related_posts')) { ?>
		<div class="related">
		<h3>Related Headlines:</h3>
		<ul>
			<?php related_posts(); ?>
		</ul>
		</div>
		<?php } ?>

<?php endwhile; ?>
</div><!-- post -->

<div id="comments-template">
<?php comments_template(); ?>
</div>

<div class="navigation">
<span class="previous"><?php previous_post_link('&laquo; %link'); ?></span>
<span class="next"><?php next_post_link(' %link &raquo;'); ?></span>
</div>
<?php endif; ?>
<?php get_footer(); ?>