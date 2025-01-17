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


require_once("classes/AUIComponent.php");

class AdminPage extends AUIComponent {
    var $menu_width = 200;
    var $key = array();
    var $description = array();
    var $title = '';

    function AdminPage($width = 800, $title = '')
    {
        $this->width = $width;
        $this->title = $title;
    }

    function addKey($kk)
    {
        array_push($this->key, $kk);
    }

    function setmenu($menu)
    {
        $this->set("menu",$menu);
        if (is_object($menu)) {$menu->setWidth($this->menu_width-10);}
    }

    function setbody($body)
    {
        $this->set("body",$body);
    }

    function drawcontent()
    {
        echo "<table border=0 width='" . $this->width . "' class='aui_bico'><tr>";
        if ($menu = $this->items["menu"]) {
          echo "<td class='aui_bico_menu' width='" . $this->menu_width . "' valign=top>\n";
          $this->drawChild($menu);
          echo "</td>";
        }
        echo "<td class=aui_bico_body valign=top>";

        $body = $this->items["body"];
        if (is_object($body)) {
          If ($menu) {
            $body->setWidth($this->width - $this->menu_width);
          } else {
            $body->setWidth($this->width);
          }
        }
        $this->drawChild($body);
        echo"</td></tr></table>\n";
    }

    function draw()
    {
        global $_SHOP;

        $this->drawHead();
        $this->drawcontent();
        $this->drawFoot();
    }

    function drawHead()
    {
        global $_SHOP;
        if (!isset($_SERVER["INTERFACE_LANG"]) or !$_SERVER["INTERFACE_LANG"]) {
            $_SERVER["INTERFACE_LANG"] = $_SHOP->langs[0];
        }
        if (isset($_SHOP->system_status_off) and $_SHOP->system_status_off) {
            $this->errmsg = "<div class=error>".con('system_halted')."</div>";
        }
         //+'&href={$_SERVER["REQUEST_URI"]}'
        echo "<head>
        <meta HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=UTF-8\">
        <META HTTP-EQUIV=\"Content-Language\" CONTENT=\"" . $_SERVER["INTERFACE_LANG"] . "\">
        <title>" . $this->getTitle() . "</title>
        <link rel='stylesheet' href='admin.css'>
		<script><!--
		function set_lang(box)
		{
			lang = box.options[box.selectedIndex].value;
			if (lang) location.href = '?setlang='+lang;
		}
    // Author: Matt Kruse <matt@mattkruse.com>
    // WWW: http://www.mattkruse.com/
    TabNext();
    // Function to auto-tab field
    // Arguments:
    // obj :  The input object (this)
    // event: Either 'up' or 'down' depending on the keypress event
    // len  : Max length of field - tab when input reaches this length
    // next_field: input object to get focus after this one
    var field_length=0;
    function TabNext(obj, event, len, next_field) {
      if (event == \"down\") {
        field_length=obj.value.length;
      }
      else if (event == \"up\") {
        if (obj.value.length != field_length) {
          field_length=obj.value.length;
          if (field_length == len) {
            next_field.focus();
          }
        }
      }
    }
        -->
		</script>
  </head>
  <body >
  		<div id='wrap'>\n";
        echo "<div  id='header'>
               <img src='{$_SHOP->images_url}fusion.png'  border='0'/>
               <h2>".administration."</h2>
               </div>";
        echo"<div id='navbar'><table width='100%'>
            <tr><td>&nbsp;";
        $this->drawOrganizer();
        echo "</td><td  align='right'>&nbsp;";
//        echo "<select name='setlang' onChange='set_lang(this)'>";

//        $sel[$_SHOP->lang] = "selected";
//        foreach($_SHOP->langs_names as $lang => $name) {
//            echo"<option value='$lang' {$sel[$lang]}>$name</option>";
//        }
//        echo "</select>";
        echo"</td></tr></table></div><br>";
        if (isset($this->errmsg)) echo "<div class='error'>$this->errmsg</div><br>";
    }

    function drawFoot() {
      echo "<br><br>";
      echo "<div id='footer'>
				Powered by <a href='http://fusionticket.org'>Fusion Ticket</a> - The Free Open Source Box Office
			</div>
		</div>
	</body>
</html>";
    }

    function setTitle($tags)
    {
        $this->title = $tags;
    }

    function getTitle()
    {
        return $this->title;
    }

    function drawOrganizer ()
    {
        global $_SHOP;                                                         //   print_r($_SHOP);
        echo "<font color='#555555'><b>" . con('welcome') . " " .
          ((is_object($_SHOP->organizer_data))?
            $_SHOP->organizer_data->organizer_name:
            $_SHOP->organizer_data['organizer_name']) . "</b></font>";
    }
}
?>