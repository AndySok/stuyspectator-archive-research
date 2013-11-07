</div> 
<div id="footer"> 
  <?php wp_footer(); ?>
  <div> &#169; <?php echo date('Y'); ?> 
    <?php bloginfo('name'); ?>
    | Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a> 
    | <a href="http://www.wp-themes.der-prinz.com/magazine/" target="_blank" title="By DER PRiNZ - Michael Oeser">WyntonMagazine theme</a> by <a href="http://www.der-prinz.com" target="_blank" title="DER PRiNZ - Michael Oeser">Michael Oeser.</a>
  <div></div> 
    <?php wp_loginout(); ?> | 
    <?php wp_register('', ' |'); ?>
	<?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds.
  </div>
</div>
</body>
</html>
