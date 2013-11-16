<?php

$pageinfo = array('full_name' => __("Neo Options",'neo_wdl'), 'optionname'=>'main', 'child'=>false, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),
	
    array(	"name" => __("Show breadcrumb",'neo_wdl'),
			"desc" => "Do you want to show breadcrumbs?",
            "id" => "breadcrumb_show",
            "type" => "radio",
            "buttons" => array(__('Yes','neo_wdl'),__('No','neo_wdl')),
            "std" => 1),
						
	array(	"name" => __("How many posts in Featured posts Slider?",'neo_wdl'),
			"desc" => __("Enter a number.",'neo_wdl'),
    		"id" => "number_posts",
    		"std" => "5",
    		"type" => "text"),
	
	array(	"type" => "close"),
						
	array(	"name" => __("Socials",'neo_wdl'),
    		"type" => "title"),

	array(	"type" => "open"),
						
	array(	"name" => __("Twitter ID",'neo_wdl'),
			"desc" => __("Enter your Twitter Id.",'neo_wdl'),
    		"id" => "twitter_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Reddit Url",'neo_wdl'),
			"desc" => __("Enter your Reddit url.",'neo_wdl'),
    		"id" => "reddit_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Delicious Url",'neo_wdl'),
			"desc" => __("Enter your Delicious url.",'neo_wdl'),
    		"id" => "delicious_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Technorati Url",'neo_wdl'),
			"desc" => __("Enter your Technorati url.",'neo_wdl'),
    		"id" => "technorati_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Facebook Url",'neo_wdl'),
			"desc" => __("Enter your Facebook url.",'neo_wdl'),
    		"id" => "facebook_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Stumbleupon Url",'neo_wdl'),
			"desc" => __("Enter your Stumbleupon url.",'neo_wdl'),
    		"id" => "stumbleupon_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Youtube Url",'neo_wdl'),
			"desc" => __("Enter your Youtube url.",'neo_wdl'),
    		"id" => "youtube_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Myspace Url",'neo_wdl'),
			"desc" => __("Enter your MySpace url.",'neo_wdl'),
    		"id" => "myspace_id",
    		"std" => "",
    		"type" => "text"),
						
	array(	"name" => __("Digg Url",'neo_wdl'),
			"desc" => __("Enter your Digg url.",'neo_wdl'),
    		"id" => "digg_id",
    		"std" => "",
    		"type" => "text"),
	
	array(	"type" => "close"),
						
	array(	"name" => __("Ads",'neo_wdl'),
    		"type" => "title"),
	
	array(	"type" => "open"),
						
	array(	"name" => __("468x60 Ad below post in Archives page.",'neo_wdl'),
			"desc" => __("Enter Ad Code.",'neo_wdl'),
    		"id" => "ads_archives_468",
    		"std" => '',
    		"type" => "textarea"),
						
	array(	"name" => __("468x60 Ad below post in Single page",'neo_wdl'),
			"desc" => __("Enter Ad Code.",'neo_wdl'),
    		"id" => "ads_single_468",
    		"std" => '',
    		"type" => "textarea"),
						
	array(	"name" => __("300x250 Ad above post in Single page.",'neo_wdl'),
			"desc" => __("Enter Ad Code.",'neo_wdl'),
    		"id" => "ads_single_300",
    		"std" => '',
    		"type" => "textarea"),
						
	array(	"name" => __("300x250 Ad in Comment form",'neo_wdl'),
			"desc" => __("Enter Ad Code.",'neo_wdl'),
    		"id" => "ads_comment_form_300",
    		"std" => '',
    		"type" => "textarea"),
	
	array(	"type" => "close")

	
);

$options_page = new am_option_pages($options, $pageinfo);

?>