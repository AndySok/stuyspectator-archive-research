<div id="sidebar">
  <ul id="sidelist">
    <?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
    <?php endif; ?>
    <?php if (is_single()) {
// this is where 10 headlines from the current category get printed	  
global $post;
$categories = get_the_category();
foreach ($categories as $category) :
?>
    <li>
      <h2>
        <?php _e('More from this category','wyntonmagazine');?>
      </h2>
      <ul class="more">
        <?php
$posts = get_posts('numberposts=5&category='. $category->term_id);
foreach($posts as $post) :
?>
        <li><a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
          </a></li>
        <?php endforeach; ?>
        <li><strong><a href="<?php echo get_category_link($category->term_id);?>" title="<?php _e('View all posts filed under','wyntonmagazine');?> <?php echo $category->name; ?>">
          <?php _e('All articles in','wyntonmagazine');?>
          '<?php echo $category->name; ?>' &raquo;</a></strong></li>
      </ul>
    </li>
    <?php endforeach;?>
        
		<?php } ?>

    <!-- Recent Posts -->
    <h2>
      <?php _e('Recent Posts','wyntonmagazine');?>
    </h2>
    <li id="recent">
      <ul class="recent">
        <?php wp_get_archives('type=postbypost&limit=10'); ?>
      </ul>
    </li>
    <!-- END OF RECENT POSTS -->
    <!-- This works only if the "Get Recent Comments" plugin is installed -->
    <?php if (function_exists('get_recent_comments')) { ?>
    <li>
      <h2>
        <?php _e('Recent Comments'); ?>
      </h2>
      <ul class="recent-comments">
        <?php get_recent_comments(); ?>
      </ul>
    </li>
    <?php } ?>
    <!-- END RECENT COMMENTS -->
    <!-- WP standard tag cloud -->
    <?php if ( function_exists('wp_tag_cloud') ) : ?>
    <li>
      <h2>Popular Tags</h2>
      <ul>
        <?php wp_tag_cloud('smallest=8&largest=22'); ?>
      </ul>
    </li>
    <?php endif; ?>
    <!-- END OF TAG CLOUD -->
    <!-- RSS Feeds -->
    <li>
      <h3>
        <?php _e('Stay informed','wyntonmagazine');?>
      </h3>
      <ul class="feed">
        <li><a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a></li>
        <li><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments RSS)</a></li>
      </ul>
    </li>
    <!-- END OF RSS -->
  </ul>
  <!--END SIDELIST-->
</div>
<!--END SIDEBAR-->
