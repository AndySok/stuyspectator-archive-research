            <div id="home_right" class="column span-7 last">
            
            	<div id="home_about">
					
					<h3 class="mast3">Welcome to <?php bloginfo('name'); ?></h3>
					
					<?php $the_query = new WP_Query('pagename=description');
			
					while ($the_query->have_posts()) : $the_query->the_post();

					$do_not_duplicate = $post->ID; ?>
					
					<?php the_content(); ?>
					
					<?php endwhile; ?>				
				
				</div>
					
				<div class="column span-4 first">
            
					<h3 class="mast">Recent Articles</h3>
					
					<?php $the_query = new WP_Query('cat=-' .$catid. ',-' .$catid2. '&showposts=5&offset=0&orderby=post_date&order=desc');
			
					while ($the_query->have_posts()) : $the_query->the_post();

					$do_not_duplicate = $post->ID; ?>
					
					<div class="home_recent_post">
					
						<?php if ( get_post_meta($post->ID, 'thumb_home_img', true) ) { ?>
						<div class="home_recent_thumb">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/thumbs/<?php echo get_post_meta($post->ID, "thumb_home_img", $single = true); ?>" alt="<?php the_title(); ?>" /></a>
						</div>
						<?php } else { ?>
						<div class="home_recent_thumb">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php
							the_title(); ?>"><?php if (function_exists('the_thumb')) { the_thumb('altappend=recent_&subfolder=recent&width=48&height=48&keepratio=0'); } ?></a>
						</div>
						<?php } ?>
	
						
						<div class="home_recent_title" id="post-<?php the_ID(); ?>">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
						</div>
						
						<div class="home_recent_date">
							<?php the_time('F j, Y'); ?>
						</div>
						
						<div class="home_recent_auth">
							<?php clean_authors(get_post_custom_values('Written by:')); clean_additional(get_post_custom_values('Additional reporting by:')); ?>
						</div>
						
					</div>
					
					<?php endwhile; ?>
					
					
					<?php include('ad_home.php'); ?>
					
					<?php if ( !function_exists('dynamic_sidebar')
					        || !dynamic_sidebar('MiddleColumn') ) : ?>
					
					<div id="side_tag_cloud">
            
						<h3 class="mast">Browse</h3>
						
						<?php wp_tag_cloud(''); ?>
            		
            		</div>					
					
					<?php endif; ?>
            	
            	</div>