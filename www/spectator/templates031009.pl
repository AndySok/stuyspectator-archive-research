#!/usr/bin/perl

1;

$nav1color = "\#003388";
$nav2color = "\#0053A8";
$leftbarcolor = "\#0053A8";
$headercolor = "\#AA0000";

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
		 "g_tennis","Girls' Tennis");

sub headtag{
    my($title)=$_[0];
    if($title=~/./){ $title=": $title"; }
    else{ $title=""; }
print<<Start_and_End;
<head>
<title>Stuyvesant Spectator Online$title</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="include/style.css" type="text/css">


</head>

Start_and_End
}

sub banners{
    print<<Start_and_End;
<!-- LOGO AND BANNER -->
            <table width="760" border="0" cellspacing="0" cellpadding="0" height="125" class="menu">
		<a name="top"></a>
                <td align="right" align="center" valign="bottom"><img src="images/newbanner2.jpg"></td>




              </tr>
            </table>
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
                <a class="topnav" href="index.cgi?section=sitemap"><b>Sitemap</b></a>
		</td>
              </tr>
              <tr>
		<td bgcolor="$nav2color" align="left" height="20">
		<b>&nbsp;</b><a class="menu" href="index.cgi">Home</a> 

Start_and_End

    for($i=0;$i<scalar(@list);$i+=2){
	if($list[$i] ne ""){
	print qq|<font class="menu">&gt;</font> <a class="menu" href="$list[$i+1]">$list[$i] </a>|;
    }

    }

    print<<Start_and_End;
                  </td>
		<td bgcolor="$nav2color" align="right" height="20"><font class="menu"><b>$date</b></font></td></span>
              </tr>
            </table>
<!-- END OF TOP NAVIGATION -->


Start_and_End
}


sub print_top{
    my($title)=shift;
    print "<html>";
    &headtag($title);
    print qq|<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">|;
    &banners;
    &navigation(@_);
}

sub leftnavtable{
    print<<Start_and_End;

    <!-- LEFT NAVBAR-->
	<table width="110" border="0" cellspacing="0" cellpadding="5" height="200">
                    <tr>       
                      <td align="left" valign="top" width="110" height="150" bgcolor="$leftbarcolor" class="menu"> 
                        <a class="menu" href="news.cgi"><b>News</b></a><br>
                        <a class="menu" href="oped.cgi"><b>Opinions</b></a><br>
                        <a class="menu" href="ae.cgi"><b>A&amp;E</b></a><br>
                        <a class="menu" href="sports.cgi"><b>Sports</b></a><br>
			<a class="menu" href="archives.cgi"><b>Archives</b></a>
			<br><br>

			</td>
                    </tr>
		    </table>
			<img src="images/leftbottom_curve.gif"><br>
<!-- END LEFT NAVBAR -->

<br>
<!-- SEARCH -->

	   <table width="100%" border="1" cellspacing="0" cellpadding="0" class="mainBody">
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

<!-- END SEARCH-->
<br>
Start_and_End
    &pollbox;
}

sub pollbox{
    my @ary=&get_pollinfo;
    my $id=shift(@ary);
    my $question=$ary[0];
    print<<Start_and_End;
<!-- POLL -->
                  <table width="110" cellspacing="0" cellpadding="0" class="mainBody" border="1">
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
    print<<Start_and_End;
<table width="760" border="0" cellspacing="0" cellpadding="0" height="100%">
                 <tr>

Start_and_End
}

sub leftbar_start{
    print<<Start_and_End;
<td width="110" valign="top" bgcolor="#FFFFFF">

Start_and_End

}

sub leftbar_end{
    print "</td>";
}

sub maincontent_start{
    print qq|<td align="left" valign="top" width="10">|;
    print qq|<img src="images/topleft_curve.gif">|;
    print qq|</td>|;
    print qq|<td align="left" valign="top"  height="100%" width="640">|;
}

