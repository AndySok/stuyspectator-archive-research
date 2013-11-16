<div id="sidebar">
	<ul class="sidebar_list">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2)) : ?>
		<li class="widget">
			<h2>Sections</h2>
			<ul>
				<?php wp_list_cats('sort_column=name'); ?>
			</ul>
		</li>
		<li class="widget">
			<h2>Web Exclusives</h2>
			<ul>
				<?php $posts = get_posts( "category=8&numberposts=5" ); ?>
				<?php if ($posts) : foreach( $posts as $post ) : setup_postdata( $post ); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><span class="recent_date"><br /><?php the_time('n/j/y') ?></span></li>
				<?php endforeach; endif; ?>
			</ul>
		</li>
		<li class="widget">
			<h2>Recent Articles</h2>
			<ul>
				<?php query_posts('showposts=10'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); 
				if (!in_category(9)) { ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><span class="recent_date"><br /><?php the_time('n/j/y') ?></span></li>
				<?php } endwhile; endif; ?>
			</ul>
		</li>
	
		
		<?php endif; ?>
	</ul>
</div>