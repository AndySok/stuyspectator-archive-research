var catData = new Object();
var refreshTimer;
var eventData = new Object();

var loadOrder = function(){
   $("#seat-chart").dialog({
      bgiframe: false,
      autoOpen: false,
      height: 'auto',
      maxHeight: 400,
      width: 'auto',
      modal: true,
      buttons: {'Close': function() {
         $(this).dialog('close');
         }
      }
   });

   $("#order_action").dialog({
      bgiframe: false,
      autoOpen: false,
      height: 'auto',
      width: 'auto',
      modal: true,
     close: function(event, ui) {
      refreshOrder();
    }

   });

   $('#cart_table').jqGrid({
      url:'ajax.php?x=cart',
      datatype: 'json',
      mtype: 'POST',
      postData: {"pos":true,"action":"CartInfo"},
      colNames: ['Expire_in','Event','Count','Tickets','Price','Total'],
      colModel :[
         {name:'Expire_in',  index:'Expire_in',  width:100, sortable:false },
         {name:'Event',      index:'Event',      width:240, sortable:false, resizable: false },
         {name:'Count',      index:'Count',      width: 55, sortable:false, resizable: false, align:'right' },
         {name:'Tickets',    index:'Tickets',    width:190, sortable:false, resizable: false                },
         {name:'Price',      index:'Price',      width: 70, sortable:false, resizable: false, align:'right' },
         {name:'Total',      index:'Total',      width:100, sortable:false, resizable: false, align:'right' }],
      altRows: true,
      height: 116,

      hiddengrid : true,
      hoverrows : false,
      footerrow : false,
      gridComplete:  function(){
      $('#cart_table td').addClass('payment_form');
      var data = $('#cart_table').getGridParam("userData");
         $.each(data.handlings,function(index, domElement){
            $(this.index).html(this.value);
      });
      $('#total_price').html(data.total);
      if (data.can_cancel) {
        $('#cancel').show();
      } else {
        $('#cancel').hide();
      }
      if (data.can_order) {
        $('#checkout').show();
      } else {
        $('#checkout').hide();
      }
      BindEventRemove()
    }
    });
//    refreshOrder();
    updateEvents();
    
    $('#event-from').datepicker({
      minDate:0, changeMonth: true,
      changeYear: true, dateFormat:'yy-mm-dd',
      showButtonPanel: true,
      onSelect: function(dateText, inst) {
         $('#event-from').change();
      }
    });
    $('#event-to').datepicker({
      minDate:0, changeMonth: true,
      changeYear: true, dateFormat:'yy-mm-dd',
      showButtonPanel: true,
      onSelect: function(dateText, inst) {
         $('#event-to').change();
      }
    });
    $('#event-from').change(function(){
       updateEvents();
    });
    $('#event-to').change(function(){
       updateEvents();
    });

   $("#event-id").change(function() {
      var eventId = $(this).val();
      if(eventId > 0){
         ajaxQManager.add({
            type:      "POST",
            url:      "ajax.php?x=cat",
            dataType:   "json",
            data:      {"pos":true,"action":"categories","event_id":eventId},
            success:function(data, status){
               catData = data; //set cat var
               
               //Fill Categories
               $("#cat-select").hide().html("");
               $.each(data.categories,function(){
                  $("#cat-select").append(this.html);
               });
               $("#cat-select").show().change();
               //Check catData for discounts...
               if(catData.enable_discounts){
                  $("#discount-select").html("");
                  $.each(catData.discounts,function(){
                     $("#discount-select").append(this.html);
                  });
                  $("#discount-name").show();
                  $("#discount-select").show();
               }else{
                  $("#discount-name").hide();
                  $("#discount-select").html("<option value='0'></option>"); //hide().
               }
            }   
         });
      }else{
         $("#cat-select").html("<option value='0'></option>");
         $("#discount-name").hide();
         $("#discount-select").html("<option value='0'></option>");//hide().
      }
   });
   
   $("#cat-select").change(function(){
      if($("#event-id").val() > 0 && $("#cat-select").val() > 0 ){
         
         var catId = $("#cat-select").val();
         updateSeatChart();
      }
   });
   
   //Creates a auto refreshing function.
   refreshTimer = setInterval(function(){refreshOrder();}, 120000);
   
   $("input:radio[name='handling_id']").click(function(){
    refreshOrder();
  });
   $('#no_fee').click(function(){
     refreshOrder();
  });

   //Make sure all add ticket fields are added to this so when clearing selection 
   // All fields are reset.
   $('#clear-button').click(function(){
      $("#cat-select").html("<option value='0'></option>");
      $("#discount-select").html("<option value='0'></option>");//hide().
      $("#discount-name").hide();
      $("#seat-qty").hide();
      $("#seat-chart").html("");
      $("#date-from").val('');
      $("#date-to").val('');
      //$("#continue").attr("type","button");
      unBindSeatChart();
      updateEvents();
      return false;
   });
   
   $("#order-form").submit(function(){
     $("#error-message").hide();
      $(this).ajaxSubmit({
         data:{ajax:"yes",action:"addtocart"},
         success: function(html){
        if(html.substring(0,2) == '~~') {
          $("#error-text").html(html.substring(2));
          $("#error-message").show();
          setTimeout(function(){$("#error-message").hide();}, 4000);
        } else {
              refreshOrder(); //Refresh Cart
              refreshCategories(); //Update ticket info (Free tickets etc)
        }
         }
      });
      return false;
   });

   $("#checkout").click(function(){
      var userdata = {ajax:"yes",pos:"yes",action:"PosConfirm"};
    	userdata['handling_id'] = $("input:radio[name='handling_id']:checked").val();
      if($("input:checkbox[name='no_fee']").is(":checked")){
        userdata['no_fee'] = 1;	
      }else{
        userdata['no_fee'] = 0;
      }
      $("#user_data :input").each(function() {
         userdata[$(this).attr("name")] = $(this).val();
      });
     $("#error-message").hide();
     ajaxQManager.add({
        type:      "POST",
        url:      "checkout.php?x=order",
        dataType:   "HTML",
        data:      userdata,
        success:function(html, status){
        if(html.substring(0,2) == '~~') {
          $("#error-text").html(html.substring(2));
          $("#error-message").show();
          setTimeout(function(){$("#error-message").hide();}, 40000);
        } else {
          $("#order_action").html(html);
           $("#order_action").dialog('open');
        }
        }
      });
      return false;
   });

   $("#cancel").click(function(){
     $("#error-message").hide();
     ajaxQManager.add({
        type:      "POST",
        url:      "checkout.php?x=cancel",
        dataType:   "HTML",
        data:      {pos:"yes",action:"PosCancel"},
        success:function(html, status){
        refreshOrder();
        }
      });
      return false;
   });

}

