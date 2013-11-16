<?php
// Prepare for localization
load_theme_textdomain ('wyntonmagazine');

//Widgetized sidebar
if ( function_exists('register_sidebar') )
    register_sidebars((2),array(
        'before_widget' => '<div class="sidebar_widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
?>