sub contenttable1_start{
    print<<Start_and_End;
    <table width="640" border="0" cellspacing="0" cellpadding="5" height="100%" align="left">
	<tr><td valign="top" align="left">
Start_and_End
}

sub contenttable1_end{
    print qq|</td></tr></table>|;
}
sub contenttable2_start{
    print qq|<table width="640" border="0" cellspacing="0" cellpadding="5" height="100%" align="left">|;
}

sub col1_start{
    my($width)=shift;
    print qq|<tr><td align="left" valign="top" width="$width">|;
}

sub col1_end{
    print "</td>";
}

sub col2_start{
    my($width)=shift;
    print qq|<td align="left" valign="top" width="$width">|;
}

sub col2_end{
    print qq|</td></tr>|;
}

sub contenttable2_end{
    print qq|</table>|;
}
sub maincontent_end{
    print qq|</td>|;
}

sub wholepage_end{
    print qq|</tr></td>|;
}

sub footer{
    print<<Start_and_End;

<!-- FOOTER -->

            <table width="760" border="0" cellspacing="0" cellpadding="0" height="40">
              <tr> 
                <td bgcolor="$nav2color" width="760" height="20" align="center">
		<a class="menu" href="index.cgi"><b>Home</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="menu" href="index.cgi?section=talk"><b>Talk To Us</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="menu" href="index.cgi?section=charter"><b>Charter</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="menu" href="index.cgi?section=manual"><b>Manual</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="menu" href="index.cgi?section=about"><b>About Us</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="menu" href="index.cgi?section=sitemap"><b>Sitemap</b></a>
		</td>
              </tr>
              <tr> 
                <td bgcolor="$nav1color" width="760" height="20" align="right">
		<a class="menu" href="#top">Back to top</a>
		</td>
              </tr>
            </table>

<!-- END FOOTER -->
</body>
</html>

Start_and_End

}

sub headline_link{
    my($pointer)=shift;
    my($i)=shift;
    print qq|<a class="headline" style="color: #0000FF" href="display.cgi?id=$pointer->[$i][6]"><font size="-1"><b>$pointer->[$i][0]</b></a></font><br><font class="content"><b>$pointer->[$i][1]</b> <i>$pointer->[$i][2]</i></font>|;
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
    
                       <table width="$width" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><span class="headline"><a href="display.cgi?id=$pointer->[$i][6]" class="headline">$pointer->[$i][0]</a></span><br>
                              <span class="content"><b>$pointer->[$i][1]</b><br>
$pointer->[$i][4]<br>


Start_and_End
    if($pointer->[$i][7] =~ /./){ print qq|<br><font class="content"><font color="black"><b>For More Info:</b> </font></font><br>$pointer->[$i][7]</font>|; }
    print<<Start_and_End;
</span></td>
                          </tr>
                        </table>


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
    
			<table width="$width" border="0" cellspacing="0" cellpadding="3">
                          <tr> <td>

<img src="http://spectator.stuy.edu/photos/$pointer->[$i][5]" align="left" width="$picwidth" border="1">


 <span class="headline"><a href="display.cgi?id=$pointer->[$i][6]" class="headline">$pointer->[$i][0]</a></span><br>
                              <span class="content"><b>$pointer->[$i][1]</b></span><br>
                              <span class="content">
				  $pointer->[$i][4]
				  <br>


Start_and_End
    if($pointer->[$i][7] =~ /./){ print qq|<br><font color="red">For More Info: </font>$pointer->[$i][7]</font>|; }

    print<<Start_and_End;
                              </span> </td>
                          </tr>
                        </table>

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

sub advsearchbox{
print<<"HTML";
<table border="1" width="500" cellspacing="0" cellpadding="1"><tr><td bgcolor="#0066CC">
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
</select><br><br>
<input type="submit" name="submit" value="Search" onclick="dothis();"></input><input type="reset"><br>
</form>
</td></tr></table>
HTML
}
