=== Plugin Name ===
Contributors: 
Donate link: 
Tags: ads, server, banner, post, comment, posts, comments, advertising, adv, server, serve, ad
Requires at least: 2.0.2
Tested up to: 2.3.1
Stable Tag: 0.3

AdServe is the advertising server for WordPress. You could setup your banner campaigns
using different sized banners, set available impressions and count resulting clicks!
Optionally AdServe links ads to blog users so that one could check the campaign results
within the Dashboard!


== Description ==

AdServe is the advertising server for WordPress. You could setup your banner campaigns
using different sized banners, set available impressions and count resulting clicks!
Optionally AdServe links ads to blog users so that one could check the campaign results
within the Dashboard!


* Unlimited number of advertisers, banners and zones.<br>
* Advertisers have web access to real-time reports for their specific campaign.<br>
* Launch a new browser when user clicks an ad, making it simple for them to return to your site.<br>



= USAGE =

= Define your banners =

Manage -> Ads -> New Ad

* title - Web site title
* url - Click destination URL (i.e. http://www.domain.com/)
* src - Image URL (i.e. http://www.domain.com/banner.jpg)
* blog user - (optional) Blog user who could check banner campaign status
* e-mail - User email
* zones - Blog zones where AdServe could serve the banner
* credits - Impression credits ( -1 = Unlimited )
* active - 1=Active, 0=Offline

*It's necessary to add credits to banners to start display it*


= Create blog ads-zones =

* Insert in your blog pages/post *[!AdServe:zone!]*

or

* Modify your code (or theme code) adding *AdServe("zone")*
where *zone* is the zone definition, i.e. AdServe("music")

*You could define more times the same zone!*



= Checking banners campaigns =

Linked blog user(s) could access Dashboard -> Ads to check Impressions, Clicks, Ratio and Credits!

Admin could check and edit banner settings within Manage -> Ads


== Installation ==

Upload AdServe folder in /wp-content/plugins/ . Then just activate it on your plugin management page.
AdServe creates the database table automatically.

Update
Override new AdServe version. You are ready!


== Frequently Asked Questions ==

= Is it wp_2.3.x compatible? =

Of course!


== Screenshots ==



== Arbitrary section ==

== Updates ==

*Version 0.1 (18 Nov 2007)*

*Version 0.1.1 (20 Nov 2007)*

*Version 0.1.2 (20 Nov 2007)*

*Version 0.1.3 (22 Nov 2007)*

* Fixed some minor bugs - Thanks to Mark

*Version 0.1.4 (27 Nov 2007)*

* Support for unlimited credit (setting cretits to -1)
* Adds impression and subtracts credit only when the current logged user is NOT the advetiser - Thanks to Casper

*Version 0.2 (6 Dec 2007)*

* Valid xhtml code - Thanks to Teerock

*Version 0.3 (31 Jan 2008)*

* Fixed security hole - Thanks to Alboth

