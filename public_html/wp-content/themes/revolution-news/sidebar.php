<!-- begin sidebar -->

<div id="sidebar">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
	
	<h3>Advertisement</h3>
		<a href="<?php echo get_settings('home'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/sample-ad.gif" alt="Alternate text goes here" /></a>
		
	<h2>Latest Headlines</h2>
		<ul>
			<?php get_archives('postbypost', 10); ?>
		</ul>

	<div class="sideleft">
	
		<h2>Sections</h2>
			<ul>
				<?php wp_list_categories('sort_column=name&title_li='); ?>
			</ul>
	
		<h2>Archives</h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			
	</div>

	<div class="sideright">
	
		<h2>Related Sites</h2>
			<ul>
				<?php get_links(-1, '<li>', '</li>', ' - '); ?>
			</ul>
	
		<h2>Admin</h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://www.wordpress.org/">WordPress</a></li>
				<?php wp_meta(); ?>
				<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>
			</ul>
			
	</div>

	<div style="clear:both;"></div>

	<?php endif; ?>
	
</div>

<!-- end sidebar -->