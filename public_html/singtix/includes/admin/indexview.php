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
require_once("admin/OptionsView.php");
require_once("admin/OrganizerView.php");

class IndexView extends AdminView {

  function draw() {
    GLOBAL $_SHOP;
    if(isset($_REQUEST['tab'])) {
      $_SESSION['_INDEX_tab'] = (int)$_REQUEST['tab'];
    }


    $menu = array( con("index_admin_tab")=>"?tab=0", con("owner_tab")=>'?tab=1', con("shopconfig_tab")=>"?tab=2");
    echo $this->PrintTabMenu($menu, (int)$_SESSION['_INDEX_tab'], "left");

    switch ((int)$_SESSION['_INDEX_tab'])
       {
       case 0:
           $licention = file_get_contents (ROOT."licence.txt");
       	 	 $this->form_head("Fusion&nbsp;Ticket&nbsp;".con('current_version').'&nbsp;'.CURRENT_VERSION,$this->width,1);
        	 echo "<tr><td class='admin_value'>" ;
           echo "<p><pre>",htmlspecialchars($licention),'</pre></p>';
           echo "</td></tr>";
		       echo "</table>\n<br>";

      	 	 $this->form_head( con('system_summary'),$this->width,2);
           $this->print_field('InfoWebVersion',  $_SERVER['SERVER_SOFTWARE']);
           $this->print_field('InfoPhpVersion',  phpversion ());
           $this->print_field('InfoMysqlVersion',ShopDB::GetServerInfo ());
           $this->print_field('InfoAdminCount',  $this->Admins_Count ());
           $this->print_field('InfoUserCount',   $this->Users_Count ());
//           $this->print_field('InfoGroupCount',  $this->Groups_Count ());
//           $this->print_field('InfoVenueCount',  $this->Venues_Count ());
           $this->print_field('InfoEventCount',  $this->Events_Count ());
		       echo "</table>\n";
           break;
       
       case 1:
           $viewer = new OrganizerView($this->width);
           $viewer->draw();
           break;

       case 2:
           $viewer = new OptionsView($this->width);
           $viewer->draw();
           break;

       }
  }

  function Users_Count () {
 	  $sql = "SELECT count(user_status) as count,user_status, IF(active IS NOT NULL,'yes','no') as active
  	       	FROM User left join auth on auth.user_id=User.user_id
            group by user_status, IF(active IS NOT NULL,'yes','no')";
 		if(!$res=ShopDB::query($sql)){
			return FALSE;
		}

		while($data=shopDB::fetch_array($res)){
      $part[$data[1]][$data[2]]=$data[0];
		}

    return vsprintf(con('index_user_count'),array($part[1]['no'],$part[3]['no'],$part[2]['yes'],$part[2]['no'],$part[2]['yes']+$part[2]['no']));
  }
  
  function Groups_Count (){
    return 'not impented yet';
  }

  function Venues_Count () {
 	  $sql = "SELECT count(*)
  	       	FROM Ort";
 		if(!$result=ShopDB::query_one_row($sql)){
			return FALSE;
		}
    return vsprintf(con('index_ort_count'),$result);

  }

  function Events_Count (){
    $part = array('pub'=>0, 'unpub'=>0, 'nosal'=>0,'trash'=>0,'total'=>0);
 	  $sql = "SELECT count(event_status) as count, event_status
  	       	FROM Event
            group by event_status";
 		if(!$res=ShopDB::query($sql)){
			return FALSE;
		}

		while($data=shopDB::fetch_array($res)){
      $part['total'] += $data[0];
      $part[$data[1]]=$data[0];
		}

    return vsprintf(con('index_events_count'),$part);
  }

  function admins_Count (){
    $part = array('admin'=>0, 'organizer'=>0, 'control'=>0,'total'=>0);
 	  $sql = "SELECT count(admin_status) as count, admin_status
  	       	FROM Admin
  	       	group by admin_status
  	       	union
  	       	SELECT count(admin_status) as count, admin_status
  	       	FROM Control
            group by admin_status";
 		if(!$res=ShopDB::query($sql)){
			return FALSE;
		}

		while($data=shopDB::fetch_array($res)){
      $part['total'] += $data[0];
      $part[$data[1]]=$data[0];
		}

    return vsprintf(con('index_admins_count'),$part);
  }

}

?>