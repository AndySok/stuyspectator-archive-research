<?php get_header(); ?>

	<div id="content">
	
		<div id="archive">

	<?php
if(isset($_GET[’author_name’])) :
$curauth = get_userdatabylogin(get_the_author_login());
else :
$curauth = get_userdata(intval($author));
endif;
?>
	<h2>Author Profile: <strong><?php echo $curauth->first_name; ?>&nbsp;<?php echo $curauth->last_name; ?></strong></h2>

<h3>Biography &raquo;</h3>
<div id="writer" class="clearfloat">
<img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/author/<?php echo $curauth->last_name; ?>.jpg" alt="" />

<?php echo $curauth->description; ?><br />
<span class="meta" style="float:right;"><a href="mailto:<?php echo $curauth->user_email; ?>" title="Email this author">Email the author</a></span></p>
</div>

<h3>Publications &raquo;</h3>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			  <div class="clearfloat">
				<?php
// this grabs the image filename
	$values = get_post_custom_values("Image");
// this checks to see if an image file exists
	if (isset($values[0])) {						
?>
 		     <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_option('home'); ?>/wp-content/themes/linoluna/images/thumbnails/<?php $values = get_post_custom_values("Image"); echo $values[0]; ?>" alt="" /></a>
      		<?php } ?>

			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="title"><?php the_title(); ?></a><br/>
				<span class="author">By <?php the_author_posts_link('namefl'); ?></span><br/>Posted in <?php the_category(', ') ?> on <?php the_time('j F Y') ?><br/>Stats: <?php if(function_exists('the_views')) { the_views(); } ?> and <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
		<?php the_excerpt() ?>
			</div>
	

		<?php endwhile;?>
	</div>

<br/><br/>		
		<div class="navigation">

			<div class="right"><?php next_posts_link('Older Entries &raquo;') ?></div>
			<div class="left"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
