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

require_once ("classes/PlaceMapPart.php");

function smarty_function_placemap($params, &$smarty){
	
    $pz = preg_match(strtolower('/no|0|false/'), $params['print_zone']);
    return placeMapDraw($params['category'], $params['restrict'], !$pz, $params['area']);

}

function placeMapMargins($shift)
{
    for ($i = 0; $i < $shift; $i++) {
        $ml = $i % $shift;
        $mr = $shift - $ml - 1;
        if ($ml > 1) {
            $tml = "<td colspan='$ml' class='pm_none'><img src='images/dot.gif' width='5' height='10'></td>\n";
        } else
            if ($ml == 1) {
                $tml = "<td class='pm_none'><img src='images/dot.gif' width='5' height='10'></td>\n";
            } else {
                $tml = "";
            }
            if ($mr > 1) {
                $tmr = "<td colspan='$mr' class='pm_none'><img src='images/dot.gif' width='5' height='10'></td>\n";
            } else
                if ($mr == 1) {
                    $tmr = "<td class='pm_none'><img src='images/dot.gif' width='5' height='10'></td>\n";
                } else {
                    $tmr = "";
                }
                $res[] = array($tml, $tmr);
    }
    return $res;
}
    
function placeMapDraw($category, $restrict, $print_zone = true, $area = 'www')
{
    global $_SHOP;

    $l_row = ' '.con('place_row').' ';
    $l_seat = ' '.con('place_seat').' ';

    $cat_ident = $category['category_ident'];
    $cat_num = 0;
    switch ($category['category_numbering']) {
        case 'both':
            $cat_num = 3;
            break;
        case 'rows':
            $cat_num = 2;
            break;
        case 'seat':
            $cat_num = 1;
            break;
    }

    $pmp = PlaceMapPart::load_full($category['category_pmp_id']);

    $cats = $pmp->categories;
    $zones = $pmp->zones;

    $pmp->check_cache();

    if ($restrict) {
        $bounds = $pmp->category_bounds($cat_ident);
        $left = $bounds['left'];
        $right = $bounds['right'];
        $top = $bounds['top'];
        $bottom = $bounds['bottom'];
    } else {
        $left = 0;
        $right = $pmp->pmp_width - 1;
        $top = 0;
        $bottom = $pmp->pmp_height - 1;
    }

    $res = "<table class='pm_table' cellpadding=0 cellspacing=1>\n";

    if ($pmp->pmp_shift) {
        $cspan = 'colspan=2';
        $ml[1] = $mr[0] = '<td class="pm_none"><img src="images/dot.gif" width=5 height=1></td>';
        $res .= '<tr>';
        $width2 = ($right - $left) * 2 + 1;
        for ($k = 0; $k <= $width2; $k++) {
            $res .= '<td class="pm_none"><img src="images/dot.gif" width=5 height=1></td>';
        }
        $res .= '</tr>';
    }

    for ($j = $top; $j <= $bottom; $j++) {
        $res .= '<tr>';
        $res .= $ml[$j % 2];
        ///////////
        for ($k = $left; $k <= $right; $k++) {
            $seat = $pmp->pmp_data[$j][$k];
            if ($seat[PM_ZONE] == 'L') {
                if ($seat[PM_LABEL_TYPE] == 'RE' and $irow = $pmp->pmp_data[$j][$k + 1][PM_ROW]) {
                    $res .= "<td $cspan class='label_RE'>$irow";
                } elseif ($seat[PM_LABEL_TYPE] == 'RW' and $irow = $pmp->pmp_data[$j][$k - 1][PM_ROW]) {
                    $res .= "<td $cspan class='label_RW'>$irow";
                } elseif ($seat[PM_LABEL_TYPE] == 'SS' and $iseat = $pmp->pmp_data[$j + 1][$k][PM_SEAT]) {
                    $res .= "<td $cspan class='label_SS'>$iseat";
                } elseif ($seat[PM_LABEL_TYPE] == 'SN' and $iseat = $pmp->pmp_data[$j - 1][$k][PM_SEAT]) {
                    $res .= "<td $cspan class='label_SN'>$iseat";
                } elseif (($seat[PM_LABEL_TYPE] == 'T') and !$seat[PM_LABEL_SIZE]) {
                    continue;
                } elseif ($seat[PM_LABEL_TYPE] == 'T' and $seat[PM_LABEL_SIZE] > 0) {
                    $label_size = $seat[PM_LABEL_SIZE];
                    if ($pmp->pmp_shift) {
                        $label_size *= 2;
                    }
                    $res .= "<td class='label_T' colspan='$label_size'>{$seat[PM_LABEL_TEXT]}";
                } elseif ($seat[PM_LABEL_TYPE] == 'E') {
                    $res .= "<td $cspan class='label_E'>";
                } else {
                    $res .= "<td $cspan class='pm_none'><img src='images/dot.gif' width=10 height=10>";
                }
            } elseif ($seat[PM_ZONE] and $seat[PM_CATEGORY]) {
                //Empty seats
                if ($seat[PM_STATUS] == PM_STATUS_FREE) {
                    if ($seat[PM_CATEGORY] == $cat_ident) {
                        $zone = $zones[$seat[PM_ZONE]];
                        //$res.= "<td $cspan class='pm_free'><input class='pm_check' type='checkbox' name='place[]' value='{$seat[PM_ID]}' onmouseover='this.T_WIDTH=100;return escape(\"{$zone->pmz_name} {$seat[PM_ROW]}/{$seat[PM_SEAT]}\")'>";
                        $res .= "<td $cspan class='pm_free'><input class='pm_check' type='checkbox' name='place[]' value='{$seat[PM_ID]}' title='";
                        if ($print_zone) {
                            $res .= $zone->pmz_name . ' ';
                        }
                        if (($cat_num & 2) and $seat[PM_ROW] != '0') {
                            $res .= $l_row . $seat[PM_ROW];
                        }
                        if (($cat_num & 1) and $seat[PM_SEAT] != '0') {
                            $res .= $l_seat . $seat[PM_SEAT];
                        }
                        $res .= "'>";
                    } else {
                        $res .= "<td $cspan class='pm_free'><img src='images/dot.gif' width=10 height=10>";
                    }
                    ////////////Reserved seats, they will only be selectable if you have area='pos' set in cat...tpl
                } elseif ($seat[PM_STATUS] == PM_STATUS_RESP) {
                    if ($area === 'pos') {
                        if ($seat[PM_CATEGORY] == $cat_ident) {
                            $zone = $zones[$seat[PM_ZONE]];
                            //$res.= "<td $cspan class='pm_free'><input class='pm_check' type='checkbox' name='place[]' value='{$seat[PM_ID]}' onmouseover='this.T_WIDTH=100;return escape(\"{$zone->pmz_name} {$seat[PM_ROW]}/{$seat[PM_SEAT]}\")'>";
                            $res .= "<td $cspan class='pm_resp'><input class='pm_check' type='checkbox' name='place[]' value='{$seat[PM_ID]}' title='";
                            if ($print_zone) {
                                $res .= $zone->pmz_name . ' ';
                            }
                            if (($cat_num & 2) and $seat[PM_ROW] != '0') {
                                $res .= $l_row . $seat[PM_ROW];
                            }
                            if (($cat_num & 1) and $seat[PM_SEAT] != '0') {
                                $res .= $l_seat . $seat[PM_SEAT];
                            }
                            $res .= "'>";
                        } else {
                            $res .= "<td $cspan class='pm_resp'><img src='images/dot.gif' width=10 height=10>";
                        }
                    } else {
                        $res .= "<td $cspan class='pm_occupied'><img src='images/dot.gif' width=10 height=10>";
                    }
                    ////////////////////////////
                } else {
                    $res .= "<td $cspan class='pm_occupied'><img src='images/dot.gif' width=10 height=10>";
                }
            } elseif ($seat[PM_ZONE]) {
                $res .= "<td $cspan class='pm_nosale'><img src='images/dot.gif' width=10 height=10>";
            } else {
                $res .= "<td $cspan class='pm_none'><img src='images/dot.gif' width=10 height=10>";
            }
            $res .= "</td>\n";
        }
        $res .= $mr[$j % 2];
        $res .= "</tr>\n";
    }

    $res .= "</table>";
    /*            <script language=\"JavaScript\" type=\"text/javascript\" src=\"wz_tooltip.js\"></script>    ";*/


    $l = $_SHOP->lang;
    switch ($pmp->pmp_scene) {
        case 'north':
            $res = "<table border=0 class=pm_table_ext><tr><td align=center valign=middle><img src='images/scene_h_$l.png'></td></tr><tr><td align=center valign=middle>$res</td></tr></table>";
            break;
        case 'south':
            $res = "<table border=0 class=pm_table_ext><tr><td align=center valign=middle>$res</td></tr><tr><td align=center valign=middle><img src='images/scene_h_$l.png'></td></tr></table>";
            break;
        case 'east':
            $res = "<table border=0 class=pm_table_ext><tr><td align=center valign=middle>$res</td><td align=center valign=middle><img src='images/scene_v_$l.png'></td></tr></table>";
            break;
        case 'west':
            $res = "<table border=0 class=pm_table_ext><tr><td align=center valign=middle><img src='images/scene_v_$l.png'></td><td align=center valign=middle>$res</td></tr></table>";
            break;
    }

    return $res;

}

?>