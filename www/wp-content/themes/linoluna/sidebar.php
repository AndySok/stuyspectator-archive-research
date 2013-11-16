<div id="sidebar">

<div id="sidebar-top">
<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
		<?php endif; ?>

</div>

<div id="sidebar-tabs">
<h3 style="margin:10px 10px 5px 10px;">Most Popular</h3>
<div id="mostPopWidget">
 
	<div id="tabsContainer">
	<ul class="tabs">
	
	<li class="selected"><a href="#">Viewed</a></li> 
	<li><a href="#">Commented</a></li> 
	<li><a href="#">Top Rated</a></li> 
	<li><a href="#">Emailed</a></li> 
	
	</ul>
	</div>

	<div class="tabContent tabContentActive" id="mostViewed">
	<ol>
	<?php if (function_exists('get_most_viewed')): ?>
   		<?php get_most_viewed('post',10); ?>
	<?php endif; ?>
	</ol>
	</div>

	<div class="tabContent" id="mostCommented">
	<ol>
	<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 10");
	foreach ($result as $topten) {
	$postid = $topten->ID;
	$title = $topten->post_title;
	$commentcount = $topten->comment_count; 
	if ($commentcount != 0) { ?>
	<li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>"><?php echo $title ?></a> - <?php echo $commentcount?> comment<?php if ($commentcount > 1) { echo 's' ;} ?></li>
	<?php } } ?> 
	</ol>
	</div>

	<div class="tabContent" id="topRated">
	<ol>
	<?php if (function_exists('get_highest_rated')): ?>
    	<?php get_highest_rated('post',5); ?>
	<?php endif; ?>
	</ol>
	</div>

	<div class="tabContent" id="mostEmailed">
	<ol>
	<?php if (function_exists('get_mostemailed')): ?>
   	<?php get_mostemailed(); ?>
	<?php endif; ?>
	</ol>
	</div>
				
	<script type="text/javascript">new Popular("mostPopWidget");</script>

</div>

</div>

<div id="sidebar-middle">
<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(4) ) : ?>
		<?php endif; ?>
</div>


<div id="sidebar-bottom">
<div id="sidebar-left">

<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
		<?php endif; ?>
</div>

<div id="sidebar-right">
<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(3) ) : ?>
		<?php endif; ?>
</div>
</div>


<?php if (!is_home()) : ?>
<div id="sidebar-ads">
<img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/ads/300x250.gif" />
</div>
<?php endif ; ?>

</div>