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


class StatisticView extends AdminView{
    var $img_pub;
    
    function fill_images()
    {
        $this->img_pub['pub']   = 'images/grun.png';
        $this->img_pub['unpub'] = 'images/rot.png';
        $this->img_pub['nosal'] = 'images/grey.png';
    }

  function plotEventStats ($start_date, $end_date, $month, $year) {
    global $_SHOP;
    $query = "select MAX(es_total) as count from Event_stat";
    if (!$res = ShopDB::query_one_row($query)){
      user_error(shopDB::error());
      return;
    }
    $max_places = $res['count'];
    if (!($max_places > 0)){
      return;
    }

    $query = "select Event_stat.*, event_id, event_name, event_date, event_time, event_status
              from Event left join Event_stat on es_event_id=event_id
              where event_status != 'unpub'
  	           and event_date >="._esc($start_date)."
        	     and event_date <="._esc($end_date)."
        	     and event_rep LIKE '%sub%'
        	    order by event_date,event_time";
    if (!$evres = ShopDB::query($query)){
      user_error(shopDB::error());
      return;
    }

    echo "<table class='admin_list' border=0 width='$this->width' cellspacing='0' cellpadding='5'>\n";
    echo "<tr>
            <td class='admin_list_title' colspan=4 align='center'>
               <a class='link' href='{$_SERVER["PHP_SELF"]}?month=" . ($month > 1?$month - 1:12) . "&year=" . ($month > 1?$year:$year - 1) . "'><<<<<</a>
               ". con('event_stats_title') ." " . strftime ("%B %Y", mktime (0, 0, 0, $month, 1, $year)) . "
	             <a class='link' href='{$_SERVER["PHP_SELF"]}?month=" . ($month < 12?$month + 1:1) . "&year=" . ($month < 12?$year:$year + 1) . "'>>>>>></a>
            </td></tr>\n";
 	  echo "</table><br>\n";

    while ($event = shopDB::fetch_assoc($evres)){
      $evtot   = $event["es_total"];
      $evfree  = $event["es_free"];
      $evsaled = ($evtot - $evfree);
      If ($event["event_status"] == 'pub' or $evsaled) {
        echo "<table class='admin_list' width='$this->width' cellspacing='0' cellpadding='5'>\n";
        echo "<tr class='stats_event_item'>
                <td class='admin_list_item' colspan=4 ><img src='{$this->img_pub[$event['event_status']]}'>&nbsp;" .
                    $event["event_name"] . " - " . formatAdminDate($event["event_date"]) . " " . formatTime($event["event_time"]) . "
                </td>
              </TR><tr>";
        $query = "select *
                  from Category left join Category_stat on cs_category_id=category_id
                  where category_event_id=" . _esc($event["event_id"]);

        if (!$res = ShopDB::query($query)){
          user_error(shopDB::error());
          return;
        }
        $alt = 0;
        while ($cat = shopDB::fetch_assoc($res)){
          echo "<tr class='admin_list_row_$alt'>
                  <td class='stats_event_item' width='20' align='right'>&nbsp;</td>
                  <td class='admin_list_item' width='180'>
                     " . $cat["category_name"] . "
                  </td>
                  <td class='admin_list_item' align='left' width='250'>";
          $tot = $cat["cs_total"];
          $free = $cat["cs_free"];
          $this->plotBar($tot, $free);
          echo "</tr>";
          $alt = ($alt + 1) % 2;
        }
        echo "<tr class='stats_event_item'>
               <td class='admin_list_item' colspan=2  width='200'>&nbsp;</td>
               <td class='admin_list_item' width='250'>";
        $this->plotBar($evtot, $evfree);
        echo "</tr>";
    	  echo "</table><br>\n";
      }
    }
  }

  function plotBar ($tot, $free){
    $saled = ($tot - $free);
    $percent = ($tot)?(100 * $saled / $tot):0;
    $percent = round($percent, 0);
    echo "<table border='0' cellspacing='0' width='100%'><tr>";//$width
    if ($percent > 0){
      echo "<td bgcolor='#ff0000' width='{$percent}%'><img src='images/dot.gif' width='0' height='12'></td>";
    }
    if ($percent < 100){
      echo "<td bgcolor='#00aa00'><img src='images/dot.gif' width='0' height='12'></td>";
    }
    echo "</tr></table><td nowrap='nowrap' align='right'>$percent% ($saled/$tot)</td>";
  }

