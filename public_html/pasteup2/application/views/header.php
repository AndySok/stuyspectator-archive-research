<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title> Stuyvesant Spectator Online </title>
<style type="text/css">

body {
	color: #000;
	padding:0;
	margin:0;
	}

#wrapper {
	width: 960px;
	margin: 0 auto;
	background-color:#FFF;
}

#subwrapper {
	width: 960px;
	position:absolute;
	top:130px;
	border-left:1px solid #999;
	border-right:1px solid #999;
}

#banner {
	width:960px;
	background:#ffffff;
	margin-bottom:2px;
	}

a:link {
	background: none; 
	font-family: Courier new; 
	font-size: 12px;
	color: #585858; 
	text-decoration: none;  
	border-bottom: 1px dashed #ccc;
	}

a:visited {
	background: none; 
	font-family: Courier new; 
	font-size: 12px;
	color: #585858; 
	text-decoration: none;  
	border-bottom: 1px dashed #ccc;
	}

a:active {
	background: none; 
	font-family: Courier new; 
	font-size: 12px;
	color: #585858; 
	text-decoration: none;  
	border-bottom: 1px dashed #ccc;
	}

a:hover {
	font-family: Courier New; 
	font-size: 12px;
	color: #cc0000; 
	text-decoration: none;  
	border-bottom: 1px dashed #ccc;
	}
#banner a:link, a:visited, a:active,a:hover {
	text-decoration: none;
	border-bottom:0;
}
strong {
		font-weight: bold;
		color: #cc0000; 
	}
select {
	background:#FFFFFF; 
	font-family: Georgia; 
	color: #000000; 
	font-size: 12pt
	}

#leftcontent {
	width:150px;
	border-right:1px solid #999B9B;
	color: #000000;
	font-family: georgia, serif;
	font-size: 85%;
	line-height: 170%;
    text-align: left;
	}


#centercontent {
	width:800px;
	float:right;
	position:absolute;
	top:0;
	left:190px;
 	color: #000000;
	font-family: georgia, serif;
	font-size: 85%;
	line-height: 170%;
 	text-align: justify;
	}

#centercontent img {
	padding-right: 10px;
	float:left;
	}


p {
	margin:0px 10px 10px 10px;
	font-size: 85%;
	line-height: 170%;
 	text-align: justify;
	}
		
h1 {
	color:#cc0000;
	font-size: 90%;
	font-weight: bold;
	font-family: Georgia;
	text-transform:uppercase;
	background-color: none; 
	border-bottom: 1px solid #cccccc;
    text-align: right;
	margin:0px 10px 10px 10px;
	}
ul {
	margin:0;
	padding-left:10px;
}
ul li {
	list-style-type:none;
	margin-left:0;
}
		
.articletitle {
	margin:10px 10px 10px 10px;
	color: #000;
	font-family: georgia, serif;
	font-weight: bold;
	font-size: 18px;
}

#rightcontent .articletitle {
	font-size: 16px;
	text-align:left;
}

#mainarticle {
	height: 500px; 
	width: 450px;
}

#rightcontent {
	height: 500px;
	position: absolute;
 	top:0;
	width: 260px; 
	left: 500px;
	border-left:1px solid #999;
}

#rightcontent h1 {
	text-align: left;
	margin:0px 10px 10px 10px;
}


.articleauthor {
	margin:-17px 10px 10px 10px;
	color: #999b9b;
	font-family: georgia, serif;
	font-size: 85%;
	}

#footer {
	text-align: center;
	font size: 85%;
	color: #000;
	padding-bottom:20px;
	border-top:1px solid #999;
	}

</style>

</head>

<body>

<div id="wrapper">



<?php $this->load->helper('url'); ?>
<div id="banner">
<?php
	#print "<a href='".base_url()."'>";
	print "<img src='". base_url() ."uploads/banner.jpg' />"; 
	#print "</a>";
?>
</div>
<div id="subwrapper">
<div id="leftcontent">
	
	<h1>frontpage</h1>

	<ul>
	<li><?php print "<a href='".base_url()."'>"; ?> Home</a></li>	
		<li><?php print "<a href='". base_url() . "index.php/home/featured'>Featured</a>" ?></li>
	</ul>

	
	<h1>Browse</h1>
	<ul>
	<li><?php print "<a href='". base_url() . "index.php/home/browse/12'>News</a>" ?></li>	
	<li><?php print "<a href='". base_url() . "index.php/home/browse/9'>Features</a>" ?></li>
	<li><?php print "<a href='". base_url() . "index.php/home/browse/10'>Opinions</a>" ?></li>	
	
	<li><?php print "<a href='". base_url() . "index.php/home/browse/7'>A&E</a>" ?></li>
	
	<li><?php print "<a href='". base_url() . "index.php/home/browse/6'>Sports</a>" ?></li>
	</ul>

	<h1>Web</h1>

	<ul>
		<li><?php print "<a href='". base_url() . "index.php/home/exclusive'>Exclusives</a>" ?></li>
	<li><a href="http://">Photo Galleries</a></li>
	<li><a href="http://">Video</a></li>	
	<li><a href="http://">Podcasts</a></li>
	</ul>

	
	<h1>About</h1>

	<ul>
	<li><a href="http://">History</a></li>	
	<li><?php print "<a href='". base_url() . "index.php/home/masthead'>Masthead</a>" ?></li>
	<li><?php print "<a href='". base_url() . "index.php/home/charter'>Charter</a>" ?></li>
	<li><?php print "<a href='". base_url() . "index.php/home/contact'>Contact</a>" ?></li>
	<li><a href="http://">Advertisements</a></li>
	</ul>


</div>

<div id="centercontent">
<div id="mainarticle">