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
 * $Id: edit_thumb.php,v 1.35 2004/04/28 21:46:45 jenst Exp $
 */
?>
<?php

require(dirname(__FILE__) . '/init.php');

// Hack check
if (!$gallery->user->canWriteToAlbum($gallery->album) && !($gallery->album->isItemOwner($gallery->user->getUid(), $index) && $gallery->album->getItemOwnerModify())) {
	echo _("You are no allowed to perform this action !");
	exit;
}
doctype();
?>

<html>
<head>
  <title><?php echo _("Custom Thumbnail") ?></title>
  <?php common_header(); ?>
</head>

<?php
if (isset($action)) {
	if ($action == "doit") {
		
		#-- rebuild the thumbnail, cropped) ---
		echo(_("Remaking the Thumbnail..."));
		my_flush();
		if ($gallery->session->albumName && isset($index)) { 
			$photo = $gallery->album->getPhoto($index);
			$photo->image->setThumbRectangle($crop_x, $crop_y, $crop_w, $crop_h);
			$gallery->album->setPhoto($photo, $index);
			$gallery->album->makeThumbnail($index);
			$gallery->album->save(array(i18n("Thumbnail modified for %s"), 
						makeAlbumURL($gallery->album->fields["name"], $gallery->album->getPhotoId($index))));
		}	
		
		#-- close and reload parent ---
		dismissAndReload();
	
	} else if ($action == "cancel") {
		#-- just close ---
		dismiss();
	}
} else {
	#-- show the applet ---
?>
<body dir="<?php echo $gallery->direction ?>">

<center>
<p class="popuphead"><?php echo _("Custom Thumbnail") ?></p>

<?php
	#-- are we a go? ---
	if ($gallery->session->albumName && isset($index)) { 

		$photo = $gallery->album->getPhoto($index);
	
		#-- the url to the image ---
		$photoURL = $gallery->album->getAlbumDirURL("highlight") . "/";
		if ($photo->image->resizedName) {
			$photoURL .= $photo->image->resizedName . "." . $photo->image->type;
		} else {
			$photoURL .= $photo->image->name . "." . $photo->image->type;
		}

		#-- the dimensions of the raw image ---
		list($image_w, $image_h) = $photo->image->getRawDimensions();
		list($t_x, $t_y, $t_w, $t_h) = $photo->image->getThumbRectangle();
	
		$bgcolor = "#FFFFFF";

		/* Build up the submit URL */
		if (isset($HTTP_SERVER_VARS['HTTPS']) && stristr($HTTP_SERVER_VARS['HTTPS'], "on")) {
		    $submit = "https://";
		} else {
		    $submit = "http://";
		}

		if (empty($HTTP_SERVER_VARS['REQUEST_URI'])) {
		    $submit .= $HTTP_SERVER_VARS['HTTP_HOST'];
		    $submit .= $HTTP_SERVER_VARS['PATH_INFO'];
		    $submit .= '?';
		    $submit .= $HTTP_SERVER_VARS['QUERY_STRING'];
		} else {
		    $submit .= $HTTP_SERVER_VARS['HTTP_HOST'];
		    $submit .= $HTTP_SERVER_VARS['REQUEST_URI'];
		}
?>

<span class="popup">
<?php echo _("Choose which part of the image will compose your thumbnail:") ?>
</span>

<APPLET CODE="ImageCrop" WIDTH=460 HEIGHT=430 CODEBASE="<?php echo $gallery->app->photoAlbumURL .'/java' ?>" ARCHIVE="ImageTools.jar">
  <PARAM NAME="type"   VALUE="application/x-java-applet;version=1.1.2">
  <PARAM NAME=bgcolor  VALUE="<?php echo $bgcolor ?>">
  <PARAM NAME=image    VALUE="<?php echo $photoURL ?>">
  <PARAM NAME=image_w  VALUE="<?php echo $image_w ?>">
  <PARAM NAME=image_h  VALUE="<?php echo $image_h ?>">
  <PARAM NAME=crop_x   VALUE="<?php echo $t_x ?>">
  <PARAM NAME=crop_y   VALUE="<?php echo $t_y ?>">
  <PARAM NAME=crop_w   VALUE="<?php echo $t_w ?>">
  <PARAM NAME=crop_h   VALUE="<?php echo $t_h ?>">
  <PARAM NAME=submit   VALUE="<?php echo $submit ?>">
  <PARAM NAME=crop_to_size  VALUE="<?php echo $gallery->album->fields["thumb_size"] ?>">
</APPLET>

<?php 
//    	-- we're not a go. abort! abort! ---
	} else { 
		echo gallery_error(_("no album / index specified"));
	} 
} 
?>
</center>
<?php print gallery_validation_link("edit_thumb.php"); ?>
</body>
</html>

