<?php
/*********************** %%%copyright%%% *****************************************
 *
 * FusionTicket - ticket reservation system
 * Copyright (C) 2007-2008 Christopher Jenkins. All rights reserved.
 *
 * Original Design:
 *	phpMyTicket - ticket reservation system
 * 	Copyright (C) 2004-2005 Anna Putrino, Stanislav Chachkov. All rights reserved.
 *
 * This file is part of fusionTicket.
 *
 * This file may be distributed and/or modified under the terms of the
 * "GNU General Public License" version 3 as published by the Free
 * Software Foundation and appearing in the file LICENSE included in
 * the packaging of this file.
 *
 * This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
 * THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE.
 *
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * Contact info@noctem.co.uk if any conditions of this licencing isn't
 * clear to you.
 */

/**
 * @author Chris Jenkins
 * @copyright 2008
 */

/**
 * This define is used to store the passwords, pleace do not change this after
 * there are uses registrated to the system.
 * This this will invalided all given passwords in the system.
 */
define ('AUTH_REALM','Fusion Ticket Login');

if (!defined('DS')) {
/**
 * shortcut for / or \ (depending on OS)
 */
	define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
	/**
	 * absolute filesystem path to the root directory of this framework
	 */
	define('ROOT',(dirname(dirname(dirname(__FILE__)))).DS);
}
if (!defined('WWW_ROOT')) {
	/**
	 * absolute filesystem path to the webroot-directory of this framework
	 */
	define('WWW_ROOT', ROOT);
}
if (!defined('INC')) {

	/**
	 * includes dir
	 */
	 define('INC',ROOT.'includes'.DS);
}

if (!defined('CLASSES')) {
	/**
	 * absolute filesystem path to the lib-directory of this framework
	 */
	define('CLASSES',INC.'classes'.DS);
}
if (!defined('PATH_SEPARATOR')) {
    if (OS_WINDOWS) {
        define('PATH_SEPARATOR', ';');
    } else {
        define('PATH_SEPARATOR', ':');
    }
}
set_include_path(INC. PATH_SEPARATOR.
                 INC.'pear'.PATH_SEPARATOR.
                 get_include_path());
?>
