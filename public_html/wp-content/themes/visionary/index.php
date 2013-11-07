<?php get_header(); ?>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" class="post">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<p class="post-time">
<?php _e('Posted on'); ?> <?php the_time('F jS, Y') ?> <?php _e('in'); ?> <?php the_category(', ') ?> <?php edit_post_link('Edit', ' &#124; ', ''); ?></p>

<div class="entry">
<?php wswwpx_content_extract ( '(Continue reading...)', 80, 55 ); ?>
</div><!-- entry -->

<p class="postmetadata">
<span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
</p>

</div><!-- post -->

<?php endwhile; ?>

<div class="navigation">
<?php posts_nav_link(" | ","<span>&laquo; Previous</span>","<span>Next &raquo;</span>"); ?>
</div>

<?php endif; ?>

<?php get_footer(); ?>