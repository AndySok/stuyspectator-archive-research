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
 * $Id: gpl.txt,v 1.6 2004/02/03 05:03:38 beckettmw Exp $
 */
?>
<?php
/* 
 * Protect against very old versions of 4.0 (like 4.0RC1) which  
 * don't implicitly create a new stdClass() when you use a variable 
 * like a class. 
 */ 
if (!isset($gallery)) { 
        $gallery = new stdClass(); 
}
if (!isset($gallery->app)) { 
        $gallery->app = new stdClass(); 
}

/* Version  */
$gallery->app->config_version = '82';

/* Features */
$gallery->app->feature["zip"] = 1;
$gallery->app->feature["rewrite"] = 1;
$gallery->app->feature["mirror"] = 0; // (missing <i>mirrorSites</i> -- it's optional)

/* Constants */
$gallery->app->galleryTitle = "Stuyvesant Spectator Online Gallery";
$gallery->app->skinname = "phpbb_aeolus";
$gallery->app->uploadMode = "form";
$gallery->app->albumDir = "/data/web/orgs/spectator/gallery/albums";
$gallery->app->tmpDir = "/data/web/orgs/spectator/gallery/temp";
$gallery->app->photoAlbumURL = "http://spectator.stuy.edu/gallery";
$gallery->app->albumDirURL = "http://spectator.stuy.edu/gallery/albums";
// optional <i>watermarkDir</i> missing
$gallery->app->movieThumbnail = "/data/web/orgs/spectator/gallery/images/movie.thumb.jpg";
// optional <i>mirrorSites</i> missing
$gallery->app->embedded_inside_type = "";
$gallery->app->geeklog_dir = "/path/to/geeklog/public_html";
$gallery->app->graphics = "ImageMagick";
// optional <i>pnmDir</i> missing
$gallery->app->pnmtojpeg = "pnmtojpeg";
$gallery->app->ImPath = "/usr/bin";
$gallery->app->autorotate = "yes";
$gallery->app->jpegImageQuality = "90";
$gallery->app->showAlbumTree = "no";
$gallery->app->highlight_size = "200";
$gallery->app->showOwners = "no";
$gallery->app->albumsPerPage = "5";
$gallery->app->showSearchEngine = "yes";
$gallery->app->slowPhotoCount = "no";
$gallery->app->gallery_thumb_frame_style = "simple_book";
$gallery->app->zipinfo = "/usr/bin/zipinfo";
$gallery->app->unzip = "/usr/bin/unzip";
$gallery->app->use_exif = "/usr/bin/jhead";
$gallery->app->cacheExif = "no";
$gallery->app->use_jpegtran = "/usr/bin/jpegtran";
$gallery->app->ML_mode = "0";
$gallery->app->dateString = "%x";
$gallery->app->dateTimeString = "%c";
$gallery->app->emailOn = "no";
// optional <i>adminEmail</i> missing
// optional <i>senderEmail</i> missing
$gallery->app->emailSubjPrefix = "[Gallery]";
// optional <i>emailGreeting</i> missing
$gallery->app->selfReg = "no";
$gallery->app->selfRegCreate = "no";
$gallery->app->multiple_create = "no";
$gallery->app->adminCommentsEmail = "no";
$gallery->app->adminOtherChangesEmail = "no";
// optional <i>email_notification</i> missing
$gallery->app->gallery_slideshow_type = "off";
$gallery->app->gallery_slideshow_length = "20";
$gallery->app->gallery_slideshow_loop = "yes";
$gallery->app->slideshowMode = "high";
$gallery->app->comments_enabled = "yes";
$gallery->app->comments_indication = "photos";
$gallery->app->comments_indication_verbose = "no";
$gallery->app->comments_anonymous = "no";
$gallery->app->comments_display_name = "!!FULLNAME!! (!!USERNAME!!)";
$gallery->app->comments_addType = "popup";
$gallery->app->comments_length = "300";
$gallery->app->comments_overview_for_all = "no";
$gallery->app->timeLimit = "30";
$gallery->app->blockRandomCache = "86400";
$gallery->app->debug = "no";
$gallery->app->devMode = "no";
$gallery->app->useSyslog = "no";
$gallery->app->use_flock = "yes";
$gallery->app->expectedExecStatus = "0";
$gallery->app->sessionVar = "gallery_session";
$gallery->app->rssEnabled = "no";
$gallery->app->rssMode = "basic";
// optional <i>rssHighlight</i> missing
$gallery->app->rssMaxAlbums = "25";
$gallery->app->rssVisibleOnly = "yes";
$gallery->app->rssDCDate = "no";
$gallery->app->rssBigPhoto = "no";
$gallery->app->rssPhotoTag = "yes";
$gallery->app->userDir = "/data/web/orgs/spectator/gallery/albums/.users";
$gallery->app->maximumAlbumDepth = "50";

