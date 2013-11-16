<?php get_header();

// CHOOSE YOUR STYLE (You can set this through the theme options, but I've left it for code junkies and such)
// Change "Default" to the the style name that you want to use (Every style utilizes the "feature post")
// Style options are: "Default" | "Excerpts" | "Full Posts"
// $style = "Full Posts";
// $style = "Excerpts";
// $style = "Default";

// DISPLAYS YOUR LAYOUT
// If using the "Default" style ***************************************
if($style == 'Default') {

	// Include the features article
	if($show_feature == 'Yes') include(TEMPLATEPATH . '/features.php');

	echo '<div id="home-bottom">';

	// Include category tabs on the home page
	if($show_cats == 'Yes') {
	include(TEMPLATEPATH . '/tabs-categories.php'); }

// BLOCK LEFT (everything in the left column goes here) ***
	echo '<div class="block-left">';
// MAKE BLOCK LEFT WIDGET-READY
if( function_exists('dynamic_sidebar') && dynamic_sidebar('Home Block Left') ) : else : 

	// Include recent posts on the home page
	include(TEMPLATEPATH . '/recent.php');

	// Include custom sidebar block (you design yourself, currently holds flickr photos)
	// include(TEMPLATEPATH . '/custom-block.php');
endif; // End widgetizing

	// End block left
	echo '</div>';

// BLOCK RIGHT (everything in the right column goes here) ***
	echo '<div class="block-right">';
// MAKE BLOCK RIGHT WIDGET-READY
if( function_exists('dynamic_sidebar') && dynamic_sidebar('Home Block Right') ) : else : 

	// Include tabs (latest, popular, etc.) on the home page
	// include(TEMPLATEPATH . '/tabs.php');

	// Include the single video section on your home page
	include(TEMPLATEPATH . '/video.php');

	// Include ads on the home page
	// include(TEMPLATEPATH . '/ads.php');
endif; // end widgetizing

	// End block right
	echo '</div>';
	echo '</div><!-- home-bottom -->';

} // End if using "Default" style

// If using "Excerpts" style ***************************************
if($style == 'Excerpts') {
	// Include the features article
	if($show_feature == 'Yes') include(TEMPLATEPATH . '/features.php');

	echo '<div id="home-bottom">';

	// Include just excerpts of latest posts on the home page
	include(TEMPLATEPATH . '/excerpts.php');

	echo '</div><!-- home-bottom -->';
	}

// If using "Full Posts" style ***************************************
if($style == 'Full Posts') {
	// Include the features article
	if($show_feature == 'Yes') include(TEMPLATEPATH . '/features.php');

	echo '<div id="home-bottom">';

	// Include just excerpts of latest posts on the home page
	include(TEMPLATEPATH . '/full-posts.php');

	echo '</div><!-- home-bottom -->';
	}
get_footer(); ?>