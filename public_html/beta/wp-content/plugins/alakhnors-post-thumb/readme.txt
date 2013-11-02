=== Post Thumb Revisited ===
Contributors: Alakhnor.
Tags: formatting, media, images, thumbnail, youtube, video, mp3, admin, swfobject, swf, flash, widget, post
Donate link: http://www.alakhnor.com/post-thumb/?page_id=2
Requires at least: 2.1
Stable tag: 2.1.9

Post-Thumb Revisited automatically creates and displays thumbnails for posts. Numerous functions and options to modify themes are available.

== Description ==

The plugin scan posts for images. Then, it can do the followings:

 * Loop display: show a thumbnail linked to the post.
 * Sidebar display: it can shows thumbnails from the most recent posts or thumbnails from random posts.

All thumbnails are dynamically created when needed and then saved. So, there is no complex thumbnail management.
The nice Highslide javascript library is included in the plugin and used if desired. It adds nice expansion effect to each link/thumbnail created by post-thumb revisited.

So, Post-Thumb revisited is a thumbnail management system.

Install the plugin, and then, you can add a thumbnail display in the Loop by a simple function:

        `<?php the_thumb(); ?>`

This will show the thumbnail of the first picture in the post for each post in the Loop.


Or you can add a list of your most recent posts represented by a thumbnail in the sidebar with:

        `<?php the_recent_thumbs(); ?>`

Or one or more random posts in the same way:

        `<?php the_random_thumb(); ?>`

Once you've done this, you do not have to care anymore about thumbnails!

For instance, if you want to change thumbnail size site-wide, just delete the thumbnails on your server, change the settings…done. Next time a page will be loaded, thumbnails will be updated automatically.

Images can be anywhere: anywhere on your server, on a remote server, on FlickR,...


= Two levels of customizing =

The plugin is highly configurable. You can set the parameters in the option screen for the entire site, or change them locally in any function call your theme template may contain.

A lot of settings are available to help you manage thumbnails exactly the way you want:

 * Size of the thumbnails
 * Save name: all thumbnails are save in a folder. You can decide what name to use, even what folder.
 * Quality: quality of thumbnails can be adjusted.
 * Additionnally, a sharpness mask can be applied to further improve quality.
 * Rounded corners can be applied to thumbnails
 * You can add text in the thumbnail
 * Javascript library: in addition, Highslide JS can be used to display image or media.

With this, you can manage how your blog shows just like you wish.

= Simple example =

         `<?php echo get_recent_thumbs('altappend=first_&width=180&height=120&category=1&offset=0&limit=1'); ?>`
         `<?php echo get_recent_thumbs('altappend=main_&width=50&height=50&category=1&offset=1&limit=6'); ?>`

First line will display the first post of category 1 with a size of 180x120. The save name will first_image.xxx.
Second line will display the 6 following posts of category 1 with a size of 50x50. The save name will main_image.xxx.


= Additionnal features =

By adding rel="thumb" to a picture link, you can create and add automatically a thumbnail to any picture in posts.

Highslide: using highslide adds many interesting features:

 * you can automatically add an expand link to each thumbnail/picture.
 * You can automatically play youtube video in an expanded frame
 * In connection with wordTube, you can play mp3/flv in expanded frames
 * With these options checked, video, mp3 and youtube are acting just like a picture (thumbnail and link)
 * Isn't that better than the ugly youtube-like players you usually see everywhere?


= Formatting display =

Post-Thumb uses only standard html code. So, all formatting will go through css. If needed, some tags or classes can be added to the thumbnails.



== Installation ==

1. Unzip the file
2. Upload the "post-thumb" folder to your Wordpress plugins folder.
3. Activate it from the admin panel.
4. Navigate to the options->post thumb and configure each option before using.

Important: You must configure the location settings correctly or it will not work.



== Detailed options ==

Leave default settings if you're unsure of what to set. On savings, main options will be checked and an error message will be return if a problem has been detected.


= Location settings =

"Base path", "Full domain name" and "Folder name" need to be set properly or the plugin won't work.

 * Base path: Absolute path to website. For example, /httpdocs or /yourdomain.com. Used to find location of thumbnails on server. http://yourdomain.com/images/pth/thumb_picture.jpg would actually be /httpdocs/images/pth/thumb_picture.jpg. No trailing '/'. In most cases, default value will be ok.
 * Full domain name: Full domain name. Includes the http://. No trailing '/'. In most cases, default value will be ok.
 * Folder name: Set the relative path to thumbs. Make sure directory exists and is writable (chmod 777). No trailing '/'
 * Default image: The location of the default image to use if no picture can be found. Enter in the relative url. Example: images/default.jpg for http://yourdomain.com/images/default.jpg.
 * Use meta data: check blog metadata for pictures. If a picture is entered in metadata "pt_meta_thumb", it will be used to create post thumbnail.
 * Use Category Names: If category names are used, this will override Default Image and Default Image for Videos. Category images should be located in the same folder as default image.
 * System check: the plugin will check for the server to see if it is compliant with post-thumb.
 ** Remote files: will check if fopen is allowed or cURL available
 ** PHP version: Dealing with remote file also requires php 4.3.0 or later
 ** GD version: GD 2 is required


