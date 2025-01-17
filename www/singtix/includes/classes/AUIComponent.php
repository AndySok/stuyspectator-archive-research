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

class AUIComponent {
    var $items = array();
    var $width = 190;

    function setWidth($width)
    {
        $this->width = $width;
    }

    function add($item)
    {
        array_push($this->items, $item);
    }

    function set($index, $item)
    {
        $this->items[$index] = $item;
    }

    function drawChild($obj)
    {
        if ($obj) {
            if (is_string($obj)) {
                echo $obj;
            } elseif (is_object($obj)) {
                $obj->draw();
            } elseif (is_array($obj)) {
                foreach($obj as $child) {
                    $this->drawChild($child);
                }
            }
        }
    }
}

?>