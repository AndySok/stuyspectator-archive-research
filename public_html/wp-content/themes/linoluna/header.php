<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<script type="text/javascript" src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/common.js"></script>
<script type="text/javascript" src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/jquery-1.2.1.min.js"></script>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<!--[if IE 7]>
		<style type="text/css"> @import url(<?php echo get_option('home'); ?>/wp-content/themes/linoluna/ie7.css); </style>
		<![endif]-->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

<script type="text/javascript">
    var $j = jQuery.noConflict();
    var t;
    var feature = '#feature_';
    var control = '#cntrl_';


    // initialize variables at last position
    var current = 4;
    var next = 1;
    var previous = 3;
    $j('#cntrl_play').hide();
    function start_loop() {
        $j('#cntrl_play').hide();
        $j(control.concat(current)).removeClass("cntrl_active");
        hide_element(feature.concat(current));
        current = next;
        $j(control.concat(next)).addClass("cntrl_active");
        if (current == 4) {
            next = 1;
        } else {
            next = current + 1;
        }
        if (current == 1) {
            previous = 4;
        } else {
            previous = current - 1;

        }
        show_element(feature.concat(current));
        t = setTimeout("start_loop()",8000);

    }

    function restart_loop() {
        // this is required to avoid odd behavior if Play is clicked when not paused
        $j('#cntrl_pause').show();
        $j('#cntrl_play').hide();
        clearTimeout(t);
        $j(control.concat(current)).removeClass("cntrl_active");
        hide_element(feature.concat(current));
        if (current == 4) {
            next = 1;
        } else {
            next = current + 1;
        }
        if (current == 1) {
            previous = 4;
        } else {
            previous = current - 1;
        }

        current = next;
        $j(control.concat(current)).addClass("cntrl_active");
        show_element(feature.concat(current));
        t = setTimeout("restart_loop()",8000);

    }

    function show_element(div) {
        $j(div).fadeIn("slow");

    }

    function hide_element(div) {
        $j(div).hide();

    }

    function stop_loop() {
        $j('#cntrl_pause').hide();
        $j('#cntrl_play').show();
        clearTimeout(t);

    }

    function switch_pane(div) {
        stop_loop();
        $j("#cntrl_1").removeClass("cntrl_active");
        $j("#feature_1").hide();
        $j("#cntrl_2").removeClass("cntrl_active");
        $j("#feature_2").hide();
        $j("#cntrl_3").removeClass("cntrl_active");
        $j("#feature_3").hide();
        $j("#cntrl_4").removeClass("cntrl_active");
        $j("#feature_4").hide();

        current = div - 1;

        $j(control.concat(div)).addClass("cntrl_active");
        show_element(feature.concat(div));

    }

    $j(document).ready(function() {
        start_loop();

    });

</script>


</head>
<body>
<div id="page" class="clearfloat">

<div class="clearfloat">
<div id="logo" class="left">
<h1 class="webtitle"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
<div class="description"><?php bloginfo('description'); ?></div>
</div>

<div class="right">
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<div class="nav"><a href="<?php echo get_option('home'); ?>">Home</a> | <a href="<?php echo get_option('home'); ?>/about/">About</a> | <a href="http://www.michaeljubel.com">Blog</a> | <a href="mailto:mjubel@yahoo.com.sg">Contact Me</a></div>
</div>

</div>

<div class="nav-bar">
<span><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/feedicon.png" /></a>&nbsp;<a href="<?php bloginfo('rss2_url'); ?>">Subscribe E-mail</a> | <a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/icons/feedicon.png" /></a>&nbsp;<a href="<?php bloginfo('rss2_url'); ?>">Subscribe RSS</a></span>
</div>






