{*
%%%copyright%%%
 * phpMyTicket - ticket reservation system
 * Copyright (C) 2004-2005 Anna Putrino, Stanislav Chachkov. All rights reserved.
 *
 * This file is part of phpMyTicket.
 *
 * This file may be distributed and/or modified under the terms of the
 * "GNU General Public License" version 2 as published by the Free
 * Software Foundation and appearing in the file LICENSE included in
 * the packaging of this file.
 *
 * Licencees holding a valid "phpmyticket professional licence" version 1
 * may use this file in accordance with the "phpmyticket professional licence"
 * version 1 Agreement provided with the Software.
 *
 * This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
 * THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE.
 *
 * The "phpmyticket professional licence" version 1 is available at
 * http://www.phpmyticket.com/ and in the file
 * PROFESSIONAL_LICENCE included in the packaging of this file.
 * For pricing of this licence please contact us via e-mail to 
 * info@phpmyticket.com.
 * Further contact information is available at http://www.phpmyticket.com/
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * Contact info@phpmyticket.com if any conditions of this licencing isn't 
 * clear to you.
 *}
<table width='100%'  cellspacing='2' style='border-top:#45436d 1px solid;border-bottom:#45436d 1px solid;'>
  <tr>
  <td class='admin_info'><img src='images/dot.gif' class='admin_order_ord' width='15' height='15' /> {!ordered!}</td>
  <td class='admin_info'><img src='images/dot.gif' class='admin_order_send' width='15' height='15' /> {!sent!}</td>
  <td class='admin_info'><img src='images/dot.gif' class='admin_order_payed' width='15' height='15' /> {!paid!}</td>
  <td class='admin_info'><img src='images/dot.gif' class='admin_order_cancel' width='15' height='15' /> {!canceled!}</td>
  <td class='admin_info'><img src='images/dot.gif' class='admin_order_reemit' width='15' height='15' /> {!reemitted!}</td>
  <td class='admin_info'><img src='images/dot.gif' class='admin_order_res' width='15' height='15' /> {!reserved!}</td>
  </tr>
  </table>
<br>
  <table width='100%'  cellspacing='2' class='admin_info' style='border-top:#45436d 1px solid;border-bottom:#45436d 1px solid;'>
  <tr><td ><img src='images/view.png' border='0'>
  {!order_details!}
</td><td><img src='images/printer.gif' border='0'>   
  {!print_order!}
</td><td ><img src='images/trash.png' border='0'>
  {!cancel_and_delete!}
</td></tr>
  </table>