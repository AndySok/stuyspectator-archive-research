<!-- BEGIN SIDEBAR-BOTTOM.PHP -->
	<div id="sidebar-bottom">
<!-- ADD FLICKR PHOTOS -->
<?php if(function_exists('get_flickrrss')) { ?>
<div class="menu flickr">
	<h2 title="<?php _e('Flickr Photos') ?>"><?php _e('Flickr Photos &raquo;'); ?></h2>
	<div>
		<?php get_flickrrss(); ?>
		<p>
		<a href="http://flickr.com/justintadlock" title="View all photos from the flickr photo stream">View flickr photostream &raquo;</a>
		</p>
	</div>
</div>
<?php } ?>
</div>
<!-- END SIDEBAR-BOTTOM.PHP -->