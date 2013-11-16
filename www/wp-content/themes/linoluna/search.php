<?php get_header(); ?>

	<div id="content">
	
	<div id="archive">
	
	<?php if (have_posts()) : ?>

	<h2>Search Results</h2>
	
	<p>You've just searched for "<?php the_search_query() ?>". Here are the results:</p>

<?php while (have_posts()) : the_post(); ?>


	<div class="clearfloat">
		<?php	$values = get_post_custom_values("Image");	if (isset($values[0])) {?>
 		     <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/thumbnails/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
      		<?php } ?>

			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="title"><?php the_title(); ?></a><br/>
				<span class="author">By <?php the_author_posts_link('namefl'); ?></span><br/>Posted in <?php the_category(', ') ?> on <?php the_time('j F Y') ?><br/>Stats: <?php if(function_exists('the_views')) { the_views(); } ?> and <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
		<?php the_excerpt() ?>
			</div>
		
<?php endwhile; ?>
		</div>
	
<br/><br/>	
		<div class="navigation">

			<div class="right"><?php next_posts_link('Next Page &raquo;') ?></div>
			<div class="left"><?php previous_posts_link('&laquo; Previous Page') ?></div>
		</div>


	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>


	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
