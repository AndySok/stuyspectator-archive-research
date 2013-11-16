<?php get_header(); ?>
<div class="post">
<h2 class="section-header"><?php single_cat_title(); ?></h2>
<?php if (is_category()) { $posts = query_posts($query_string . '&orderby=date&showposts=1'); } ?> 
<?php if(have_posts()) : ?>
<div class="entry">
<?php echo category_description(); ?>
</div></div>
<?php 
while(have_posts()) : the_post();
$do_not_duplicate = $post->ID;

// CHECKS TO SEE IF THERE'S AN IMAGE FOR THIS POST
$image = get_post_meta($post->ID, 'Thumbnail', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS IMAGE
$image_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>

<div id="post-<?php the_ID(); ?>" class="post main">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="byline">
<span class="time"><?php the_time('F jS, Y') ?></span>
<span class="category"><?php the_category(', ') ?></span>
<span class="comment"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>
</p>
<div class="entry">

<?php  // IF THERE'S AN IMAGE ASSOCIATED WITH THIS POST
if($image !== '') { ?>
	<p><?php // set up image link ?>
	<a href="<?php echo the_permalink(); ?>"
	title="<?php if($image_alt !== '') { echo $image_alt; } else { echo the_title(); } ?>"
	>
	<?php // set up image display, class, alt, and size ?>
	<img src="<?php echo $image; ?>" 
	class="left thumbnail" 
	alt="<?php if($image_alt !== '') { echo $image_alt; } else { echo the_title(); } ?>" 
	/></a>
	</p>
<?php } // end if statement

// IF THERE'S NOT AN IMAGE
else { echo ''; } ?>

<?php the_excerpt();  ?>

<p class="post-meta-data">
	<?php edit_post_link('Edit', '<span class="edit">', ' &#124;</span> '); ?>
	<span class="more"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story</a></span>
</p>
</div><!-- entry -->
</div><!-- post -->
<?php endwhile; ?>

<?php else : ?>
<p><strong>Not Found</strong></p>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php endif; ?>

<?php if (is_category()) { $posts = query_posts($query_string . '&orderby=date&offset=1&showposts=-1'); } ?> 
<?php if(have_posts()) : ?>
<div class="post">
<h2 class="post-title"><?php _e('Previous Stories'); ?></h2>
<div class="entry">
<ul>
<?php while(have_posts()) : the_post();
if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul></div></div>
<?php else: 
endif; ?>
<?php get_footer(); ?>