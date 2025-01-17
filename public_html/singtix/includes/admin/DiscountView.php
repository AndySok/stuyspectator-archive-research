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

class DiscountView extends AdminView {

    function discount_form (&$data, &$err, $title)
    {
        echo "<form method='POST' action='{$_SERVER['PHP_SELF']}'>\n";
        echo "<table class='admin_form' width='$this->width' cellspacing='1' cellpadding='4'>\n";
        echo "<tr><td class='admin_list_title' colspan='2'>" . $title . "</td></tr>";

        $this->print_field('discount_id', $data);
        $this->print_field('event_name', $data);

        $this->print_input('discount_name', $data, $err, 30, 50);
        $this->print_select ("discount_type", $data, $err, array("fixe", "percent"));

        $this->print_input('discount_value', $data, $err, 6, 5);
        echo "<tr><td align='center' class='admin_value' colspan='2'>
   <input type='submit' name='submit' value='" . save . "'>
  <input type='reset' name='reset' value='" . res . "'></td></tr>";

        echo "</table>\n";

        echo "<input type='hidden' name='discount_event_id' value='{$data['discount_event_id']}'/>\n";
        echo "<input type='hidden' name='event_name' value='" . htmlentities($data['event_name'], ENT_QUOTES) . "'/>\n";

        if ($data['discount_id']) {
            echo "<input type='hidden' name='discount_id' value='{$data['discount_id']}'/>\n";
            echo "<input type='hidden' name='action' value='update_disc'/>\n";
        } else {
            echo "<input type='hidden' name='action' value='insert_disc'/>\n";
        }

        echo "</form><br><center>
              <a class='link' href='{$_SERVER['PHP_SELF']}?action=view_pm&pm_id={$data['event_pm_id']}'>" . admin_list . "</a></center>"; //print_r($data);
    }

    function discount_check (&$data, &$err)
    {
        if (empty($data['discount_name'])) {
            $err['discount_name'] = mandatory;
        }

        if (empty($data['discount_value'])) {
            $err['discount_value'] = mandatory;
        }

        return empty($err);
    }

    function discount_list ($discount_event_id, $showTable = true)
    {
        global $_SHOP;
        $query = "SELECT event_name,ort_name,event_status
          FROM Event left join Ort on ort_id=event_ort_id
          WHERE event_id="._esc((int)$discount_event_id);
        if (!$names = ShopDB::query_one_row($query)) {
            $err = shopDB::error();
            if ($err) user_error($err);
            return;
        }

        $query = "SELECT * FROM Discount WHERE discount_event_id="._esc((int)$discount_event_id);
        if (!$res = ShopDB::query($query)) {
            user_error(shopDB::error());
            return;
        }

        $alt = 0;
        echo "<table class='admin_list' width='$this->width' cellspacing='0' cellpadding='4'>\n";
        echo "<tr><td  colspan='6' align='center'>";

        echo "<div class='admin_list_title'>" . discount_title . "</div>";

        while ($row = shopDB::fetch_assoc($res)) {
            echo "<tr class='admin_list_row_$alt'>";
            echo "<td class='admin_list_item'>{$row['discount_id']}</td>\n";
            echo "<td class='admin_list_item'>{$row['discount_name']}</td>\n";
            if ($row['discount_type'] == 'percent') {
                $type = "%";
            } else if ($row['discount_type'] == 'fixe') {
                $type = $_SHOP->organizer_data->currency;
            }
            echo "<td class='admin_list_item'>{$row['discount_value']}$type</td>\n";
            echo "<td class='admin_list_item' width='20'></td>\n";
            echo "<td class='admin_list_item' width='20'><a class='link' href='{$_SERVER['PHP_SELF']}?action=edit_disc&discount_id={$row['discount_id']}&discount_event_id=$discount_event_id'><img src='images/edit.gif' border='0' alt='" . edit . "' title='" . edit . "'></a></td>\n";

            if ($names['event_status'] == 'unpub' or $names['event_status'] == 'nosal') {
                echo "<td class='admin_list_item' width='20'><a class='link' href='javascript:if(confirm(\"" . delete_item . "\")){location.href=\"{$_SERVER['PHP_SELF']}?action=remove_disc&discount_id={$row['discount_id']}&discount_event_id=$discount_event_id\";}'><img src='images/trash.png' border='0' alt='" . remove . "' title='" . remove . "'></a></td>\n";
            } else {
                echo "<td></td>";
            }
            echo "</tr>";
            $alt = ($alt + 1) % 2;
        }
        echo "<tr><td colspan='6'><br><center><a class='link' href='{$_SERVER['PHP_SELF']}?action=add_disc&discount_event_id=$discount_event_id'>" . add . "</a></td></tr>";
        echo "</table>\n";
    }

    function draw ()
    {
        if ($_POST['action'] == 'insert_disc') {
            if (!$this->discount_check($_POST, $err)) {
                $this->discount_form($_POST, $err, discount_add_title);
            } else {
                $query = "INSERT Discount (
                            discount_event_id,
                            discount_name,
                            discount_type,
                            discount_value
                            ) VALUES (
                            " . _ESC($_POST['discount_event_id']).",
                            " . _ESC($_POST['discount_name']) . ",
                            " . _ESC($_POST['discount_type']) . ",
                            " . _ESC($_POST['discount_value']) . "
                            )";
          //      echo $query ;
                if (!ShopDB::query($query)) {
                    user_error(shopDB::error());
                    return;
                }
                return true;
            }
        } else

        if ($_POST['action'] == 'update_disc') {
            if (!$this->discount_check($_POST, $err)) {
                $this->discount_form($_POST, $err, discount_update_title);
            } else {
                $query = "UPDATE Discount SET
                            discount_event_id=" . _ESC($_POST['discount_event_id']) . ",
                            discount_name="     . _ESC($_POST['discount_name']) . ",
                            discount_type="     . _ESC($_POST['discount_type']) . ",
                            discount_value="    . _ESC($_POST['discount_value']) . "
                          WHERE discount_id="   . _ESC($_POST['discount_id']) ;

                if (!ShopDB::query($query)) {
                    user_error(shopDB::error());
                    return;
                }
                return true;
            }
        } else
        if ($_GET['action'] == 'add_disc') {
            $query = "SELECT * FROM  Event WHERE event_id="._esc((int)$_GET['discount_event_id']);
            if (!$row = ShopDB::query_one_row($query)) {
                user_error(shopDB::error());
                return;
            }
            $row['discount_event_id'] = $row['event_id'];
            $this->discount_form($row, $err, discount_add_title);
        } else
        if ($_GET['action'] == 'edit_disc') {
            $query = "SELECT * FROM Discount left join Event on discount_event_id=event_id
                      WHERE discount_id="._esc($_GET['discount_id']);
            if (!$row = ShopDB::query_one_row($query)) {
                return;
            }
            $this->discount_form($row, $err, discount_update_title);
        } else
        if ($_GET['action'] == 'remove_disc' and $_GET['discount_id'] > 0) {
            $discount_id = (int)$_GET['discount_id'];
            $query = "SELECT count(*) count as count from Seat where seat_discount_id="._esc($discount_id);
            if (!$count = ShopDB::query_one_row($query)) {
                return;
            }

            if ($count['count'] != 0) {
                echo "<div class=error>" . con('in_use') . "</div>";
                return;
            }

            $query = "DELETE FROM Discount WHERE discount_id="._esc($_GET['discount_id'])." LIMIT 1";
            if (!ShopDB::query($query)) {
                return;
            }
            return true;
        }
    }
}

?>