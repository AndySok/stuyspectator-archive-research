<?php
$title = "My messages";
require_once('header.php');

check_credentials(3);

print "My messages:<br />";
get_messages($_SESSION['cat']);


require_once('footer.php');
?>