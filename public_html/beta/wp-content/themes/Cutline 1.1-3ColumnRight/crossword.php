<?php
/*
Template Name: Crossword
*/
?>

<?php get_header(); ?>
<div id="content_box">

<div id="content" class="posts">
<h1>Crosswords</h1>
	
<?php global $post;
 $myposts = get_posts('category=14');
 foreach($myposts as $post) :
 setup_postdata($post); ?>

			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<h4><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></h4>

				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>


			</div>

		<?php endforeach; ?>

					<?php include (TEMPLATEPATH . '/navigation.php'); ?>

				

				</div>

				<?php include (TEMPLATEPATH . '/sidebar.php'); ?>

				<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>

			</div>

		<?php get_footer(); ?>
