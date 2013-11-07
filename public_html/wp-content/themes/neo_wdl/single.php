<?php global $am_option; get_header(); ?>

	<div id="main_col">
		
		<?php if($am_option['main']['breadcrumb_show']==1) : ?>
			<?php breadcrumb_trail('echo=1&separator=/'); ?>
		<?php endif; ?>

		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
			
			<div class="date">
				<p class="month"><?php the_time('M') ?></p>
				<p class="day"><?php the_time('d') ?></p>
			</div>
		
			<div class="title">
				<h2><?php the_title(); ?></h2>
			</div><!-- /title -->
			<p class="posted"><?php _e('Posted by :','neo_wdl'); ?> <span class="author"><?php the_author() ?></span> | <?php _e('On :','neo_wdl'); ?> <span><?php the_time(get_option( 'date_format' )) ?></span></p>
			<div class="metadata">
				<p>
					<span class="label"><?php _e('Category:', 'neo_wdl') ?></span>
					<span class="text"><?php the_category(', ') ?></span>
				</p>
				<?php the_tags('<p><span class="label">'.__('Tags:','neo_wdl').'</span><span class="text">', ', ', '</span></p>'); ?>
				<div class="bot"></div>
			</div><!-- /metadata -->
			<?php if(!empty($am_option['main']['ads_single_300'])) : ?>
			<div class="ads ads_big"><?php echo $am_option['main']['ads_single_300']; ?></div>
			<?php endif; ?>
			
			<div class="entry">
				<?php the_content(__('Read more', 'neo_wdl')); ?>
					<div class="clear"></div>
				<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'neo_wdl' ) . '</span>', 'after' => '</div>' ) ); ?>
				<?php edit_post_link(__('Edit', 'neo_wdl'), '<br /><p>', '</p>'); ?>
		
			</div><!-- /entry -->
			
			<?php if(!empty($am_option['main']['ads_single_468'])) : ?>
			<div class="ads ads_small"><?php echo $am_option['main']['ads_single_468']; ?></div>
			<?php endif; ?>
			
		</div><!-- /post -->
			
		<?php comments_template(); ?>
		<?php endwhile; endif; ?>

	</div><!-- /content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>