= Filename settings =

 * Append: Choose to put text before image name or after. Unchecking will put text before.
 * Append / Prepend text: Choose text to append or prepend image with. Example: thumb_yourimage.jpg


= Video image settings =

 * Video regex: If you want to scan a post for a video and use a default image. Uses regex to scan for video.
 * Video default image: The location of the default image to use if a video is found. Enter in the relative url. Example: images/defaultvideo.jpg for http://yourdomain.com/images/defaultvideo.jpg.


= Stream Video image settings =

 * Stream Check: If you want to scan a post for a stream video. Supports Youtube, Gvideo and Dailymotion. Will display a thumb for each specific source.


= Image settings =

 * Resize width x height: size of the thumbnails.
 * Quality for jpeg: quality of the thumbnail if image is a jpg file. From 0 to 100 (best quality, highest size). Default: 75
 * Compression for png: quality of the thumbnail if image is a png file. From 0 (no compression, best quality) to 9. Default: 6. This option will only appear if php version is greater than 5.1.2.
 * Keep ratio: Check this option if you want to apply original picture ratio to thumbnails. Choose your resize width and height. Will resize in proportion to original width and height. If you do not care about proportions, uncheck keep ratio.
 * Use rounded corner: save thumbnails with rounded corners.
 * Corner ratio: set the corner size if "rounded corner" is checked. From 0 to 1. Typical: 0.15
 * Use png: Check this option if you want to save thumbnails in .png format. Checking this option will increase thumbnail size but will be used anyway if rounded corners is checked.
 * Use unsharp mask: Check this option if you want to apply a sharpness filter to thumbnails. WARNING: checking this option slows down the thumbnail creation.
 * Unsharp amount: From 0 to 100. Typical: 80
 * Unsharp radius: From 0 to 1. Typical: 0.5
 * Unsharp threshold: From 0 to 5. Typical: 3


= Javascript settings =

These settings define highslide appearance.

 * Use Highslide: Unckecking this will disable all Highslide effects.
 * Picture frame border style: choose border style for pictures.
 * Other frame border style: choose border style for other expanded frames.
 * Frame color: color of the background of the frame.
 * Use Highslide in posts: checking this option will enabled wordTube detection, youtube tags and adding HS expansion to thumbnails in posts.
 * Detect wordTube Media: enabled/disable wordTube detection.
 * wordTube size (width x height): Wordtube thumbnail size.
 * wordTube text: Text to prepend to wordtube thumbnail name.
 * Detect Youtube video: enable/disable youtube tags.
 * Youtube display size (width x height): Youtube thumbnail size.
 * Youtube play size (width x height): Size of the frame to play Youtube video.


= Additionnal settings =

 * Replace image by thumbnail in posts: Check this option if you want Post-Thumb to replace images by thumbnails in posts.
 The following settings define how thumbnails are created if the previous option is checked:
 * Resize width x height: size of the thumbnails.
 * Append / Prepend text: Choose text to append or prepend image with. Example: pthumb_yourimage.jpg
 * Keep ratio: Check this option if you want to apply original picture ratio to thumbnails.
 * Use rounded corner: save thumbnails with rounded corners.
 * Use png: Check this option if you want to save thumbnails in .png format.
 * Use unsharp mask: Check this option if you want to apply a sharpness filter to thumbnails.


== Formatting display ==

 Post-thumb returns pure html code. Therefore, displaying can be fully managed with CSS.
 You can also add your own class to the thumbnail if you need.
 This is done with the MYCLASSIMG or MYCLASSHREF parameters.



== Loop functions ==

 get_thumb()
 the_thumb()


== Sidebar functions ==

 get_recent_thumbs()
 the_recent_thumbs()
 get_random_thumb()
 the_random_thumb()



== Additional template constant ==

 POSTHUMB_INFRAME. This constant is defined when you call any page of your blog. It is set to 0 for a direct call and is set to 1 if the call is done through an expandable link.

 It lets you change the template you want to display in popup frames.

 Example:
		`<?php if (POSTHUMB_INFRAME == 0) { ?>
			<?php get_sidebar(); ?>
		<?php } ?>`

		This will not display the sidebar if the page is displayed in a popup frame.



== Parameters ==

 Each function can be used with numerous parameters to manage display or how or where thumbnails are saved. You do not have to use them unless you want different settings from the default options you have choosen in the option screen.

 Each parameter should be input with its value separated with '=' and separated from the other parameters with '&'.

 Example:
		`<?php get_recent_thumbs('WIDTH=100&HEIGHT=80&ROUNDED=1&LIMIT=12'); ?>`



