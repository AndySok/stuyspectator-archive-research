<div class="recent">
<?php
// The second loop showing articles after the feature

global $post, $do_not_duplicate;
rewind_posts();

 // Query posts by newest first (change "$posts_wanted=3" to the number of posts you want shown)
	$i = 1;
	$posts_wanted = 3;
	$posts = query_posts('orderby=date&order=DESC&showposts='.$posts_wanted+1);
   
	while(have_posts() && $i <= $posts_wanted) : the_post();
   
// If the feature is found in the query, skip over it
// Subtract "1" from $i to compensate for the lost post
	if ($post->ID == $do_not_duplicate) { 
		continue;
		update_post_caches($posts);
		$i--;
		}

// Checks for a thumbnail for the post
	$thumb = get_post_custom_values($key = 'Thumbnail');
// Checks for alt text for the thumbnail
	$thumb_alt = get_post_custom_values($key = 'Thumbnail Alt');
// Checks to see if there's a custom "short" excerpt for front page display
	$excerpt = get_post_custom_values($key = 'Excerpt');
	?>

<div id="recent-post-<?php the_ID(); ?>" class="post">

<?php
	// Checks thumbnail array to see if there's any information in the Value field
	if(isset($thumb[0]) && strcmp($thumb[0],'')!= 0)  {
		?>
		<p>
		<img src="<?php echo $thumb[0]; ?>" alt="<?php if($thumb_alt !== '') echo $thumb_alt[0]; else echo the_title(); ?>" class="left" />
		</p>
	<?php } // endif ?>

	<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<div class="entry">
	<?php 
	// Checks excerpt array to see if there's any information in the Value field
		if(isset($excerpt[0]) && strcmp($excerpt[0],'')!= 0) echo $excerpt[0];
	// If no Value set, display normal excerpt
		else the_excerpt(); 
	?>
	</div><!-- entry -->
</div><!-- post -->
<?php
	$i++; // Iterate the $i variable
	endwhile; // endwhile - loop
?>
</div><!-- recent -->