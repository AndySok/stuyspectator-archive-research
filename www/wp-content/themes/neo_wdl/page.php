<?php global $am_option; get_header(); ?>

	<div id="main_col" class="page_defaut">
		
		<?php if($am_option['main']['breadcrumb_show']==1) : ?>
			<?php breadcrumb_trail('echo=1&separator=/'); ?>
		<?php endif; ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
		
			<div class="title">
				<h2><?php the_title(); ?></h2>
			</div><!-- /title -->
			
			<div class="entry">
				<?php the_content(__('Read more', 'neo_wdl')); ?>
				<div class="clear"></div>
				<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'neo_wdl' ) . '</span>', 'after' => '</div>' ) ); ?>
				<?php edit_post_link(__('Edit', 'neo_wdl'), '<br /><p>', '</p>'); ?>
		
			</div><!-- /entry -->
			
		</div><!-- /post -->
			
		<?php comments_template(); ?>
		<?php endwhile; endif; ?>

	</div><!-- /content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>