<!-- begin l_sidebar -->

<div id="l_sidebar">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
	
	<h2>Latest Headlines</h2>
		<ul>
			<?php get_archives('postbypost', 10); ?>
		</ul>
	
	<h2>Sections</h2>
		<ul>
			<?php wp_list_categories('sort_column=name&title_li='); ?>
		</ul>
	
	<h2>Archives</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>

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
			
	<?php endif; ?>
	
</div>

<!-- end l_sidebar -->