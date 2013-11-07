<?php // Flickr Photo Stream

	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
		else { $$value['id'] = get_settings( $value['id'] ); } } 
	global $flickr_url;
	$flickr_url = $st_flickr_url;
// Add flickr photos
if(function_exists('get_flickrrss')) { ?>
<div class="menu flickr">
	<h2 title="<?php _e('Flickr Photos') ?>"><?php _e('Flickr Photos'); ?></h2>
	<div>
		<?php get_flickrrss(); ?>
		<p>
		<!-- PLEASE EDIT THE LINK BELOW TO YOUR FLICKR PAGE (now in theme options) -->
		<a href="<?php echo $flickr_url; ?>" title="View all photos from the flickr photo stream">View flickr photostream &raquo;</a>
		</p>
	</div>
</div>
<?php } 
// End flickr.php ?>