<?php
/* Define the custom box */

// WP 3.0+
// add_action('add_meta_boxes', 'am_add_custom_box');

// backwards compatible
add_action('admin_init', 'am_add_custom_box', 1);

/* Do something with the data entered */
add_action('save_post', 'am_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function am_add_custom_box() {
    add_meta_box( 'am_sectionid', __( 'Featured Post', 'neo_wdl' ), 
                'am_slider_custom_box', 'post', 'side' );
}

/* Prints the box content */
function am_slider_custom_box($post) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'am_noncename' );
  
  $slider = get_post_meta($post->ID, '_slider', true);

  if($slider=='yes')
  	$slider_ck = ' checked="checked"';
  else
  	$slider_ck = '';

  // The actual fields for data entry
  echo '<input type="checkbox" id="am_slider" name="_slider"'.$slider_ck.' value="yes" /> ';
  echo '<label for="am_slider">' . __("Feature this post?", 'neo_wdl' ) . '</label>';
}

/* When the post is saved, saves our custom data */
function am_save_postdata( $post_id ) {

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['am_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data

  $_slider = $_POST['_slider'];
  esc_attr( $_slider );
  
  update_post_meta($post_id, '_slider', $_slider);

  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)

   return $mydata;
}
add_filter( 'the_content_more_link', 'am_more_link', 10, 2 );

function am_more_link( $more_link, $more_link_text ) {
	return '<br /><br />'.$more_link;
}

add_filter('the_title','am_has_title');
function am_has_title($title){
	global $post;
	if($title == ''){
		return get_the_time(get_option( 'date_format' ));
	}else{
		return $title;
	}
}
?>