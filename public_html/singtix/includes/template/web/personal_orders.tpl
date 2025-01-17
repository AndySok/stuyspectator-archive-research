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
<table width="100%" cellpadding="3" class="main">
	<tr>
    <td colspan="7" class="title"><h3>{!pers_orders!}</h3></td>
  </tr>
  <tr>
    <td><p><strong>{!event!}</strong></p></td>
	  <td><p><strong>{!order_id!}</strong></p></td>
	  <td><p><strong>{!order_date!}</strong></p></td>
	  <td><p><strong>{!tickets!}</strong></p></td>
	  <td><p><strong>{!total_price!}</strong></p></td>
	  <td><p><b>{!status!}</b></p></td>
	  <td><p><b>{!options!}</b></p></td>
  </tr>
  {if $user->logged}
    {order->order_list user_id=$user->user_id order_by_date="DESC"}
	    {if $shop_order.order_status eq "cancel"}
  			<tr class='user_order_{$shop_order.order_status}'>
  		{elseif $shop_order.order_status eq "reemit"}
  			<tr class='user_order_{$shop_order.order_status}'>
  		{elseif $shop_order.order_status eq "res"}
  			<tr class='user_order_{$shop_order.order_status}'>
  		{elseif $shop_order.order_shipment_status eq "send"}
  			<tr class='user_order_{$shop_order.order_shipment_status}'>
  		{elseif $shop_order.order_payment_status eq "payed"}
  			<tr class='user_order_{$shop_order.order_payment_status}'>
  		{elseif $shop_order.order_status eq "ord"}
  			<tr class='user_order_{$shop_order.order_status}'>
  		{else}
  			<tr class='user_order_cancel'>
  		{/if}
    		<td class='admin_info'>
      		{order->tickets order_id=$shop_order.order_id limit=1}
      		{$shop_ticket.event_name}
      		{/order->tickets}
    		</td>
        <td class='admin_info'>{$shop_order.order_id}</td>
    		<td class='admin_info'>{$shop_order.order_date}</td>
    		<td class='admin_info'>{$shop_order.order_tickets_nr}</td>
    		<td class='admin_info'>{$shop_order.order_total_price}</td>
    		<td class='admin_info'>
    		{if $shop_order.order_status eq "cancel"}{!pers_cancel!}
    		{elseif $shop_order.order_status eq "reemit"}{!pers_reemit!}
    		{elseif $shop_order.order_status eq "res"}{!pers_res!}
    		{elseif $shop_order.order_shipment_status eq "send"}{!pers_send!}
    		{elseif $shop_order.order_payment_status eq "payed"}{!pers_payed!}
    		{elseif $shop_order.order_status eq "ord"}{!pers_ord!}
    		{else}{!pers_unknown!}
    		{/if}</td>
    		<td class='admin_info'>
          <a href='?personal_page=orders&id={$shop_order.order_id}'>
            <img border='0' src='images/view.png'> {!view_order!}
          </a>
    		</td>
      </tr>
    {/order->order_list}
  {/if}
</table>