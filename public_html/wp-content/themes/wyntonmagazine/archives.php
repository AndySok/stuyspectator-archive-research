<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="pagecontent">

<?php include (TEMPLATEPATH . '/searchform.php'); ?>

<h2><?php _e('Archives by Month:','wyntonmagazine'); ?></h2>
  <ul class="bullets">
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h2><?php _e('Archives by Subject:','wyntonmagazine'); ?></h2>
  <ul class="bullets">
     <?php wp_list_categories('title_li='); ?>
  </ul>

</div>	


<?php get_footer(); ?>
