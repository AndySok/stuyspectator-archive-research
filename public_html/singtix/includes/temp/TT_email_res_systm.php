<?php 
/*this is a generated code. do not edit!
produced C
*/

class TT_email_res_systm {
  var $object_id;
  var $engine;
  var $langs = array("en");
  
  function TT_email_res_systm(){}

    function build(&$mail,&$data,$lang="en"){
    if($lang=="en"){
      $mail->setSubject("Confirmation of Tickets | Order No. ".$data["order_id"]."");
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHtml("
<p >Dear ".$data["user_firstname"]." ".$data["user_lastname"].",</p>

<p >This email confirms your ticket order from Stuyvesant High School.</p>

<p >Your purchase number is: <b >".$data["order_id"]."</b></p>

<p >Your tickets are only reserved for a limited time. To purchase the tickets please <a HREF=\"".$data["order_link"]."".$data["order_id"]."\" >click here</a>.</p>

<p >Thank you very much.</p>

<p >".$data["order_date"]."</p>
");
      $mail->setText("
Dear ".$data["user_firstname"]." ".$data["user_lastname"].",

This email confirms your ticket order from Stuyvesant High School.

Your reservation number is: ".$data["order_id"]."

Your tickets are only reserved for a limited time. To purchase the tickets please go to: ".$data["order_link"]."".$data["order_id"]."
Thank you very much.

".$data["order_date"]."

");
    }
      $mail->setFrom(" <>" );
      $mail->setCc("log@demo.mail.com");
      $mail->setBcc("log@demo.mail.com");
      $this->to[]="".$data["user_firstname"]." ".$data["user_lastname"]." <".$data["user_email"].">";
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
  }

}

?>