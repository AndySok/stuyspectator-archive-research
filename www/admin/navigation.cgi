#!/usr/bin/perl
print "Content-type: text/html\n\n";

%fullsportnames=("b_basketball","Boys' Basketball",
		 "bowling","Bowling",
		 "b_soccer","Boys' Soccer",
		 "fencing","Fencing",
		 "b_swimming","Boys' Swimming",
		 "b_xcountry","Boys' Cross Country",
		 "b_track","Boys' Indoor Track",
		 "b_gymnastics","Boys' Gymnastics",
		 "wrestling","Wrestling",
		 "football","Football",
	      		 "g_basketball","Girls' Basketball",
		 "g_swimming","Girls' Swimming",
		 "g_volleyball","Girls' Volleyball",
		 "g_xcountry","Girls' Cross Country",
		 "g_track","Girls' Indoor Track",
		 "g_gymnastics","Girls' Gymnastics",
		 "baseball","Baseball",
		 "b_handball","Boys' Handball",
		 "b_outtrack","Boys' Outdoor Track",
		 "b_tennis","Boys' Tennis",
		 "b_volleyball","Boys' Volleyball",
		 "golf","Golf",
		 "g_handball","Girls' Handball",
		 "g_outtrack","Girls' Outdoor Track",
		 "g_soccer","Girls' Soccer",
		 "softball","Softball",
		 "g_tennis","Girls' Tennis");

print<<Start_and_End;

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../include/style.css"
</head>

<body bgcolor="#FFFFFF">

<img src="/images/BackendLogo.jpg" align="center">
<table>
<tr>
<td>
<p class="content">Additions:<br>
&nbsp&nbsp&nbsp&nbsp<a class="content" href="#" onClick="javascript:window.open('add_article.htm',
'displayWindow','width=760,height=540,scrollbars=yes,resizable=yes');">Add an article</a>
<br>

&nbsp&nbsp&nbsp&nbsp<a class="content" href="#" onClick="javascript:window.open('add_gamesched.htm',
'displayWindow','width=760,height=540,scrollbars=yes');">Add a game schedule</a>

<br>

&nbsp&nbsp&nbsp&nbsp<a class="content" href="#" onClick="javascript:window.open('../photouploader/index.cgi',
'displayWindow','width=760,height=540,scrollbars=yes');">Add photos</a>
&nbsp&nbsp&nbsp&nbsp<a class="content" href="#" onClick="javascript:window.open('http://www.stuyspectator.com/serve_image.pl?gallery=1',
'displayWindow','width=760,height=540,scrollbars=yes');">Access photos</a>

</p>




<td>
<p class="content">Display:


<form action="list.cgi" target="mainFrame">
<input type="hidden" name="db" value="articles">
<select name="section">
<option selected value="news">News</option>
<option selected value="oped">Oped</option>
<option selected value="ae">A&E</option>
<option selected value="sports">Sports</option>
<option selected value ="features">Features</option>
</select><br><input type="submit"></form>


<form action="list.cgi" target="mainFrame">
<input type="hidden" name="db" value="gamesched">
<select name="section">

Start_and_End

foreach $key (keys(%fullsportnames)){
print qq|<option value="$key">$fullsportnames{$key}</option>|;

}

print<<Start_and_End;

</select><input type="submit">
<br>
</form>

</td>



<td>
<p class="content">Administrative:
</p>
</td>

</tr>
</table>




<a class="content" href="#" onClick="parent.location='admin_layout.htm'">Keselman Layout Manager</a>

</body>
</html>

Start_and_End
