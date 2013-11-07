/* 
Theme Name: Structure
Theme URI: http://justintadlock.com/archives/2007/12/09/structure-wordpress-theme
Description: A theme for news/magazine sites with a blog-friendly option too.  It includes built-in video and image features that easily allow you to customize your site. There are content blocks that you can place virtually anywhere on the page.
Version: 1.1.5
Author: Justin Tadlock
Author URI: http://justintadlock.com
Copyright (c) 2007 - 2008 Justin Tadlock
*/

/* IMPORTANT **************************** */
The most recent version of this instructions file is located at: 
http://justintadlock.com/projects/wordpress-themes/structure/instructions
That page is the source you should read.  It is better organized and more up to date.

As a text file, this readme has gotten a little uncontrollable, so I'll probably update it with an XHTML version later.

********************
UPDATES
********************

Future update plans:
- Update this readme file.
- Use _() and _e() for people that want to easily translate the theme.

VERSION 1.1.5 ***
- Add this below the <body> tag to check what versions users are using for theme-support purposes:
	<?php // Structure Version Check
	echo '<!-- Structure theme: Version 1.1.5 -->'; ?>

- In "style.css," I fixed a couple of errors in the CSS (see "new-style-rules.css").
- In "video.php," I changed the ID of the video object, so it would not conflict with the ID of the video in the sidebar when on a single post page (only relevant if user is using the video block in the sidebar).
	- Changed id="video" to id="video-block-"
	<object type="application/x-shockwave-flash" data="<?php echo $video[0]; ?>" style="width: 290px; height: 242px; border: none; padding: 0; margin: 0;" id="video-block-<?php echo $i; ?>">
- Fix the "full posts" from resizing images.
- Deleted "sidebar-single.php" and "sidebar-archive.php" because they weren't being used anyway.  Their functionality was already added to "sidebar.php."  This makes no changes for previous version users.
- Added the class "full-posts" to the main div in "full-posts.php" at the top of the file.
	<div class="excerpts full-posts">
