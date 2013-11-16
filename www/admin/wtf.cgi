#! /usr/bin/perl

use DBI;
use Time::Local;
#use CGI qw/:param/;

# script for displaying crap
# Vote Peiran Guo for President!!
#written fro Spectator Online 11/28/01

%tv = ("second" =>1,
       "minute" =>60,
       "hour" => 3600,
       "day" =>86400,
       "month" =>2592000,
#1 month = 30 days ALWAYS (use "days" if you don't like it)
       "year" => 31536000,
       "week" => 604800);

@timenow = localtime(time);

       

# predefined subroutines by viclickdick
require "tools.pl";
sub to_time{
    my($mytime) = $_[0];
    if($mytime=~ /today/){
	return timelocal(0,0,0,$timenow[3], $timenow[4], $timenow[5]);
    }
    if($mytime=~ /\+ago/){
	my($stime) = timelocal(0,0,0,$timenow[3], $timenow[4], $timenow[5]);
	$mytime =~ /^(.*)\+ago$/;
	my($str) = $1;
	foreach $pair (split(/\+and\+/, $str)){
	    #$pair == "2+weeks"
	    $pair =~ /^(\d*)\+(\w*?)s?$/;
	    $stime -= $1* $tv{$2};
	}
	return $stime;
    }
    # $mytime = "mm/dd/yy hh:mm:ss"
    my(@stime) = (0,0,0,1,0,70);
    my(@strs) = split(/\s/, $mytime);
    my(@nums) = split(/\W/, $strs[0]);
    # $strs[0] had better be "mm/dd/yy"
    $stime[4] = $nums[0] -1; #month
    $stime[3] = $nums[1]; #day
    $stime[5] = $nums[2]; #year
    if($strs[1]){
	@nums = split(/\W/, $strs[1]);
	# $strs[1] had better be "hh:mm:ss"
	$stime[2] = $nums[0]; #hour
	$stime[1] = $nums[1]; #min
	$stime[0] = $nums[2]; #sec
    }
    return timelocal(@stime);
}


# some shiet to do

#&connect_to_db; # connect to vic's umbrella

#&Connect_To_Shadow;
#&Connect_To_Live;
&connect_to_db;

@pairs = split(/&/, $ENV{"QUERY_STRING"});
#@pairs = split(/&/, "id=1&type_art=articles");  #type_art=news_articles
#@pairs = split(/&/, "type_art=articles&id=0&author=author&from=12+weeks+ago&to=12%2F3%2F01&submit=submit");
foreach $pair (@pairs){
    ($key, $value) = split(/=/, $pair);
    
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $queries{$key} = ($value);

}
	       
#print $queries{'id'}, "\n\n";

print<<"HEAD";  #---------Scroll to "End of HTML" ----------
Content-type: text/html\n\n

<html><head><title>stuff - Spec online</title></head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0">
<!--TOP--><!-- Top table: logo -->
<table width="760" bgcolor="#4444BB">
<tr><td><table width="100">
<tr height="30" align="left">
<td width="100" valign="center" bgcolor="gray"><font color="white">Logo Here<br>Logo Here<br>Logo Here</font></td>
</tr></table></td></tr>
</table><!-- End Top logo table-->
<!--Top table: navigation -->
<table width="760" bgcolor="#000000">
<tr><td><font color="white" size="2" face="arial,sans-serif">
<b>Home > Form (We desparately need input)</b></font></td>
<td align="right"><font color="white" size="2" face="arial,sans-serif">
<b>November 24, 2001</b>
</font></td></tr></table>
<!-- End top navigation table -->
<!-- END TOP--><!--BODY--><!--Table frame-->
<table width="760" height="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF"><tr>
<!-- Navigation --><td width="130" bgcolor="gray" valign="top">
<table width="130" height="100%"><tr><td bgcolor="#CCCCCC"><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>News (mouseover)</b></td></tr>
<tr><td><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>Opinions</b></td></tr><tr><td><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>Arts & Entertainment</b></td></tr>
<tr><td><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>Sports</b></td></tr><tr><td><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>Calendar</b></td></tr><tr><td><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>Weather</b></td></tr><tr><td><font size="1" face="arial,sans-serif" color="#FFFFFF"><b>Job Listings</b></td></tr>
</table></td><!-- End navigation-->
<!-- fluff -->
<td width="5">&nbsp;</td>
<!--form-->
<td width="620" valign="top">
HEAD
# ------------------End of HTML -----------------------

