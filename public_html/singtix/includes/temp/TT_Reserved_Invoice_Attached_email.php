<?php 
/*this is a generated code. do not edit!
produced C
*/

class TT_Reserved_Invoice_Attached_email {
  var $object_id;
  var $engine;
  var $langs = array("en");
  
  function TT_Reserved_Invoice_Attached_email(){}

    function build(&$mail,&$data,$lang="en"){
    if($lang=="en"){
      $mail->setSubject("Invoice for Order No. ".$data["order_id"]."");
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHtml("
<p >Dear ".$data["user_firstname"]." ".$data["user_lastname"].",</p>

<p >This email confirms your reservation.</p>
<p >Your purchase number is: <b >".$data["order_id"]."</b></p>

<p >The invoice is attached. You have 10 days to pay the invoice. Once we receive your payment, we will send your e-tickets by email.</p>

<p >Thank you for your support!</p>

<p >Order Date:".$data["order_date"]."
Order ID: ".$data["order_id"]."</p>

<p >To contact us, email <a HREF=\"mailto:victor@stuyspectator.com\" >the SU</a>.</p>
");
      $mail->setText("Dear ".$data["user_firstname"]." ".$data["user_lastname"].",

This email confirms your reservation.

Your order number is: ".$data["order_id"]."

The invoice is attached. You have 10 days to pay the invoice.

Once we receive your payment, we will send your e-tickets by email.

Thank you for your support!

Order Date:".$data["order_date"]."
Order ID: ".$data["order_id"]."

To contact us email us at victor@stuyspectator.com.

");
    }
      $mail->setFrom(" <>" );
      $this->to[]="".$data["user_firstname"]." ".$data["user_lastname"]." <".$data["user_email"].">";
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->addAttachment( new Attachment( Order::print_order($data["order_id"],'', 'data', FALSE, 2), "invoice_".$data["order_id"].".pdf", 'application/pdf', new Base64Encoding()));
  }

}

?>