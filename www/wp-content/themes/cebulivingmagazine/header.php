<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title><?php if (is_single() || is_page() || is_archive()) { wp_title('',true); } else { bloginfo('name'); echo(' &#8212; '); bloginfo('description'); } ?></title>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/yui/grids-min.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/yui/reset-fonts-grids.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/yui/fonts-min.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="http://stuyspectator.com/rss/" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>   
</head>
<body>
<div id="doc4" class="yui-t7">
   <div id="hd" onclick="location.href='<?php bloginfo('url'); ?>';" style="cursor: pointer;"><p class="date"><? echo date("l, F jS, Y"); ?> &bull; New York, NY</p></div>

<div id="invertedtabsline">&nbsp;</div>
<div id="invertedtabs">
<ul>
<li style="margin-left: 1px"><a href="<?php bloginfo('url'); ?>" title="Home"><span>Home</span></a></li>
<li><a href="<?php bloginfo('url'); ?>/archives/" title="Archives"><span>Archives</span></a></li>
<li><a href="http://stuyspectator.com/mail/?p=subscribe" title="Newsletter Subscription"><span>Newsletter</span></a></li>
<li><a href="<?php bloginfo('url'); ?>/contact/" title="Contact Us"><span>Contact</span></a></li>
<li><a href="<?php bloginfo('url'); ?>/about/" title="About The Spectator"><span>About</span></a></li>
<li><a href="http://blogs.stuyspectator.com/" title="Spectator Blogs"><span>Blogs</span></a></li>
</ul>
</div>
<br style="clear: left" />
<!-- <div id="bannerad">
</div> -->