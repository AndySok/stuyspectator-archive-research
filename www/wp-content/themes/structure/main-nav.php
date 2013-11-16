<!-- BEGIN MAIN-NAV.PHP -->
<ul>
<!-- This menu uses Dynamic Menu Highlighting.  To learn more, go to http://codex.wordpress.org/Dynamic_Menu_Highlighting -->

<!-- To show "current" on the home page -->
<li<?php if (is_home()) { echo " id=\"current\""; } ?>>
<a href="<?php bloginfo('url'); ?>" title="<?php _e('Home Page'); ?>"><span><?php _e('Home'); ?></span></a></li>

<!-- To show "current" on the About Page -->
<li<?php if (is_page('About')) { echo " id=\"current\""; } ?>>
<a href="<?php echo get_permalink(2); ?>" title="<?php _e('About'); ?>"><span><?php _e('About'); ?></span></a></li>

<?php 
// Copy the next block of code to make multiple links
// Change get_permalink(2) to the ID of the page you want to go to, or change the link entirely ?>
<!-- To show "current" on the Example Page -->
<li<?php if (is_page('Example')) { echo " id=\"current\""; } ?>>
<a href="<?php echo get_permalink(2); ?>" title="<?php _e('Example'); ?>"><span><?php _e('Example'); ?></span></a></li>

</ul>
<!-- END MAIN-NAV.PHP -->