/* Defaults */
$gallery->app->default["bordercolor"] = "black";
$gallery->app->default["border"] = "1";
$gallery->app->default["font"] = "arial";
$gallery->app->default["cols"] = "4";
$gallery->app->default["rows"] = "4";
$gallery->app->default["thumb_size"] = "150";
$gallery->app->default["resize_size"] = "640";
$gallery->app->default["resize_file_size"] = "0";
$gallery->app->default["max_size"] = "off";
$gallery->app->default["max_file_size"] = "0";
$gallery->app->default["useOriginalFileNames"] = "yes";
$gallery->app->default["add_to_beginning"] = "no";
$gallery->app->default["fit_to_window"] = "no";
$gallery->app->default["use_fullOnly"] = "no";
$gallery->app->default["print_photos"] = "";
$gallery->app->default["returnto"] = "yes";
$gallery->app->default["defaultPerms"] = "everybody";
$gallery->app->default["display_clicks"] = "yes";
$gallery->app->default["extra_fields"] = "Description";
$gallery->app->default["showDimensions"] = "no";
$gallery->app->default["item_owner_modify"] = "yes";
$gallery->app->default["item_owner_delete"] = "yes";
$gallery->app->default["item_owner_display"] = "no";
$gallery->app->default["voter_class"] = "Nobody";
$gallery->app->default["poll_type"] = "critique";
$gallery->app->default["poll_scale"] = "3";
$gallery->app->default["poll_hint"] = "Vote for this image";
$gallery->app->default["poll_show_results"] = "no";
$gallery->app->default["poll_num_results"] = "3";
$gallery->app->default["poll_orientation"] = "vertical";
$gallery->app->default["poll_nv_pairs"][0]["name"] = "Excellent";
$gallery->app->default["poll_nv_pairs"][0]["value"] = "5";
$gallery->app->default["poll_nv_pairs"][1]["name"] = "Very Good";
$gallery->app->default["poll_nv_pairs"][1]["value"] = "4";
$gallery->app->default["poll_nv_pairs"][2]["name"] = "Good";
$gallery->app->default["poll_nv_pairs"][2]["value"] = "3";
$gallery->app->default["poll_nv_pairs"][3]["name"] = "Average";
$gallery->app->default["poll_nv_pairs"][3]["value"] = "2";
$gallery->app->default["poll_nv_pairs"][4]["name"] = "Poor";
$gallery->app->default["poll_nv_pairs"][4]["value"] = "1";
$gallery->app->default["poll_nv_pairs"][5]["name"] = "";
$gallery->app->default["poll_nv_pairs"][5]["value"] = "";
$gallery->app->default["poll_nv_pairs"][6]["name"] = "";
$gallery->app->default["poll_nv_pairs"][6]["value"] = "";
$gallery->app->default["poll_nv_pairs"][7]["name"] = "";
$gallery->app->default["poll_nv_pairs"][7]["value"] = "";
$gallery->app->default["poll_nv_pairs"][8]["name"] = "";
$gallery->app->default["poll_nv_pairs"][8]["value"] = "";
$gallery->app->default["slideshow_type"] = "ordered";
$gallery->app->default["slideshow_recursive"] = "no";
$gallery->app->default["slideshow_loop"] = "yes";
$gallery->app->default["slideshow_length"] = "0";
$gallery->app->default["album_frame"] = "simple_book";
$gallery->app->default["thumb_frame"] = "solid";
$gallery->app->default["image_frame"] = "solid";
?>
