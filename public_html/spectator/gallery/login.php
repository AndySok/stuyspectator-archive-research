<?php
/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2004 Bharat Mediratta
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * $Id: login.php,v 1.51 2004/05/20 22:06:03 cryptographite Exp $
 */
?>
<?php

require(dirname(__FILE__) . '/init.php');

// Security check.
if (!isset($username)) {
	$username="";
}
$username = removeTags($username);
doctype();
?>

<html>
<head>
	<title><?php echo sprintf(_("Login to %s"), $gallery->app->galleryTitle) ?></title>
  <?php common_header(); ?>
</head>
<body dir="<?php echo $gallery->direction ?>">

<center>
<span class="popuphead"><?php echo sprintf(_("Login to %s"), $gallery->app->galleryTitle) ?></span>
<br>
<br>
<?php

if (isset($username) && isset($gallerypassword)) {
       	$tmpUser = $gallery->userDB->getUserByUsername($username);
       	if ($tmpUser && $tmpUser->isCorrectPassword($gallerypassword)) {

		$tmpUser->log("login");
		$tmpUser->save();
	       	$gallery->session->username = $username;
		gallery_syslog("Successful login for $username from " . $HTTP_SERVER_VARS['REMOTE_ADDR']);
	       	if ($tmpUser->getDefaultLanguage() != "") {
		       	$gallery->session->language = 
				$tmpUser->getDefaultLanguage();
	       	}
	       	if (!$gallery->session->offline) {
		       	dismissAndReload();
	       	} else {
		       	print "<span class=error>SUCCEEDED</span><p>";
		       	return;
	       	}
       	} else {
	       	$invalid = 1;
	       	$gallerypassword = null;
		gallery_syslog("Failed login for $username from " . $HTTP_SERVER_VARS['REMOTE_ADDR']);
       	}
}
?>
<div class="popup">
<?php echo makeFormIntro("login.php", array("name" => "login_form", "method" => "POST")); ?>
<?php echo _("Logging in gives you greater permission to view, create, modify and delete albums.") ?>
<p>
<table>
<?php if (isset($invalid)) { ?>
 <tr>
  <td colspan=2>
   <?php echo gallery_error(_("Invalid username or password")); ?>
  </td>
 </tr>
<?php } ?>

 <tr>
  <td class="popup">
   <?php echo _("Username") ?>
  </td>
  <td>
   <input type=text name="username" value="<?php echo $username ?>">
  </td>
 </tr>

<?php if (isset($error) && !isset($username)) { ?>
 <tr>
  <td colspan=2 align=center>
   <?php echo gallery_error(_("You must specify a username")); ?>
  </td>
 </tr>
<?php } ?>

 <tr>
  <td class="popup">
	<?php echo _("Password") ?>
  </td>
  <td>
   <input type=password name="gallerypassword">
  </td>
 </tr>

<?php if (isset($error) && !isset($gallerypassword)) { ?>
 <tr>
  <td colspan=2 align=center>
   <?php echo gallery_error(_("You must specify a password")); ?>
  </td>
 </tr>
<?php } ?>

</table>
<p>
<input type="submit" name="login" value="<?php echo _("Login") ?>">
<input type="button" name="cancel" value="<?php echo _("Cancel") ?>" onclick='parent.close()'>
</form>
<br><hr>

<?php 
if (isset($gallery->app->emailOn) && $gallery->app->emailOn == 'yes') {

echo makeFormIntro("login.php", array("name" => "forgot_form", "method" => "POST")); ?>
<span class="popuphead"><?php echo _("Forgotten your password?") ?></span>
<br>
<br>
<?php
if (isset($forgot)) {
       	$tmpUser = $gallery->userDB->getUserByUsername($username);
       	if ($tmpUser) {
		$wait_time=15;
		if ($tmpUser->lastAction ==  "new_password_request" && 
			time() - $tmpUser->lastActionDate < $wait_time * 60) {
		       	echo gallery_error(sprintf(_("The last request for a password was less than %d minutes ago.  Please check for previous email, or wait before trying again."), $wait_time));
			
		} else if (gallery_validate_email($tmpUser->getEmail())) {
		       	if (gallery_mail( $tmpUser->email,
				_("New password request"),
			       	sprintf(_("Someone requested a new password for user %s from Gallery '%s' on %s. You can create a password by visiting the link below. If you didn't request a password, please ignore this mail. "), $username, $gallery->app->galleryTitle, $gallery->app->photoAlbumURL) . "\n\n" .
			      	sprintf(_("Click to reset your password: %s"),
				       	$tmpUser->genRecoverPasswordHash()) . "\n",
				sprintf(_("New password request %s"), $username))) {
			       	$tmpUser->log("new_password_request");
			       	$tmpUser->save();
			       	echo sprintf(_("An email has been sent to the address stored for %s.  Follow the instructions to change your password.  If you do not receive this email, please contact the Gallery administrators."),$username)  ?> 
					<br><br>
			       	<form> <input type="button" value="<?php echo _("Dismiss") ?>" onclick='parent.close()'> </form>
				<?php
		       	} else {
			       	echo gallery_error(sprintf(_("Email could not be sent.  Please contact %s administrators for a new password"),$gallery->app->galleryTitle ));
		       	}
		       	return;
	       	} else {
		       	echo gallery_error(sprintf(_("There is no valid email for this account.  Please contact %s administrators for a new password"),$gallery->app->galleryTitle ));
	       	}
       	} else {
	       	echo gallery_error(_("Not a valid username"));
	}
} 
?>

<p>
<table>
 <tr>
  <td class="popup">
   <?php echo _("Username") ?>
  </td>
  <td>
   <input type="text" name="username" value="<?php echo $username ?>">
  </td>
 </tr>
 </table>
 <p>
<input type="submit" name="forgot" value="<?php echo _("Send me my password") ?>">
</form>
<?php } /* End if-email-on */ ?>

<script language="javascript1.2" type="text/JavaScript">
<!--
// position cursor in top form field
document.login_form.username.focus();
//--> 
</script>

</div>
</center>
<?php print gallery_validation_link("login.php"); ?>
</body>
</html>
