<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>
<?php
if (is_home()) {
	echo bloginfo('name'); echo ": "; echo bloginfo('description');
} elseif (is_404()) {
	echo '404 Not Found';
} elseif (is_category()) {
	echo 'Topics:'; wp_title('');
} elseif (is_search()) {
	echo 'Search Results';
} elseif (is_day() || is_month() || is_year() ) {
	echo 'Archives:'; wp_title('');
} else {
	echo wp_title('');
	$subtitle = get_post_meta($post->ID, 'Subtitle', $single = true);
	if($subtitle !== '') { echo ': ' . $subtitle; }
} ?>
</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="robots" content="all" />
<meta name="y_key" content="af3e5c186bff0380" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php //comments_popup_script(); // off by default ?>
<script type="text/javascript" src="<?php echo bloginfo(stylesheet_directory) .'/jquery.js'; ?>"></script>
<script type="text/javascript" src="<?php echo bloginfo(stylesheet_directory) .'/tabs.js'; ?>"></script>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php 
// Do not delete
	wp_head(); 
// Controls the style through theme options
	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
		else { $$value['id'] = get_settings( $value['id'] ); } } 
	global $style, $show_cats, $show_feature, $feed, $feed_email;
	$style = $st_theme_style;
	$show_cats = $st_show_tabs_categories;
	$show_feature = $st_show_feature;
	$feed = $st_feed;
	$feed_email = $st_feed_email; ?>
</head><body>
<?php // Structure Version Check
echo '<!-- Structure theme: Version 1.1.5 -->'; ?>
<div id="body-container">
<div id="nav-container">
	<div id="main-nav">
		<?php include (TEMPLATEPATH . '/main-nav.php'); ?>
	</div>
	<div id="search">
		<?php include(TEMPLATEPATH . '/searchform.php'); ?>
	</div><!-- search -->
</div><!-- nav-container -->

<div id="header">
	<h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>

<div id="feed">
<!-- Change your feed addresses (at least your email feed address) (can now be done in dashboard "Structure Options") -->
	<ul>
	<li class="feed-blog"><a href="<?php if($feed !== '') echo $feed; else bloginfo('rss2_url'); ?>" title="Subscribe to the feed">Subscribe by RSS</a></li>
	<li class="feed-email"><a href="<?php if($feed_email !== '') echo $feed_email; else bloginfo('rss2_url'); ?>" title="Subscribe to the feed">Subscribe by email</a></li>
	</ul>
</div><!-- feed -->
</div><!-- header -->

<div id="container">
<?php // displays a different class if at home.php
	if (is_home()) echo '<div id="home">';
// If on any page besides home
	else { echo '<div id="content"'; if(is_home()) echo '>'; else echo 'class="single">'; } ?>