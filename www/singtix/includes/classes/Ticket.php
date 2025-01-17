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

class Ticket {

  var $event_id; 
  var $category_id;
  var $seat_id;
  var $price;
  var $discount_id;

  function Ticket ($event_id,$category_id,$seat_id,$user_id,$sid,$cat_price,$discount=null) {
    $this->event_id=$event_id;
    $this->category_id=$category_id;
    $this->seat_id=$seat_id;
    $this->user_id=$user_id;
    $this->sid = $sid;
    if(isset($discount)){
      $this->price=$discount->apply_to($cat_price);
      $this->discount_id=$discount->discount_id;
    }else{
      $this->price=$cat_price;
    }  
    
  }

  function order_id ($order_id=0){
    if($order_id){
      $this->order_id=$order_id;
    }
    return $this->order_id;
  }
  
  function save (){
    if(!$this->order_id){ return FALSE; }
    $code=$this->generate_code(8);

    $query="update Seat set 
    seat_order_id={$this->order_id}, 
    seat_user_id={$this->user_id}, 
    seat_price='{$this->price}',
    seat_discount_id='{$this->discount_id}',
    seat_code='$code',
    seat_status='com'
    where seat_id='{$this->seat_id}' and 
    seat_status='res' and
    seat_sid='{$this->sid}'
    limit 1";
    
    if(ShopDB::query($query) and shopDB::affected_rows()==1){
      return $this->seat_id;
    }else{
      return FALSE;
    }
  }
  
  // Like placing an order but insted of setting the tickets or 'ord' we set them too
  // 'resp' as this is reserved by the Sale Point
  function reserve (){
    if(!$this->order_id){ return FALSE; }
    $code=$this->generate_code(8);

    $query="update Seat set 
    seat_order_id={$this->order_id}, 
    seat_user_id={$this->user_id}, 
    seat_price='{$this->price}',
    seat_discount_id='{$this->discount_id}',
    seat_code='$code',
    seat_status='resp'
    where seat_id='{$this->seat_id}' and 
    seat_status='res' and
    seat_sid='{$this->sid}'
    limit 1";
    
    if(ShopDB::query($query) and shopDB::affected_rows()==1){
      return $this->seat_id;
    }else{
      return FALSE;
    }
  }  
  
  function generate_code ($length){
    $chars = "0123456789";
     
    $code = '' ;

    for($i=0;$i <$length;$i++) {
        $code.=$chars{rand()%10};
    }

    return $code;
  }

  //static functions for all
  function reemit ($order_id,$seat_id,$code_length=8){
    global $_SHOP;
  
    $new_code=Ticket::generate_code($code_length);

    $query="update Seat 
            set seat_code='$new_code'
	    where seat_id='$seat_id' and
	          seat_order_id='$order_id'
	    LIMIT 1";
  
  
    if(!ShopDB::query($query) or shopDB::affected_rows()!=1){
      echo "<div class=error> $seat_id : ".ticket_not_reemited."</div>";
      return FALSE;
    }

    echo "<div class=success> $seat_id : ".ticket_reemited."</div>";
    return TRUE;
  }
}
?>