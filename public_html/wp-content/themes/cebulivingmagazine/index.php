<?php get_header(); ?>
   <div id="bd">
   	<div id="singlepanel">
   		<div class="yui-ge">
    		<div class="yui-u first">
    			<div class="topdarkblue">
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<p class="byline">By <?php the_author(); ?> <br />Published <?php the_time('F jS, Y') ?></p>
				<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
				<?php comments_template(); ?>
				<?php endwhile; else: ?>
				<p>Sorry, no posts matched your criteria.</p>
				<?php endif; ?>					
        </div>
	    	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>