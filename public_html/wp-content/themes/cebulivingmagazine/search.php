<?php get_header(); ?>
  <div id="bd">
    <div id="singlepanel">
   		<div class="yui-ge">
    		<div class="yui-u first">
    			<div class="topdarkblue">
    			<h1>Search Results 
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
				    <h2><?php the_title(); ?></h2>
            <p class="byline">By <?php the_author(); ?> <br />Published <?php the_time('F jS, Y') ?></p>
				<?php the_content() ?>
				<?php endwhile; else: ?>
				<p>Sorry, no posts matched your criteria.</p>
				<?php endif; ?>					
          </div>
	    	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>