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

require_once("admin/AdminView.php");

class import_xml extends AdminView {

  function cp_form (&$data,&$err){
		global $_SHOP;
				
    echo "<form method='POST' action='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data'>\n";
		$this->form_head(import_xml_title);
		
		echo "<tr><td class='admin_name'  width='40%'>".import_xml_file."</td>
					<td class='admin_value'><input type='file' name='import_xml_file'></td></tr>";

		echo "
		<tr><td align='center' class='admin_value' colspan='2'>
  	<input type='hidden' name='import_type' value='xml'>
		<input type='submit' name='submit' value='".import_xml_submit."'></td></tr>
		</table></form>";
  }

    
  function import (){
    global $_SHOP;
  
		if(!empty($_FILES['import_xml_file']) and !empty($_FILES['import_xml_file']['name']) and !empty($_FILES['import_xml_file']['tmp_name'])){
			require_once('classes/xml2sql.php');
			echo import_xml_title." : ".$_FILES['import_xml_file']['name']." ... ";
			flush();
			xml2xml::xml2sql($_FILES['import_xml_file']['tmp_name']);
			echo done;
			return TRUE;
    }  
  }
  
  function draw (){
    $this->cp_form($_GET,$this->err);
  }
	
}
?>