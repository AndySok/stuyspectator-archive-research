<div id="sidebar">
	<ul class="sidebar_list">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1)) : ?>
		<li class="widget">
			<h2>Search It!</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</li>
		<li class="widget" style='background-color:#B1D95B;color:#000;padding-left:8px;'>
		Choose the next Sports Columnist!
		<a href="http://stuyspectator.com/choose-your-sports-columnist/">Vote now</a>
		</li>
		<li class="widget" style='background-color:#011235;color:white;padding-left:8px;'>
			Hear something funny? Submit to Overheard At Stuy by emailing overheard@stuyspectator.com
			
		</li>
		
		
		
		<li class="widget">
			<h2>A&E</h2>
			<ul>
				<?php $posts = get_posts( "category=4&numberposts=5" ); 
				 ?>
				<?php if ($posts) : foreach( $posts as $post ) : setup_postdata( $post ); 
				if (!in_category(9)) { ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><span class="recent_date"><?php the_time('n/j/y') ?></span></li>
				<?php } endforeach; endif; ?>
			</ul>
		</li>
	
		
		<li class="widget">
			<h2>Monthly Archives</h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>

		<?php endif; ?>
	</ul>
</div>