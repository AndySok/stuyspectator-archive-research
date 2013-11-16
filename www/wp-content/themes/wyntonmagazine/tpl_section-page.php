<?php
/*
Template Name: Section Page
*/
?>
<?php get_header(); ?>

<div id="section-content">
  <div id="section-teaser">
    <?php // "Section teaser" module begins	  
	query_posts('showposts=1&cat=30'); ?>
    <?php while (have_posts()) : the_post(); ?>
    <small class="commentmetadata">
    <?php _e('By','wyntonmagazine');?>
    <?php the_author_posts_link('namefl'); ?>
    |
    <?php the_time(__ ('F jS, Y', 'wyntonmagazine'));?>
    |
    <?php _e('Category:','wyntonmagazine');?>
    <?php the_category(', ');?>
    |
    <?php comments_popup_link(__ ('No Comments &#187;', 'wyntonmagazine'), __ ('1 Comment &#187;', 'wyntonmagazine'), __ngettext ('% comment', '% comments', get_comments_number (),'wyntonmagazine')); ?>
    <?php edit_post_link('Edit', ' | ', ' | '); ?>
    </small> <a href="<?php the_permalink() ?>" rel="bookmark" class="section-title">
    <?php 
// this is where title of the article gets printed	  
	  the_title(); ?>
    </a><br />
        <?php
// this grabs the image filename
	$values = get_post_custom_values("section-teaser-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="left" src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("section-teaser-image"); echo $values[0]; ?>" alt="image" /></a>
    <?php } ?>

    <?php the_excerpt(); ?>
    <div class="section-read-on">
    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php _e('[ Continue reading... ]','wyntonmagazine');?></a>
    </div>
    <?php endwhile; ?>
  </div>
  <div id="section-articlelist">
    <?php // "Section headlines" module begins	  
	query_posts('showposts=5&cat=30&offset=1'); ?>
    <?php while (have_posts()) : the_post(); ?>
    <?php
// this grabs the image filename
	$values = get_post_custom_values("section-category-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="left" src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("section-category-image"); echo $values[0]; ?>" alt="image" /></a>
    <?php } ?>
    <small class="commentmetadata">
    <?php _e('By','wyntonmagazine');?>
    <?php the_author_posts_link('namefl'); ?>
    |
    <?php the_time(__ ('F jS, Y', 'wyntonmagazine'));?>
    |
    <?php _e('Category:','wyntonmagazine');?>
    <?php the_category(', ');?>
    |
    <?php comments_popup_link(__ ('No Comments &#187;', 'wyntonmagazine'), __ ('1 Comment &#187;', 'wyntonmagazine'), __ngettext ('% comment', '% comments', get_comments_number (),'wyntonmagazine')); ?>
    <?php edit_post_link('Edit', ' | ', ' | '); ?>
    </small> <a href="<?php the_permalink() ?>" rel="bookmark" class="section-subtitle">
    <?php 
// this is where title of the article gets printed	  
	  the_title(); ?>
    </a><br />
    <div class="section-p"><?php the_excerpt(); ?></div>
    <?php endwhile; ?>
  </div>
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
<?php get_footer(); ?>