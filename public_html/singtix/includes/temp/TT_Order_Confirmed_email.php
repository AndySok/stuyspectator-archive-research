<?php 
/*this is a generated code. do not edit!
produced C
*/

class TT_Order_Confirmed_email {
  var $object_id;
  var $engine;
  var $langs = array("en");
  
  function TT_Order_Confirmed_email(){}

    function build(&$mail,&$data,$lang="en"){
    if($lang=="en"){
      $mail->setSubject("Confirmation of Tickets | Order No. ".$data["order_id"]."");
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHtml("

<p >Dear ".$data["user_firstname"]." ".$data["user_lastname"].",</p>

<p >This email confirms your ticket order from Stuyvesant High School. </p>

<p >Your receipt number is: <b >".$data["order_id"]."</b></p>

<p >Thank you for your support!</p>

<p >".$data["order_date"]."</p>

");
      $mail->setText("Dear ".$data["user_firstname"]." ".$data["user_lastname"].",

This email confirms your ticket order from Stuyvesant High School. 

Your receipt number is: ".$data["order_id"]."

Thank you for your support!

".$data["order_date"]."

");
    }
      $mail->setFrom(" <>" );
      $this->to[]="".$data["user_firstname"]." ".$data["user_lastname"]." <".$data["user_email"].">";
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
  }

}

?>