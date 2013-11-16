<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

?>

<!-- You can start editing here. -->


<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number('No Comment', 'One Comment', '% Comments' );?> <a href="#respond" title="<?php _e("Leave a comment"); ?>">&raquo;</a></h3>
<ol>
	<?php foreach ($comments as $comment) : ?>
	
<?php
$isByAuthor = false;
if($comment->comment_author_email == get_the_author_email()) {
$isByAuthor = true;
}?>
		<div class="commentlist<?php if($isByAuthor ) { echo '_author';} ?>">

<li id="comment-<?php comment_ID() ?>" class="clearfloat">

			<div class="comment_text">
			<?php if ($comment->comment_approved == '0') : ?>
			<em>Your comment is awaiting moderation.</em>
			<?php endif; ?>
			<?php comment_text() ?>
			</div>	
	
			<div class="commentmetadata"><div class="left"><cite>//<?php comment_author_link() ?> <?php if($isByAuthor ) { echo '(author)';} ?> </cite><br/><span class="meta"><?php comment_date('j F Y') ?> at <?php comment_time() ?> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></span></div></div>
		
		</li>

</div>
	<?php endforeach; /* end for each comment */ ?>
</ol>
	

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>


<h3 id="respond">Have your say!</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p>Add your comment below, or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your own site. You can also <?php comments_rss_link('subscribe to these comments'); ?> via RSS.</p>

<p>Be nice. Keep it clean. Stay on topic. No spam.</p>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)"; ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small>Website (optional)</small></label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" cols="100%" rows="15" tabindex="4"></textarea></p>
<p>You can use these tags:<br/><code><?php echo allowed_tags(); ?></code></p>

<p><input name="submit" class="button" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; ?>


