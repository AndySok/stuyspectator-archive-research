<?php get_header();

// EXCLUDE VIDEO POSTS BY CHANGING THE NUMBER, BUT NOT THE "-" SIGN FROM YOUR HOME PAGE
// YOU ONLY WANT THEM IN YOUR SIDEBAR
query_posts("cat=-157");

// GETS THE LATEST FEATURE ARTICLE FIRST
$my_query = new WP_Query('category_name=features&showposts=1');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;

// CHECKS TO SEE IF THERE'S AN IMAGE FOR THIS POST
$feature_image = get_post_meta($post->ID, 'Feature Image', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS IMAGE
$feature_alt = get_post_meta($post->ID, 'Feature Image Alt', $single = true);
?>

<h2 class="section-header">Featured News &raquo;</h2>

<div id="post-<?php the_ID(); ?>" class="post feature">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="byline">
<span class="author"><?php the_author_posts_link(); ?></span>  
<span class="category"><?php the_category(', ') ?></span>
<span class="time"><?php the_time('F jS, Y') ?></span> 
<?php edit_post_link('Edit', '<span class="edit">', '</span>'); ?></p>
<div class="entry">

<?php  // IF THERE'S AN IMAGE ASSOCIATED WITH THIS POST
if($feature_image !== '') { ?>
	<p><?php // set up image link ?>
	<a href="<? echo the_permalink(); ?>"
	title="<?php if($feature_alt !== '') { echo $feature_alt; } else { echo the_title(); } ?>"
	>
	<?php // set up image display, class, alt, and size ?>
	<img src="<?php echo $feature_image; ?>" 
	alt="<?php if($feature_alt !== '') { echo $feature_alt; } else { echo the_title(); } ?>" 
	class="left" /></a>
	</p>
<?php } // end if statement

// IF THERE'S NOT AN IMAGE
else { echo ''; } ?>

<?php the_excerpt();  ?>
<p class="post-meta-data"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story &raquo;</a></p>
</div><!-- entry -->
</div><!-- main -->
<?php endwhile; ?>


<h2 class="section-header">Recent Headlines &raquo;</h2>

<?php 
// THE SECOND LOOP SHOWING THE ARTICLES AFTER THE FEATURE
if (have_posts()) : 
$i = 1;
while (have_posts()) : the_post();
if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);

// CHECKS TO SEE IF THERE'S AN IMAGE FOR THIS POST
$thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS IMAGE
$thumb_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>

<?php // for controlling the layout of the home pages bottom excerpts up to 10 posts
if($i == '1' || $i == '3' || $i == '5' || $i == '7' || $i == '9') { ?>
<div class="secondary">
<?php } // endif ?>

	<div class="<?php if($i % 2 == 0) { echo 'post-right'; } else { echo 'post-left';} ?>">
	<div id="post-<?php the_ID(); ?>" class="post">
	<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	<div class="entry">
	<?php if($thumb !== '') {
		?>
		<p>
		<img src="<?php echo $thumb?>" alt="<?php if($thumb_alt !== '') echo $thumb_alt; else echo the_title; ?>" class="left" />
		</p>
	<?php } ?>
	<p class="byline"><?php the_time('F jS, Y') ?></p>
	<?php the_excerpt(); ?>
	<p><?php edit_post_link('Edit', '', ' &#124; '); ?><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story &raquo;</a></p>
	</div><!-- entry -->
	</div><!-- post -->
	</div><!-- post left or right -->

<?php // for controlling the layout of the home pages bottom excerpts up to 10 posts
if($i == '2' || $i == '4' || $i == '6' || $i == '8' || $i == '10') { ?>
</div><!-- secondary -->
<?php } // endif ?>
<?php $i++; ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>