<?php global $am_option; get_header(); ?>

	<div id="main_col" class="page_defaut">
		
		<?php if($am_option['main']['breadcrumb_show']==1) : ?>
			<?php breadcrumb_trail('echo=1&separator=/'); ?>
		<?php endif; ?>
                                                                    
        <div class="post page">

            <div class="title">
            	<h2><?php _e('Error 404 - Page not found!', 'neo_wdl') ?></h2>
            </div><!-- /title -->
            <div class="entry"><p><?php _e('The page you trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.', 'neo_wdl') ?></p></div>

        </div><!-- /post -->
        
	</div><!-- /content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>