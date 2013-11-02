<?php
 

$host = 'localhost'; 
$username = 'stuyspec_backend'; 
$password = 'random_pass2'; 
$database = 'stuyspec_main';
/**
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'pasteup'; */

$connection = mysql_pconnect($host, $username, $password); 

mysql_select_db($database, $connection);

?>