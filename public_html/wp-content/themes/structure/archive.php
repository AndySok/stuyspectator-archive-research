<?php get_header(); ?>
<div class="post">
<?php if (is_archive()) { $posts = query_posts($query_string . '&orderby=date&showposts=1'); } ?>
<?php if(have_posts()) : ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="section-header">Archive for <?php the_time('F jS, Y'); ?></h2>
	<div class="entry"><p>You are browsing the archives of <strong><?php wp_title(''); ?></strong>.</p></div>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="section-header">Archive for <?php the_time('F Y'); ?></h2>
	<div class="section-header"><p>You are browsing the archives of <strong><?php wp_title(''); ?></strong>.</p></div>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="section-header">Archive for <?php the_time('Y'); ?></h2>
	<div class="entry"><p>You are browsing the archives of <strong><?php wp_title(''); ?></strong>.</p></div>
<?php /* If this is a search */ } elseif (is_search()) { ?>
<h2 class="section-header">Search Results</h2>
	<div class="entry"><p>You are browsing the search results for <strong><?php wp_title(''); ?></strong>.</p></div>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="section-header">Author Archive</h2>
	<div class="entry"><p>You are browsing the archives of <strong><?php wp_title(''); ?></strong>.</p></div>
<?php /* If this is an author archive */ } elseif (is_tag()) { ?>
<h2 class="section-header">Tag Archive: <?php wp_title(''); ?></h2>
	<div class="entry"><p>You are browsing the tag archive for <strong><?php wp_title(''); ?></strong>.</p></div>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="section-header">Blog Archives</h2>
<?php } ?>
</div>

<?php 
while(have_posts()) : the_post();
$do_not_duplicate = $post->ID;


// CHECKS TO SEE IF THERE'S AN IMAGE FOR THIS POST
$image= get_post_meta($post->ID, 'Thumbnail', $single = true);
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

<?php the_excerpt(); ?>
<p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story &raquo;</a></p>
</div><!-- entry -->
</div>
<?php endwhile; ?>

<?php else : ?>
<p><strong>Not Found</strong></p>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php endif; ?>

<?php if (is_archive()) { $posts = query_posts($query_string . '&orderby=date&offset=1&showposts=-1'); } ?> 
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