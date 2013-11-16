<?php
/*
Template Name: Full Width
*/

global $am_option; 
get_header(); ?>

	<div id="main_col">
		
		<?php if($am_option['main']['breadcrumb_show']==1) : ?>
			<?php breadcrumb_trail('echo=1&separator=/'); ?>
		<?php endif; ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
		
			<div class="title">
				<h2><?php $title = am_get_custom_field('title', get_the_ID(), true); if(!empty($title)) : echo $title; else : the_title(); endif; ?></h2>
			</div><!-- /title -->
			
			<div class="entry">
				<?php the_content(__('Read more', 'neo_wdl')); ?>
				<div class="clear"></div>
				<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'neo_wdl').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(__('Edit', 'neo_wdl'), '<br /><p>', '</p>'); ?>
		
			</div><!-- /entry -->
			
		</div><!-- /post -->
		<?php endwhile; endif; ?>

	</div><!-- /content -->

<?php get_footer(); ?>