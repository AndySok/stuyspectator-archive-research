<div id="sidebar">
<?php 

/* You can choose any sidebar element you want on any page by commenting out (placing "//" in front of the area you don't want) or by removing the comment (remove "//" from in front of a php line to display what you want). */

	// Include tabs (tabs aren't widgetized yet - must edit them manually in tabs.php)
	include(TEMPLATEPATH . '/tabs.php');

// widgets
if( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar') ) : else : 

// Sidebar for home.php ******************************************
if(is_home()) { 

	// Include ads
	include(TEMPLATEPATH . '/ads.php');

	// Include flickr sidebar block
	include(TEMPLATEPATH . '/flickr.php');

	// Include custom sidebar block
	// include(TEMPLATEPATH . '/custom-block.php');

	// Include tags (WordPress 2.3 +)
	// include(TEMPLATEPATH . '/tags.php');

	// Include video
	// include(TEMPLATEPATH . '/video.php');

	// Include recent posts (recent.php)
	// include(TEMPLATEPATH . '/recent.php');
	}

// Sidebar for single.php and page.php ******************************************
if(is_single() || is_page()) {
	// Include ads
	include(TEMPLATEPATH . '/ads.php');

	// Include flickr sidebar block
	include(TEMPLATEPATH . '/flickr.php');

	// Include custom sidebar block
	// include(TEMPLATEPATH . '/custom-block.php');

	// Include tags (WordPress 2.3 +)
	include(TEMPLATEPATH . '/tags.php');

	// Include video
	// include(TEMPLATEPATH . '/video.php');

	// Include recent posts (recent.php)
	// include(TEMPLATEPATH . '/recent.php');
	} 

// Sidebar for all archives (archive, category, author, etc.) and search *************************
if(is_archive() || is_search() || is_404()) { 
	// Include ads
	include(TEMPLATEPATH . '/ads.php');

	// Include flickr sidebar block
	include(TEMPLATEPATH . '/flickr.php');

	// Include custom sidebar block
	// include(TEMPLATEPATH . '/custom-block.php');

	// Include tags (WordPress 2.3 +)
	include(TEMPLATEPATH . '/tags.php');

	// Include video
	// include(TEMPLATEPATH . '/video.php');

	// Include recent posts (recent.php)
	// include(TEMPLATEPATH . '/recent.php');
	} 

endif; // end widgets
?>
<!-- IE6 bug fix / Do not remove -->
<p class="ie6-bug">&nbsp;</p>
</div><!-- sidebar -->