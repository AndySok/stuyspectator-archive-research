<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
    <h2>
      <?php the_title(); ?>
    </h2>
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
    </small>
        <div class="entry">
       <?php the_content("<p class=\"serif\">" . __('Read the rest of this page', 'wyntonmagazine') ." &raquo;</p>"); ?>

      <?php wp_link_pages("<p><strong>" . __('Pages', 'wyntonmagazine') . ":</strong>", '</p>', __('number','wyntonmagazine')); ?>
    </div>
    <?php if ( function_exists('the_tags') ) {
			the_tags('<div id="tags"><strong>Tags:</strong> ', ', ', '</div>'); } ?>
  </div>
  <?php comments_template(); ?>
  <?php endwhile; else: ?>
  <p><?php __('Sorry, no posts matched your criteria.','wyntonmagazine');?></p>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
<?php get_footer(); ?>
