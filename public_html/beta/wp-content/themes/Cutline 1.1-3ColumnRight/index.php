<?php get_header(); ?>

	<div id="content_box">
	<div id="frontpage">
		<?php include (TEMPLATEPATH . '/l_sidebar.php'); ?>
		
		<div id="content" class="posts">
		<div id="primary">
		<!-- FrontPageNews-->
		<?php $posts = get_posts( "category=9" ); ?>
		<?php if( $posts ) : ?>
		
		<?php foreach( $posts as $post ) : setup_postdata( $post ); 
		if (in_category(7)) {
		?>

		<div id="main_post_text">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<h4><?php the_time('F jS, Y') ?> &middot; <?php
		clean_authors(get_post_custom_values('Written by:'));
		clean_additional(get_post_custom_values('Additional reporting by:'));
		
		?> </h4>
		
		<div id="main_post_image">
		<?php  print get_thumb(); ?>
		</div>
		
		<div class="entry" style='text-align:left;'>
		
		<?php wswwpx_content_extract ( '(More...)', '4:s', 55 ); ?>
		</div>
	
		</div> <div class='small_clear'></div>
		
		<?php } endforeach; ?> <?php endif; ?>
		</div>
				<!-- <?php query_posts('showposts=2&category=7'); ?>
							<?php if (have_posts()) : while (have_posts()) : the_post(); 
							if (!in_category(9)) { ?>
							<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
							<?php } endwhile; endif; ?> -->
		<!-- EndFrontPageNews-->
		</div>
							
		<div id="sidecore">
			<div id="leftcore">
					<div id="minicore">
					
					<br />
					<div style='background-color:#B1D95B;color:#000;padding-left:8px;font-size:12px;'>
				Welcome to the new frontpage.
					</div><br /><br />
					
					<!-- Sports-->
					<?php $posts = get_posts( "category=15" ); ?>
					<?php if( $posts ) : ?>
					
					<?php foreach( $posts as $post ) : setup_postdata( $post ); 
					if (in_category(7)) { ?>
					<h1><a href="section/news/">News</a></h1>
					
					<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h5>

					<h4><?php the_time('F jS, Y') ?> <?php
						clean_authors(get_post_custom_values('Written by:'));
						clean_additional(get_post_custom_values('Additional reporting by:'));
						
						?> </h4>
					<div class="entry">
					<?php wswwpx_content_extract ( '(More...)', '1:s', 55 ); ?>
					</div>
					
					<?php } endforeach; ?> <?php endif; ?>
					<!-- EndSports-->
					</div><br />
					
					<!-- Features-->
					<?php $posts = get_posts( "category=15" ); ?>
					<?php if( $posts ) : ?>
					
					<?php foreach( $posts as $post ) : setup_postdata( $post ); 
					if (in_category(6)) { ?>
					<h1><a href="section/features/">Features</a></h1>
				
					<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h5>
				
					<h4><?php the_time('F jS, Y') ?> <?php
						clean_authors(get_post_custom_values('Written by:'));
						clean_additional(get_post_custom_values('Additional reporting by:'));
						
						?> </h4>
					<div class="entry">
					<?php wswwpx_content_extract ( '(More...)', '1:s', 55 ); ?>
					</div>
					
					<?php } endforeach; ?> <?php endif; ?>
					<!-- EndFeatures-->
		
			</div>
			
			<div id="rightcore">
					<div id="minicore">
					
					<div class="widget" style='background-color:#011235;color:white;padding-left:8px;font-size:12px;'>
					Hear something funny? Submit to Overheard At Stuy by emailing overheard@stuyspectator.com
					</div><br />
					
					<!-- Opinions-->
					<?php $posts = get_posts( "category=15" ); ?>
					<?php if( $posts ) : ?>
					
					<?php foreach( $posts as $post ) : setup_postdata( $post ); 
					if (in_category(3)) { ?>
					<h1><a href="section/opinions/">Opinions</a></h1>
					
					<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h5>

					<h4><?php the_time('F jS, Y') ?> &middot; <?php
					clean_authors(get_post_custom_values('Written by:'));
					clean_additional(get_post_custom_values('Additional reporting by:'));

					?> </h4>
					<div class="entry">
					<?php wswwpx_content_extract ( '(More...)', '1:s', 55 ); ?>
					</div>
					
					<?php } endforeach; ?> <?php endif; ?>
					<!-- EndOpinions-->
					</div><br />
					
					<!--web exclusives-->
					<?php $posts = get_posts( "category=15" ); ?>
					<?php if( $posts ) : ?>

					<?php foreach( $posts as $post ) : setup_postdata( $post ); 
					if (in_category(8)) { ?>
					<h1><a href="section/webexclusives/">Web Exclusives</a></h1>

					<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h5>

					<h4><?php the_time('F jS, Y') ?> &middot; <?php
					clean_authors(get_post_custom_values('Written by:'));
					clean_additional(get_post_custom_values('Additional reporting by:'));
					
					?> </h4>
					<div class="entry">
					<?php wswwpx_content_extract ( '(More...)', '1:s', 55 ); ?>
					</div>
					
					<?php } endforeach; ?> <?php endif; ?>
					<!--Endwebexclusives-->
			</div>
			
		</div>
		</div>
		
	</div>
	
	<div id="morecontent">
		
		<div id="leftboxes">
		<div id="leftmini">
		<h1>A&E</h1>
			<?php $posts = get_posts( "category=9" ); ?>
			<?php if( $posts ) : ?>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); 
			if (in_category(4)) { ?>
				<?php the_thumb('link=p&height=180&width=180')?>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2
			<?php } endforeach; ?> <?php endif; ?>
		</div>
		
		<div id="rightmini">
		<h1>SPORTS</h1>
			<?php $posts = get_posts( "category=9" ); ?>
			<?php if( $posts ) : ?>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); 
			if (in_category(5)) { ?>
				<?php the_thumb('link=p&height=180&width=180')?>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2
			<?php } endforeach; ?> <?php endif; ?>
		</div>
		</div>
		
		<div id="rightboxes">
		<div id="leftmini">
		<h1>FEATURES</h1>
			<?php $posts = get_posts( "category=9" ); ?>
			<?php if( $posts ) : ?>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); 
			if (in_category(6)) { ?>
				<?php the_thumb('link=p&height=180&width=180')?>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2
			<?php } endforeach; ?> <?php endif; ?>
		</div>
		
		<div id="rightmini">
		<h1>OPINIONS</h1>
			<?php $posts = get_posts( "category=9" ); ?>
			<?php if( $posts ) : ?>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); 
			if (in_category(3)) { ?>
				<?php the_thumb('link=p&height=180&width=180')?>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2
			<?php } endforeach; ?> <?php endif; ?>
		</div>
		</div>
		
	</div>
	<div id="evenmore">
		<?php query_posts('showposts=5'); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); 
		if (!in_category(9) || !in_category(15)) { ?>
	<h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5> <h4>
		<?php
		clean_authors(get_post_custom_values('Written by:'));
		clean_additional(get_post_custom_values('Additional reporting by:'));
		?> </h4>
				
		<?php wswwpx_content_extract ( '(More...)', '4:s', 55 ); ?><br /><br />
		<?php } endwhile; endif; ?>
	</div>

<?php get_footer(); ?>