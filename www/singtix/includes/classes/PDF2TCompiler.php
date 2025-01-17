<?PHP
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

class PDF2TCompiler {

  function PDF2TCompiler ($font_dir=''){
  }

  function build ($pdf, $data, $testme=false){
    global $_SHOP;
    require_once("smarty/Smarty.class.php");
    require_once("classes/gui_smarty.php");

    $smarty = new Smarty;
    $gui    = new gui_smarty($smarty);

    $smarty->plugins_dir  = array("plugins", $_SHOP->includes_dir . "shop_plugins");
    $smarty->cache_dir    = $_SHOP->tmp_dir;
    $smarty->compile_dir  = $_SHOP->tmp_dir;
    $smarty->compile_id   = "HTML2PDF_".$_SHOP->lang;
    $smarty->assign("_SHOP_lang", $_SHOP->lang);
    $smarty->assign((array)$_SHOP->organizer_data);
    $smarty->assign($data);
    $smarty->assign("OrderData",$data);
    $smarty->assign("_SHOP_files", $_SHOP->files_url );//ROOT.'files'.DS
    $smarty->assign("_SHOP_images", $_SHOP->images_url);


    $smarty->my_template_source = $this->sourcetext;
    $htmlresult = $smarty->fetch("text:".get_class($this));
    $pdf->WriteHTML($htmlresult, $testme);
    unset($smarty);
    unset($gui);
  }

  function compile ($input, $out_class_name){

$ret=
'
/*this is a generated file. do not edit!

produced '.date("l dS of F Y h:i:s A").' 

*/
require_once("classes/PDF2TCompiler.php");

class '.$out_class_name.' extends PDF2TCompiler {
  function write($pdf, $data, $testme=false){
    $this->build($pdf, $data, $testme);
  }
}
';
    //  echo "<pre>$ret</pre>";
      return $ret;
  }
}
?>