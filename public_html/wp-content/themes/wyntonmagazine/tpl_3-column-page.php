<?php
/*
Template Name: 3-Column-Page
*/
?>

<?php get_header(); ?>


  <div id="pageleft">
    <?php
// this is where you enter the ID of the category you want to display
$display_categories = array(9);
foreach ($display_categories as $category) { ?>
    
      <?php query_posts("showposts=1&cat=$category"); ?>
      
      <h3><a href="<?php echo get_category_link($category);?>"><?php 
	// this is where the name of each category gets printed	  
	  single_cat_title(); ?></a></h3>
      <?php while (have_posts()) : the_post(); ?>
      <?php
// this grabs the image filename
	$values = get_post_custom_values("3-column-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to','wyntonmagazine'), get_the_title())?>"><img src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("3-column-image"); echo $values[0]; ?>" alt="image" /></a><br /><br />
      <?php } ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php 
// this is where title of the article gets printed	  
	  the_title(); ?></a><br />
      <?php the_excerpt() ; ?>
      <?php endwhile; ?>
      
      <strong><?php __('Recently postet','wyntonmagazine');?><br /><br /></strong>
		<?php 
// this is where the last three headlines are pulled from the category	    
		query_posts('showposts=3&cat=5'); 		
		?>
		<ul class="recent">
 	<?php while (have_posts()) : the_post(); ?>
      <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></li>
 	<?php endwhile; ?>
 	</ul>
 	
   
    <?php } ?>
  </div><!-- END LEFT COLUMN -->

  <div id="pagemiddle">
    <?php
// this is where you enter the ID of the category you want to display
$display_categories = array(6);
foreach ($display_categories as $category) { ?>
   
      <?php query_posts("showposts=1&cat=$category"); ?>
      
      <h3><a href="<?php echo get_category_link($category);?>"><?php 
	// this is where the name of each category gets printed	  
	  single_cat_title(); ?></a></h3>
      <?php while (have_posts()) : the_post(); ?>
      <?php
// this grabs the image filename
	$values = get_post_custom_values("3-column-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to','wyntonmagazine'), get_the_title())?>"><img src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("3-column-image"); echo $values[0]; ?>" alt="image" /></a><br /><br />
      <?php } ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php 
// this is where title of the article gets printed	  
	  the_title(); ?></a><br />
      <?php the_excerpt() ; ?>
      <?php endwhile; ?>
    
      <strong><?php __('Recently postet','wyntonmagazine');?><br /><br /></strong>
		<?php 
// this is where the last three headlines are pulled from the News (or whatever) category	  
		query_posts('showposts=3&cat=6'); 		
		?>
		<ul class="recent">
 	<?php while (have_posts()) : the_post(); ?>
      <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></li>
 	<?php endwhile; ?>
 	</ul>
    
    <?php } ?>
  </div><!-- END MIDDLE COLUMN -->

  <div id="pageright">
    <?php
// this is where you enter the ID of the category you want to display
$display_categories = array(8);
foreach ($display_categories as $category) { ?>
    
      <?php query_posts("showposts=1&cat=$category"); ?>
      
      <h3><a href="<?php echo get_category_link($category);?>"><?php 
	// this is where the name of the category gets printed	  
	  single_cat_title(); ?></a></h3>
      <?php while (have_posts()) : the_post(); ?>
      <?php
// this grabs the image filename
	$values = get_post_custom_values("3-column-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to','wyntonmagazine'), get_the_title())?>"><img src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("3-column-image"); echo $values[0]; ?>" alt="image" /></a><br /><br />
      <?php } ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php 
// this is where title of the article gets printed	  
	  the_title(); ?></a><br />
      <?php the_excerpt() ; ?>
      <?php endwhile; ?>
    
      <strong><?php __('Recently postet','wyntonmagazine');?><br /><br /></strong>
		<?php 
// this is where the last three headlines are pulled from the category	  
		query_posts('showposts=3&cat=8'); 		
		?>
		<ul class="recent">
 	<?php while (have_posts()) : the_post(); ?>
      <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></li>
 	<?php endwhile; ?>
 	</ul>
    
    <?php } ?>
  </div><!-- END RIGHT COLUMN -->

	
<div class="clear"></div>
<?php get_footer(); ?>