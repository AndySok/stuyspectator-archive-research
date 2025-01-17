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

require_once("admin/AdminView.php");
require_once("classes/Event.php");

class DeleteEventView extends AdminView{
  function cat_view (&$data)
  {
    echo "<table class='admin_form' width='500' cellspacing='1' cellpadding='4'>\n";
    echo "<tr><td class='admin_list_title' colspan='2'>{$data['category_name']}</td></tr>";

    $this->print_field('category_id', $data);
    $this->print_field('category_name', $data);
    $this->print_field('category_price', $data);
    $this->print_field('category_numbering', $data);
    if ($data['category_numbering'] == 'none'){
      $this->print_field('category_size', $data);
    }else{
      $this->print_field('category_pm_id', $data);
    }

    echo "</table>\n";
  }

  function event_view (&$data)
  {
    $data["event_date"] = formatAdminDate($data["event_date"]);
    $data["event_time"] = formatTime($data["event_time"]);
    $data["event_open"] = formatTime($data["event_open"]);
  $data["event_end"]=formatTime($data["event_end"]);
    $event_id = $data["event_id"];

    echo "<table class='admin_form' width='500' cellspacing='1' cellpadding='4'>\n";
    echo "<tr><td colspan='2' class='admin_list_title'>" . $data["event_name"] . "
        </td></tr>";

    $this->print_field('event_id', $data);
    $this->print_field('event_name', $data);
    $this->print_field('ort_name', $data);
    $this->print_field('event_short_text', $data);
    $this->print_field('event_text', $data);
    $this->print_field('event_url', $data);
    $this->print_field('event_date', $data);
    $this->print_field('event_time', $data);
    $this->print_field('event_open', $data);

    echo "</table>\n";
  }

  function confirm_button (&$event, $show_button = true)
  {
    echo "<div class='info'><br>" . delete_confirm_msg;
    if ($show_button){
      echo "<form action='{$_SERVER['PHP_SELF']}' method='POST'>";
      /*
if($event['event_rep']=='main'){
     echo "<input type=checkbox name=also_sub id=also_sub style='border:0px;' value=1><label for='also_sub'> ".also_sub."</label></br>";
   }
*/
      echo "<input type='hidden' name='event_id' value='{$event['event_id']}'><br>
         <input type='submit' name='confirm' value='YES'>
         </form>";
    }
    echo "<br></div>";
  }

  function draw ()
  {
    global $_SHOP;

    if ($_POST['confirm'] == 'YES' and $_POST['event_id'] > 0){
      if ($event = Event::load($_POST['event_id'], false)){
        if ($event->delete()){
          echo "<div class='success'> <b>'{$event->event_name}'</b> " . con("delete_success") . "</div>\n";
          Event::emptyTrash();
        }else{
          echo "<div class='err'> <b>'{$event->event_name}'</b> " . con("delete_failure") . "</div>\n";
        }

        /*if($event->event_rep=='main' and $_POST['also_sub'] and $subs=Event::load_all_sub($event->event_id)){
        foreach($subs as $sub){
	  $date=formatAdminDate($sub->event_date);

          if($sub->event_status=='pub'){
	    if($sub->stop_sales()){
              echo "<div class='success'> <b>'$date'</b> ".con("stop_success")."</div>\n";
            } else {
              echo "<div class='err'> <b>'$date'</b> ".con("stop_failure")."</div>\n";
            }
	  }
	}
      }
*/
        if ($event->event_rep == 'sub'){
          require_once('admin/EventSubPropsView.php');
          $view = new EventSubPropsView;
          $view->event_list($event->event_main_id);
        }else{
          require_once('admin/EventPropsView.php');
          $view = new EventPropsView;
          $view->event_list();
        }
      }
    }else if ($_GET['event_id'] > 0){
      if (!$event = Event::load($_GET['event_id'], false)){
        return;
      }

      $event_d = (array)$event;

      $this->confirm_button($event_d, false);
      $this->event_view($event_d);

      require_once('classes/PlaceMapCategory.php');
      if ($cats = PlaceMapCategory::loadAll_event($_GET['event_id'])){
        foreach($cats as $category){
          $category_d = (array)$category;
          $err = $this->cat_view($category_d);
        }
      }

      $this->confirm_button($event_d);
    }
  }
}

?>