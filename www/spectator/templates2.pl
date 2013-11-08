#!/usr/bin/perl

1;

$nav1color = "\#FFFFFF";
$nav2color = "\#DF6002";
$leftbarcolor = "\#FFFFFF";
#$headercolor = "\#AA0000";
$headercolor = "\#DF6002";
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
		 "Football","Football", # backwards compatibility hack
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
		 "g_ultimate","Girls' Ultimate",
		 "b_ultimate","Boys' Ultimate",
		 "g_tennis","Girls' Tennis");

sub headtag{
    my($title)=$_[0];
    if($title=~/./){ $title=": $title"; }
    else{ $title=""; }
print<<Start_and_End;
<head>
<title>Stuyvesant Spectator Online$title</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="demo_final.css" type="text/css">


</head>

Start_and_End
}

sub banners{
    print<<Start_and_End;
<!-- LOGO AND BANNER -->
    <div id="holder">
    <div id="header">
    <a href="http://www.stuyspectator.com"><img src="../photos/specheaderbetter.jpg" width="1025" height="151"border="0" />
    </a>
    </div>
<!-- END OF LOGO AND BANNER -->

Start_and_End

}

sub navigation{
    my(@list)=@_;
    my($i,$date);
# $list[0]=name
# $list[1]=link
# e.g. $list[0] is "Sports", $list[1] is "sports.cgi", etc.
    open(INFILE,"date +\"%A, %B %d\"|");
    $date=<INFILE>;
    close(INFILE);
    print<<Start_and_End;
<!-- TOP NAVIGATION -->
            <table width="760" border="0" cellspacing="0" cellpadding="0" height="40">
              <tr> 
                <td bgcolor="$nav1color" width="760" height="20" align="center" colspan="2">
		<a class="topnav" href="index.cgi"><b>Home</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="topnav" href="index.cgi?section=talk"><b>Talk To Us</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="topnav" href="index.cgi?section=charter"><b>Charter</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="topnav" href="index.cgi?section=manual"><b>Manual</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="topnav" href="index.cgi?section=about"><b>About Us</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="topnav" href="index.cgi?section=sitemap"><b>Sitemap</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="topnav" href="gallery/" TARGET="_blank"><b>Gallery</b></a>
		</td>
              </tr>
              <tr>
		<td bgcolor="$nav2color" align="left" height="20">
		<b>&nbsp;</b><a class="history" href="index.cgi">Home</a> 

Start_and_End

    for($i=0;$i<scalar(@list);$i+=2){
	if($list[$i] ne ""){
	print qq|<font class="history">&gt;</font> <a class="history" href="$list[$i+1]">$list[$i] </a>|;
    }

    }

    print<<Start_and_End;
                  </td>
		<td bgcolor="$nav2color" align="right" height="20"><font class="history"><b>$date</b></font></td></span>
              </tr>
            </table>
<!-- END OF TOP NAVIGATION -->


Start_and_End
}


sub print_top{
    my($title)=shift;
    print "<html>";
    &headtag($title);
    print qq|<body>|;
    &banners;
#    &navigation(@_);
}

sub leftnavtable{
    print<<Start_and_End;

    <!-- LEFT NAVBAR-->
	<div id="nav">
	  <ul>
	  <li><a href = "http://www.stuyspectator.com/spectator/indextmp.cgi">Home</a></li>
	  <li><a href = "http://www.stuyspectator.com/spectator/news.cgi">News</a></li>
	  <li><a href="http://www.stuyspectator.com/spectator/oped.cgi">Opinions</a></li>
	  <li><a href = "http://www.stuyspectator.com/spectator/sports.cgi">Sports</a></li>
	  <li><a href="http://www.stuyspectator.com/spectator/features.cgi">Features</a></li>
	  <li><a href = "http://www.stuyspectator.com/spectator/ae.cgi">A&amp;E</a></li>
	  <li><a href="http://www.stuyspectator.com/spectator/photos.cgi">Photos</a></li>
	  <li><a href = "http://www.stuyspectator.com/spectator/blogs.cgi">Blogs</a></li>
	  <li><a href="http://www.stuyspectator.com/spectator/archives.cgi">Archives</a></li>
	  <li><a href = "http://www.stuyspectator.com/spectator/about.cgi">About</a></li>
	  <li><a href="http://www.stuyspectator.com/spectator/contact.cgi">Contact</a></li>
	  </ul>
	  
	  <!-- close of nav --> </div>
	<div id="undernav">
	</div>
	
<!-- END LEFT NAVBAR -->
	

<!-- SEARCH

	   <table width="100%" border="0.5" cellspacing="0" cellpadding="0" class="mainBody">
	    <tr> 
	     <td width="100%" bgcolor="$headercolor"> 
	      <div align="center"><font color="white"><b>Search</b></font></div>
                </td>
	     </tr>
	     <tr><td bgcolor="white">
		<table width="100%" bgcolor="white"><tr><td align="left">
		<form style="margin-top: 0px; margin-bottom: 0px;" action="search.cgi">
		<input type="text" size="6" maxlength="40" name="searchstr">
		</td><td><input type="submit" value="GO" leftmargin="0" class="navbutton"></td></tr></table>
		</form>
		<a class="menu2" href="advsearch.cgi">Advanced Search</a>
		</td></tr></table>

<!-- END SEARCH
#<br>-->
Start_and_End
 #   &pollbox;
}

