<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="breadcrumb">
			<?php if (class_exists('breadcrumb_navigation_xt')) {
			echo 'Browse > ';
			// New breadcrumb object
			$mybreadcrumb = new breadcrumb_navigation_xt;
			// Options for breadcrumb_navigation_xt
			$mybreadcrumb->opt['title_blog'] = 'Home';
			$mybreadcrumb->opt['separator'] = ' / ';
			$mybreadcrumb->opt['singleblogpost_category_display'] = true;
			// Display the breadcrumb
			$mybreadcrumb->display();
			} ?>	
		</div>
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		
		<div class="date">
			<p><?php the_time('F j, Y'); ?></p>
		</div>
	
		<?php the_content(__('Read more'));?><div style="clear:both;"></div>
		
		<div class="postmeta">
			<p>Written by <?php the_author(); ?> &middot; Filed Under <?php the_category(', ') ?>&nbsp;<?php edit_post_link('(Edit)', '', ''); ?></p>
		</div>
		
		<?php endwhile; else: ?>
		
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
		<p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>
				
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>