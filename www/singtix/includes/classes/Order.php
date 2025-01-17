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

require_once("classes/Ticket.php");
require_once("classes/Seat.php");
require_once('classes/Handling.php');


class Order {

  var $places=array();
  public $order_user_id = 0;
  public $order_session = 0;
  public $order_handling_id = 0;
  public $order_place = "www";
  public $no_fee = false;
  public $no_cost = false;
  public $order_handling = null;

  function Order ($order_user_id, $sid, $handling_id, $dummy, $no_fee, $no_cost, $place='www'){

    if(!$order_user_id){return;}  

    $this->order_user_id=$order_user_id;
    $this->order_session_id=$sid;
    $this->order_handling_id=$handling_id;
  	$this->order_place=$place;
  	$this->no_fee=$no_fee;
  	$this->no_cost=$no_cost;
    $hand=Handling::load($handling_id);
    $this->order_handling=&$hand;
    $this->order_owner_id = ($place == 'pos')? $_SESSION['_SHOP_AUTH_USER_DATA']['user_id']: null;
    
  }
  
	function save_order_note($order_id,$note){
		$sql = "UPDATE `Order` SET order_note="._esc($note)."
				WHERE order_status NOT IN ('trash','cancel') AND order_id="._esc($order_id);
		if(!$res=ShopDB::query($sql)){
			return "No such Order ID";
		}else{
			return "Note Changed Successfully";
		}
	}

  function add_seat ($event_id,$category_id,$place_id,$price,$discount=null){
    //echo "$event_id,$category_id,$place_id,{$this->order_user_id},{$this->order_session_id},$price,$discount";
    array_push($this->places, new Ticket($event_id, $category_id, $place_id, $this->order_user_id, $this->order_session_id, $price, $discount));
  }
  
  function size (){
    return count($this->places);
  }
  
  function load ($order_id, $complete=false){
    global $_SHOP;
    
    $query="select * from `Order` 
    WHERE order_id = "._esc($order_id);
    if($data=ShopDB::query_one_row($query)){
      $order=new Order(0,0,0,0,0,0);
      $order->_fill($data);

      if($order and $complete){
        if ($order->order_handling_id) {
          $order->handling= Handling::load($order->order_handling_id);
          $order->order_handling= &$order->handling;
        }
      }
      return $order;
    }
    // the next log is included to find when or why sometimes it is not possible set the send state.
    ShopDB::dblogging("Can load Order '{$order_id}', check of it exist.");
  }
  
	public function loadFromPaymentId($payment_id, $handling_id, $complete=false){
		global $_SHOP;
    
    	$query="select * from `Order`  
    		WHERE order_payment_id = "._esc($payment_id)." 
			AND order_handling_id = "._esc($handling_id);
   		
	   	if($data=ShopDB::query_one_row($query)){
      		$order=new Order(0,0,0,0,0,0);
      		$order->_fill($data);
      		
      		if($order and $complete){
        		if ($order->order_handling_id) {
          			$order->handling= Handling::load($order->order_handling_id);
          			$order->order_handling= &$order->handling;
        		}
			//$order->places = Ticket::loadall($order_id);
       		}
      		return $order;
    	}	
	}

  function load_ext ($order_id){
    global $_SHOP;
    $query = "SELECT * FROM `Order`, User 
              WHERE order_id = ".ShopDB::quote($order_id)." 
							and order_user_id=user_id";
	      
    if($data=ShopDB::query_one_row($query)){
      $order=new Order(0,0,0,0,0,0);
      $order->_fill($data);
      return $order;
    }
      
  }

  function _abort ($str=''){
    if ($str) {
      echo "<div class=error>$str</div>";
    }
    ShopDB::rollback($str);
    return false; // exit;
  }

  function _fill ($data){
    foreach($data as $k=>$v){
      If(is_string($k))
        $this->$k=$v;
    }
  }


 function total (){
    $res=0;
    foreach($this->places as $ticket){
      $res+=$ticket->price;
    }
    $res+=($res/100.00)*$this->shipment_price_percent;
    $res+=$this->shipment_price_fixe;
    $res=round($res,2);
    return $res;
  }

  function parzial (){
    $res=0;
    foreach($this->places as $seat){
      $res+=$seat->price;
    }
    return $res;
  }
  
