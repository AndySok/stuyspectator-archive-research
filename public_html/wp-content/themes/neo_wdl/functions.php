<?php
global $am_option;

$am_themename = "Neo_wdl";
$am_shortname = "neo_wdl";
$am_textdomain = "neo_wdl";

$am_option['url']['includes_path'] = 'includes';
$am_option['url']['extensions_path'] = $am_option['url']['includes_path'].'/extensions';
$am_option['url']['extensions_url'] = get_template_directory_uri().'/'.$am_option['url']['extensions_path'];
$am_option['url']['themeoptions_path'] = $am_option['url']['includes_path'].'/theme-options';
$am_option['url']['themeoptions_url'] = get_template_directory_uri().'/'.$am_option['url']['themeoptions_path'];

// Functions
require_once($am_option['url']['includes_path'].'/fn-core.php');
require_once($am_option['url']['includes_path'].'/fn-custom.php');

// Extensions
require_once($am_option['url']['extensions_path'].'/breadcrumb-trail.php');

/* Theme Init */
require_once($am_option['url']['includes_path'].'/theme-init.php');

/* Admin */
require_once($am_option['url']['themeoptions_path'].'/fn-admin.php');
require_once($am_option['url']['themeoptions_path'].'/am-main.php');

?>