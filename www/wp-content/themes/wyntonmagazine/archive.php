<?php get_header(); ?>

<div id="content">
  <?php is_tag(); ?>
  <?php if (have_posts()) : ?>
  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
  <?php /* If this is a category archive */ if (is_category()) { ?>
  <h2 class="pagetitle"><?printf( __('%s','wyntonmagazine'), single_cat_title('', false)); ?></h2>
  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
  <h2 class="pagetitle">
    <?php _e('Posts Tagged','branfordmagazine'); ?>
    &#8216;
    <?php single_tag_title(); ?>
    &#8217;</h2>
  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
  <h2 class="pagetitle"><?printf( __('Archive for %s','wyntonmagazine'), get_the_time(__('F jS, Y','wyntonmagazine'))); ?></h2>
  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
  <h2 class="pagetitle"><?printf( __('Archive for %s','wyntonmagazine'), get_the_time(__('F Y','wyntonmagazine'))); ?></h2>
  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
  <h2 class="pagetitle"><?printf( __('Archive for %s','wyntonmagazine'), get_the_time('Y')); ?></h2>
  <?php /* If this is a search */ } elseif (is_search()) { ?>
  <h2 class="pagetitle">
    <?php __('Search Results','wyntonmagazine'); ?>
  </h2>
  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
  <h2 class="pagetitle">
    <?php _e('All entries by this author','wyntonmagazine'); ?>
  </h2>
  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="pagetitle">
      <?php _e('Blog Archives','wyntonmagazine'); ?>
    </h2>
    <?php } ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post">
    <h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php __('Permanent Link to','wyntonmagazine');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h4>
    <small class="commentmetadata">
    <?php _e('By','wyntonmagazine');?>
    <?php the_author_posts_link('namefl'); ?>
    |
    <?php the_time(__ ('F jS, Y', 'wyntonmagazine'));?>
    |
    <?php _e('Category:','wyntonmagazine');?>
    <?php the_category(', ');?>
    | 
    <?php comments_popup_link(__ ('No Comments &#187;', 'wyntonmagazine'), __ ('1 Comment &#187;', 'wyntonmagazine'), __ngettext ('% comment', '% comments', get_comments_number (),'wyntonmagazine')); ?>
    <?php edit_post_link('Edit', ' | ', ' | '); ?>
    </small>
    <div class="entry">
      <?php the_excerpt() ?>
    </div>
    <hr />
    <br />
  </div>
  <?php endwhile; ?>
  <div class="navigation">
    <div class="preventries">
      <?php next_posts_link(__('&laquo; Older articles','wyntonmagazine')) ?>
    </div>
    <div class="nextentries">
      <?php previous_posts_link(__('Newer articles &raquo;','wyntonmagazine')) ?>
    </div>
  </div>
  <?php else : ?>
  <h2 class="center">
    <?php __('Not Found','wyntonmagazine') ?>
  </h2>
  <?php include (TEMPLATEPATH . '/searchform.php'); ?>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
<?php get_footer(); ?>
