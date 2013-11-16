<!-- begin r_sidebar -->

<div id="r_sidebar">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : ?>
	
	<h3>Advertisement</h3>
		<a href="<?php echo get_settings('home'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/sample-ad2.gif" alt="Alternate text goes here" /></a>

	<?php endif; ?>
	
</div>

<!-- end r_sidebar -->