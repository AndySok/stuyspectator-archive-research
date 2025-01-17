<?php get_header(); ?>
		
	<div id="content_box">

		<div id="content" class="posts">
		
		<?php if (have_posts()) : ?>

			<?php //$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	
			<?php /* If this is a category archive */ if (is_category()) { ?>				
			<h1 class="archive_head"><?php echo single_cat_title(); ?></h1>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2 class="archive_head">Entries from <?php the_time('F Y'); ?></h2>

			<?php } ?>
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>

			<?php while (have_posts()) : the_post(); ?>
			
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a> </h2>
		   <h4><?php the_category(' &middot; '); ?>- <?php the_time('F jS, Y') ?> 	&middot; <?php
			clean_authors(get_post_custom_values('Written by:'));
			clean_additional(get_post_custom_values('Additional reporting by:'));
			
			?><!-- by --> <?php // the_author() ?> <?php // comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></h4>
			<div class="entry">
				<?php the_excerpt() ?>
				<p><a href="<?php the_permalink() ?>#more-<?php the_ID(); ?>" title="Read the rest of this entry">[Read more &rarr;]</a> 
				</p>
			</div>
			
			<!-- <div class="clear"></div> -->
			
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>

		<?php else : ?>
		
			<h2 class="page_header">Welp, we couldn't find that...try again?</h2>
			<div class="entry">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
			
		</div>
	
		<?php include (TEMPLATEPATH . '/sidebar.php'); ?>
		
		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>
		
	</div>
		
<?php get_footer(); ?>