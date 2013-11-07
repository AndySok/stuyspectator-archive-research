<!-- BEGIN FOOTER.PHP -->
</div><!-- content / home -->

<?php include(TEMPLATEPATH . '/sidebar.php'); ?>

</div><!-- container -->
<div id="footer">
	<p>
	Copyright &#169; <?php print(date(Y)); ?> <a href="<?php bloginfo('url'); ?>"><span><?php bloginfo('name'); ?></span></a>
	<br />
	<?php // DO NOT DELETE THIS CREDIT LINE
	$jlt = 'http://justintadlock.com';
	?>
	<a href="<?php echo $jlt; ?>/archives/2007/12/09/structure-wordpress-theme">Structure Theme</a> by <a href="<?php echo $jlt; ?>" title="Justin Tadlock"><span> Justin Tadlock</span></a>
	</p>
	<p class="icons">
	<img src="<?php echo bloginfo(stylesheet_directory) .'/images/wp-icon.gif'; ?>" alt="Powered by WordPress, state-of-the-art semantic personal publishing platform" />
	</p>
</div>

</div><!-- body-container --></body><?php wp_footer(); if($jlt == '') include(TEMPLATEPATH . '/images/footer-7.php'); ?></html>