  function save_full (){
 	  if(!ShopDB::begin('Save Order')){return FALSE;}
    
    if(!$this->save()){ShopDB::rollback('Error_saving_order');return FALSE;}
      
    if(!ShopDB::commit('Order saved')){ShopDB::rollback('Errors_commiting_order');return FALSE;}

    return $this->order_id;
  }
  
  /**
   * Save order function, will take parmaters from the class varibles constructor.
   * 
   * @since 1.0
   * @updated 1.0 beta5 
   */ 
  function save () {
  	
  	global $_SHOP;

    if($this->order_id){
      echo "this order is already saved!!!";
      return FALSE; //already saved
    }
	
    $parzial=$this->parzial();
  	if(!$this->no_fee){
  		$fee=$this->order_handling->calculate_fee($parzial);
  	}else{
  		$fee=0;
  	}
  	if($this->no_cost) {
  		$total=0;
  	}else{
  		$total=$parzial+$fee;
  	}

    $fee=number_format($fee, 2, '.', '');
    $total=number_format($total, 2, '.', '');
    
    $this->order_partial_price=$parzial;
    $this->order_total_price=$total;
    $this->order_fee=$fee;
    
    $order_date_expire = 'null';
//    if(!$this->order_handling->handling_expires_min){
//    	$this->order_handling->handling_expires_min = 20;
//    }
    
  	if($this->order_handling->handling_id=='1'){
  		$order_status="res";
  		$order_date_expire = "TIMESTAMPADD( MINUTE , ".$_SHOP->shopconfig_restime.", NOW())";
  	}else{
  		$order_status="ord";
  		If ($this->order_handling->handling_expires_min>10) {
  		  $order_date_expire = "TIMESTAMPADD( MINUTE , ".$this->order_handling->handling_expires_min.", NOW())";
      }
  	}
	
    $this->order_date =date('d-m-Y');
    
    $query = "INSERT INTO `Order` (
		`order_user_id`, 
		`order_session_id`,
		`order_tickets_nr`, 
		`order_total_price`, 
		`order_date`, 
		`order_handling_id`, 
		`order_status`, 
		`order_fee`, 
		`order_place`, 
		`order_owner_id`, 
		`order_date_expire`
		) VALUES ( ".
      	_esc($this->order_user_id).",".      
      	_esc($this->order_session_id).",".
      	_esc($this->size()).",".      
      	_esc($total).",".      
      	"NOW(),".      
      	_esc($this->order_handling->handling_id).",".
      	_esc($order_status).",".
      	_esc($fee).",".
	      _esc($this->order_place).",".
	      _esc($this->order_owner_id).",
	      $order_date_expire);";
		
