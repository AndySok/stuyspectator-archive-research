<?php
	global $am_option, $post;

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'neo_wdl') ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('Comments', 'neo_wdl').' (0)', __('Comment', 'neo_wdl').' (1)', __('Comments', 'neo_wdl').' (%)'); ?></h3>

	<ol class="commentlist">
	<?php wp_list_comments('callback=am_comments'); ?>

	</ol>

	<?php $paginate_comments_links = paginate_comments_links('echo=0'); ?>
	<?php if(!empty($paginate_comments_links)) : ?>
	<div class="pagination2">
		<?php echo $paginate_comments_links; ?>
	</div>
	<?php endif; ?>
<?php endif; ?>
<?php if(!empty($am_option['ads']['ads_comment_form_300'])) : ?>
<div class="ads ads_comments"><?php echo $am_option['ads']['ads_comment_form_300']; ?></div>
<?php endif; ?>
<?php 


	$fields =  array(
		'author' => '<p><input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="22" tabindex="1" /><label for="author"><small>'.__('Name', 'neo_wdl') . ( $req ? __('(required)', 'neo_wdl').'</small></label></p>':'' ),
		
		'email' => '<p><input type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="22" tabindex="2" /><label for="email"><small>'.__('E-mail', 'neo_wdl') . ( $req ? __('(required)', 'neo_wdl').'</small></label></p>':'' ),
		
		'url'    => '<p><input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="22" tabindex="3" /><label for="url"><small>'.__('Website', 'neo_wdl').'</small></label></p>'
	);

	$args = array(
		'fields' => $fields,
		'comment_notes_after' => ''
	);
	comment_form( $args );
?>