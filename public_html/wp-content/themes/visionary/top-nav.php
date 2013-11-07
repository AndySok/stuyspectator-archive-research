<!-- BEGIN TOP-NAV.PHP / FEEL FREE TO ADD MORE LINKS TO THIS PAGE -->
<ul>
<!-- This menu uses Dynamic Menu Highlighting.  To learn more, go to http://codex.wordpress.org/Dynamic_Menu_Highlighting -->

<!-- To show "current" on the Advertise Page -->
<li<?php if (is_page('Advertise')) { echo " id=\"current\""; } ?>>
<a href="<?php echo get_permalink(2); ?>" title="<?php _e('Advertise'); ?>"><span><?php _e('Advertise'); ?></span></a></li>

<!-- To show "current" on the Contact Page -->
<li<?php if (is_page('Contact')) { echo " id=\"current\""; } ?>>
<a href="<?php echo get_permalink(2); ?>" title="<?php _e('Contact'); ?>"><span><?php _e('Contact'); ?></span></a></li>

<!-- To show "current" on the Links Page -->
<li<?php if (is_page('Links')) { echo " id=\"current\""; } ?>>
<a href="<?php echo get_permalink(2); ?>" title="<?php _e('Links'); ?>"><span><?php _e('Links'); ?></span></a></li>
</ul>

<!-- END TOP-NAV.PHP -->