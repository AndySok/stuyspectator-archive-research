<?php get_header(); ?>
   <div id="bd">
      <div id="toppanel">
        <div class="yui-g">
          <div class="yui-u first">
            <div id="banner">
            <?php $posts = get_posts( "category=9&numberposts=1" ); ?>
            <?php if( $posts ) : ?>
            <?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
            <?php the_excerpt(); ?>
            <h1 class="home"><a href="<?php the_permalink() ?>" title="Click to read <?php the_title(); ?>"><?php the_title(); ?></a></h1>
            <?php the_content("Continue reading '" . the_title('', '', false) . "'"); ?>
          <?php endforeach; ?>
          <?php endif; ?>
          </div>
        </div>

        <div class="yui-g">
          <div class="yui-u first">
            <div id="recentfeatures">
            <h4 class="sectionheaders">News</h4>
            <?php $posts = get_posts( "category=7&numberposts=3" ); ?>
            <?php if( $posts ) : ?>
            <?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
            <div class="colitem">
            <h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <p><?php $values = get_post_custom_values("summary"); echo $values[0]; ?> &rarr; <a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>">Read more</a> </p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <div class="yui-u">
          <div id="promocolumn">
          <h4 class="sectionheaders">Find An Article</h4>
          <div class="colitem">
          <?php include(TEMPLATEPATH . '/searchform.php') ; ?>
          </div>
          <?php include(TEMPLATEPATH . '/promobox.php') ; ?>
        <div class="topdarkblue">
        <h2>Weather</h2>
        <script src="http://netwx.accuweather.com/netweatherV2.asp?zipcode=10282&lang=eng&size=5&theme=1&metric=0"></script>
        </div>
      </div>
      </div>
    </div>
	</div>
</div>

<div id="bottompanel">
  <div class="yui-g">
    <div class="yui-g first">
      <div class="yui-u first">
        <div class="topbrown">
          <h4 class="sectionheaders">Features</h4>
          <?php $posts = get_posts( "category=6&numberposts=3" ); ?>
          <?php if( $posts ) : ?>
          <?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
          <h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
          <p><?php $values = get_post_custom_values("summary"); echo $values[0]; ?> &rarr; <a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>">Read more</a> </p>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

        <div class="yui-u">
          <div class="toplightblue">
          <h4 class="sectionheaders">Recent Comments</h4>
          <?php if (function_exists('get_recent_comments')) { ?>
          <h2><?php _e('Recent Comments:'); ?></h2>
          <ul>
            <?php get_recent_comments(); ?>
          </ul>
          <?php } ?>   
        </div>
      
      </div>
    </div>

    <div class="yui-g">
        <div class="yui-u first">
        	<div class="topdarkblue">
          <h4 class="sectionheaders">A&E</h4>
          <?php $posts = get_posts( "category=4&numberposts=2" ); ?>
          <?php if( $posts ) : ?>
          <?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
          <h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
          <p><?php $values = get_post_custom_values("summary"); echo $values[0]; ?> &rarr; <a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>">Read more</a> </p>
            <?php endforeach; ?>
            <?php endif; ?>
			</div>
	        </div>

        <div class="yui-u">
        	<div class="topyellow">
            <h4 class="sectionheaders">Sports</h4>
            <?php $posts = get_posts( "category=5&numberposts=2" ); ?>
            <?php if( $posts ) : ?>
            <?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
            <h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <p><?php $values = get_post_custom_values("summary"); echo $values[0]; ?> &rarr; <a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>">Read more</a> </p>
            <?php endforeach; ?>
            <?php endif; ?>
			  </div>
        </div>
        </div>
        </div>
      </div>
      </div>
<?php get_footer(); ?>