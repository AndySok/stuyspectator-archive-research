
<html>
<head>
<title>
My Spectator
</title>
</head>
<body>

<?php

require(user.php);
require(session.php);
	
if (isset($_REQUEST['email'])&&isset($_REQUEST['password']))	
{
	$valid_login = session::check_valid($_REQUEST['email'],$_REQUEST['password']);	
	if($valid_login)
	{
	$session = new session();
	$level = $session->get_level();
	switch ($level){
	case $GENERALUSER:
		$user = new generaluser();	
		$user->printinfo();
		break;
	case $STAFF:
		$user = new staff();	
		$user->printinfo();
		break;
	case $EDITOR:
		$user = new editor();	
		$user->printinfo();
		break;
	case $MANAGING:
		$user = new managing();	
		$user->printinfo();
		break;
	case $WEBMASTER:
		$user = new webmaster();	
		$user->printinfo();
		break;
	case default:
		print"Some unexpected error";
		break;
	}
	else
	{
		print "Bad login info please give correct login information or register";
	}
}