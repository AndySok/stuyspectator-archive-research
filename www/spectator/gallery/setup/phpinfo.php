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
 * $Id: phpinfo.php,v 1.9.2.2 2004/08/24 17:22:08 cryptographite Exp $
 */
?>
<?php
	/* load necessary functions */
	require (dirname(__FILE__) . '/init.php');	
	require (GALLERY_SETUPDIR . '/functions.inc');
	configLogin(basename(__FILE__));
	if (isset($_POST)) unset($_POST);
	if (isset($_REQUEST)) unset($_REQUEST);
	if (isset($_GET)) unset($_GET);
	if (isset($_COOKIE)) unset($_COOKIE);
	if (isset($_SERVER["HTTP_COOKIE"])) unset($_SERVER["HTTP_COOKIE"]);
	phpinfo(); 
?>