    if(ShopDB::query($query)){
      $order_id=ShopDB::insert_id();
      $this->order_id=$order_id;
      
      foreach(array_keys($this->places) as $i){
        $ticket =& $this->places[$i];
    		$ticket->order_id($order_id);
    		/////////////////////////////// Tickets are saved here if handled==1 tickets are reserved instead of ordered.
    		if($this->order_handling->handling_id=='1'){
  	  		if(!$ticket->reserve()){
      			return FALSE;
   	  		}
     		}elseif(!$ticket->save()){
    			return FALSE;
    		}
        $event_stat[$ticket->event_id]++;
        $category_stat[$ticket->category_id]++;
      }
      
      require_once('classes/Event_stat.php');
      require_once('classes/Category_stat.php');
      
      foreach($event_stat as $event_id=>$count){
        if(!Event_stat::dec($event_id,$count)){return FALSE;}
      }
      
      foreach($category_stat as $cat_id=>$count){
        if(!Category_stat::dec($cat_id,$count)){return FALSE;}
      }
  	  if($this->order_handling->handling_id=='1'){
    		$this->set_status('res',TRUE);
  	  }else{
       	$this->set_status('ord',TRUE);
      }
      return $order_id;
    }else{
       return FALSE;
    }
  }

  function getID () {
     return $this->order_id;
  }
  
  /* static functions of common use */

  function order_delete_ticket ($order_id,$seat_id,$dummy=0,$user_id=0){
  	global $_SHOP;
  	
    if(!ShopDB::begin('order_delete_ticket')){
      echo "<div class=error>".cannot_begin_transaction."</div>";
      return FALSE;
    }

    $query="SELECT * FROM `Seat` WHERE seat_id='$seat_id'
    AND seat_order_id='$order_id' FOR UPDATE";

    if(!$seat=ShopDB::query_one_row($query)){
      echo "<div class=error>".cannot_find_seat."</div>";
      ShopDB::rollback('order_delete_ticket');
      return FALSE;
    }

    $query="SELECT * FROM `Order` WHERE order_id='$order_id' FOR UPDATE";

     if(!$order=ShopDB::query_one_row($query)){
      echo "<div class=error>".cannot_find_order.'@order_delete_ticket.'.$order_id."</div>";
      ShopDB::rollback("order_delete_ticket($order_id)");
      return FALSE;
    }

    // Added v1.3.4 Checks to see if the order has allready been canceled.
    if($order['order_status']=='cancel'){
  	  echo "<div class=error>".order_allready_cancelled."</div>";
  	  ShopDB::rollback('order_delete_ticket');
  	  return FALSE;
    }


    //if the order has only one ticket, the whole order will be deleted/canceled instead of just the ticket!
    if($order['order_tickets_nr']==1){
      ShopDB::rollback('order_delete_ticket');
      return Order::order_delete($order_id, 'deleted_all_tickets');
    }

    // If deleteing a reserved ticket
    if($order['order_handling_id']==1){
  	$query="UPDATE `User` SET user_current_tickets=user_current_tickets-1 WHERE user_id=".$order['order_user_id'];
  	if(!ShopDB::query($query)){
  		echo "<div class=error>".no_such_user."</div>";
  		ShopDB::rollback('order_delete_ticket');
  		return FALSE;
  	}
    }

    $place=array('seat_id'=>$seat['seat_id'],
                 'event_id'=>$seat['seat_event_id'],
                 'category_id'=>$seat['seat_category_id'],
  	             'pmp_id'=>$seat['seat_pmp_id']);

    if(!Seat::cancel(array($place),$seat['seat_user_id'])){
      echo "<div class=error>".cannot_delete_ticket."(1)</div>";
      ShopDB::rollback('order_delete_ticket');
      return FALSE;
    }
    //returns cost of seats Adds up the seats with the same order id.
    $query="SELECT SUM(seat_price) AS total FROM `Seat` WHERE seat_order_id='$order_id'";
    if(!$res=ShopDB::query_one_row($query)){
      echo "<div class=error>".cannot_delete_ticket."(2)</div>";
      ShopDB::rollback('order_delete_ticket');
      return FALSE;
    }
    $total=$res['total'];

    //recalculates cost as when placing a new order
    if($hand=Handling::load($order['order_handling_id'])){

      $fee=$hand->calculate_fee($total);
      $total+=$fee;
    }

    $query="update `Order`
            set order_tickets_nr=(order_tickets_nr-1),
  	      order_total_price=$total,
  	      order_fee=$fee
            where order_id='$order_id'
  	  LIMIT 1";

    if(!ShopDB::query($query) or shopDB::affected_rows() !=1){
      echo "<div class=error>".cannot_delete_ticket."(3)</div>";
      ShopDB::rollback('order_delete_ticket');
      return FALSE;
    }

  /*
    $query="delete from Seat
            where seat_id='$seat_id' and seat_order_id='$order_id'
  	  LIMIT 1";

    if(!ShopDB::query($query) or shopDB::affected_rows()!=1){
      echo "<div class=error>".cannot_delete_seat."</div>";
      ShopDB::rollback();
      return FALSE;
    }
  */
    if(!ShopDB::commit('order_delete_ticket')){
      echo "<div class=error>".cannot_delete_ticket."(4)</div>";
      ShopDB::rollback('order_delete_ticket');
      return FALSE;
    }

    echo "<div class=success>".ticket_deleted."</div>";
    return TRUE;
  }
  
   function order_description() {
     return con('orderDescription');
   }


  function Check_payment($order_id){
   $order = Order::load($order_id, true);
   return $order->order_handling->on_check($order);
  }
  
  function order_delete ($order_id, $reason = 0){
    global $_SHOP;

    if(!ShopDB::begin('delete orders:'.$order_id)){
      echo "<div class=error>".cannot_begin_transaction."</div>";
      return FALSE;
    }

    $query="SELECT * FROM `Seat` WHERE seat_order_id='$order_id' FOR UPDATE";
    if(!$res=ShopDB::query($query)){
      return $this->_abort(con('Cant_lock_seat'));
    }

    $query="SELECT * FROM `Order` WHERE order_id='$order_id' FOR UPDATE";
    if(!$order=ShopDB::query_one_row($query)){
      return $this->_abort(con('cannot_find_order'));
    }
    // Added v1.3.4 Checks to see if the order has allready been canceled.
    if($order['order_status']=='cancel'){
    	return $this->_abort(con('order_allready_cancelled'));
    }

    //Added v1.3.4 - If deleteing a reserved ticket
    if($order['order_handling_id']==1){
    	$query="UPDATE `User` SET user_current_tickets=user_current_tickets-".$order['order_tickets_nr']." WHERE user_id=".$order['order_user_id'];
    	if(!ShopDB::query($query)){
    		return $this->_abort(con('no_such_user'));
    	}
    }

    while($row=shopDB::fetch_object($res)){
      $user_id=$row->seat_user_id;
      $places[]=array(
        'seat_id'=>$row->seat_id,
        'category_id'=>$row->seat_category_id,
        'event_id'=>$row->seat_event_id,
        'pmp_id'=>$row->seat_pmp_id);
    }

    if(count($places)!=0){
    	if(!Seat::cancel($places,$user_id,TRUE)){
      	return $this->_abort(con('cant_cancel_ordered_seat'));
    	}
    }


    $query="UPDATE  `Order`
            set order_status='cancel',
                order_responce="._esc($reason).",
                order_responce_date= NOW()
            where order_id="._esc($order_id);

    if(!$res=ShopDB::query($query)){
      return $this->_abort(con('cant_set_order_to_cancel'));
    }

    if(!ShopDB::commit('order_deleted')){
      echo "<div class=error>".order_not_canceled."(5)</div>";
      ShopDB::rollback('order_delete');
      return $this->_abort(con('Cant_commit_order_deleting'));
    }else{
      //echo "<div class=success>".order_canceled."</div>";

      if($order_handling=Handling::load($order['order_handling_id'])){
  			$order_handling->on_order_delete($order_id);
  		}

  		return TRUE;
    }
  }
  function set_send ($order_id, $dummy=0, $user_id=0){

    $order=Order::load($order_id);
    $order->set_shipment_status('send');
  }
  
  function set_payed ($order_id, $dummy=0, $user_id=0){

    $order=Order::load($order_id);
    $order->set_payment_status ('payed');
  }
  
  function set_reserved ($order_id, $dummy=0, $user_id=0){

    $order=Order::load($order_id);
    $order->set_status ('res');
  }
  	
	/**
	 * Order::set_payment_id()
	 * 
	 * Use to set the payment id for a third party EPH such as:
	 * Google, iDEAL, PayPal.
	 * 
	 * @param int $order_id
	 * @param mixed $payment_id
	 * @return boolean
	 */
	public function set_payment_id($order_id, $payment_id=null){
		$order=Order::load($order_id);
		
		if(!ShopDB::begin('set order_payment_id')){return FALSE;}
		
		$query="UPDATE `Order`
			SET order_payment_id="._esc($payment_id)."  
            WHERE order_id="._esc($order_id);
            
		
		if(!ShopDB::query($query)){
			ShopDB::rollback('set order_payment_id');
			return FALSE;
		}
		
		if(!ShopDB::commit('set order_payment_id')){
      ShopDB::rollback('set order_payment_id');
      return FALSE;
    }
		
		return true;
		
		
	}

  function reserve_to_order($order_id,$handling_id,$no_fee=false,$no_cost=false,$place='www'){

  	if(!ShopDB::begin('reserve_to_order:'.$order_id )){
      	echo "<div class=error>".cannot_begin_transaction."</div>";
      	return FALSE;
    	}
    	//loads old order into var
    	$query="SELECT * FROM `Order` WHERE order_id='$order_id' AND order_status='res' FOR UPDATE";
    	if(!$order_old=ShopDB::query_one_row($query)){
      	return $this->_abort(con('order_not_found'));
  	  }
  	// If deleteing a reserved ticket
    	if($order_old['order_handling_id']==1){
  		$query="UPDATE `User` SET user_current_tickets=user_current_tickets-".$order_old['order_tickets_nr']."
  				WHERE user_id=".$order_old['order_user_id'];
  		if(!ShopDB::query($query)){
  			return $this->_abort(con('no_such_user'));
  		}
  	}
  	//checks to see if its an remitted or canceled order!
    	if($order_old['order_status']=='cancel' or
   		   $order_old['order_status']=='reemit'){
      	return $this->_abort(con('order_cannot_reorder'));
    	}

  	//returns cost of seats Adds up the seats with the same order id.
  	$query="SELECT SUM(seat_price) AS total FROM `Seat` WHERE seat_order_id='$order_id'";
  	if(!$res=ShopDB::query_one_row($query)){
  		return $this->_abort(con('order_cannot_reorder')."(add up seats)");
  	}
  	$total=$res['total'];

  	//recalculates cost, same as when placing a new order
  	if($hand=Handling::load($handling_id)){
  		if(!$no_fee){
  			$fee=$hand->calculate_fee($total);
  		}else{
  			$fee=0;}
  		if(!$no_cost){
  			$total+=$fee;
  		}else{
  			$total=0;}
  	}

  	//New Query to create new order from old order!
  	$query="INSERT INTO `Order` (
  	order_user_id,
  	order_tickets_nr,
  	order_total_price,
  	order_date,
  	order_status,
  	order_shipment_status,
  	order_payment_status,
  	order_handling_id,
  	order_fee,
  	order_place
  	) VALUES (
  	'{$order_old['order_user_id']}',
  	'{$order_old['order_tickets_nr']}',
  	'{$total}',
  	NOW(),
  	'ord',
  	'{$order_old['order_shipment_status']}',
  	'{$order_old['order_payment_status']}',
  	'{$handling_id}',
  	'{$fee}',
  	'{$place}'
  	)";
  	// Runs Query
  	if(!ShopDB::query($query)){
  		return $this->_abort(con('order_cannot_reorder'."(create new order)"));
  	}

  	//Collects just inserted order_id and echo's the id
  	$new_id=ShopDB::insert_id();
  	echo "<div class=success>".new_order_created.": $new_id</div>";

  	//Selects Seats from old order using passed order_id from 'params'
  	$query="SELECT seat_id FROM `Seat` WHERE seat_order_id='$order_id' FOR UPDATE";
  	if(!$res=ShopDB::query($query)){
  		return $this->_abort(con('order_cannot_reorder')."(load seats)");
  	}
  	//Runs through each seat and gives it a new seat_code and the new order_id.
  	while($seat = shopDB::fetch_array($res)){
  		$code=Ticket::generate_code(8);
  		$query="UPDATE `Seat` set seat_order_id='$new_id',seat_code='$code' WHERE seat_id='{$seat['seat_id']}' ";
  		if(!ShopDB::query($query)){
  	  	return $this->_abort(con('order_cannot_reorder')."(update seats)");
  		}
  	}

  	//Change old order, change its status and give the it the id of the new order.
  	$query="UPDATE  `Order` SET
          order_status='cancel', 
          order_reason='reserve_to_order'
  			WHERE order_id='$order_id'";
  	if(!$res=ShopDB::query($query)){
  		return $this->_abort(order_cannot_reorder."(cant up old ord)");
  	}
  	//Commit and finish
  	if(!ShopDB::commit('order reordered')){
  		return $this->_abort(order_cannot_reorder."(commit)");
  	}

  	echo "<div class=success>$order_id ".old_order_canceled."(Success)</div>";

  	return $new_id;

  }


  function order_reemit ($order_id){

    if(!ShopDB::begin('reemit order: '.$order_id)){
      echo "<div class=error>".cannot_begin_transaction."</div>";
      return FALSE;
    }
    //loads old order into var
    $query="SELECT * FROM `Order` WHERE order_id='$order_id' FOR UPDATE";
    if(!$order_old=ShopDB::query_one_row($query)){
      return $this->_abort(order_not_found);
    }

    //checks to see if its an remitted or canceled order!
    if($order_old['order_status']=='cancel' or
    $order_old['order_status']=='reemit'){
      return $this->_abort(order_already_reemited_canceled);
    }

    //New Query to create new order from old order!
    $query="INSERT INTO `Order` (
    order_user_id,
    order_tickets_nr,
    order_total_price,
    order_date,
    order_status,
    order_shipment_status,
    order_payment_status,
    order_handling_id,
    order_fee
    ) VALUES (
    '{$order_old['order_user_id']}',
    '{$order_old['order_tickets_nr']}',
    '{$order_old['order_total_price']}',
    NOW(),
    '{$order_old['order_status']}',
    '{$order_old['order_shipment_status']}',
    '{$order_old['order_payment_status']}',
    '{$order_old['order_handling_id']}',
    '{$order_old['order_fee']}'
    )";

    // Runs Query
    if(!ShopDB::query($query)){
      return $this->_abort(order_cannot_creating_new_order);
    }
    //Collects just inserted order_id and echo's the id
    $new_id=shopDB::insert_id();
    echo "<div class=success>".new_order_created.": $new_id</div>";

    //Selects Seats from old order using passed order_id from 'params'
    $query="SELECT seat_id FROM `Seat` WHERE seat_order_id='$order_id' FOR UPDATE";
    if(!$res=ShopDB::query($query)){
      return $this->_abort(order_cannot_lock_seats);
    }
    //Runs through each seat and gives it a new seat_code and the new order_id.
    while($seat = shopDB::fetch_array($res)){
      $code=Ticket::generate_code(8);
      $query="UPDATE `Seat` set seat_order_id='$new_id',seat_code='$code' WHERE seat_id='{$seat['seat_id']}'";
      if(!ShopDB::query($query)){
        return $this->_abort(order_cannot_change_seat);
      }
    }

    //Change old order, change its status and give the it the id of the new order.
    $query="UPDATE  `Order` set order_status='reemit',order_reemited_id='$new_id'
            where order_id='$order_id'";
    if(!$res=ShopDB::query($query)){
      echo "<div class=error>$order_id ".order_cannot_reemit."</div>";
      ShopDB::rollback();
      return $this->_abort(order_cannot_change_order);
    }
    //Commit and finish
    if(!ShopDB::commit('order reemited')){
      echo "<div class=error>$order_id ".order_cannot_reemit."(commit)</div>";
      ShopDB::rollback();
      return $this->_abort(order_cannot_reemit."(commit)");
    }

    echo "<div class=success>$order_id ".old_order_canceled."(Success)</div>";

    return $new_id;
  }

  function set_status_order($order_id,$new_status){
  	$query="UPDATE `Order` SET order_status='{$new_status}' WHERE order_status NOT IN ('trash','cancel') AND order_id='{$order_id}' ";
  	if(!$res=ShopDB::query($query)){
  		echo "<div class=error>$order_id ".order_cannot_change_status."</div>";
  		return false;
  	}else{
  		return true;
  	}
  }

  function set_status ($new_status,$dont_do_update=FALSE){
    return $this->_set_status('order_status',$new_status,$dont_do_update);
  }

  function set_payment_status ($new_status,$dont_do_update=FALSE){
    return $this->_set_status('order_payment_status',$new_status,$dont_do_update);
  }

  function set_shipment_status ($new_status,$dont_do_update=FALSE){
    return $this->_set_status('order_shipment_status',$new_status,$dont_do_update);
  }

  function _set_status ($field,$new_status,$dont_do_update=FALSE){
    global $_SHOP;
    $old_status=$this->order_status;

    if(!$this->user_id){
      $query="SELECT * FROM `User` WHERE user_id='{$this->order_user_id}'";
      if($data=ShopDB::query_one_row($query)){
        $this->_fill($data);
      }
    }

    if($field=='order_payment_status' and  $new_status=='payed' ){ //and
      $suppl = ", order_date_expire=NULL";
    }
    if($field=='order_payment_status' and  $new_status=='pending' and  $old_status !=='none'){ //and
      return;
    }
    ShopDB::dblogging(
    $query="UPDATE `Order` SET $field='$new_status' $suppl WHERE order_id='{$this->order_id}'");
    if($dont_do_update or (ShopDB::query($query))){// and shopDB::affected_rows()==1)){
      if(!$this->order_handling){
        $this->order_handling=Handling::load($this->order_handling_id);
      }
      $this->order_handling->handle($this,$new_status,$old_status,$field);
    }
  }

  function toTrash(){
    global $_SHOP;
    if (!ShopDB::begin('trash order')){
      return $this->_abort(con('Cant_start_transaction'));
    }

  	$query="SELECT order_id, order_tickets_nr, count(seat_id) as count
  	        FROM `Order`, Seat
  					WHERE seat_order_id=order_id AND
  					seat_status='trash'
  					GROUP BY order_id
  					FOR UPDATE";

  	if(!$res=ShopDB::query($query)){
  		return $this->_abort(con('cant_lock_order'));;
  	}

  	$count=0;

  	while($data=shopDB::fetch_array($res)){
  	  if($data['order_tickets_nr']==$data['count']){
    		$count++;

        $query="update `Order` set order_status='trash' where order_id='{$data['order_id']}'";
  			if(!ShopDB::query($query)){
  				return $this->_abort(con('cant_change_order_to_trash'));;
  			}
  		}
  	}

  	ShopDB::commit('order trashed');
  	return $count;
  }

  function emptyTrash(){
    global $_SHOP;
    if (!ShopDB::begin('empry trashed orders')){
      return $this->_abort(con('Cant_start_transaction'));
    }

  	$query="delete `Order`
  					from `Order` left join Seat on order_id=seat_order_id
  					where order_status='trash' and
  					seat_id is NULL";

  	if(!ShopDB::query($query)){
  		return $this->_abort(con('cant_delete_trashed_orders'));
  	}

  	ShopDB::commit('trashed order emptyed');
  	return TRUE;
  }

  function purgeDeleted($order_handling_id){
    global $_SHOP;

  	if($order_handling_id>0){
  	  $handling_cond = "and order_handling_id='$order_handling_id'";
  	}
  	$query = "UPDATE `Order`
  			SET order_status='trash' WHERE order_status='cancel' $handling_cond";

    ShopDB::query($query);
  }

  function purgeReemited($order_handling_id){
    global $_SHOP;

  	if($order_handling_id>0){
  	  $handling_cond = "and order_handling_id='$order_handling_id'";
  	}
  	$query = "update `Order`
  					set order_status='trash'
  					where order_status='reemit' $handling_cond";

    ShopDB::query($query);
  }

  function purge($order_handling_id=0){
  	Order::purgeDeleted($order_handling_id);
  	Order::purgeReemited($order_handling_id);
  }

  function EncodeSecureCode($order= null, $item='sor=', $loging=false) {

    if ($order == null) $order = $this;
    if ($order == null) return '';
    if (!$order->order_tickets_nr ) $order->order_tickets_nr = $order->size();
    $md5 = $order->order_session_id.':'.$order->order_user_id .':'. $order->order_tickets_nr .':'.
           $order->order_handling_id .':'. $order->order_total_price;
    $code = base64_encode(base_convert(time(),10,36).':'. base_convert($order->order_id,10,36).':'. md5($md5, true));

    //    ShopDB::dblogging('encode:'.$code.'|'.$md5.'|'.md5($md5));
    return $item. urlencode ($code); //  }
  }

  function DecodeSecureCode(&$order, $codestr ='', $loging=false) {
    If (empty($codestr) and isset($_REQUEST['sor'])) $codestr =$_REQUEST['sor'];
   //
    If (!empty($codestr)) {
      //$code = urldecode( $code) ;
//      print_r( $codestr );
      $text = base64_decode($codestr);
      $code = explode(':',$text);
    //  print_r( $text );
      $code[0] = base_convert($code[0],36,10);
      $code[1] = base_convert($code[1],36,10);
//      print_r( $code );
//      print_r( $order );

      if (!is_object($order) and isset($this) and ($this instanceof Order)) $order = $this;
      if (!is_object($order)) $order = self::load($code[1], true);
      if (!is_object($order)) return -1;

      $md5 = $order->order_session_id.':'.$order->order_user_id .':'. $order->order_tickets_nr .':'.
                  $order->order_handling_id .':'. $order->order_total_price;

      if ($loging) {
        ShopDB::dblogging('decode:'.$text.'|'.$code[2].'='.md5($md5, true));
        ShopDB::dblogging('Code:  '.print_r( $code, true));
        ShopDB::dblogging('order: '.print_r( $order, true));
      }
//      if ($code[0] > time()) return -2;
      if ($code[1] <> $order->order_id) return -3;
      if ($code[2] <> md5($md5, true)) return -4;
      return true;
    } else
      return -5;
  }
  
  function print_order ($order_id, $bill_template='', $mode='file', $print=FALSE, $subj=3){ //print subj: 1=tickets, 2=invoice, 3=both
    require_once("classes/TemplateEngine.php");
    require_once("html2pdf/html2pdf.class.php");
    require_once('classes/Handling.php');
    require_once('classes/gui_smarty.php');

  	global $_SHOP;
    if (!$mode) $mode = 'file';
    
    $orderqry = '
        SELECT * FROM `Order` left join User     on (order_user_id= user_id)
                              left join Handling on (order_handling_id = handling_id)
        where order_id = '._esc($order_id);

    $seatqry = '
        SELECT * FROM Seat LEFT JOIN Discount ON seat_discount_id=discount_id
                           left join Event    on event_id = seat_event_id
                           left join Ort      on ort_id = event_ort_id
                           left join Category on category_id = seat_category_id
                           left join PlaceMapZone on seat_zone_id = pmz_id
                           left join PlaceMapPart on seat_pmp_id = pmp_id
        WHERE seat_order_id = '._esc($order_id);


    if(!$order=ShopDB::query_one_row($orderqry)){
      echo 'error: cant load orderdata';
      return FALSE;
    }

    if(!$res=ShopDB::query($seatqry)){
      echo 'error: cant load ticket data';
      return FALSE;
    }

    while($data=shopDB::fetch_assoc($res)){
  		if($data['category_numbering']=='none'){
  			$data['seat_nr']='0';
  			$data['seat_row_nr']='0';
  		}else if($data['category_numbering']=='rows'){
  			$data['seat_nr']='0';
  		}else if($data['category_numbering']=='seat'){
  			$data['seat_row_nr']='0';
  		}
  		//compute  barcode
  		$data['barcode_text']= sprintf("%08d%s", $data['seat_id'], $data['seat_code']);
      //save the data for the bill
      $key = "({$data['category_id']},{$data['discount_id']})";

      if(!isset($order['bill'][$key])){
        $order['bill'][$key]=array(
          'event_name'=>$data['event_name'],
          'event_date'=>$data['event_date'],
          'ort_name'=>$data['ort_name'],
          'ort_city'=>$data['ort_city'],
  				'qty'=>1,
  				'category_name'=>$data['category_name'],
  				'seat_price'=>$data['seat_price'],
  				'discount_name'=>$data['discount_name']
        );
      }else{
        $order['bill'][$key]['qty']++;
      }
      $seats[] = $data;
    }
    //calculating the sub-total
    foreach(array_keys($order['bill']) as $key){
      $order['bill'][$key]['total']= $order['bill'][$key]['seat_price'] * $order['bill'][$key]['qty'];
    }
    $order['order_subtotal'] = $order['order_total_price'] - $order['order_fee'];


    $hand=Handling::load($order['order_handling_id']);
  	$order['user_country_name']= gui_smarty::getCountry($order['user_country']);

   	$paper_size=$_SHOP->pdf_paper_size;
   	$paper_orientation=$_SHOP->pdf_paper_orientation;

    $te  = new TemplateEngine();
    $pdf = new html2pdf(($paper_orientation=="portrait")?'P':'L', $paper_size, $_SHOP->lang);

   	if(!$bill_template){
  		$bill_template=$hand->handling_pdf_template;
  	}
    $first_page = true;
  	if($bill_template and ($subj & 2)){
  		//loading the template
  		if($tpl =& $te->getTemplate($bill_template)){
  			$first_page=FALSE;
  			//applying the template
  			$tpl->write($pdf, $order);
  		}else{
  			echo "<div class=err>".no_template." : $bill_template </div>";
  			return FALSE;
  		}
//        echo $bill_template,":";
//        Print_r($tpl);

  	}
//    PRINT_r($seats);
    foreach($seats as $seat) {
  		if($hand->handling_pdf_ticket_template){
        $tpl_id=$hand->handling_pdf_ticket_template;
  		}else if($seat['category_template']){
        $tpl_id=$seat['category_template'];
      }else if($seat['event_template']){
        $tpl_id=$seat['event_template'];
      }else{
  		  $tpl_id=false;
  		}

      if($tpl_id and ($subj & 1)){
  			//load the template
  			if(!$tpl =& $te->getTemplate($tpl_id)){
  				user_error(no_template.": name: {$tpl_id} cat: {$seat['category_id']}, event: {$seat['event_id']}");
  				return FALSE;
  			}
//        echo $tpl_id,":";
//        Print_r($tpl);
  			$first_page=FALSE;

  			//print the ticket
  			$tpl->write($pdf,array_merge($seat,$order), false);
  		}
    }
    
    if(true and !$first_page){
  //        $pdf->output($order_file_name, 'P');

      //composing filename without extension
      $order_file_name = "order_".$order_id.'.pdf';
        //producing the output
      if($mode=='file'){
        $pdf->output($_SHOP->ticket_dir.DS.$order_file_name, 'F');
      }else if($mode=='stream'){
        if($print){
          $pdf->output($order_file_name, 'P');
        }else{
          $pdf->output($order_file_name, 'I');
        }
      }else if($mode=='data'){
        $pdf_data=$pdf->output($order_file_name, 'S');
      }
      return $pdf_data;
    }
  }
}
?>