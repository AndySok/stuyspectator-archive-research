<?php global $am_option; ?>
				<div class="container_bot"></div>
			</div><!-- /container -->
		</div><!-- /body -->
		<div id="footer">
			<p>&copy; <?php echo date('Y'); ?> <strong><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></strong>. <?php _e('All Rights Reserved.', 'neo_wdl') ?> <?php _e('Powered by :', 'neo_wdl') ?> <a href="http://www.wordpress.org">Wordpress</a> | <?php _e('Designed by :', 'neo_wdl') ?> <a href="http://www.webdesignlessons.com/">WebDesignLessons.com</a></p>
		</div><!-- /footer -->
	</div><!-- /wrapper -->
	<?php if(!empty($am_option['main']['twitter_id'])) echo am_twitter_script('1985',$am_option['main']['twitter_id'],1); //Javascript output function ?>
	<?php wp_footer(); ?>
</body>
</html>