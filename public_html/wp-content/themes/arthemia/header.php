<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<link rel="icon" href="<?php echo get_option('home'); ?>/wp-content/themes/arthemia/images/favicon.ico" />
<link rel="shortcut icon" href="<?php echo get_option('home'); ?>/wp-content/themes/arthemia/images/favicon.ico" />

<?php wp_head(); ?>

</head>
<body>

<div id="head" class="clearfloat">

<div class="clearfloat">
	<div id="logo" class="left">
	<a href="<?php echo get_option('home'); ?>/"><img src="<?php echo get_option('home'); ?>/wp-content/themes/arthemia/images/logo.png" width="177px" height="39px" alt="" /></a>
	<div id="tagline"><?php bloginfo('description'); ?></div>
	</div>

	<div class="right">
	<img src="<?php echo get_option('home'); ?>/wp-content/themes/arthemia/images/banners/wide.jpg" alt="" width="468px" height="60px"  />
	</div>

</div>

<div id="navbar" class="clearfloat">

<ul id="page-bar" class="left clearfloat">

<li><a href="<?php echo get_option('home'); ?>/">Frontpage</a></li>
<li class="page_item page-item-2"><a href="http://stuyspectator.com/about/?preview=1&amp;template=arthemia&amp;stylesheet=arthemia" title="About Us">About Us</a>

<ul>
	<li class="page_item page-item-2553"><a href="http://stuyspectator.com/about/this-site/?preview=1&amp;template=arthemia&amp;stylesheet=arthemia" title="About This Site">About This Site</a></li>
</ul>
</li>
<li class="page_item page-item-12"><a href="http://stuyspectator.com/archive/?preview=1&amp;template=arthemia&amp;stylesheet=arthemia" title="Archive">Archive</a>
<ul>
	<li class="page_item page-item-1278"><a href="http://stuyspectator.com/archives/pdfs/?preview=1&amp;template=arthemia&amp;stylesheet=arthemia" title="PDFs">PDFs</a></li>
</ul>
</li>
<li class="page_item page-item-292"><a href="http://stuyspectator.com/charter/?preview=1&amp;template=arthemia&amp;stylesheet=arthemia" title="The Charter of The Spectator">The Charter of The Spectator</a></li>
<li class="page_item page-item-228"><a href="http://stuyspectator.com/contact/?preview=1&amp;template=arthemia&amp;stylesheet=arthemia" title="Contact">Contact</a></li>

<!-- <?php wp_list_pages('sort_column=menu_order&title_li='); ?> -->

</ul>

<?php include (TEMPLATEPATH . '/searchform.php'); ?>

</div>

</div>

<div id="page" class="clearfloat">