sub pollbox{
    my @ary=&get_pollinfo;
    my $id=shift(@ary);
    my $question=$ary[0];
    print<<Start_and_End;
<!-- POLL -->
                  <table width="110" cellspacing="0" cellpadding="0" class="mainBody" border="0.5">
                    <tr> 
			<td width="110" bgcolor="$headercolor"> 
                        <div align="center" class="mainBody"><font color="white"><b>Poll</b></font></div>
                      </td>
                    </tr>
                    <tr> 
                      <td align="left" valign="top" width="97" bgcolor="white"> 
                        <div align="center"><span class="mainBody">$question</span><br>
                        </div>
                        <form method="get" action="poll.cgi" target="_blank">
			    <input type="hidden" name="poll" value="$id">
				<div align="center">
Start_and_End

    for($i=1; $i<scalar(@ary); $i++){
	print qq|<span class="mainBody"><input type="radio" name="choice" value="$i">$ary[$i]</span><br>|;
    }

    print<<Start_and_End;
                            <input type="submit" name="Submit" value="Vote">
                          </div>
                        </form>
                      </td>
                    </tr>
                  </table>
<!-- END POLL -->

Start_and_End
}

sub wholepage_start{
=pod
  print<<Start_and_End;
<table width="760" border="0" cellspacing="0" cellpadding="0" height="100%">
                 <tr>

Start_and_End
=cut
}

sub leftbar_start{
=pod
    print<<Start_and_End;
<td width="110" valign="top" bgcolor="#FFFFFF">

Start_and_End
=cut
}

sub leftbar_end{
   # print "</td>";
}

sub maincontent_start{
    <!--maincontent_start-->
}

sub contenttable1_start{
    print;
}

