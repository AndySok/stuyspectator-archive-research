=== Custom Write Panel ===
Contributors: alphaoide
Donate link: http://wordpress.org
Tags: admin, custom write panel, custom, write panel
Requires at least: 2.2
Tested up to: 2.2

Custom Write Panel allows user to create customized write panel.

== Description ==

Custom Write Panel provides the functionality to create individual write panels similar to "Write Post" panel only with
customized input fields. This plugin allows adding new input fields with a specific type. The following are the 
supported types.

* Textbox
* Multiline Textbox
* Checkbox
* Checkbox List
* Radiobutton List
* Dropdown List
* Listbox

In addition to having new input fields. This plugin allows hidding WordPress' input fields so that the custom write 
panel only shows relevant input fields. Those input fields are the following.

* Title
* Categories
* Discussion
* Post Password
* Post Slug
* Post Status
* Post Timestamp
* Upload
* Optional Excerpt
* Trackbacks
* Custom Fields

== Installation ==

Follow the following steps to install this plugin.

1. Upload folder `custom-write-panel` and its content to the `/wp-content/plugins/` folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. An option page will be available under 'Option' menu and management page under 'Manage' menu

Deactivating this plugin from 'Plugins' menu will retain the database tables and all data created by this plugin.
To completely remove the trace of this plugin from your WordPress installation, do the following steps.

1. Go to 'Options' > 'Custom Write Panel'
1. Type **uninstall** in the last textbox
1. Click 'Update Options'
1. Deactivate the plugin from the 'Plugins' menu

== Frequently Asked Questions ==

= How do I create a new custom write panel? =

Go to 'Manage' > 'Custom Write Panel,' click on 'Create Custom Write Panel' and follow the on-screen instruction.

= How do I add a custom input field? =

After creating a custom write panel, click on 'View'  to view the custom write panel info, click 'Create Custom Field'
and follow on-screen instruction.

= I have a question. Who's to ask? =

Ask your question on [the forum](http://forum.rhymedcode.net).


== Credits ==

* ["Clutter Free"](http://txfx.net/code/wordpress/clutter-free/) plugin from which I adapted the code to hide WordPress'
input fields

