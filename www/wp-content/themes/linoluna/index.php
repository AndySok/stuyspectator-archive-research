<?php get_header(); ?>

	<div id="content">
   
	<div id="slideshow" style="padding:0px 10px 0px 10px;">
	
	<div class="clearfloat">

	<div id="control">
      	<span id="cntrl_1"><a href="#null" onclick="switch_pane('1')">1</a></span><span id="cntrl_2"><a href="#null" onclick="switch_pane('2')">2</a></span><span id="cntrl_3"><a href="#null" onclick="switch_pane('3')">3</a></span><span id="cntrl_4"><a href="#null" onclick="switch_pane('4')">4</a></span><span id="cntrl_play"><a href="#null" onclick="restart_loop();">Next</a></span><span id="cntrl_pause"><a href="#null" onclick="stop_loop();">Pause</a></span>
	</div>
	
	<?php query_posts("showposts=4&cat=9"); $i = 1; ?>
	<?php while (have_posts()) : the_post(); ?>	

	<div id="feature_<?php echo $i; ?>" style="display: none">

	<?php $values = get_post_custom_values("Image");?>
 	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/slideshows/<?php echo $values[0];?>" /></a>		
	<a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php the_title(); ?></a>
	<br/><span class="author">By  <?php the_author_posts_link(); ?> </span>
	<br/><span class="meta">[<?php the_time('j M Y') ?>|<?php comments_popup_link('No Comment', 'One Comment', '% Comments');?>]</span>	
	<?php the_excerpt(); ?>
	
	</div>

	<?php $i++; endwhile; ?>
	
	</div>

	</div>

	<div id="aside">
	
	<?php $arr_cat = array(6,7);
	foreach ($arr_cat as $cat) { ?>

	<?php query_posts("showposts=1&cat=$cat"); ?>
		
      <?php while (have_posts()) : the_post(); ?>
	<div class="clearfloat">
		
	<?php	$values = get_post_custom_values("Image");

	if (isset($values[0])) { ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/asides/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
      <?php } ?>
	<h3><a href="<?php echo get_category_link($cat);?>">//
	<?php single_cat_title(); ?></a></h3>
	<a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php the_title(); ?></a>
     	<br/><span class="author">By <?php the_author_posts_link('namefl'); ?></span>
	<br/><span class="meta">[<?php the_time('j M Y') ?>|<?php comments_popup_link('No Comment', 'One Comment', '% Comments');?>]</span>
      <?php the_excerpt(); ?>
	</div>
      <?php endwhile; ?>
	<?php } ?>

		
	</div>

	<div id="aside-1">
	<?php query_posts("showposts=1&cat=5"); ?>
		
      <?php while (have_posts()) : the_post(); ?>
	<h3><a href="<?php echo get_category_link($cat);?>">//
	<?php single_cat_title(); ?></a></h3>
 	
	<a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php the_title(); ?></a>
     	<br/><span class="author">By <?php the_author_posts_link('namefl'); ?></span>
	<br/><span class="meta">[<?php the_time('j M Y') ?>|<?php comments_popup_link('No Comment', 'One Comment', '% Comments');?>]</span>
	
	<?php	$values = get_post_custom_values("Image");

	if (isset($values[0])) { ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/thumbnails/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
      <?php } ?>
      <?php the_excerpt(); ?>
      <?php endwhile; ?>

	</div>

	<div id="aside-2">
	<?php query_posts("showposts=1&cat=8"); ?>
		
      <?php while (have_posts()) : the_post(); ?>
	<h3><a href="<?php echo get_category_link($cat);?>">//
	<?php single_cat_title(); ?></a></h3>
 	
	<a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php the_title(); ?></a>
     	<br/><span class="author">By <?php the_author_posts_link('namefl'); ?></span>
	<br/><span class="meta">[<?php the_time('j M Y') ?>|<?php comments_popup_link('No Comment', 'One Comment', '% Comments');?>]</span>
	<?php	$values = get_post_custom_values("Image");

	if (isset($values[0])) { ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/thumbnails/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
      <?php } ?>
      <?php the_excerpt(); ?>
      <?php endwhile; ?>
	</div>

	<div id="aside-3">
	<?php query_posts("showposts=1&cat=11"); 
$wp_query->is_category = false;
$wp_query->is_archive = false;
$wp_query->is_home = true; ?>
		
      <?php while (have_posts()) : the_post(); ?>
	<h3><a href="<?php echo get_category_link($cat);?>">//
	<?php single_cat_title(); ?></a></h3>

	<a href="<?php the_permalink() ?>" rel="bookmark" class="title"><?php the_title(); ?></a>
     	<br/><span class="author">By <?php the_author_posts_link('namefl'); ?></span>
	<br/><span class="meta">[<?php the_time('j M Y') ?>|<?php comments_popup_link('No Comment', 'One Comment', '% Comments');?>]</span>
	<?php	$values = get_post_custom_values("Image");

	if (isset($values[0])) { ?>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/thumbnails/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
      <?php } ?>
      <?php the_excerpt(); ?>
      <?php endwhile; ?>
	</div>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
