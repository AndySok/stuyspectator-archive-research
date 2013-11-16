<?php get_header(); ?>

	<div id="content">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">
	
	<a href="<?php echo get_option('home'); ?>/">Home</a> &raquo; <?php the_category(', ') ?>
	
	<h2 class="title"><?php the_title(); ?></h2>
		
	<div id="top_banner">	
	<?php	$values = get_post_custom_values("Image");
	if (isset($values[0])) { ?>

	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/banner/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
	<?php } ?></div>
	
	<div class="entry">
	<div class="clearfloat">
	<div id="stats"><span style="display:block"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/author.gif" /> <?php the_author_posts_link('namefl'); ?></span><span style="display:block"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/date.gif" /> <?php the_time('j F Y') ?></span><span style="display:block"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/category.gif" /> <?php the_category(', ') ?></span><span style="display:block"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/view.gif" /> <?php if(function_exists('the_views')) { the_views(); } ?></span><span style="display:block"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/comment.gif" /> <?php comments_number('No Comment', 'One Comment', '% Comments' );?></span><span style="display:block"><?php if(function_exists('wp_print')) { print_link(); } ?></span><span style="display:block"><?php if(function_exists('wp_email')) { email_link(); } ?></span></div>
	
	<?php the_content('Read the rest of this entry &raquo;'); ?>

	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	
	</div>

	<span style="float:right;display:block;"><?php if(function_exists('the_ratings')) { the_ratings(); } ?></span>

	<center>
	<img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/ads/468x60.gif" class="ads" />
	</center>

 	</div>
	</div>
	
	<div id="comments">
	<?php comments_template(); ?>
	</div>

	<?php endwhile; else: ?>

	<p>Sorry, no posts matched your criteria.</p>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>