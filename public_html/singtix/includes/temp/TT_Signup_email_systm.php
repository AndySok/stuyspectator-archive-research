<?php 
/*this is a generated code. do not edit!
produced C
*/

class TT_Signup_email_systm {
  var $object_id;
  var $engine;
  var $langs = array("en");
  
  function TT_Signup_email_systm(){}

    function build(&$mail,&$data,$lang="en"){
    if($lang=="en"){
      $mail->setSubject("Confirmation of Registration");
      $mail->setTextCharset("UTF-8");
      $mail->setHtmlCharset("UTF-8");
      $mail->setHeadCharset("UTF-8");
      $mail->setHtml("
<p >Dear ".$data["user_firstname"]." ".$data["user_lastname"].",</p>

<p >Please click on the link below:</p>

<a HREF=\"".$data["link"]."\" >Confirm Registration</a>

<p >Thank you.</p>
 
");
      $mail->setText("
Dear ".$data["user_firstname"]." ".$data["user_lastname"].",

Please copy the following link into your browser:
".$data["link"]."

Thank you.

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