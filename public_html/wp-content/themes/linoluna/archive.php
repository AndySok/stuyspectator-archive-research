<?php get_header(); ?>

	<div id="content">
	
	<?php if (have_posts()) : ?>
	<div id="archive">
 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2>Articles in the <strong><?php single_cat_title(); ?></strong> Category</h2>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2>Article Archive for <strong><?php the_time('j F Y'); ?></strong></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2>Article Archive for <strong><?php the_time('F Y'); ?></strong></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 >Article Archive for <strong>Year <?php the_time('Y'); ?></strong></h2>

 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2>The Archives</h2>
 	  <?php } ?>

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
	
<br/><br/>		

			<div class="navigation">

			<div class="right"><?php next_posts_link('Next Page &raquo;') ?></div>
			<div class="left"><?php previous_posts_link('&laquo; Previous Page') ?></div>
		</div>
	
	</div>
	<?php else : ?>
	<div id="archive">
		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
