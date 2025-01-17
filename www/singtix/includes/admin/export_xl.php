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
require_once 'Spreadsheet/Excel/Writer.php';

class export_xl extends AdminView {

  function xl_form (&$data,&$err){
    echo "<form method='get' action='{$_SERVER['PHP_SELF']}'>";
    echo "<table class='admin_list' border='0' width='$this->width' cellspacing='1' cellpadding='5'>";
    echo "<tr><td colspan='2' class='admin_list_title'>".xl_view_title."</td></tr>";
    $this->print_date('xl_start',$data,$err);
    $this->print_date('xl_end',$data,$err);
    echo "<tr><td align='center' class='admin_value' colspan='2'>
  
		<input type='hidden' name='export_type' value='xl'>
		
		<input type='submit' name='submit' value='".generate_xl."'>
		<input type='reset' name='reset' value='".res."'></td></tr>";
    echo "</table></form>";
  }

  function xl_check (&$data) {
    if(isset($data['xl_start-y']) or isset($data['xl_start-m']) or isset($data['xl_start-d'])){
      $y=$data['xl_start-y'];
      $m=$data['xl_start-m'];
      $d=$data['xl_start-d'];
    }
    if(!checkdate($m,$d,$y)){$err['xl_start']=invalid;}
    else{$data['xl_start']="$y-$m-$d 00:00:00";}
    if(isset($data['xl_end-y']) or isset($data['xl_end-m']) or isset($data['xl_end-d'])){
      $y=$data['xl_end-y'];
      $m=$data['xl_end-m'];
      $d=$data['xl_end-d'];
    }
    if(!checkdate($m,$d,$y)){$err['xl_end']=invalid;}
    else{$data['xl_end']="$y-$m-$d 23:59:59";}
    return empty($err);
  } 
  
  function generate_xl ($res,$start,$end){
    $start=substr($start,0,10);
    $end=substr($end,0,10);
    // Creating a workbook
    $workbook = new Spreadsheet_Excel_Writer();
    // sending HTTP headers
    $workbook->send("ticket".$start."_".$end.".xls");
    // Creating a worksheet
    $worksheet =& $workbook->addWorksheet('Tickets Data');
    // The actual data
    $worksheet->write(0, 0, 'Seat ID');
    $worksheet->write(0, 1, 'Order ID');
    
    $worksheet->write(0, 2, 'User_ID');
    $worksheet->write(0, 3, 'User_LastName');
    $worksheet->write(0, 4, 'User_FirstName');
    $worksheet->write(0, 5, 'User_Address');
    $worksheet->write(0, 6, 'User_Address1');
    $worksheet->write(0, 7, 'User_ZIP');
    $worksheet->write(0, 8, 'User_City');
    $worksheet->write(0, 9, 'User_Country');    
    $worksheet->write(0, 10, 'User_Phone');
    $worksheet->write(0, 11, 'User_Fax');
    $worksheet->write(0, 12, 'User_Email');    
    $worksheet->write(0, 13, 'User_Status');

    $worksheet->write(0, 14, 'Event_ID');
    
    $worksheet->write(0, 15, 'Event_Name');
    $worksheet->write(0, 16, 'Event_Date');
    $worksheet->write(0, 17, 'Event_Time');
    $worksheet->write(0, 18, 'Ort_id');
    $worksheet->write(0, 19, 'Ort_Name');

    $worksheet->write(0, 20, 'Category_ID');

    $worksheet->write(0, 21, 'Category_Name');
    $worksheet->write(0, 22, 'Category_Price');
    
    $worksheet->write(0, 23, 'Seat_Price');
    $worksheet->write(0, 24, 'Discount_Name');
    $worksheet->write(0, 25, 'Discount_Type');
    $worksheet->write(0, 26, 'Discount_Value');
    
    $i=1;
    while($row=shopDB::fetch_assoc($res)){
      $worksheet->write($i, 0, $row['seat_id']);
      $worksheet->write($i, 1, $row['seat_order_id']);
      
      $worksheet->write($i, 2, $row['user_id']);
      $worksheet->write($i, 3, $row['user_lastname']);
      $worksheet->write($i, 4, $row['user_firstname']);
      $worksheet->write($i, 5, $row['user_address']);
      $worksheet->write($i, 6, $row['user_address1']);
      $worksheet->write($i, 7, $row['user_zip']);
      $worksheet->write($i, 8, $row['user_city']);
      $worksheet->write($i, 9, $row['user_country']);    
      $worksheet->write($i, 10, $row['user_phone']);
      $worksheet->write($i, 11,$row['user_fax']);
      $worksheet->write($i, 12,$row['user_email']);    
      $worksheet->write($i, 13,$row['user_status']);

      $worksheet->write($i, 14,$row['event_id']);
    
      $worksheet->write($i, 15,$row['event_name']);
      $worksheet->write($i, 16,$row['event_date']);
      $worksheet->write($i, 17,$row['event_time']);

      $worksheet->write($i, 18,$row['ort_id']);
      $worksheet->write($i, 19,$row['ort_name']);

      $worksheet->write($i, 20,$row['category_id']);

      $worksheet->write($i, 21,$row['category_name']);
      $worksheet->write($i, 22,$row['category_price']);
    
      $worksheet->write($i, 23,$row['seat_price']);
      if($row['discount_id']){
        $worksheet->write($i, 24,$row['discount_name']);
        $worksheet->write($i, 25,$row['discount_type']);
        $worksheet->write($i, 26,$row['discount_value']);
      
      }
      $i++;
    }
    // Let's send the file
    $workbook->close();  
  }
  
  function export (){
   global $_SHOP;
  
   if($_GET['submit']){
     if(!$this->xl_check($_GET,$this->err)){
       return FALSE;
     }else{
       $start=_esc($_GET["xl_start"]);
       $end=_esc($_GET["xl_end"]);
       $query="select * from Seat LEFT JOIN Discount ON seat_discount_id=discount_id,`Order`,User,Event,Category,Ort where 
               seat_order_id=order_id AND order_date>=$start AND order_date<=$end
	       AND seat_event_id=event_id AND  seat_category_id=category_id 
	       AND seat_user_id=user_id AND event_ort_id=ort_id";
       if(!$res=ShopDB::query($query)){
         return 0;
       }
       $this->generate_xl($res,$_GET["xl_start"],$_GET["xl_end"]);
       return TRUE; 
     }
   }  
  }
  
  function draw (){
    $this->xl_form($_GET,$this->err);
  }
}
?>