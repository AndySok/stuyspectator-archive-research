<?php
	global $am_option;
?>
<div id="sidebar" class="col_sidebar">
	<div class="sidebar_widgets">
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(am_get_sidebar_id()) ) : ?>	
		
		<div class="widget widget_pages">
			<h3 class="widgettitle"><?php _e('Pages', 'neo_wdl') ?></h3>
			<ul>
			<?php wp_list_pages('title_li='); ?>
			</ul>	
		</div><!-- /widget -->
		
		<div class="widget widget_categories">
			<h3 class="widgettitle"><?php _e('Categories', 'neo_wdl') ?></h3>
			<ul><?php wp_list_categories('show_count=0&title_li='); ?></ul>	
		</div><!-- /widget -->
		
		<div class="widget widget_archive">
			<h3 class="widgettitle"><?php _e('Archives', 'neo_wdl') ?></h3>
			<ul>
			<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</div><!-- /widget -->
		
		<div class="widget widget_links">
			<h3 class="widgettitle"><?php _e('Blogrolls', 'neo_wdl') ?></h3>
			<ul>
			<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
			</ul>	
		</div><!-- /widget -->
		
		<?php endif; ?>
	</div><!-- /sidebar_widgets -->
</div><!-- /sidebar -->