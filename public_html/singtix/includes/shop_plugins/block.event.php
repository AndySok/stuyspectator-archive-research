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

function smarty_block_event ($params, $content, &$smarty,&$repeat) {
	global $_SHOP;

  if ($repeat) {
    $from='Event';
    $where="where event_status='pub'";		
		
    if($params['order']){
			$params['order']=_esc($params['order'], false);
      $order_by="order by {$params['order']}";
    }
    
    if($params['event_id']){
			$where .= " and event_id="._esc($params['event_id']);
    }

    if($params['ort']){
      $from.=' LEFT JOIN Ort ON ort_id=event_ort_id';
    }

    if($params['place_map']){
      $from.=' LEFT JOIN PlaceMap2 ON pm_event_id=event_id';
    }
  
    if($params['stats']){
      $from.=' left join Event_stat on event_id=es_event_id';
    }

    if($params['cats']){
      $from.=' left join Category on event_id=category_event_id ';
      $from.=' left join Category_stat on cs_category_id=category_id';
    }

    if($params['event_group']){
      $from.=' left join Event_group on Event.event_group_id=Event_group.event_group_id';
      $where .= " and Event_group.event_group_id="._esc($params['event_group']);
    }

    if($params['join_event_group']){
      $from.=' LEFT JOIN Event_group ON Event.event_group_id=Event_group.event_group_id';
    }

    if($params['start_date']){
      $where .= " and event_date>="._esc($params['start_date']);
    }
    if($params['end_date']){
      $where .= " and event_date<="._esc($params['end_date']);
    }

    $limit=($params['limit'])?'limit '._esc($params['limit'],false):'';
    

    if($params['search']){
      $params['search']=_ESC($params['event_search']);
      //$where .= " AND (event_name like '{$params['event_search']}' or event_text like '{$params['event_search']}' or event_short_text like '{$params['event_search']}') ";
      $where .= " AND
      (event_name like '%{$params['search']}%'
      or event_text like '%{$params['search']}%'
      or event_short_text like '%{$params['search']}%'\n";
      if($params['ort']){
        $where .= "or ort_name like '%{$params['search']}%'
                   or ort_city like '%{$params['search']}%'\n";
      }
      $where .= ") ";
    }


    if($params['event_type']){
      $types=explode(",",$params['event_type']);
      $first=true;
      foreach($types as $type){
				$type=shopDB::escape_string($type);
				if($first){
        $par.="'$type'";
	      $first=false;
       }else{
        $par.=",'$type'";
       }
      }
      $where.=" and FIELD(event_type,$par)>0";
    }

    if($params['sub']){
      $where.=" and event_rep LIKE '%sub%'";

      if($params['event_main_id']){
        $where.=" and event_main_id="._esc($params['event_main_id']);
      }
    }

    if($params['main']){
      $where.=" and event_rep LIKE '%main%'";
    }

    if($params['first']){
			$params['first']=(int)$params['first'];
      $limit='limit '.$params['first'];
      if($params['length']){
				$params['length']=(int)$params['length'];
        $limit.=','.$params['length'];
      }
    }else if($params['length']){
			$params['length']=(int)$params['length'];
      $limit='limit 0,'.$params['length'];
    }
  
	if($limit){
		$cfr='SQL_CALC_FOUND_ROWS';
	}
	
	if($params['search']){
		$where .= "AND (event_name LIKE '%"._esc($params['search'],false)."%' 
			OR event_text LIKE '%"._esc($params['search'],false)."%'
			OR event_date LIKE '%"._esc($params['search'],false)."%' ";
		if($params['ort']){
			$where .= "OR ort_name LIKE '%"._esc($params['search'],false)."%' ";
		}
		$where .= ")";
	}
		
    $query="select $cfr * from $from $where $order_by $limit";
    $res=ShopDB::query($query);

	  $part_count=shopDB::num_rows($res);

		if($cfr){
		  $query='SELECT FOUND_ROWS();';
      if($row=ShopDB::query_one_row($query, false)){
			  $tot_count=$row[0];
			}
		}else{
		  $tot_count=$part_count;
		}

    $event=shopDB::fetch_array($res);

  } else {
    $res_a=array_pop($smarty->_SHOP_db_res);

		$res=$res_a[0];
		$tot_count=$res_a[1];
		$part_count=$res_a[2];
		
    $event=shopDB::fetch_array($res);
  }

  $repeat=!empty($event);

  if($event){

		$event['tot_count']=$tot_count;
    $event['part_count']=$part_count;

    $smarty->assign("shop_event",$event);

    $smarty->_SHOP_db_res[]=array($res,$tot_count,$part_count);
  }

  return $content;
}

?>