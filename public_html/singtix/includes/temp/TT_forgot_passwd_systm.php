<?php 
/*this is a generated code. do not edit!
produced C
*/

class TT_forgot_passwd_systm {
  var $object_id;
  var $engine;
  var $langs = array("en");
  
  function TT_forgot_passwd_systm(){}

    function build(&$mail,&$data,$lang="en"){
    if($lang=="en"){
      $mail->setSubject("Your New Password");
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHtml("
<p >Dear ".$data["user_firstname"]." ".$data["user_lastname"].",</p>

<p >Your new password is: <b >".$data["new_password"]."</b></p>

");
      $mail->setText("
Dear ".$data["user_firstname"]." ".$data["user_lastname"].",

Your new password is: ".$data["new_password"]."

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