<?php get_header(); ?>

	<div id="pagecontent">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				 <?php the_content("<p class=\"serif\">" . __('Read the rest of this page', 'wyntonmagazine') ." &raquo;</p>"); ?>

				<?php wp_link_pages("<p><strong>" . __('Pages', 'wyntonmagazine') . ":</strong>", '</p>', __('number','wyntonmagazine')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit', '<p>', '</p>'); ?>
	</div>

<div class="clear"></div>
<?php get_footer(); ?>