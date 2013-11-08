<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Stuyvesant Spectator</title>

	<style type="text/css">
		body {
			margin:0;
			padding:0;
			text-align: center;
			font: 62.5%/1.4 'Lucida Grande', Verdana, sans-serif;
			background-color:#FFF;
		}
		
		#wrapper {	
			width:860px;
			margin: 0 auto;
			
			text-align: left;
		}
		
		#header {
			height:25px;
			line-height:25px;
			width:860px;
			font-size:140%;
			color:#FFF;
			background-color:#284265;
			margin: 0 auto;
			text-align: left;
		}
		
		#header .title {
			padding-left:20px;
		}
		
		#header .account {
			float:right;
			padding-right:30px;
		}
		
		#header .account a, 
		#header .account a:active, 
		#header .account a:visited {
			color:#FFF;
			text-decoration:none;
		}
		
		#header .account a:hover {
			text-decoration:underline;
		}
		
		#nav {
			height:25px;
			font-size:130%;
			line-height:25px;
			background-color:#90221F;
		}
		#nav ul {
			list-style:none;
			margin:0;
			padding:0;
			padding-left:20px;
		}
		#nav ul li {
			float:left;
			padding-left:10px;
		}
		
		#nav a, #nav a:active, #nav a:visited {
			color:#FFF;
			text-decoration:none;
		}
		
		#nav a:hover {
			color:#162135;
			text-decoration:none;
			background-color:#7E9AAF;
		}
		
		#main_content {
			width:820px;
			margin: 0 auto;
			padding-bottom:5px;
			font-size:120%;
		}
		
		#footer {
			font: 9px "Trebuchet MS",Trebuchet,Arial,Verdana,Sans-serif;
			text-transform:uppercase;
			letter-spacing:3px;
			line-height:25px;
			color:#000;
			height:25px;
			padding-top:50px;
			clear:both;
			position:relative;
			bottom:0px;
			width:100%;
		}
	</style>
</head>
<body>
<div id="header">
	<span class="title">Stuyvesant Spectator: Desk </span>
	<div class="account">
	<?php
	if ($this->spectator->check_level(1))
	{
		print "<a href='".base_url()."index.php/account/logout'>Logout</a>"; 	
	}
	?>
	</div>
</div>
<div id="wrapper">

	<div id="nav">
		<ul>
		<?php
	
	if ($this->spectator->check_level(3))
	{
	print "<li><a href='".base_url()."index.php/pasteup'>Pasteup</a></li>";
	}
	if ($this->spectator->check_level(1))
	{
		print "<li><a href='".base_url()."index.php/assignment'>Assignments</a></li>";
		print "<li><a href='".base_url()."index.php/upload'>Uploads</a></li>";
	}
	if ($this->spectator->check_level(4))
	{
		print "<li><a href='".base_url()."index.php/pasteup/manual'>Manual</a></li>";
		print "<li><a href='".base_url()."index.php/account/list_all'>Accounts</a></li>";
		print "<li><a href='".base_url()."index.php/pasteup/issue_manager'>Issue Manager</a></li>";
	}
	
	
	#print "<li><a href='".base_url()."index.php/blog/manage'>Blogs</a></li>";
	
	?>
			<?php #print $sub_nav; ?>
		</ul>
	</div>

	<div id="main_content"> <br />
