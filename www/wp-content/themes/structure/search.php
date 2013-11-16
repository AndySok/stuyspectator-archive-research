<?php get_header(); ?>
<div class="post">
<h2 class="section-header"><?php _e('Search Results'); ?></h2>
</div>

<?php if(have_posts()) : 
while(have_posts()) : the_post();
$do_not_duplicate = $post->ID;

// CHECKS TO SEE IF THERE'S AN IMAGE FOR THIS POST
$thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS IMAGE
$image_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>

<div id="post-<?php the_ID(); ?>" class="post main">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="byline">
<span class="time"><?php the_time('F jS, Y') ?></span> | 
<span class="category"><?php the_category(', ') ?></span> | 
<span class="comment"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>
</p>
<div class="entry">

<?php  // IF THERE'S AN IMAGE ASSOCIATED WITH THIS POST
if($thumb !== '') { ?>
	<p><?php // set up image link ?>
	<a href="<?php echo the_permalink(); ?>"
	title="<?php if($image_alt !== '') { echo $image_alt; } else { echo the_title(); } ?>"
	>
	<?php // set up image display, class, alt, and size ?>
	<img src="<?php echo $thumb; ?>" 
	class="left" 
	alt="<?php if($image_alt !== '') { echo $image_alt; } else { echo the_title(); } ?>" 
	/></a>
	</p>
<?php } // end if statement

// IF THERE'S NOT AN IMAGE
else { echo ''; } ?>

<?php the_excerpt();  ?>

<p class="post-meta-data">
	<?php edit_post_link('Edit', '<span class="edit">', ' &#124;</span> '); ?>
	<span class="more"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story &raquo;</a></span>
</p>
</div><!-- entry -->
</div><!-- post -->
<?php endwhile; ?>

<div class="navigation">
<?php posts_nav_link(" | ","<span>&laquo; Previous</span>","<span>Next &raquo;</span>"); ?>
</div>

<?php else : ?>
<div class="post">
<h2><?php _e('Not Found'); ?></h2>
<div class="entry">
<p><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></p>
</div>
</div>

<?php endif; ?>

<?php get_footer(); ?>