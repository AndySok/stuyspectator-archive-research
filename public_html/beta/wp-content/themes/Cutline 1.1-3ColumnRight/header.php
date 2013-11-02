<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php if (is_single() || is_page() || is_archive()) { wp_title('',true); } else { bloginfo('name'); print "- "; bloginfo('description'); } ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<meta name="Title" content="The Stuyvesant Spectator">
		<meta name="Description" content="The Official newspaper of Stuyvesant High School">
	    <meta name="Keywords" content="newspaper, stuyvesant, high school, journalism, students, spectator">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom.css" type="text/css" media="screen" />
	<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie7.css" media="screen" />
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie6.css" media="screen" />
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>
</head>
<body class="custom">

<div id="container">
	<a href="<?php bloginfo('url'); ?>">


	<div id="masthead">
		<img src="<?php bloginfo('template_url'); ?>/images/header_1.jpg">
	</div>
		</a>

	<ul id="nav">
		<li><a <?php if (is_home()) echo('class="current" '); ?>href="<?php bloginfo('url'); ?>">frontpage</a></li>
		<li><a <?php if (is_archive() || is_page('archives')) echo('class="current" '); ?>href="<?php bloginfo('url'); ?>/archives/">archives</a></li>
		<li><a href="http://stuyspectator.com/mail/?p=subscribe">newsletter</a></li>
		<li><a <?php if (is_page('contact')) echo('class="current" '); ?>href="<?php bloginfo('url'); ?>/contact/">contact</a></li>
		<li><a <?php if (is_page('about')) echo('class="current" '); ?>href="<?php bloginfo('url'); ?>/about/">about</a></li>
		<li>SEARCH:</li>
		<li><?php include (TEMPLATEPATH . '/searchform.php'); ?></li>
		<li class="rss"><a href="<?php bloginfo('rss2_url'); ?>">RSS</a></li>
	</ul>
	
