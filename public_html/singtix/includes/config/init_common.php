<?php
/**
%%%copyright%%%
 *
 * FusionTicket - ticket reservation system
 *  Copyright (C) 2007-2009 Christopher Jenkins, Niels, Lou. All rights reserved.
 *
 * Original Design:
 *	phpMyTicket - ticket reservation system
 * 	Copyright (C) 2004-2005 Anna Putrino, Stanislav Chachkov. All rights reserved.
 *
 * This file is part of FusionTicket.
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
 * Any links or references to Fusion Ticket must be left in under our licensing agreement.
 *
 * By USING this file you are agreeing to the above terms of use. REMOVING this licence does NOT
 * remove your obligation to the terms of use.
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * Contact help@fusionticket.com if any conditions of this licencing isn't
 * clear to you.
 */

 
  global $_SHOP;

  require_once('defines.php');
  if (!file_exists(INC.'config'.DS."init_config.php")){
    echo "<a href='inst/index.php'>Install me now!</a>";
    exit;
  }


 /*
	if (ini_get('register_globals')) {

		// Emulate register_globals off
		if (ini_get('register_globals')) {
			 $superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET, $_REQUEST);
			 if (isset($_SESSION)) {
					 array_unshift($superglobals, $_SESSION);
			 }
			 foreach ($superglobals as $superglobal) {
					 foreach ($superglobal as $global => $value) {
							 unset($GLOBALS[$global]);
					 }
			 }
		}

	}
*/
 //Shopping cart and place reservation delay
  //how many times the place can stay reserved
  $_SHOP->res_delay=660;

  //the same value for the shopping cart, usually smaller
  $_SHOP->cart_delay=$_SHOP->res_delay-60;
  

//  $_SHOP->dir_mode=0755;
  $_SHOP->file_mode=0644;

  $_SHOP->install_dir =ROOT;
  $_SHOP->includes_dir=INC;

	//where uploaded files lives (event images, ..)
	//should be writable
  $_SHOP->files_dir=ROOT."files";

  //this folder contains font files required by pdf templates
  //it should be writable by php
  $_SHOP->font_dir=INC."fonts".DS;

  //temporary folder
  //should be writeable by php
  $_SHOP->tmp_dir=INC."temp".DS;
  
  	//Where templates are stored..
	$_SHOP->templates_dir=INC."temp".DS;
	
  //where smarty templates and other tpl related stuff lives
  $_SHOP->tpl_dir=INC."template".DS;
  
  // this selects the theme that you like to use.
  $_SHOP->theme_dir = $_SHOP->tpl_dir . "theme".DS."default".DS;

	//default paper size and orientation for pdf files
	//paper size: 'a4', 'legal', etc..or  array(x0,y0,x1,y1), in points
  //or  array(width,height), in centimeters
	//paper orientation: portrait, landscape
	//see ezpdf docs (readme.pdf) for possible values
  $_SHOP->pdf_paper_size="A4";
  $_SHOP->pdf_paper_orientation="portrait";



  //external url connection settings, used by connect_func.php
  //choose one of settings:
  
  //1.use libCurl (php should be compiled with libCurl)
  $_SHOP->url_post_method='libCurl';
  
  //2.use php function fsocketopen():
  //$_SHOP->url_post_method='fso';
  
  //3.use external curl command:
  //$_SHOP->url_post_method='curl';
  //$_SHOP->url_post_curl_location='/usr/bin/curl';
  
  $_SHOP->input_time_type = 24; //12; //
  $_SHOP->input_date_type = 'dmy'; // 'mdy'
 
  ini_set("magic_quotes_runtime",0);
  ini_set('allow_call_time_pass_reference',0);
  
	//emulates magic_quotes_gpc off
	function stripslashes_deep($value){
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
		return $value;
 	}
	if (get_magic_quotes_gpc()) {
	    $_POST = array_map('stripslashes_deep', $_POST);
	    $_GET = array_map('stripslashes_deep', $_GET);
	    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
	    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	}

	//accepted languages
	$_SHOP->langs=array('en');
	$_SHOP->langs_names=array('en'=>'English',
                            'de'=>'Deutsch',
                            'nl'=>'Nederlands'
                           );

	$_SHOP->langs_locales=array('sv'=>'sv_SE'
                             );
	$_SHOP->is_admin = false;
	$_SHOP->event_type_enum = array('','classics','jazz','blues','funk','pop','rock','folklore','theater','sacred','ballet',
                                  'opera','humour','music','other','cinema','party','exposition');
  $_SHOP->event_group_type_enum = array('','festival','tournee','theatre');
  
  // 'mail', 'sendmail', 'smtp'
  $_SHOP->mail_mode      = 'mail';
  $_SHOP->mail_smtp_host = null;
  $_SHOP->mail_smtp_port = null;
  $_SHOP->mail_smtp_auth = null;
  $_SHOP->mail_smtp_user = null;
  $_SHOP->mail_smtp_pass = null;
  $_SHOP->mail_smtp_helo = null;
  
  $_SHOP->mail_sendmail  = null;

  $_SHOP->valutas  = array( 'EUR' => '&euro;',
                            'AUD' => '&#36;',
                            'CAD' => '&#36;',
                            'USD' => '&#36;',
                            'SGD' => '&#36;',
                            'NZD' => '&#36;',
                            'GBP' => '&pound;',
                            'JPY' => '&yen;');

  require_once(INC.'config'.DS."init_config.php");
  
  $_SHOP->files_url=$_SHOP->root."files/";
  $_SHOP->images_url=$_SHOP->root."images/";

  if (!defined('CURRENT_VERSION')) {
    define('CURRENT_VERSION','Unknown');
  }

  include_once('classes/basics.php');
  
?>