sub contenttable1_end{
    print;
}
sub contenttable2_start{
    print;
}
sub col1_start{
    print qq{ <div id = \"content\">};
}

sub col1_end{
    print qq{</div>};
}

sub col2_start{
    print "<div id=\"more\">";

}

sub col2_end{
    print "</div>";
}

sub contenttable2_end{
    print;
}
sub maincontent_end{
    <!-- main content end -->
}

sub wholepage_end{
    print;
}

sub footer{
    print<<Start_and_End;

<!-- FOOTER -->
    </div>
    <div id= "footer">
    <p>&copy;2007 Stuyvesant  Spectator - &quot;The Pulse of the Student Body&quot;. All rights reserved. This Website is Best Viewed Using <a href="http://www.mozilla.com">FireFox</a>. </p>
    
<!-- END FOOTER --></div>

</body>
</html>

Start_and_End

}

sub headline_link{
    my($pointer)=shift;
    my($i)=shift;
    print qq|<a href="display.cgi?id=$pointer->[$i][6]"><b>$pointer->[$i][0]</b></a><br><b>$pointer->[$i][1]</b> <i>$pointer->[$i][2]</i>|;
}

sub generic_article{
    my($width)=shift;
    my($pointer)=shift;
    my($i)=shift;
    if($pointer->[$i][8] eq "0")
    {
	print qq|<font class="content"><font color="red"><b>ONLINE ONLY</b></font></font>|;
    }
    print<<Start_and_End;
    
    <div class="substory">
                            <h3>$pointer->[$i][0]</h3>
                              <span class="author">$pointer->[$i][1]</span><br>
$pointer->[$i][4]<a href="display.cgi?id=$pointer->[$i][6]">Read More</a>

Start_and_End
    if($pointer->[$i][7] =~ /./){ print qq|<br><font class="content"><font color="black"><b>For More Info:</b> </font></font><br>$pointer->[$i][7]</font>|; }
    print<<Start_and_End;

    </div>


Start_and_End
}


sub special_article{
    my($width)=shift;
    my($picwidth)=shift;
    my($diff)=$width-$picwidth;
    my($pointer)=shift;
    my($i)=shift;
    if($pointer->[$i][5] !~ /./){ &generic_article($width,$pointer,$i); return 0;}
    print<<Start_and_End;
    <div class="feature">

#	<img src="http://stuyspectator.com/spectator/photos/$pointer->[$i][5]" width="$picwidth">
	<img src="http://stuyspectator.com/spectator/photos/$pointer->[$i][5]" width="150" height"150">


 <h3>$pointer->[$i][0]</h3>
                              <span class="author"><b>$pointer->[$i][1]</b></span><br />
				  $pointer->[$i][4]
				  
				  ..<a href="display.cgi?id=$pointer->[$i][6]">Read</a>
				  Start_and_End
    if($pointer->[$i][7] =~ /./){ print qq|<br><font color="red">For More Info: </font>$pointer->[$i][7]</font>|; }
    print<<Start_and_End;
    
            </div>                  
                          
Start_and_End

			}




sub getscores{
    my($pointer)=shift;
    my($row)=shift;
    my(@teams)=split(/\|/,$pointer->[$row][2]);
    my(@scores)=split(/\|/,$pointer->[$row][3]);
    my($i);
    my($string);
    for($i=0; $i<scalar(@teams); $i++){
	$string.="$teams[$i] $scores[$i]<br>";
    }
    return $string;

}

sub print_with_logo{
    $text = shift;

    print<<Start_and_End;
    
    <p><img src = "/photos/SpecOnlineLogo.jpg" width = "62" height = "31" /><span class="sectitle">$text</span></p>

Start_and_End

}

sub advsearchbox{
print<<"HTML";
<table border="0.5" width="500" cellspacing="0" cellpadding="1"><tr><td bgcolor="#0066CC">
<p class="headline" style="text-decoration:none" align="center"><font color="white" size="2"><b>Advanced Search</b></font></p>
</td></tr><tr><td bgcolor="#FFFFFF">
<form method="get" action="search.cgi" name="asd">
<p class="content"><font size="2">
<input type="hidden" name="from" value="">
<input type="hidden" name="to" value="">
<input type="checkbox" name="bystr" value="yes" checked>
Search for string: <input type="text" name="searchstr" value=""></input><br>
<p class="content"><font size="2">
<input type="checkbox" name="byauth" value="yes" unchecked> 
Search by author: <input type="text" name="author" value=""></input><br>
<p class="content"><font size="2"><input type="checkbox" name="bytime" value="yes" unchecked>Search by time: <br>
From: <select name="fmon">
<option value="1">Jan</option>
<option value="2">Feb</option>
<option value="3">Mar</option>
<option value="4">Apr</option>
<option value="5">May</option>
<option value="6">Jun</option>
<option value="7">Jul</option>
<option value="8">Aug</option>
<option value="9">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
&nbsp
<select name="fday">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
&nbsp
<select name="fyear">
<option value="1999">1999</option>
<option value="2000">2000</option>
<option value="2001">2001</option>
<option value="2002">2002</option>
<option value="2003">2003</option>
</select>
&nbsp to 
<select name="tmon">
<option value="1">Jan</option>
<option value="2">Feb</option>
<option value="3">Mar</option>
<option value="4">Apr</option>
<option value="5">May</option>
<option value="6">Jun</option>
<option value="7">Jul</option>
<option value="8">Aug</option>
<option value="9">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
&nbsp
<select name="tday">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
&nbsp
<select name="tyear">
<option value="1999">1999</option>
<option value="2000">2000</option>
<option value="2001">2001</option>
<option value="2002">2002</option>
<option value="2003">2003</option>
</select><br><br>
<input type="submit" name="submit" value="Search" onclick="dothis();"></input><input type="reset"><br>
</form>
</td></tr></table>
HTML
}