//The refresh orderpage, the ajax manager SHOULD ALLWAYS be used where possible.
var refreshOrder = function(){
    var data = $('#cart_table').getGridParam('postData');
  data['handling_id'] = $("input:radio[name='handling_id']:checked").val();
  if($("input:checkbox[name='no_fee']").is(":checked")){
  	data['no_fee'] = 1;	
  }else{
  	data['no_fee'] = 0;
  }
  
  $('#cart_table').setGridParam('postData', data);

  $('#cart_table').trigger("reloadGrid");
}

//refreshSeatChart
var refreshCategories = function(){
   if($("#event-id").val() > 0 ){
      var eventId = $("#event-id").val();
      
      ajaxQManager.add({
         type:      "POST",
         url:      "ajax.php?x=cat2",
         dataType:   "json",
         data:      {"pos":true,"action":"categories","categories_only":true,"event_id":eventId},
         success:function(data, status){
            if(data.status){
               catData.categories = data.categories; //set cat var
               updateSeatChart();
            }
         }   
      });
   }
}

var updateSeatChart = function(){
   var catId = $("#cat-select").val();
   unBindSeatChart();
   if(catData.categories[catId].numbering){
      $("#seat-qty").hide();
      $("#seat-qty input").val('');
      $("#seat-chart").html(catData.categories[catId].placemap);
      bindSeatChart();
   }else{
      unBindSeatChart();
      $("#seat-chart").html("");
      $("#seat-qty").show();
   }
}
// Update events function will take the dates and compile onto the event var
var updateEvents = function(){
   var dateFrom = $('#event-from').val();
   var dateTo = $('#event-to').val();
   
   ajaxQManager.add({
      type:      "POST",
      url:      "ajax.php?x=event",
      dataType:   "json",
      data:      {pos:true,action:"events",datefrom:dateFrom,dateto:dateTo},
      success:function(data, status){
         if(data.status){
            eventData = data//set event data
            //Fill Categories
            $("#event-id").hide().html("");
            $.each(eventData.events,function(){
               $("#event-id").append(this.html);
            });
            $("#event-id").show().change();
         }
      }   
   });
}
var seatCount = 0;
var bindSeatChart = function(){
   $("#show-seats").show();
   $("#show-seats button").click(function(){
      $("#seat-chart").dialog('open');
   });
   $("#seat-chart > input").click(function(){
      if($(this).attr('checked') == "checked"){
         seatCount++;
      }else{
         if(seatCount>0){
            seatCount--;
         }
      }
      $("#show-seats input").val(seatCount);
   });
}
var unBindSeatChart = function(){
   //$("#seat-chart").dialog('destroy');
   $("#show-seats").hide();
   $("#show-seats button").unbind( "click" );
}

var BindEventRemove = function(){
   $("#remove").submit(function(){
      $(this).ajaxSubmit({
         data:{ajax:"yes",action:"remove"},
         success: function(html){
            refreshOrder(); //Refresh Cart
            refreshCategories(); //Update ticket info (Free tickets etc)
         }
      });
      return false;
   });
}

function formatItem(row) {
   return row[1];
}
function formatResult(row) {
   return row[1].replace(/(<.+?>)/gi, '');
}