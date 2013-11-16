/* 
Theme Name: Visionary
Theme URI: http://justintadlock.com/
Description: A theme for news/magazine sites.  It includes built-in video features that easily allow you to add videos to your site.
Version: 1.1.2
Author: Justin Tadlock
Author URI: http://justintadlock.com
Copyright (c) 2007 - 2008 Justin Tadlock
*/

*******************************
UPDATES
*******************************
Version 1.1.1 (December 5, 2007)
- Fixed a minor bug in "sidebar-tags.php"
	- It is now compatible with WordPress version prior to 2.3

*******************************
BEFORE USING VISIONARY
*******************************
Before you decide to use this theme, you should know that this takes a little bit of extra work because of adding custom fields and/or optional excerpts.  It's not hard once you learn how to do it, but if you don't want to learn, that's okay too.  Of course, you can use this theme without custom fields or optional exerpts, but the beauty of it will be lost.  Also, using Sidebar Widgets will make the Tabbed sidebar disappear.

Please direct all questions to the theme's page.

*****************
INSTALLATION
*****************
- Unzip the downloaded file. You'll get a folder named "visionary"
- Upload the "visionary" folder to your "themes" folder
- Login into WordPress admin panel
- Click on the "Presentation" tab
- Click on the "visionary" theme screenshot or title
- Then just take a look at your blog and hit refresh to see the new theme.

- Upload the "/plugins/visionary" folder to your "plugins" folder (just the /visionary part).
- Click on the Plugins tab in your admin panel and activate "Visionary" to use the custom plugin for this theme.

- I suggest downloading the latest version of WordPress at (http://wordpress.org/download)

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

USING THE FLASH VIDEO PLAYER PLUGIN: ============================================
- You must have the plugin from http://www.mac-dev.net/blog installed.
- Open "/plugins/flash-video-player/flash-video-player.php" because we need to add one line of code.
- Scroll to the bottom of the file and find:
	add_filter('the_content', 'FlashVideo_Parse');
- Under this add:
	add_filter('the_excerpt', 'FlashVideo_Parse'); 
- Now, save the file and close it.

- To add videos with this plugin, you must put them in the Optional Excerpt box in the Write Page panel.
- Add this to the Optional Excerpt box:
	[flashvideo filename="/wp-content/uploads/videos/visionary.flv" width="275" height="230" /]
- You obviously need to change the file name to the video you want to play.
- Leave the width and height the same.  Otherwise, you will break the layout because the video will be too big for the sidebar.
- You also need to put this in the post box to add to a post.  You can change the width and height when doing this, but not in the Optional Excerpt portion.
- Please don't ask me support questions about this plugin.  Ask the plugin developer.

********************************************
REMOVE VIDEOS FROM NORMAL HOME LOOP
********************************************
- Open home.php and find at the top of the file:
	query_posts("cat=-157");
- Change the number that's there to the ID of your Video category.
- This will remove them from the loop because they are already in your sidebar.

********************
FEATURE ARTICLES
********************
This theme has a feature article that is always listed first on the home page.  
- You need to create a category named "Features" or open home.php and change the feature category to whatever you want to name it.
- Add posts that you want featured to the "Features" category.

FEATURE IMAGE
- You need to add an image in the custom fields box.
- Create a Key named "Feature Image"
-- Give it a value of the URL to your image (see: http://codex.wordpress.org/Using_Image_and_File_Attachments if you don't know how to upload images).

Optional: Create a Key named "Feature Alt" and give it a value of "the alt text you want."  If you don't, the alt text will default to the the post title.

Feature image size is scaled down to 300px by 175px, so it would be best to give your images these dimensions for maximum compatibility and quality.

*******************
POST THUMBNAILS
*******************
You can add thumbnail images with each post.

- Create a custom field Key named "Thumbnail" and give it a Value of the URL of your image.
- Optional: create a Key named "Thumbnail Alt" and give it a Value of the alt text you want displayed (defaults to post title).
- Thumbnails are scaled down to 75px by 75px.  I suggest making your images this size before uploading for the best quality.

*******************
SIDEBAR WIDGETS
*******************
Even though this theme supports sidebar widgets, I suggest not using them because this theme wasn't made to use them.
It would be best to customize the sidebar yourself or use the default sidebars.

More sidebar "Modules" (as I call them) will be released for this theme over time.  So, look out for them.
Basically, this will just be little customizations to add to your sidebar without much work.

*********************
SUPPORTED PLUGINS
*********************
- Flickr RSS: http://eightface.com/wordpress/flickrrss/
- Related Posts: http://wasabi.pbwiki.com/Related%20Entries

************************
CUSTOM FIELDS PLUGIN
************************
The custom fields plugin packaged with this theme will let you input your Videos, Feature Images, and Thumbnails easily.
You don't have to use it, but it makes it a little easier for people who haven't used custom fields before.

**************************
ADDING TO THE SIDEBAR
**************************
The best place to customize the sidebar with extra things is sidebar-bottom.php.  It's kind of an open part of the sidebar that you can do a lot with.  Currently, it has the code for the flickr RSS plugin in it, but you can add anything else you want.  Or, you can create new sidebar-nameofsidebar.php files and include them in footer.php.  You can see the other included files there to see how this is done.

************************************
ALIGNING IMAGES & OTHER THINGS
************************************
There are 3 CSS classes that you can use to align things: left, right, center.
- Example: <img class="left" src="image.gif" /> will align your image to the left.

*******************************
HOME PAGE DISPLAY POSTS
*******************************
You need to go to your Admin Panel
- Options
-- Reading
--- Blog Pages > Show at most: [odd number] posts
This will ensure that your display isn't all wacked.  If it's not an odd number, then your layout will break.

You also, as stated earlier, need to remove the video category from the normal loop:
- Open home.php and find at the top of the file:
	query_posts("cat=-157");
- Change the number that's there to the ID of your Video category.
- This will remove vidoes from the loop because they are already in your sidebar.

*****************
LICENSE
*****************
Copyright (c) 2007 - 2008 Justin Tadlock
(a copy of the legal code is included with your download in the license.txt file)