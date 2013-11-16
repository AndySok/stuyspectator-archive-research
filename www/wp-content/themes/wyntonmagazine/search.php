<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results','wyntonmagazine');?></h2>

			<?php while (have_posts()) : the_post(); ?>

			<div class="post">
				<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php __('Permanent Link to','wyntonmagazine');?> <?php the_title(); ?>"><?php the_title(); ?></a></h4>
				<small><?php the_time(__ ('F jS, Y', 'wyntonmagazine')) ?></small>
	<div class="entry">
					<?php the_excerpt() ?>
				</div>
<hr /><br />
				
			</div>

		<?php endwhile; ?>
		
		<div class="navigation">
				<div class="preventries"><?php next_posts_link(__('&laquo; Previous entries','wyntonmagazine')) ?></div>
				<div class="nextentries"><?php previous_posts_link(__('Next entries &raquo;','wyntonmagazine')) ?></div>
		</div>	

	<?php else : ?>

		<h2 class="center"><?php _e('No posts found. Try a different search?','wyntonmagazine');?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>