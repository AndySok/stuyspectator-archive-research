<!-- BEGIN SIDEBAR-ARCHIVE.PHP -->
	<div id="sidebar-archive">
<div class="menu tabbed">
	<ul class="tabs">
	<li class="t1"><a class="t1 tab" title="<?php _e('Latest Headlines'); ?>"><?php _e('Latest'); ?></a></li>
	<li class="t2"><a class="t2 tab" title="<?php _e('Popular Stories'); ?>"><?php _e('Popular'); ?></a></li>
	<li class="t3"><a class="t3 tab" title="<?php _e('Sections'); ?>"><?php _e('Sections'); ?></a></li>
	<li class="t4"><a class="t4 tab" title="<?php _e('Archives'); ?>"><?php _e('Archives'); ?></a></li>
	</ul>

	<!-- LATEST HEADLINES -->
	<div class="t1">
	<?php rewind_posts(); ?>
	<ul id="latest">
	<?php $posts = get_posts('numberposts=10&offset=0'); foreach ($posts as $post): setup_postdata($post); ?>
	<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>

	<!-- POPULAR (MOST COMMENTED POSTS) -->
	<div class="t2">
	<ul id="popular">
	<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 10");
	foreach ($result as $topten) {
	$postid = $topten->ID;
	$title = $topten->post_title;
	$commentcount = $topten->comment_count; 
	if ($commentcount != 0) { ?>
	<li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>"><?php echo $title ?></a></li>
	<?php } } ?> 
	</ul>
	</div>

	<!-- SECTIONS (CATEGORIES) -->
	<div class="t3">
	<ul id="categories">
	<?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li='); ?>
	</ul>
	</div>

	<!-- ARCHIVES -->
	<div class="t4">
	<ul id="archives">
	<?php wp_get_archives('type=monthly&limit=10'); ?>
	</ul>
	</div>

</div><!-- tabbed -->
</div>
<!-- END SIDEBAR-ARCHIVE.PHP -->