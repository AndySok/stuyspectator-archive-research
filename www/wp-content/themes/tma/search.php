<?php get_header(); ?>        
        
        <div id="topbanner_arch" class="column span-14">   <!-- start top banner -->
            <div class="pagetitle">
                // here you go
            </div>
        </div>   <!-- end top banner -->
        
        
        <div id="arch_content" class="column span-14">   <!-- start home_content -->
        
        	<div class="column span-3 first">        
            	<h2 class="archive_name">Search Results</h2>        
            	
            	<div class="archive_meta">
					
					<div class="archive_number">
						You searched for '<?php the_search_query(); ?>'. Your search returned <?php $NumResults = $wp_query->found_posts; echo $NumResults; ?> results.
					</div>

            	</div>
            	
<p>If you're looking for a specific author, try using quotes around the name. </p><p>Can't find it? <strong>Put quotes around your search</strong> or try your query again with Google Site Search.</p>

<form action="http://stuyspectator.com/results/" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="000339603842136090691:posfatx_cb0" />
    <input type="hidden" name="cof" value="FORID:11" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="20" />
    <input type="submit" name="sa" value="Search" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&lang=en"></script>

            </div>

        <?php if (have_posts()) : ?>
                        
            <div class="column span-8">
            
            <?php while (have_posts()) : the_post(); ?>
            
            	<div class="archive_post_block">
            		<h3 class="archive_title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
            		
            		<div class="archive_post_meta"><?php
		clean_authors(get_post_custom_values('Written by:'));
		clean_additional(get_post_custom_values('Additional reporting by:'));
		?><!-- By <?php the_author_posts_link(); ?> --> <span class="dot">&sdot;</span> <?php the_time('F j, Y'); ?> <span class="dot">&sdot;</span> <a href="<?php comments_link(); ?>"><?php comments_number('Post a comment','One comment','% comments'); ?></a></div>
            		
            		<?php the_excerpt(); ?>
            	</div>
            	
            	<?php endwhile; ?>

				<div class="navigation">
					<p><?php next_posts_link('&laquo; Previous') ?> &nbsp; <?php previous_posts_link('Next &raquo;') ?></p>
				</div>

				<?php else : ?>     
            
            <div class="column span-8">
            	<div class="archive_post_block">
					<h3 class="archive_title">Welp, we couldn't find that...try again?</h3>
<div class="archive_post_meta">We all type things wrong at times.</div>
					<p>Don't give up hope! Try again with Google site search.</p>
<p>
<div id="cse" style="width: 100%;">Loading</div>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
   google.load('search', '1');
   google.setOnLoadCallback(function(){
      new google.search.CustomSearchControl('000339603842136090691:posfatx_cb0').draw('cse');
   }, true);
</script>
</p><br />
<p>Lost? You can go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
            	</div>

				<?php endif; ?>
            	
            </div>
            
            <?php get_sidebar(); ?>
        
        </div>   <!-- start home_content -->
        
        
<?php get_footer(); ?>