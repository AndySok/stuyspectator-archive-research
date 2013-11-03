<?php 
/*this is a generated code. do not edit!
produced C
*/

class TT_Tickets_Attached_email {
  var $object_id;
  var $engine;
  var $langs = array("en");
  
  function TT_Tickets_Attached_email(){}

    function build(&$mail,&$data,$lang="en"){
    if($lang=="en"){
      $mail->setSubject("Your Tickets (Order No. ".$data["order_id"].")");
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHtml("
<p >Dear ".$data["user_firstname"]." ".$data["user_lastname"].",</p>

<p >Your tickets are attached to this email. </p>

<p >You will need a PDF reader to view and print your tickets.  If you do not have a PDF reader installed, <a HREF=\"http://www.foxitsoftware.com/pdf/reader/\" >click here</a> to download Foxit Reader.</p>

<p ><i >If you have questions or problems please email victor@stuyspectator.com.</i></p>
");
      $mail->setText(" 
Dear ".$data["user_firstname"]." ".$data["user_lastname"].",

Your tickets are attached to this email.  

You will need a PDF reader to view and print your tickets. If you do not have a PDF reader installed, visit http://www.foxitsoftware.com/pdf/reader/ to download Foxit Reader.

If you have any problems, please email victor@stuyspectator.com.

");
    }
      $mail->setFrom(" <>" );
      $mail->setBcc("demo@demotickets.com");
      $this->to[]="".$data["user_firstname"]." ".$data["user_lastname"]." <".$data["user_email"].">";
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHeader("2","1");
      $mail->addAttachment( new Attachment( Order::print_order($data["order_id"],'', 'data', FALSE, 3), "order_".$data["order_id"].".pdf", 'application/pdf', new Base64Encoding()));
      $order=Order::load($data["order_id"]);
      if ($order) {
        $order->set_shipment_status('send');
      }
  }

}

?>