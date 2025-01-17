<?php get_header(); ?>

	<div id="content">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
	<div class="post" id="post_<?php the_ID(); ?>">
	<a href="<?php echo get_option('home'); ?>/">Home</a> &raquo; <?php the_title(); ?>
		
	<h2><?php the_title(); ?></h2>
		
		<div class="entry">
		<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		</div>
		
		
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

	</div>
		
	<?php endwhile; endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
