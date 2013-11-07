<?php
// SIDEBAR OPTIONS
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name'=>'Home Block Left',
		'before_widget' => '<div class="menu">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h2 class="menu-header">', // Replaces <h2>
		'after_title' => '</h2>', // Replaces </h2>
	));
	register_sidebar(array(
		'name'=>'Home Block Right',
		'before_widget' => '<div class="menu">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h2 class="menu-header">', // Replaces <h2>
		'after_title' => '</h2>', // Replaces </h2>
	));
	register_sidebar(array(
		'name'=>'Sidebar',
		'before_widget' => '<div class="menu">', // Removes <li>
		'after_widget' => '</div></div>', // Removes </li>
		'before_title' => '<h2>', // Replaces <h2>
		'after_title' => '</h2><div>', // Replaces </h2>
	)); }

// RECENT WIDGET
function widget_structure_recent() {
include(TEMPLATEPATH . '/recent.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Recent'), 'widget_structure_recent');
// TAGS WIDGET
function widget_structure_tags() {
include(TEMPLATEPATH . '/tags.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Tags'), 'widget_structure_tags');
// FLICKR WIDGET (Use this instead of normal FlickrRSS)
function widget_structure_flickrrss() {
include(TEMPLATEPATH . '/flickr.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Flickr'), 'widget_structure_flickrrss');
// ADS WIDGET (For Ad Block 1)
function widget_structure_ads1() {
include(TEMPLATEPATH . '/ads.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Ads'), 'widget_structure_ads1');
// ADS WIDGET (For Ad Block 2)
function widget_structure_ads2() {
include(TEMPLATEPATH . '/ads2.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Ads 2'), 'widget_structure_ads2');
// VIDEO WIDGET (For Video Block)
function widget_structure_video() {
include(TEMPLATEPATH . '/video.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Video'), 'widget_structure_video');
// CUSTOM BLOCK WIDGET
function widget_structure_custom_block() {
include(TEMPLATEPATH . '/custom-block.php');
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Structure Custom Block'), 'widget_structure_custom_block');
// THEME OPTIONS - DO NOT EDIT UNLESS YOU KNOW WHAT YOU'RE DOING
$themename = "Structure";
$shortname = "st";
$options = array (
	array("name" => "Theme Style",
		"id" => $shortname."_theme_style",
		"std" => "Default",
		"type" => "select",
		"options" => array("Default","Excerpts","Full Posts")),
	array("name" => "Display Feature Article?",
		"id" => $shortname."_show_feature",
		"std" => "Yes",
		"type" => "select",
		"options" => array("Yes","No")),
	array("name" => "Feed URL",
		"id" => $shortname."_feed",
		"std" => "",
		"type" => "text"),
	array("name" => "Feed By Email URL",
		"id" => $shortname."_feed_email",
		"std" => "",
		"type" => "text"),
	array("name" => "Flickr URL",
		"id" => $shortname."_flickr_url",
		"std" => "http://flickr.com",
		"type" => "text"),
	array("name" => "Display Category Tabs?",
		"id" => $shortname."_show_tabs_categories",
		"std" => "Yes",
		"type" => "select",
		"options" => array("Yes","No")),
	array("name" => "Category Tab 1",
		"id" => $shortname."_category_1",
		"std" => "Uncategorized",
		"type" => "text"),
	array("name" => "Category Tab 2",
		"id" => $shortname."_category_2",
		"std" => "",
		"type" => "text"),
	array("name" => "Category Tab 3",
		"id" => $shortname."_category_3",
		"std" => "",
		"type" => "text"),
	array("name" => "Category Tab 4",
		"id" => $shortname."_category_4",
		"std" => "",
		"type" => "text"),
	array("name" => "Category Tab 5",
		"id" => $shortname."_category_5",
		"std" => "",
		"type" => "text"),
	array("name" => "Category Tab 6",
		"id" => $shortname."_category_6",
		"std" => "",
		"type" => "text"),
	array("name" => "Category Tab 7",
		"id" => $shortname."_category_7",
		"std" => "",
		"type" => "text"),
	array("name" => "Category Tab 8",
		"id" => $shortname."_category_8",
		"std" => "",
		"type" => "text")
);
function theme_add_admin() { global $themename, $shortname, $options; if ( $_GET['page'] == basename(__FILE__) ) { if ( 'save' == $_REQUEST['action'] ) { foreach ($options as $value) { update_option( $value['id'], $_REQUEST[ $value['id'] ] ); } foreach ($options as $value) { if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } } header("Location: themes.php?page=functions.php&saved=true"); die; } else if( 'reset' == $_REQUEST['action'] ) { foreach ($options as $value) { delete_option( $value['id'] ); } header("Location: themes.php?page=functions.php&reset=true"); die; } }  add_theme_page($themename." Options", "Structure Options", 'edit_themes', basename(__FILE__), 'theme_admin'); } function theme_admin() { global $themename, $shortname, $options; if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>'; if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';?><div class="wrap"><h2><?php echo $themename; ?> settings</h2><form method="post"><table class="optiontable"><?php foreach ($options as $value) { if ($value['type'] == "text") { ?><tr valign="top"><th scope="row"><?php echo $value['name']; ?>:</th><td><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td></tr><?php } elseif ($value['type'] == "select") { ?><tr valign="top"><th scope="row"><?php echo $value['name']; ?>:<br /><small><?php echo $value['desc']; ?></small></th><td><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td></tr><?php } } ?></table><p class="submit"><input name="save" type="submit" value="Save changes" /><input type="hidden" name="action" value="save" /></p></form><form method="post"><p class="submit"><input name="reset" type="submit" value="Reset" /><input type="hidden" name="action" value="reset" /></p></form><?php } function theme_wp_head() { ?> <?php } add_action('wp_head', 'theme_wp_head'); add_action('admin_menu', 'theme_add_admin'); ?>