  function eventStats ($start_date, $end_date, $month, $year){
    global $_SHOP;
    $curr = $_SHOP->currency;
    $query = "select seat_category_id, SUM(seat_price) as total_sum from Seat group by
            seat_category_id";
    if (!$res = ShopDB::query($query)){
      user_error(shopDB::error());
      return;
    } while ($sums = shopDB::fetch_assoc($res)){
      $sum[$sums["seat_category_id"]] = $sums["total_sum"];
    }

    $query = "select Event_stat.*,event_id,event_name,event_date,event_time, event_status
             from Event left join Event_stat on es_event_id=event_id
             where event_status != 'unpub'
      	     and event_date >= '$start_date'
      	     and event_date <= '$end_date'
      	     and event_rep LIKE '%sub%'
             order by event_date, event_time";
    if (!$res = ShopDB::query($query)){
      user_error(shopDB::error());
      return;
    }
    while ($event = shopDB::fetch_assoc($res)){
      $events[] = $event;
    }

    echo "<table class='admin_list' width='$this->width' cellspacing='0' cellpadding='5'>\n";
    echo "<tr><td class='admin_list_title' colspan='5' align='center'>
          <a class='link' href='{$_SERVER["PHP_SELF"]}?month=" . ($month == 1?12:$month - 1) . "&year=" . ($month == 1?$year - 1:$year) . "'><<<<< </a>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
    event_stats_title . " " .
    strftime ("%B %Y", mktime (0, 0, 0, $month, 1, $year)) .
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a class='link' href='{$_SERVER["PHP_SELF"]}?month=" . (($month < 12)?($month + 1):1) . "&year=" . ($month < 12?$year:$year + 1) . "'>>>>>></a></td></tr>\n";
	  echo "</table><br>\n";
    for($i = 0;$i < sizeof($events);$i++){
      $evtot = $events[$i]["es_total"];
      $evfree = $events[$i]["es_free"];
      $evsaled = ($evtot - $evfree);
      If ($events[$i]["event_status"] == 'pub' or $evsaled) {
        $evpercent = ($evtot)?(100 * $evsaled / $evtot):0;
        $evpercent = round($evpercent, 2);

        echo "<table class='admin_list' width='$this->width' cellspacing='0' cellpadding='5'>\n";
        echo "<tr class='stats_event_item'><td colspan='5'><img src='{$this->img_pub[$events[$i]['event_status']]}'>&nbsp;" . $events[$i]["event_name"] . " " .
        formatAdminDate($events[$i]["event_date"]) . " " . formatTime($events[$i]["event_time"]) . "</td></tr>";

        $query = "select *
                  from Category left join Category_stat on cs_category_id=category_id
                  where category_event_id=" . _esc($events[$i]["event_id"]);
        if (!$res = ShopDB::query($query)){
          user_error(shopDB::error());
          return;
        }
        $alt = 0;
        while ($cat = shopDB::fetch_assoc($res)){
          $tot = $cat["cs_total"];
          $free = $cat["cs_free"];
          $saled = ($tot - $free);
          $percent = ($tot)?(100 * $saled / $tot):0;
          $percent = round($percent, 2);
          // $gain=$cat["category_price"]*$saled;
          if ($sum[$cat["category_id"]]){
            $gain = $sum[$cat["category_id"]];
          }else{
            $gain = 0;
          }
          $sum_gain += $gain;
          echo "
                <tr  class='admin_list_row_$alt'>
                    <td class='stats_event_item' width='20'>&nbsp;</td>
                    <td width='180'>" .$cat["category_name"] . "</td>
                    <td width='125' align='right' >$percent%</td>
  	                <td width='125' align='right' >$saled/$tot</td>
                    <td align='right'> " . sprintf("%1.2f", $gain) . " $curr</td>
                </tr>";
          $alt = ($alt + 1) % 2;
        }
        echo "
              <tr class='stats_event_item'>
                <td width='200' colspan='2'>&nbsp;&nbsp;</td>
                <td width='125' align='right' >$evpercent%</td>
                <td width='125' align='right' >$evsaled/$evtot</td>
                <td align='right'>  " . sprintf("%1.2f", $sum_gain) . " $curr</td>
              </tr>";
   //     echo "<tr><td colapsn='5'></td></tr>";
    	  echo "</table><br>\n";

        $sum_gain = 0;
      }
    }
    //echo "</table>";
  }

  function draw ()
  {
    global $_SHOP;
    $this->fill_images();
    if (!($_GET['month'] or $_GET['year'])){
      $date = date('Y-m-1');

      $query = "select event_date from Event where event_date>='$date' order by event_date,event_time limit 1";
      require_once('classes/ShopDB.php');
      if ($row = ShopDB::query_one_row($query, false) and !empty($row[0])){
        list($year, $month) = split('-', $row[0]);
        $start_date = "$year-$month-1";
        $end_date = "$year-$month-31";
      }else{
        $start_date = date("Y-m-01");
        $end_date = date("Y-m-31");
        $month = date("m");
        $year = date("Y");
      }
    }elseif (!($_GET["month"] and $_GET["year"])){
      $start_date = date("Y-m-01");
      $end_date = date("Y-m-31");
      $month = date("m");
      $year = date("Y");
    }else{
      $start_date = $_GET["year"] . "-" . $_GET["month"] . "-01";
      $end_date = $_GET["year"] . "-" . $_GET["month"] . "-31";
      $month = $_GET["month"];
      $year = $_GET["year"];
      $mydate = "&month={$_GET["month"]}&year={$_GET["year"]}";

    }

    if(isset($_REQUEST['tab'])) {
      $_SESSION['_STATS_tab'] = (int)$_REQUEST['tab'];
    }


    $menu = array(con('show_text_stats')=>"?tab=0&month={$month }&year={$year}",
                  con('show_grafik_stats')=>"?tab=1&month={$month }&year={$year}");
    echo $this->PrintTabMenu($menu, (int)$_SESSION['_STATS_tab'], "left");

    if ((int)$_SESSION['_STATS_tab'] == 1){
      $this->plotEventStats($start_date, $end_date, $month, $year);
    }else{
      $this->eventStats($start_date, $end_date, $month, $year);
    }
  }
}

?>