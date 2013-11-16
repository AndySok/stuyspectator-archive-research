<?php get_header(); ?>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" class="post">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<div class="entry">
<?php the_content(); ?>
<?php wp_link_pages('before=<p><strong>Pages:</strong>&after=</p>'); ?>
<?php edit_post_link('Edit', '<p class="edit">', '</p>'); ?>

</div><!-- entry -->

</div><!-- post -->
<?php endwhile; ?>
<div id="comments-template">
<?php comments_template(); ?>
</div>
<?php endif; ?>
<?php get_footer(); ?>