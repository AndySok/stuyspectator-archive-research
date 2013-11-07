<!-- BEGIN FOOTER.PHP -->
</div><!-- content / home -->

<div id="sidebar">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar') ) : else : ?>
<?php // SIDEBAR FOR HOME.PHP
if(is_home()) { ?>
		<?php include(TEMPLATEPATH . '/sidebar-home.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-video.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-bottom.php'); ?>
<?php } ?>

<?php // SIDEBAR FOR SINGLE and PAGE
if(is_single() || is_page()) { ?>
		<?php include (TEMPLATEPATH . '/sidebar-single.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-ads-horizontal.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-bottom.php'); ?>
<?php } ?>

<?php // SIDEBAR FOR ARCHIVE, CATEGORY, AUTHOR, SEARCH
if(is_archive() || is_search() || is_404()) { ?>
		<?php include (TEMPLATEPATH . '/sidebar-archive.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-ads-horizontal.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-tags.php'); ?>
		<?php include(TEMPLATEPATH . '/sidebar-bottom.php'); ?>
<?php } ?>
<?php endif; ?>
</div><!-- sidebar -->

</div><!-- container -->
<div id="footer">
	<p>
	Copyright &#169; <?php print(date(Y)); ?> <a href="<?php bloginfo('url'); ?>"><span><?php bloginfo('name'); ?></span></a>
	<br />
	<a href="http://justintadlock.com/archives/2007/11/04/visionary-wordpress-theme" title="Visionary WordPress theme by Justin Tadlock">Visionary theme</a> by <a href="http://justintadlock.com" title="Justin Tadlock"><span> Justin Tadlock</span></a>
	</p>
	<p class="icons">
	<a href="http://justintadlock.com/archives/2007/11/04/visionary-wordpress-theme" title="Visionary theme for WordPress"><img src="<?php echo bloginfo(stylesheet_directory) .'/images/visionari.gif'; ?>" alt="Visionary WordPress Theme by Justin Tadlock" /></a>
	<a href="http://wordpress.org" title="Powered by WordPress, state-of-the-art semantic personal publishing platform"><img src="<?php echo bloginfo(stylesheet_directory) .'/images/wp-icon.gif'; ?>" alt="Powered by WordPress, state-of-the-art semantic personal publishing platform" /></a>
	</p>
</div>

</div><!-- body-container -->
</body>
<?php wp_footer(); ?>
</html>