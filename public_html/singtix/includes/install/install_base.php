<?php
/**
%%%copyright%%%
 *
 * FusionTicket - ticket reservation system
 *  Copyright (C) 2007-2009 Christopher Jenkins, Niels, Lou. All rights reserved.
 *
 * Original Design:
 *  phpMyTicket - ticket reservation system
 *   Copyright (C) 2004-2005 Anna Putrino, Stanislav Chachkov. All rights reserved.
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
function Install_Form_Open ($target_pg, $onsubmit='', $ispage=true){
  global $states; //{$states[$target_pg]} 

  if (!is_numeric($target_pg)){
    echo "<form name='install' method=\"post\" action='$target_pg' onSubmit=\"".$onsubmit."\">\n";
  }else{
    echo "<form name='install' method=\"post\" action='".$_SERVER['PHP_SELF']."' onSubmit=\"".$onsubmit."\">\n";
    if (isset($target_pg)){
      echo "<input type='hidden' name=inst_pg value='{$target_pg}' /> \n";
    }
  }
  echo "<table border=0 cellpadding=\"0\" cellspacing=\"0\" width='100%' style=\"height: 400\">";
  echo "<tr ><td colspan=2 valign='top' height='100%' >\n"  ;
}

function Install_Form_Buttons (){
  echo "</td></tr><tr>\n";
  echo "<td  colspan=2 bgcolor=\"#f5F5f5\" valign=\"bottom\" style='border-top:1px solid #c0c0c0;padding: 5px;' align=\"right\">
          <input type=\"submit\" tabindex='1' value=\"Next\" name=\"do\" />
          &nbsp;
          <input type=\"button\" tabindex='2' value=\"Cancel\" name=\"do\" onClick=\"Confirm_Inst_Cancel()\" />\n";
}

function Install_Form_Rollback ($name='Back'){
  echo "</td></tr><tr>\n";
  echo "<td  colspan=2 bgcolor=\"#f5F5f5\" valign=\"bottom\" style='border-top:1px solid #c0c0c0;padding: 5px;' align=\"right\">
          <input type=\"submit\" tabindex='1' value=\"{$name}\"  name=\"do\"  />
          &nbsp;
          <input type=\"button\" tabindex='2' value=\"Cancel\" name=\"do\" onClick=\"return(Confirm_Inst_Cancel());\" />
          \n";
}

function Install_Form_Close (){
  echo "</td></tr></table></center></form>\n";
}

function Install_request($arr, $Sub=''){
  foreach ($arr as $info){
    If (isset($_REQUEST[$info])){
      if ($Sub) {
        $_SESSION[$Sub][$info] = $_REQUEST[$info];
      } else {
        $_SESSION[$info] = $_REQUEST[$info];
      }
    } else {
      if ($Sub) {
        unset($_SESSION[$Sub][$info]);// = $_REQUEST[$info];
      } else {
        unset($_SESSION[$info]);// = $_REQUEST[$info];
      }
    
    }
  }
}

function loginmycheck ($link, $username,$auth){
  $query="SELECT admin_id FROM `Admin` 
          WHERE `admin_login`="._esc($username). "
          AND  `admin_password`="._esc(Md5($auth));
  if($res=ShopDB::query_One_row($query)){
    return True;
  }	else {
    return false;
  }
}

function Opendatabase(){
  global $_SHOP;
  $DB_Hostname = $_SESSION['SHOP']['db_host'];
  $DB_Username = $_SESSION['SHOP']['db_uname'];
  $DB_Password = $_SESSION['SHOP']['db_pass'];
  $DB_Database = $_SESSION['SHOP']['db_name'];
  
  $pos = strpos($DB_Hostname,':');
  if ($pos != false) {
    $DB_Hostname = substr($DB_Hostname,0, $pos);
    $port = substr($DB_Hostname,$pos+1);
  } else
    $port = 3306;
  
  $link = @ new mysqli($DB_Hostname, $DB_Username, $DB_Password, '', $port);

  If (!(@mysqli_connect_error() or @mysqli_error($link))){
    $link->select_db($DB_Database);
    $_SHOP->link = $link;
  }
  return $link;
}  
/*
* mysql < dump.sql
*/
function file_to_db($filename){
  
  if (!$lines = file($filename)){
    return "<div class=err>ERROR: can not read $filename</div>";
  }
  foreach ($lines as $l){
    if (preg_match("/^\s*(#|--)/", $l)){
      // do no
    }else
    if (preg_match("/;\s*$/", $l)){
      $query = $query . substr($l, 0, - 1);

      if (!shopDB::query($query)){
        return "<div class=err>ERROR: cannot execute database query</div><pre>$query/\n".ShopDB::Error()." </pre>";
      }
      $query = '';
    }else{
      $query = $query . $l;
    }
  }
  return '';
}

function callback($matches){
  return $_SESSION[$matches[1]];
}

Function ShowResults($Install,$inst_mode){ 
  If ((count($Install->Errors)>0 || count($Install->Warnings)>0)){
    Install_Form_Open ($Install->return_pg,'');
    echo "<input type='hidden' name='inst_mode' value='{$inst_mode}' />\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    if(count($Install->Errors)>0){
      echo "<tr>\n<td colspan=\"2\"><h2><font color=\"#3366CC\">Error</font></h2></td>\n</tr><tr><td>\n";
      echo "The installer encountered the following errors:<br><ul>\n";
      for($i=0;$i<count($Install->Errors);$i++){echo "<li class='err'>".$Install->Errors[$i]."</li>\n";}
      echo "</ul></td></tr>";
    }
    // Handle Warnings
    if(count($Install->Warnings)>0){
      echo "<tr>\n<td colspan=\"2\"><h2><font color=\"#3366CC\">Warning !</font></h2></td>\n</tr><tr><td>\n";
      echo "The installer has issued the following warnings:<br><ul>\n";

      for($i=0;$i<count($Install->Warnings);$i++){echo "<li class='warn'>".$Install->Warnings[$i]."</li>\n";}
      echo "</ul></td></tr>";
    }
    echo "</table>";
    
    If (count($Install->Errors)>0){
      Install_Form_Rollback (($inst_mode=='pre')?'Retry':'Back');
    } else {
      echo "<input type='hidden' name='continue' value='1' />\n";
      Install_Form_Buttons ();
    }

    $Install->Errors   = Array ();
    $Install->Warnings = Array ();
    
    Install_Form_Close ();
    return true;//count($Install->Errors)>0;
  }
  return false;
} 

function RemoveDir($dir, $DeleteMe) {
  if(!$dh = @opendir($dir)) return;
  while (false !== ($obj = readdir($dh))) {
    if($obj=='.' || $obj=='..') continue;
    if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
  }
  closedir($dh);
  if ($DeleteMe){
    @rmdir($dir);
  }
}
?>