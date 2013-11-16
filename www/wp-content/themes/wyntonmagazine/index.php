<?php get_header(); ?>
<div id="homecontent-top">
  <div id="homecontent-topleft" class="left">
    <div id="leadcontainer">
      <!-- LEAD ARTICLE -->
      <div id="lead">
        <ul>
          <?php 
// this is where the Lead Story module begins   
   query_posts('showposts=1&cat=1'); //selects 1 article of the category with ID 1 ?>
          <?php while (have_posts()) : the_post(); ?>
          <div id="leadheader">
            <h3>
              <?php 
	// this is where the name of the Lead Story category gets printed	  
	wp_list_categories('include=1&title_li=&style=none'); ?>
            </h3>
            <span class="leadmeta">
            <?php the_time(__('M jS, Y','wyntonmagazine')); ?>
            <?php _e('By','wyntonmagazine'); ?>
            <?php the_author_posts_link('namefl'); ?>
            </span> <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="title">
            <?php 
// this is where the title of the Lead Story gets printed	  
	the_title(); ?>
            </a> </div>
          <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; 
// this is where the Lead Story image gets printed	
	$values = get_post_custom_values("Leadimage"); echo $values[0]; ?>" alt="image" id="leadpic" /></a>
          <?php 
// this is where the excerpt of the Lead Story gets printed. It´s reccomended you use the optional excerpt in the write post panel.	  
	the_excerpt() ; ?>
          <div class="read-on"> <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
            <?php _e('[ Continue reading... ]','wyntonmagazine'); ?>
            </a> </div>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>
    <div id="homebottom"></div>
  </div>
  <div id="homecontent-topright" class="right">
    <div id="hometop-rightcol">
      <?php 
// "Featured articles" module begins	  
	query_posts('showposts=3&cat=1&offset=1'); ?>
      <?php while (have_posts()) : the_post(); ?>
      <div class="feature"> <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/';
// this is where the custom field prints images for each Feature	  
	$values = get_post_custom_values("featured-article-image"); echo $values[0]; ?>" alt="image" /></a> <a href="<?php the_permalink() ?>" rel="bookmark" class="title">
        <?php 
// title of the "featured articles"	  
	  the_title(); ?>
        </a> </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>
<div class="clear"></div>
<hr />
<div class="adsense-banner"> <img src="<?php bloginfo('template_url'); ?>/images/adverts/728x90.gif" alt="advert" /> </div>
<hr />
<div id="homecontent-bottom">
  <div id="homeleftcol">
    <?php
// enter the IDs of which categories you want to display
$display_categories = array(3,4,);
foreach ($display_categories as $category) { ?>
    <div class="clearfloat">
      <?php query_posts("showposts=1&cat=$category");
	    $wp_query->is_category = false;
		$wp_query->is_archive = false;
		$wp_query->is_home = true;
		 ?>
      <div class="cat-head">
        <h3><a href="<?php echo get_category_link($category);?>">
          <?php 
	// name of each category gets printed	  
	  single_cat_title(); ?>
          </a></h3>
      </div>
      <?php while (have_posts()) : the_post(); ?>
      <?php
// this grabs the image filename
	$values = get_post_custom_values("home-category-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="home-cat-img" src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("home-category-image"); echo $values[0]; ?>" alt="image" /></a>
      <?php } ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" class="title">
      <?php 
// this is where title of the article gets printed	  
	  the_title(); ?>
      </a><br />
      <?php the_content_rss('', TRUE, '', 35); ?>
      <?php endwhile; ?>
    </div>
    <?php } ?>
  </div>
  <!--END LEFTCOL-->
  <div id="homemidcol">
    <?php
// enter the IDs of which categories you want to display
$display_categories = array(5,9);
foreach ($display_categories as $category) { ?>
    <div class="clearfloat">
      <?php query_posts("showposts=1&cat=$category");
	    $wp_query->is_category = false;
		$wp_query->is_archive = false;
		$wp_query->is_home = true;
		 ?>
      <div class="cat-head">
        <h3><a href="<?php echo get_category_link($category);?>">
          <?php 
	// name of each category gets printed	  
	  single_cat_title(); ?>
          </a></h3>
      </div>
      <?php while (have_posts()) : the_post(); ?>
      <?php
// this grabs the image filename
	$values = get_post_custom_values("home-category-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="home-cat-img" src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("home-category-image"); echo $values[0]; ?>" alt="image" /></a>
      <?php } ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" class="title">
      <?php 
// this is where title of the article gets printed	  
	  the_title(); ?>
      </a><br />
      <?php the_content_rss('', TRUE, '', 35); ?>
      <?php endwhile; ?>
    </div>
    <?php } ?>
  </div>
  <!--END MIDCOL-->
  <div id="homerightcol">
    <?php
// enter the IDs of which categories you want to display
$display_categories = array(6,8);
foreach ($display_categories as $category) { ?>
    <div class="clearfloat">
      <?php query_posts("showposts=1&cat=$category");
	    $wp_query->is_category = false;
		$wp_query->is_archive = false;
		$wp_query->is_home = true;
		 ?>
      <div class="cat-head">
        <h3><a href="<?php echo get_category_link($category);?>">
          <?php 
	// name of each category gets printed	  
	  single_cat_title(); ?>
          </a></h3>
      </div>
      <?php while (have_posts()) : the_post(); ?>
      <?php
// this grabs the image filename
	$values = get_post_custom_values("home-category-image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="home-cat-img" src="<?php bloginfo('url'); echo '/'; echo get_option('upload_path'); echo '/'; $values = get_post_custom_values("home-category-image"); echo $values[0]; ?>" alt="image" /></a>
      <?php } ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" class="title">
      <?php 
// this is where title of the article gets printed	  
	  the_title(); ?>
      </a><br />
      <?php the_content_rss('', TRUE, '', 35); ?>
      <?php endwhile; ?>
    </div>
    <?php } ?>
  </div>
  <!--END RIGHTCOL-->
  <!--END CONTENT-->
</div>
<?php get_footer(); ?>