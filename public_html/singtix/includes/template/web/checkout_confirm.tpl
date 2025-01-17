{*                  %%%copyright%%%
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
 *}
{include file="header.tpl" name=!order_reg! header=!tnx_order_mess!}

  <table class='table_dark' cellpadding='5' bgcolor='white' width='100%'>
    {eval var=$shop_handling.handling_text_payment assign=test}
    {gui->view name=payment value=$test}
    {eval var=$shop_handling.handling_text_shipment  assign=test}
    {gui->view name=shipment value=$test }
    {gui->valuta value=$order_total_price assign=test}
    {gui->view name=total_price value=$test}
    {gui->view name=order_id value=$order_id}
  </table><br>
  <table class='table_dark' cellpadding='5' bgcolor='white' width='400'>
    <tr>
      <td>
      {eval var=$confirmtext}
      </td>
    </tr>
  </table><br>
 
 
 {include file="footer.tpl"}