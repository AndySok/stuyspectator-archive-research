<?php
/*
Template Name: Section Page
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="homepage">
				
	<div id="homepageleft">		
	
		<div class="featured">
			<h2>Featured Section Story</h2>
			<img style="margin-bottom:10px" src="<?php bloginfo('template_url'); ?>/images/section-main.jpg" alt="Featured Story" />
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(125, "Read more &raquo;"); ?><div style="clear:both;"></div>
			<?php endwhile; ?>
		</div>
		
		<h3>Other Featured Stories</h3>
			<ul>
				<?php $recent = new WP_Query("cat=1&showposts=10"); while($recent->have_posts()) : $recent->the_post();?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
			</ul>
			
	</div>
		
	<div id="homepageright">

		<h2>Latest Section Headlines</h2>
	
			<?php $recent = new WP_Query("cat=1&showposts=5"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(110, "Read more &raquo;"); ?>
			
			<div class="hppostmeta">
				<p><?php the_time('F j, Y'); ?></p>
			</div>
			
			<?php endwhile; ?><br />

	</div>
		
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>