<!-- FULL POSTS - HOME.PHP (Full Posts Template) -->
<div class="excerpts full-posts">
<?php 
// THE SECOND LOOP SHOWING THE ARTICLES AFTER THE FEATURE
if(have_posts()) : while(have_posts()) : the_post(); 
	if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);

// CHECKS TO SEE IF THERE'S AN IMAGE FOR THIS POST
$thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
// CHECKS TO SEE IF THERE'S A SET ALT TEXT FOR THIS IMAGE
$thumb_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>

<div id="post-<?php the_ID(); ?>" class="post">
	<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<p class="byline">By 
	<span class="author"><?php the_author_posts_link() ?></span> on 
	<span class="time"><?php the_time('F jS, Y') ?></span>
	<?php edit_post_link('Edit', ' | ', ' '); ?> | <?php 
	comments_popup_link('No Comments &raquo;', '1 Comment &raquo;', '% Comments &raquo;'); ?>
	</p>
	<div class="entry">
	<?php if($thumb !== '') {
		?>
		<p>
		<img src="<?php echo $thumb?>" alt="<?php if($thumb_alt !== '') echo $thumb_alt; else echo the_title(); ?>" class="left" />
		</p>
	<?php } ?>
	<?php
	the_content();
	?>
<p class="post-meta-data">
	<strong>Categories:</strong> <span class="category"><?php the_category(', ') ?></span>
	<br />
	<?php if(function_exists('the_tags')) { ?>
	<strong>Tags:</strong> <span class="tags"><?php the_tags('', ', ', ''); ?></span>
<?php } ?>
</p>
	</div><!-- entry -->
</div><!-- post -->
<?php endwhile; endif; ?>
<!-- IE6 bug fix / Do not remove -->
<p class="ie6-bug">&nbsp;</p>
</div><!-- full-posts -->