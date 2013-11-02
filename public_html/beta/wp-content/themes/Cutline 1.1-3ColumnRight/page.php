<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content" class="pages">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<h2><?php the_title(); ?></h2>	
			<div class="entry">		
				<?php the_content('<p>Read the rest of this page &rarr;</p>'); ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>
			<?php if ('open' == $post-> comment_status) { ?>
			<div class="clear"></div>
			<?php } else { ?>
			<div class="clear rule"></div>
			<?php } ?>
			
			<?php endwhile; endif; ?>
			
	

		</div>

		<?php include (TEMPLATEPATH . '/sidebar.php'); ?>
		
		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>

	</div>

<?php get_footer(); ?>