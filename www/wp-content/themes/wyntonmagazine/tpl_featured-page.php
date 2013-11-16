<?php
/*
Template Name: Featured Page
*/
?>
<?php get_header(); ?>

<div id="featured-top">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="featured-leftcol"> <img class="left" src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("featuredpagepic"); echo $values[0]; ?>" alt="image" id="featuredpagepic" />
  <h2>
    <?php $values = get_post_custom_values("featuredpageheadline"); echo $values[0]; ?>
  </h2>
  <span id="featured-text">
  <?php $values = get_post_custom_values("featuredpagetext"); echo $values[0]; ?>
  </span> </div>
  
<div id="featured-rightcol">
  <h2><?php _e('Recent Posts','wyntonmagazine');?></h2>
  <li id="featured-recent">
    <ul class="recent">
      <?php wp_get_archives('type=postbypost&limit=5'); ?>
    </ul>
  </li>
</div>

</div>

<div id="featured-content">
  
  <div class="featured_post" id="post-<?php the_ID(); ?>">
    <h2>
      <?php the_title(); ?>
    </h2>
    
    <div class="entry">
      <?php the_content("<p class=\"serif\">" . __('Read the rest of this page', 'wyntonmagazine') ." &raquo;</p>"); ?>
	  <?php wp_link_pages("<p><strong>" . __('Pages', 'wyntonmagazine') . ":</strong>", '</p>', __('number','wyntonmagazine')); ?>
    </div>
    
  </div>
  
  <?php endwhile; endif; ?>
  
  <?php edit_post_link('Edit', '<p>', '</p>'); ?>
  
</div>

<div id="featured-sidebar">

    <?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
    <?php endif; ?>

</div>
<div class="clear"></div>
<?php get_footer(); ?>
