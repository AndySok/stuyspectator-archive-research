<?php

    //Bad Behavior
    include_once('/mail/bad-behavior/bad-behavior-phplist.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<meta name="Powered-By" content="phplist version <?php echo VERSION?>" />

    <?php
    //Bad Behavior
    if (function_exists('bb2_insert_head')) {
      bb2_insert_head();
    }
    ?>