= Display parameters =

 * WIDTH: resize width. Overides default if greater than 0.
 * HEIGHT: resize height. Overides default if greater than 0.
 * HCROP: horizontal crop. Crops if greater than 0.
 * VCROP: vertical crop. Crops if greater than 0.
 * KEEPRATIO: if set to 1, image ratio is kept. Overides default if it exists.
 * ROUNDED: creates thumbnails with rounded corners. Overides default if it exists.



= Addtitional display parameters =

 * TEXTBOX:  write a text in the bottom = 1. Default is 0.
 * TEXT:  text to be written if TEXTBOX is set to 1.
 * SHOWTITLE: display title, author or date below the thumbnail. Parameters: T, A, D.
 * TITLE: choose wether content (C), excerpt (E) or title (T) is used in title tag of the thumbnail. Default is 'T'.
 * MYCLASSHREF: output class name in html `<a class="myclasshref" href=...>`
 * MYCLASSIMG: output class name in html `<img class="myclassimg" href=...>`
 * LB_EFFECT: use highslide to display image or link.
 * CAPTION: display or not the caption for pictures.



= Savings parameters =

 * ALTAPPEND: text to append to create thumbnail name. Overide default if exists.
 * BASENAME: force generation of thumbnail and use generic name. Default is 0. Used in the random function.
 * SUBFOLDER: name of the subfolder to save thumbnails in. Only one level, no wrapping '/'.



= Template parameters =

 * USECATNAME: choose if category default image should be used or not. Override default if exists.
 * SHOWPOST: force Highslide to expand on post if set to 1. Default is 0 (expand on image or post)
 * LINK: force Highslide to expand on post if set to p, on url if set to u. Default is i, image (expand on image or post)



= get_recent_thumb parameters =

 * LIMIT: number of posts to display
 * OFFSET: skip posts by the given number. Default is 0.
 * CATEGORY: categories to get posts from, or categories to exclude from search.


= get_random_thumb parameters =

 * LIMIT: number of posts to display.
 * CATEGORY: categories to get random from.



== Post formatting ==

= Image and thumbnail =

 If you insert an image with a thumbnail in your post, with Image Manager for example, the image will be displayed using Highslide.
 This can be enabled/disabled in Options.

 If you add rel="thumb" to a img link in a post, the plugin will automatically creates the thumbnail and replace it.
 Aspect of thumbnails can be set in options. This can be enabled/disabled in Options.

= wordTube Media =

 WordTube media can be detected and displayed with thumbnails. The media will be played in an expanded frame when clicking on the thumbnail.
 See Options to adjust parameters.



= wordTube Playlist =

Post-thumb revisited provides it's own playlist tag for wordTube media playlist.

 * `[PTPLAYLIST=n|WIDTH=xxx|HEIGHT=xxx|MP3/FLV]`
 MP3/FLV will select either one of the two. Default is all (none selected). Playlist with 0 will select all media.
 WIDTH and HEIGHT are the playsize of the media.




== Inserting Youtube video ==

Youtube video can be inserted in post. The tag will display a thumbnail and the video will be viewed in an expanded frame when clicking on it.

 * `[YOUTUBE=(video ID) title=(video title)]`




== Widgets ==

Widgets are gathered in the Post-thumb widgets plugin. It needs to be activated too. If your theme is widget ready, then the following functions will be available:

Supported functions:

 * pt-random: returns thumbnails from random posts
 * pt-recent: returns thumbnails from most recent posts
 * pt-recent-video: returns thumbnails & link to wordTube media from most recent posts
 * pt-recent-youtube: returns thumbnails & link to youtube from most recent posts
 * pt-categories: list categories. Same as wp_list_categories but adds a popup link.
 * pt-bookmarks: list bookmarks. Same as wp_list_bookmarks but opens link in a popup frame.
 * pt-last-youtube: display last youtube from a given youtube user

Unsupported:

 * pt-slideshow
 * pt-news
 * pt-wordTube: to display a thumbnail linked to a wordTube media in the sidebar


== Support ==

Support can be found on plugin homepage: http://www.alakhnor.com/post-thumb

You can also view project here: http://trac.herewithme.fr/project/post-thumb/



== Additional note: Unsharp ==

An "unsharp mask" is actually used to sharpen an image, contrary to what its name might lead you to believe.  Sharpening can help you emphasize texture and detail, and is critical when post-processing most digital images.  Unsharp masks are probably the most common type of sharpening, and can be performed with nearly any image editing software (such as Photoshop). An unsharp mask cannot create additional detail, but it can greatly enhance the appearance of detail by increasing small-scale acutance.

Amount: controls the magnitude of each overshoot.  This can also be thought of as how much contrast is added at the edges.

Radius: controls the amount to blur the original for creating the mask.  This affects the size of the edges you wish to enhance, so a smaller radius enhances smaller-scale detail.

Threshold: sets the minimum brightness change that will be sharpened.  This is equivalent to clipping off the darkest non-black pixel levels in the unsharp mask.  The threshold setting can be used to sharpen more pronounced edges, while leaving more subtle edges untouched.  This is especially useful to avoid amplifying noise, or to sharpen an eye lash without also roughening the texture of skin.
