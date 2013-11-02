<?php get_header(); ?>

	<div id="content_box">
			<h1 class='department'><?php the_category(' &middot; '); ?></h1>
		<div id="content" class="posts">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<div class="small_clear"></div>
			<h2><?php the_title(); ?></h2>
			<h4><?php the_time('F jS, Y') ?> &middot; <?php
			clean_authors(get_post_custom_values('Written by:'));
			clean_additional(get_post_custom_values('Additional reporting by:'));
			
			?>  <!-- &middot; <a href="<?php the_permalink() ?>#comments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a> --></h4>
			
		 
			<div class="entry">
				<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>
			
			<!-- <p class="tagged"><strong>Tags:</strong> <?php the_category(' &middot; ') ?></p> -->
			<div class="clear"></div>
			<h2>Related Posts:</h2><br />
			<div style='font-size:14px;'>
		<?php		related_posts();
?></div>
			<?php comments_template(); ?>
			
		<?php endwhile; else: ?>
		
			<h2 class="page_header">Uh oh.</h2>
			<div class="entry">
				<p>Sorry, no posts matched your criteria. Wanna search instead?</p>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
		
		</div>
		
		<?php include (TEMPLATEPATH . '/sidebar.php'); ?>

		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>
			
	</div>

<?php get_footer(); ?>