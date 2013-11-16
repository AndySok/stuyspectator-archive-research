<?php get_header(); ?>

<div id="content">

	<div id="homepage">
				
	<div id="homepageleft">		
	
		<div class="featured">
			<h2>Breaking News</h2>
			<img style="margin-bottom:10px" src="<?php bloginfo('template_url'); ?>/images/hp-main.jpg" alt="Featured Story" />
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(125, "Read more &raquo;"); ?><div style="clear:both;"></div>
			<?php endwhile; ?>
		</div>
		
		<div class="newsletter">
			<h2>eNews &amp; Updates</h2>
			<p>Sign up to receive the latest breaking news, as well as all of your other favorite headlines!</p><form action="http://www.feedburner.com/fb/a/emailverify" method="post" target="popupwindow" onsubmit="window.open('http://www.feedburner.com', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p><input type="text" value="Enter your email address..." id="s2" onfocus="if (this.value == 'Enter your email address...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your email address...';}" name="email"/><input type="hidden" value="http://feeds.feedburner.com/~e?ffid=FEEDBURNERID" name="url"/><input type="hidden" value="eNews Subscribe" name="title"/><input type="submit" value="GO" id="sbutt2" /></p></form>
		</div>
		
		<h3>Other Featured Stories</h3>
			<ul>
				<?php $recent = new WP_Query("cat=1&showposts=10"); while($recent->have_posts()) : $recent->the_post();?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
			</ul>
			
	</div>
		
	<div id="homepageright">

		<h2>News Section #1</h2>
	
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(130, ""); ?>
			
			<div class="hppostmeta">
				<p><?php the_time('F j, Y'); ?> | <a href="<?php the_permalink() ?>" rel="bookmark">Read the story &raquo;</a></p>
			</div>
			
			<?php endwhile; ?><br />
			
		<h2>News Section #2</h2>
	
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(130, ""); ?>
			
			<div class="hppostmeta">
				<p><?php the_time('F j, Y'); ?> | <a href="<?php the_permalink() ?>" rel="bookmark">Read the story &raquo;</a></p>
			</div>
			
			<?php endwhile; ?><br />
			
		<h2>News Section #3</h2>
	
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(130, ""); ?>
			
			<div class="hppostmeta">
				<p><?php the_time('F j, Y'); ?> | <a href="<?php the_permalink() ?>" rel="bookmark">Read the story &raquo;</a></p>
			</div>
			
			<?php endwhile; ?><br />
			
		<h2>News Section #4</h2>
	
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(130, ""); ?>
			
			<div class="hppostmeta">
				<p><?php the_time('F j, Y'); ?> | <a href="<?php the_permalink() ?>" rel="bookmark">Read the story &raquo;</a></p>
			</div>
			
			<?php endwhile; ?><br />
			
		<h2>News Section #5</h2>
	
			<?php $recent = new WP_Query("cat=1&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
			<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
			<?php the_content_limit(130, ""); ?>
			
			<div class="hppostmeta">
				<p><?php the_time('F j, Y'); ?> | <a href="<?php the_permalink() ?>" rel="bookmark">Read the story &raquo;</a></p>
			</div>
			
			<?php endwhile; ?><br />
						
	</div>
		
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>