&done("The Database is down or the programmer is stupid") unless $dbh;
&done("Enter something in type.") unless $queries{'type_art'};

sub done{
	my($msg) = $_[0];
	print $msg;
	print<<"END";
</td></tr>
<!-- end form-->
<tr><td colspan="3" height="42"> <center>bottom (for navigation or something) e.g. <a href="www.stuyspectator.org">home</a></center>
</td></tr></table>
<!--END BODY--></body></html>
END
	$sth->finish;
	$dbh->disconnect;
	exit;
}

if($queries{'id'} && ($queries{'id'} ne '0')){
    #print "<!-- DSFLJSDLFKJ ID ADASDASD-->\n\n";
	$sth = $dbh->prepare(
		"select author,headline,content,summary,section,type,header_img,pic_author,pic_caption,date,pic_file,priority,issue from $queries{'type_art'} where id=$queries{'id'}");
	&done("DB prepare prob: $sth->errstr\n") unless ($sth);
	$sth->execute() or
		&done("DB execute prob: $sth->errstr\n");
	&done("no entry\n") if ($sth->rows < 1);
	&done("DB prob: multiple entries\n") if ($sth->rows > 1);
	#everything fine...
	@data = $sth->fetchrow_array();	
	print<<"HTML";
<!-- KEVIN EDIT THIS, REPLACE script123 WITH vicisgay OR WHATEVER ITS CALLED-->
<form METHOD="GET" ACTION="script123.cgi">
<br>author:<input type="text" name="author" value="$data[0]"></input>
<br>headline:<input type="text" name="headline" value="$data[1]"></input>
<br>content:<input type="text" name="content" value="$data[2]"></input>
<br>summary:<input type="text" name="summary" value="$data[3]"></input>
<br>section:<input type="text" name="section" value="$data[4]"></input>
<br>type:<input type="text" name="type_article" value="$data[5]"></input>
<br>header img:<input type="text" name="header_img" value="$data[6]"></input>
<br>pic_author:<input type="text" name="pic_author" value="$data[7]"></input>
<br>caption:<input type="text" name="pic_caption" value="$data[8]"></input>
<br>date:<input type="text" name="date" value="$data[9]"></input>
<br>pic_file:<input type="text" name="pic_file" value="$data[10]"></input>
<br>priority:<input type="text" name="priority" value="$data[11]"></input>
<br><input type="submit" name="submit" value="update"></input><br>
</form>
HTML
	#$sth->finish;
	&done();
}

# $queries{'id'} not filled

# MySQL uses Local time
if($queries{'from'}){

	
    $ftime = &to_time($queries{'from'});
#    $sql = "select author,headline,content,summary,section,type,header_img,pic_author,pic_caption,date,pic_file,priority,issue from $queries{'type_art'} where ";
    $sql = "select id,author,headline,DATE_FORMAT(date,'%W %M %D %Y') from $queries{'type_art'} where ";

    $sql .= "UNIX_TIMESTAMP(date) > $ftime";
    if($queries{'to'}){

	$ttime = &to_time($queries{'to'});
	$sql .= " and UNIX_TIMESTAMP(date) < $ttime" 
	    if $queries{'to'} ne "now" && $queries{'to'} ne "today";
    }
#    print $sql , "\n\n";
    $sth = $dbh->prepare($sql);
    &done("DB prepare prob: $sth->errstr\n") unless ($sth);
    $sth->execute() or
	&done("DB execute prob: $sth->errstr\n");
    &done("no entry\n") if ($sth->rows < 1);

    #print "<form method="get" action="pei4prez2k.cgi">\n";
    while (@data = $sth->fetchrow_array()) {
	print<< "HTML";
<a href="pei4prez.cgi?id=$data[0]&type_art=$queries{'type_art'}">$data[2] by $data[1], $data[3]</a><br>
HTML
    }
    &done();
}

&done("not yet implemented; pay me<br>\n");
