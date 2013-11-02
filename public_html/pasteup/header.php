<?php
require_once('core.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php print $title; ?></title>
</head>
<body>

<?php
if ($title != "Login" && $title != "Register") {
	print "<a href='home.php'>Home</a> | <a href='index.php'>Login</a> | <a href='my_account.php'>My account</a> | <a href='pasteup.php'>View Pasteup</a> | <a href='my_messages.php'>My messages</a> <align='right'>Welcome " .$_SESSION['name'] . "</align>";
}
elseif ($title == "Login") {
	print "Login";
}
else {
	print "Register";
}

?> <br /><hr /> 