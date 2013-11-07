<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php global $am_option, $query_string; ?><html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php
if (is_category()) {
	echo __('Category: ','neo_wdl'); wp_title(''); echo ' - ';

} elseif (function_exists('is_tag') && is_tag()) {
	single_tag_title(__('Tag Archive for &quot;','neo_wdl')); echo '&quot; - ';

} elseif (is_archive()) {
	wp_title(''); echo __(' Archive - ','neo_wdl');

} elseif (is_page()) {
	echo wp_title(''); echo ' - ';

} elseif (is_search()) {
	echo __('Search for &quot;','neo_wdl').esc_html($s).'&quot; - ';

} elseif (!(is_404()) && (is_single()) || (is_page())) {
	wp_title(''); echo ' - ';

} elseif (is_404()) {
	echo __('Not Found - ','neo_wdl');

} bloginfo('name');
?></title>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<div id="menu">
			<?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'menu_class' => 'sf-menu', 'menu_id'=>'sf-menu', 'fallback_cb' => 'am_wp_page_menu', 'container'=>'') ); ?>
				<?php $search_query = get_search_query(); if(empty($search_query)) $search_query = __('Enter your search query here...', 'neo_wdl'); ?>
				<div class="search_box">
				<form method="get" action="<?php echo home_url(); ?>/">
					<fieldset>
						<p><input type="text" onblur="if(this.value=='') this.value='<?php echo $search_query ?>'" onfocus="if(this.value=='<?php echo $search_query ?>') this.value=''" value="<?php echo $search_query; ?>" name="s" class="text" /></p>
						<p><input class="submit" type="submit" value="<?php _e('go','neo_wdl'); ?>" /></p>
					</fieldset>
				</form>
			</div>
		</div><!-- /menu -->
		<div id="header">
			<a href="<?php echo home_url(); ?>/" id="logo" title="<?php bloginfo('name'); ?>">
				<span class="title"><?php bloginfo('name'); ?></span>
				<span class="desc"><?php bloginfo('description'); ?></span>
			</a>
			<div class="social_box">
				<ul>
					<li><a href="<?php bloginfo('rss2_url'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_rss.png" alt="" /></a></li>
					<?php if(!empty($am_option['main']['reddit_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['reddit_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_robot.png" alt="reddit" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['delicious_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['delicious_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_del.png" alt="delicious" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['technorati_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['technorati_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_g.png" alt="technorati" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['facebook_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['facebook_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_fb.png" alt="facebook" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['stumbleupon_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['stumbleupon_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_sv.png" alt="stumbleupon" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['youtube_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['youtube_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_youtube.png" alt="youtube" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['myspace_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['myspace_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_myspace.png" alt="myspace" /></a></li>
					<?php endif; ?>
					<?php if(!empty($am_option['main']['digg_id'])) : ?>
					<li><a href="<?php echo $am_option['main']['digg_id']; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_digg.png" alt="digg" /></a></li>
					<?php endif; ?>
				</ul>
			</div>
			<?php query_posts('ignore_sticky_posts=1&post_type=post&meta_key=_slider&meta_value=yes&showposts='.$am_option['main']['number_posts']); ?>
			<?php if (have_posts()) : ?>
			<div id="featured_slider">
				<div id="slides">
					<?php while (have_posts()) : the_post(); ?>
					<div class="item">
						<?php if ( has_post_thumbnail()) : ?>
						<div class="pic"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium'); ?></a></div>
						<?php endif; ?>
						<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php echo am_get_limited_string(get_the_title(), 40, '...') ?></a></h2>
						<?php the_excerpt(); ?>
						<p><a href="<?php the_permalink() ?>" class="btn_more"><span><?php _e('Read More','neo_wdl'); ?></span></a></p>
					</div>
					<?php endwhile;  ?>
				</div>
				<div id="nav"><div></div></div>
			</div>
			<?php endif; wp_reset_query(); ?>
		</div><!-- /header -->
		<div id="body">
			<div class="container">
				<div class="twitter_box">
				<?php
					if(!empty($am_option['main']['twitter_id'])) :
				?>
					<div id="twitter_update_list_1985"></div>
				<?php endif; ?>
				</div>