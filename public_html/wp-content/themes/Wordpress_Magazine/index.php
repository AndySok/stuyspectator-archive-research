<?php get_header(); ?>
	
	<!-- Container -->	
	<div id="content-wrap">
		<!-- Left Column -->
		<div id="leftcolumn">
		
			<!-- Featured Article -->
			<div id="featured">	
				<!-- Featured article loop -->
				<?php query_posts('cat=3&showposts=1'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<!-- title of featured article -->
				<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>				<!-- content of featured article-->
				<?php the_excerpt_reloaded(30, '<img><a>', 'content', false, 'More...', true);?>
					<!-- Featured Article Post Details -->
					<div id="postdetails">
						<?php the_time('F j, Y'); ?> | <?php comments_popup_link(__('Leave comment'), __('1 Comment'), __('% Comments'));?> | <a href="<?php echo get_permalink(); ?>" title="Read More">Read More</a>
					</div>
				<!-- End of Loop fore featured article -->
				<?php endwhile; else : ?>
				<?php endif; ?>
			</div>
			
			<!-- Latest featured articles list -->
			<div id="featurednewslist">
				<h2>Latest featured stories</h2>
				<ul>
					<?php query_posts('cat=3&showposts=10'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; else : ?>							
					<?php endif; ?>
				</ul>
			</div>			
			<?php include (TEMPLATEPATH . '/300x250ad.php'); ?>
		</div>
		<!-- /Left Column -->
		
		<!-- Middle Column -->
		<div id="midcolumn">
			<h2>Latest News</h2>
			<!-- Loop for latest news -->
			<?php $oddentry = 'class="gray" '; ?>
			<?php query_posts('cat=5,6,7,8,9,10,11,12,13&showposts=4'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php echo $oddentry; ?>>
				<div class="midcolumnpost">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<?php the_excerpt_reloaded(30, '<img><a>', 'content', false, 'More...', true);?>
					<div class="details">
						<?php the_time('F j, Y'); ?> | <?php comments_popup_link(__('Leave comment'), __('1 Comment'), __('% Comments'));?> | <a href="<?php echo get_permalink(); ?>" title="Read More">Read More</a>
					</div>
				</div>
			</div>
			<?php /* Changes every other post to a different class */	$oddentry = ( empty( $oddentry ) ) ? 'class="gray" ' : ''; ?>
			<!-- End of Loop for middle column -->
			<?php endwhile; else : ?>		
			<?php endif; ?>
		</div>
		<!-- /Middle Column -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>