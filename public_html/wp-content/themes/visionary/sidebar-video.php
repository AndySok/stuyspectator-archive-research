<!-- BEGIN SIDEBAR-VIDEO.PHP -->
<div id="sidebar-video">
<div class="menu">
<h2 id="video-head">Latest Videos &raquo;</h2>
<div>
	<?php rewind_posts(); ?>
	<div class="video-list">
	<ul class="video">
	<?php 
	// GETS THE LATEST VIDEO ARTICLE
	$my_query = new WP_Query('category_name=video&showposts=5');
	$i = 1;
	while ($my_query->have_posts()) : $my_query->the_post();
		$do_not_duplicate = $post->ID; 
		$video = get_post_meta($post->ID, 'Video', $single=true); ?>
		<li class="v<?php echo $i; ?>">
		<a class="v<?php echo $i; ?> vlink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</li>
	<?php $i++; endwhile; ?>
	</ul>
	</div>

	<?php rewind_posts(); ?>
	<?php 
	// GETS THE LATEST VIDEO ARTICLE
	$my_query = new WP_Query('category_name=video&showposts=5');
	$i = 1;
	while ($my_query->have_posts()) : $my_query->the_post();
		$do_not_duplicate = $post->ID; 
		$video = get_post_meta($post->ID, 'Video', $single=true);
		$flash_video = get_post_meta($post->ID, 'Flash Video', $single=true); ?>
		<div class="v<?php echo $i; ?> video">
			<?php 
			if($video !== '') { ?>
<object type="application/x-shockwave-flash" data="<?php echo $video; ?>" style="width: 275px; height: 230px; border: none; padding: 0; margin: 0;" id="video<?php echo $i; ?>">
	<param name="movie" value="<?php echo $video; ?>" />
	<param name='wmode' value='transparent' />
	<param name="quality" value="best" />
	<param name="bgcolor" value="#FFFFFF" />
	<param name="FlashVars" value="playerMode=embedded" />
</object>
				<?php 
				}
			elseif($flash_video !== '') {
				echo '<p>'; echo $flash_video; echo '</p>';
				}
			else {
				the_excerpt(); 
				} ?>
		<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">View full story &raquo;</a></p>
		</div> <!-- center -->
	<?php $i++; endwhile; ?>

</div>
</div><!-- video menu -->
</div><!-- sidebar-video -->
<!-- END SIDEBAR-VIDEO.PHP -->