- Added a new style rule (see "new-style-rules.css") so images in the Full Posts layout option won't resize.
- Added a new style rule for list items on the home page (see "new-style-rules.css").
- Updated for multiple-paged WordPress Pages.  The previous tag was depreciated.  In "page.php," change this replace this line (thanks to WordPress Modder <http://wordpressmodder.org> for pointing this out):
	<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
With this:
	<?php wp_link_pages('before=<p><strong>Pages:</strong>&after=</p>'); ?>
- Added the ability to have multiple-paged posts.  Below the call for the_content() in "single.php," I added this line:
	<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
- See <http://codex.wordpress.org/Template_Tags/wp_link_pages> for details on how to create multiple-paged posts and pages.

VERSION 1.1.4 *** 
- In "header.php," I changed the variable for the feed email to $feed_email instead of $feed.

VERSION 1.1.3 ***
- Placed the <p> outside of the_tags fuction in "single.php."
- Deleted the extra "s" on "1 Comments" in "features.php."
- Deleted the extra "l" in the title of one of the feed links in "header.php."
- Added a "Full Posts" layout option
	-- Changes were made to "functions.php" and "home.php."
	-- A new file called "full-posts.php" was added.
- Several CSS changes were made (see "new-style-rules.css") for the "Full Posts" style option and a few minor bugs.
- Updated the license details so others can more easily understand its details.

*** Quick fix (between version updates)
- "Response to" in comments.php

VERSION 1.1.2 ***
- Fixed (I hope) "recent.php" to query correctly in all instances of its use.
	-- Thanks to Mr Papa (http://klasen.us) for helping me iron out the details and squash bugs.
- Fixed a style error with the left and right content blocks on "home.php" (see "new-style-rules.css").
- Added an option to display the feature article and flickr and feed options to the "Structure Options" panel under "Presentation."
- Changed some styling in case someone decided to not display the feature post.

VERSION 1.1.1 ***
- Release for a quick bug fix (Firefox video problem in sidebar)
-- Fixed Video "content block" problem with Firefox when a user uses widgets to put the video block in the sidebar.

- Fixed the $do_not_duplicate problem with "recent.php."  Now, the file always displays the three most recent posts, while skipping the "feature" post, no matter if it was one of the last three posts.
	- Note: Still working on other potential ways to fix this.
- Fixed issues with how custom fields are read in "recent.php" and "video.php." (Video was working fine, but I wanted to make it better.)
- Cleaned up much of the code in "tabs-categories.php."
- Cleaned code in a few different files.
- Added "new-style-rules.php" for changes in the style.
	- The comments section "<pre><code></pre></code>" and "<pre></pre>" elements were too wide for their containing elements.

VERSION 1.1 ***
- Added a theme options page for the category tabs and theme style.
- Widgetized the left and right blocks on home.php and sidebar.php (sidebar stays the same across all pages with this option).
- Created Widgets for all my content blocks previously packaged with the theme, so that the user can more easily move different blocks of content around.

***************************************
BEFORE USING THE STRUCTURE THEME
***************************************
Before you decide to use this theme, you should know that this takes a little bit of extra work because of adding custom fields and/or optional excerpts.  It's not hard once you learn how to do it, but if you don't want to learn, that's okay too.  Of course, you can use this theme without custom fields or optional exerpts, but the beauty of it will be lost.  

This theme is WordPress 2.3-compatible and up.  You can change the feature article thing below to make it compatible with 2.1+.

Please direct all questions to the theme's page.  I will not answer questions through my contact page or email.

This is in no way a complete readme.txt file.  There's so much you can do with this theme as far as customization goes that it would take me forever to write the entire thing.  I'll try to continously update it and make it better.

*****************
INSTALLATION
*****************
- Unzip the downloaded file. You'll get a folder named "structure"
- Upload the "structure" folder to your "themes" folder
- Login into WordPress admin panel
- Click on the "Presentation" tab
- Click on the "structure" theme screenshot or title
- Then just take a look at your blog and hit refresh to see the new theme..

- I suggest downloading the latest version of WordPress at (http://wordpress.org/download)

**********************
THEME OPTIONS
**********************
- Easily set your theme's options.

This theme comes packaged with 2 different home pages styles, "Default" and "Excerpts" and a category tabs section that displays 2 posts from the categories of your choice.  The theme options page helps you display this easily.

- In your WordPress Dashboard, under the "Presentation" tab, click "Structure Options."  This will take you to a page that will allow you to customize a few things.

OPTIONS ***
- Theme Style 
Choose either "Default" or "Excerpts" for your overall layout

- Display Feature Article?
Select "Yes" or "No" to display a feature article on "home.php."

- Feed URL
Enter your feed URL for the feed section on the front page (defaults to blog's normal RSS feed).

- Feed by Email URL
Enter your feed's email URL (defaults to blog's normal RSS feed).

- Flickr URL
Enter the URL to your Flickr photostream if you're using the FlickrRSS plugin (defaults to http://flickr.com).

- Display Category Tabs? 
Select "Yes" or "No" to display your category tabs section on "home.php."

- Category 1-8 
Input your category slug (probably the same as your category name) for each category you want to display.  
Note, you don't have to use every category, and I suggest only using as many that will fit on the page properly (you'll have to test how this looks on your page).

Read farther down the page for specific information on how to manually input this information.

*******************
WIDGETS
*******************
- Version 1.1 updates the use of widgets with this theme.

- I've created widgets for each previous content block in Version 1.0 (ads.php, ads2.php, tags.php, flickr.php, custom-block.php, video.php, and recent.php).  

- You have to option to put widgets on the left and right content blocks below the category tabs on "home.php" and your sidebar. 
- I've created several widgets that are specific to this theme that you can move around.  You'll notice them by their name prefix of "Structure."  For example, the video widget is named "Structure Video." 

- If you want to edit any of the widgets, you'll have to open the corresponding ".php" file in your theme directory.  For example, you'll need to change the Flickr link that says "View flickr photostream >>" if you use the "Structure Flickr" widget.  So, you have to edit "flickr.php" in your theme directory.

- I suggest using any "Structure" widget for your needs first because they were designed for this theme specifically.

- The default "FlickrRSS Widget" doesn't work well with the theme, so I created the new widget "Structure Flickr."  Of course, you'll need the Flickr RSS plugin for that to work anyway (http://eightface.com/wordpress/flickrrss/).

- Note that "tabs.php" (the Sidebar Tabs) is not widgetized.  If you want to edit their content or remove them, you'll have to do so through the file "sidebar.php."
- Note that you can no longer have different sidebars on "home.php," "archive.php," "single.php," and so on if you use widgets on your sidebar (this doesn't include widgets on the home content blocks).

**********************
KNOWN ISSUES
**********************
- In Firefox, the tabs (latest, popular, etc) might not display if you add them to #home-bottom below anything else.  It works if at the top of the block and in the sidebar
- Browser text resizing (larger) can cause the tabs to get misaligned if you have too many.

**********************
ADDING VIDEOS
**********************
VIDEOS FROM YOUTUBE, GOOGLE, ETC.: ===================================
Adding videos is easy if you've used custom fields before.
- Read: http://codex.wordpress.org/Using_Custom_Fields - WordPress custom field guide.
- Read: http://justintadlock.com/archives/2007/10/24/using-wordpress-custom-fields-introduction - my personal tutorial on custom fields.

To add a video from YouTube, Google, or Metacafe:
- Find the video that you want and grab the embed code.
-- YouTube example: Here's a video I have on YouTube - http://www.youtube.com/watch?v=2VOQgMMErxA
-- The embed code is:

	<object width="425" height="355"><param name="movie" value="http://www.youtube.com/v/2VOQgMMErxA&rel=1"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/2VOQgMMErxA&rel=1" type="application/x-shockwave-flash" wmode="transparent" width="425" height="355"></embed></object>

-- We want to strip that down to the simplest thing we can get it to: the URL.
	http://www.youtube.com/v/2VOQgMMErxA&rel=1
-- Now, remove the &rel=1 from the end because we don't need that.
-- You URL should now look like:
	http://www.youtube.com/v/2VOQgMMErxA

- Create a custom field Key named "Video" (it must be capitalized - case-sensitive)
- In the Value field, add the URL http://www.youtube.com/v/2VOQgMMErxA

- Now, you can write your post, but it has to be in a Category named "Video."
- Your video will now show up in the sidebar.

********************
FEATURE ARTICLES
********************
This theme has a feature article that is always listed first on the home page.  
- You need to create a tag named "Features" or open home.php and change the features tag to whatever you want to name it.
- Add the tag "features" to whatever post you want featured.

- If you would rather put your posts in a featured category, then you'll have to modify the code a bit.  
	**** YOU MUST DO THIS FOR WORDPRESS VERSIONS PRIOR TO 2.3 ***
- Create a category called features.
- Open "features.php"
	Change:
		$my_query = new WP_Query('tag=features&showposts=1')
	To this:
		$my_query = new WP_Query('category_name=features&showposts=1');


FEATURE IMAGE
- You need to add an image in the custom fields box.
- Create a Key named "Feature Image"
-- Give it a value of the URL to your image (see: http://codex.wordpress.org/Using_Image_and_File_Attachments if you don't know how to upload images).

Optional: Create a Key named "Feature Alt" and give it a value of "the alt text you want."  If you don't, the alt text will default to the the post title.

Feature image size is scaled down to 300px by 175px, so it would be best to give your images these dimensions for maximum compatibility and quality.  You can change this by opening "sytle.css" and changing the width and height values under "#home .feature img."

*******************
POST THUMBNAILS
*******************
You can add thumbnail images with each post.

- Create a custom field Key named "Thumbnail" and give it a Value of the URL of your image.
- Optional: create a Key named "Thumbnail Alt" and give it a Value of the alt text you want displayed (defaults to post title).
- Thumbnails are scaled down to 75px by 75px.  I suggest making your images this size before uploading for the best quality.

********************
SINGLE.PHP IMAGES
********************
- To add an image (besides the thumbnail or feature image) to single.php do this.
- Create a custom field Key named "Image" and give it a Value of the URL of your image.
- Optional: Create a Key named "Image Alt" and give it a Value of the alt text you want displayed.
- Optional: Create a Key named "Image Class" and give it a Value of any CSS class you want to use.

- If you don't want to display a specific image, but have created a Thumbnail or Feature Image, the Thumbnail or Feature Image will be displayed.

*******************
HOME.PHP DISPLAY
*******************
- There are 2 different styles that you can set your home page to, "default" and "excerpts."
- It is currently set to the "default" style.
- The code looks like this:
	// $style = "excerpts";
	$style = "default";
- To change it to display the "excerpts" style, replace the code with this:
	$style = "excerpts";
	// $style = "default";

- I may add a "Theme Options" page in the WordPress dashboard for this in the future.  Look for updates.

*******************
CATEGORY TABS
*******************
- The category tabs section (under the feature article on home.php) must be modified either through the Theme Options or manually.
- I've updated "tabs-categories.php" with notes on how to manually change your category tabs.  See "THEME OPTIONS" above to easily do this through the "theme options" page.

*******************
CONTENT BLOCKS
*******************
- Note: This only works for the default home page style. 
- Version 1.1, you can now change these through the use of Widgets, but lose some of the control you might've previously had by doing so.

- This theme has many different "blocks" that can be moved around.  Each is around 300px wide, and the layout of the theme is 3 columns side by side. 3x300.

- You can open "sidebar.php" or "home.php" and comment out or uncomment any blocks you want.  You can also move the order of these around.  You should see how this is structured in those files and shouldn't have too much trouble.  Feel free to ask if you do though.

- There is a filed named "custom-block.php" that you can customize how you want.  It currently has the flickr photo feature in it.

Note:  I'll probably update this section of the readme file later.

- I may add a "Theme Options" page in the WordPress dashboard for this in the future, or I might just make everything widgets.  Look for updates.

*********************
SMALL EXCERPTS
********************
- In "recent.php" there is an option to make smaller excerpts by creating a key named "Excerpt" and giving it a value of a shorter Excerpt than normal.  This way, it won't conflict with your normal excerpts on other pages than "home.php"

- This is just a small aesthetic thing, but could be a feature that makes your theme look better if you use the "recent.php" block.

*********************
SUPPORTED PLUGINS
*********************
- Flickr RSS: http://eightface.com/wordpress/flickrrss/
- Related Posts: http://wasabi.pbwiki.com/Related%20Entries
- Alex King's Popularity Content http://wordpress.org/extend/plugins/popularity-contest/

**************************
ADDING TO THE SIDEBAR
**************************
The best place to customize the sidebar with extra things is sidebar-bottom.php.  It's kind of an open part of the sidebar that you can do a lot with.  Currently, it has the code for the flickr RSS plugin in it, but you can add anything else you want.  Or, you can create new sidebar-nameofsidebar.php files and include them in footer.php.  You can see the other included files there to see how this is done.

************************************
ALIGNING IMAGES & OTHER THINGS
************************************
There are 3 CSS classes that you can use to align things: left, right, center.
- Example: <img class="left" src="image.gif" /> will align your image to the left.

- You can clear floats with the CSS class "clear"

*****************
CREDITS
*****************
Thanks to this article (http://www.communitymx.com/content/article.cfm?cid=b0029) by Zoe Gillenwater, I figured out a thing or two with negative margins that was giving me trouble -- trying to do something that was probably impossible with the tabs.  So, I opted to use relative positioning (http://www.w3schools.com/css/pr_class_position.asp).

*****************
LICENSE
*****************
Copyright (c) 2007 - 2008 Justin Tadlock
(a copy of the legal code is included with your download in the license.txt file)