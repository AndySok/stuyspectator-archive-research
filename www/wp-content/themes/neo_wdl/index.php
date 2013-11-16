<?php global $am_option; get_header(); ?>

	<div id="main_col">

		<?php if (have_posts()) : ?>

		<?php $count = 0; while (have_posts()) : the_post(); $count++; ?>
			<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
			
				<div class="date">
					<p class="month"><?php the_time('M') ?></p>
					<p class="day"><?php the_time('d') ?></p>
				</div>
				<div class="title">
					<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'neo_wdl' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</div>
				<p class="posted"><?php _e('Posted by :','neo_wdl'); ?> <span class="author"><?php the_author() ?></span> | <?php _e('On :','neo_wdl'); ?> <span><?php the_time(get_option( 'date_format' )) ?></span></p>
				<div class="metadata">
					<p>
						<span class="label"><?php _e('Category:', 'neo_wdl') ?></span>
						<span class="text"><?php the_category(', ') ?></span>
					</p>
					<?php the_tags('<p><span class="label">'.__('Tags:','neo_wdl').'</span><span class="text">', ', ', '</span></p>'); ?>
					<div class="bot"></div>
				</div><!-- /metadata -->
				<?php if($count==1 && !empty($am_option['main']['ads_archives_468'])) : ?>
				<div class="ads ads_small"><?php echo $am_option['main']['ads_archives_468']; ?></div>
				<?php endif; ?>
				<div class="entry">
					<?php the_content(__('<span>Continue Reading</span>', 'neo_wdl')); ?>
					<div class="clear"></div>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'neo_wdl' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div>
						
			</div><!-- /post -->
		<?php endwhile; ?>
		
		<?php 
		$next_page = get_next_posts_link(__('Previous', 'neo_wdl')); 
		$prev_pages = get_previous_posts_link(__('Next', 'neo_wdl'));
		if(!empty($next_page) || !empty($prev_pages)) :
		?>
		<div class="pagination">
			<?php if(!function_exists('wp_pagenavi')) : ?>
            <div class="al"><?php echo $next_page; ?></div>
			<div class="ar"><?php echo $prev_pages; ?></div>
            <?php else : wp_pagenavi(); endif; ?>
		</div><!-- /pagination -->
		<?php endif; ?>
		
	<?php else : ?>
		<div class="nopost">
        	<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'neo_wdl') ?></p>
         </div><!-- /nopost -->
	<?php endif; ?>

	</div><!-- /content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>