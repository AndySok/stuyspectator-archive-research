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
 
class install_login {
  function precheck($Install) {
    If ($_SESSION['ConfigExist']){ 
      include (ROOT."includes/config/init_config.php");
      $_SESSION['SHOP']  = (Array)$_SHOP;
      $link      = OpenDatabase();
      
      if (!$result = $link->Query("SHOW TABLE STATUS LIKE 'Admin'")) {
        $_SESSION['DatabaseExist'] = false; 
      } elseif ( !$row = $result->fetch_assoc()) {
        $_SESSION['DatabaseExist'] = false; 
      } elseif ( $row['rows']>0  ) {
        $_SESSION['DatabaseExist'] = false; 
      } else {
        $_SESSION['DatabaseExist'] = true; 
        $_SESSION['radio'] = 'UPGRADE';
      } 
    }
    return  ($_SESSION['DatabaseExist']);
  }
  
  function postcheck($Install) {
    $link      = OpenDatabase();
    if(!loginmycheck ($link, $_POST['username'], $_POST['password'])){
      array_push($Install->Errors,"Admin User not found in database.");
    }
    return true;
  }

  function display($Install) {
    Install_Form_Open ($Install->return_pg,'Validate_Inst_Database()');
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
            <tr>
              <td colspan=\"2\">
                <h2>Login to update you system</h2>
              </td>
            </tr>
            <tr>
              <td colspan=\"2\">
                For security please login with your admin username and password. This is the one that you use to administer the system.<br><br>
              </td>
            </tr>
            <tr>
              <td>Admin login:</td>
              <td><input type=\"text\" name=\"username\" value=\"\" /></td>
            </tr>
            <tr>
              <td>Admin password:</td>
              <td><input type=\"password\" name=\"password\" value=\"\" /> (at least 6 letters)</td>
            </tr>
          </table>";
    Install_Form_Buttons ();
    Install_Form_Close ();
  }  
}
?>