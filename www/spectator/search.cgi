#! /usr/bin/perl -w

use DBI;
use Time::Local;

# script to search thru database
# written by Peiran Guo for Spectator Online; 12/16/01;  orig file: /home/peiran/search/search.cgi.commented
# note: maybe we should change our blobs to texts and make a FULLTEXT column for our db's

# ?searchstr=asd
# advanced:  ?searchstr=asd+lkj&author=guo&from=10%2F23%2F84&to=today&type_art=ae_articles
require "tools.pl";
require "templates.pl";

&connect_to_db;

#@pairs = split(/&/, "searchstr=stuy");
@pairs = split(/&/, $ENV{"QUERY_STRING"});
#@pairs = split(/&/, "type_art=articles&searchstr=asdf&author=&from=10%2F23%2F84&to=3+days+ago&submit=Find+my+article%21");
foreach $pair (@pairs){
    ($key, $value) = split(/=/, $pair);
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $queries{$key} = ($value);
}

$start=($queries{'page'}+1)*10-9;
$start=1 if ($queries{'page'} !~ /./);

print "Content-type: text/html\n\n";
&print_top("Search","Search","advsearch.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;
&contenttable1_start;

print<<"HTML";
\n<table width="630" cellpadding="0" border="0" cellspacing="0" height="14">
HTML

#&done("The Database is down or the programmer is stupid") unless $dbh;
#&done("Enter something in type.") unless $queries{'type_art'};
#$queries{'type_art'} = 'articles'  unless $queries{'type_art'};

sub done{
	my($msg) = $_[0];
	print qq|<p class="content"><font size="3"><b>$msg</b></font></p>|;
	print "</tr></td></table><br><br><center>\n";
	&advsearchbox;
	print qq|</center><br><br>|;
	&contenttable1_end;
	&maincontent_end;
	&wholepage_end;
	&footer;
	exit(0);
}

%tv = ("second" =>1,
       "minute" =>60,
       "hour" => 3600,
       "day" =>86400,
       "month" =>2592000,
#1 month = 30 days ALWAYS (use "days" if you don't like it)
       "year" => 31536000,
       "week" => 604800);

@timenow = localtime(time);
sub to_time{
    my($mytime) = $_[0];
    if($mytime=~ /today/){
	return timelocal(0,0,0,$timenow[3], $timenow[4], $timenow[5]);
    }
    if($mytime=~ /\+ago$/){
	my($stime) = timelocal(0,0,0,$timenow[3], $timenow[4], $timenow[5]);
	$mytime =~ /^(.*)\+ago$/;
	my($str) = $1;
	foreach $pair (split(/\+and\+/, $str)){
	    $pair =~ /^(\d*)\+(\w*?)s?$/;
	    $stime -= $1* $tv{$2};
	}
	return $stime;
    }
    my(@stime) = (0,0,0,1,0,70);
    my(@strs) = split(/\+/, $mytime);
    my(@nums) = split(/\D/, $strs[0]);
    $stime[4] = $nums[0] -1;  #month
    $stime[3] = $nums[1];     #day
    $stime[5] = $nums[2];     #year
    if($strs[1]){
	@nums = split(/\D/, $strs[1]);
	$stime[2] = $nums[0]; #hour
	$stime[1] = $nums[1]; #min
	$stime[0] = $nums[2]; #sec
    }
    return timelocal(@stime);
}
#$sql = "select id,author,headline,DATE_FORMAT(date,'%M %D %Y') from $queries{'type_art'} where";
$sql = "select id,author,headline,DATE_FORMAT(date,'%M %D %Y'),summary from articles where";
$sqlwhere = "";

if($queries{'from'}){	
    $ftime = &to_time($queries{'from'});
    $sqlwhere .= " and UNIX_TIMESTAMP(date) > $ftime";
    if($queries{'to'}){
	$ttime = &to_time($queries{'to'});
	$sqlwhere .= " and UNIX_TIMESTAMP(date) < $ttime" 
	    if $queries{'to'} ne "now" && $queries{'to'} ne "today";
    }
}

if($queries{'author'} and $queries{'author'} ne "author"){
    $queries{'author'}=&unwebify($queries{'author'});
    $sqlwhere .= " and author like ";
    $queries{'author'} =~ s/([^+]*)/%\1%/g;
    $sqlwhere .= $dbh->quote($queries{'author'});
}

if($queries{'searchstr'}){
    #my $contentstr;
    my $word;
    $queries{'searchstr'}=&unwebify($queries{'searchstr'});
    foreach $bareword (split(/\+/, $queries{'searchstr'})){
	$equals = 0;
	$sqlwhere .= " and (content like ";  #word
	$word = lc($bareword);
	$equals = 1 if $word eq $bareword;
	$word =~ s/([^+]*)/%\1%/g;
	$sqlwhere .= $dbh->quote($word);
	
	$sqlwhere .= " or content like ";  #acronym
	$word = uc($bareword);
	$equals = 1 if $word eq $bareword;
	$word =~ s/([^+]*)/%\1%/g;
	$sqlwhere .= $dbh->quote($word);
	
	$sqlwhere .= " or content like ";  #proper name
	$word = ucfirst lc($bareword);
	$equals = 1 if $word eq $bareword;
	$word =~ s/([^+]*)/%\1%/g;
	$sqlwhere .= $dbh->quote($word);
	
	unless($equals){
	    $sqlwhere .= " or content like ";  #something else
	    $bareword =~ s/([^+]*)/%\1%/g;
	    $sqlwhere .= $dbh->quote($bareword);
	}
	$sqlwhere .= ")";
    }
}

#$sqlwhere =~ s/^ or/ and\(/;
#$sqlwhere .= ")";
#$sqlwhere .= $sqlwhere;

if($sqlwhere eq ""){
    &done("<tr><td><p class=\"content\"><font size=\"3\"><b>Please enter a search string.<br>");
}

$sqlwhere =~ s/^ (and|or)//;
$sql .= $sqlwhere;                #where
$sql .= " order by id";           #order

if($queries{'page'} =~ /(\d+)/){  #limit
    $queries{'page'} = $1;
    $_ = $1*10;
    $sql .= " limit $_,10";
}
else{
    $sql .= " limit 10";
}

#print "\n\n\n\n\n\n<!-- $sql --> ";
#print "<!-- $ENV{'QUERY_STRING'} --> \n\n\n\n\n\n\n";

print<<"HTML";
<tr><td width="100%" height="100%" colspan=3>\n
HTML

$sth = $dbh->prepare($sql);
&done("DB prepare prob: $sth->errstr\n") unless ($sth);
$sth->execute() or
  &done("DB execute prob: $sth->errstr\n");

&done("Sorry, no matches were found. Please try again.\n") if ($sth->rows < 1);

#$_ = $sth->rows;
#print "nums: $_<br>";
#print "<p>Results:<br><br></p>";

while (@data = $sth->fetchrow_array()) {
    for(0..3){
	$data[$_] =~ s/<br>/ /g;
    }
  print<< "HTML";
<a class="headline" href="display.cgi?id=$data[0]">$start. $data[2]</a>
<p class="content">$data[1]<br>$data[3]</p>
<p class="content">$data[4]</p>
<a class="content" href="display.cgi?id=$data[0]">Go to article</a><hr>
HTML
    $start++;
}
print "<br><br>\n";
print "\n</td></tr><tr><td width=\"33%\" height=\"14\">\n";
&printprev();
print "\n</td><td width=\"33%\" height=\"14\">\n";
&printadvanced();
print "\n</td><td width=\"33%\" height=\"14\">\n";
&printnext();
#print "\n</td></tr></table>\n";

&done();

sub printprev{
    if($queries{'page'}){
	my $refq = $ENV{'QUERY_STRING'};
	my $pagenum = $queries{'page'}-1;
	$refq =~ s/page=([\w+]*)/page=$pagenum/;
	print<< "HTML";
<a align=left class="content" href="search.cgi?$refq">previous</a>
HTML
}
    else{
	print "<p align=left class=\"content\">previous</p>";
    }
}

sub printadvanced{
    print <<"HTML";
<!--<a class="content" href="advsearch.cgi" align="center">Advanced</a>-->
HTML
}

sub printnext{
    if($sth->rows < 10){
	print "<p align=right class=\"content\">next</p>";
    }
    elsif($queries{'page'} gt -1){
	my $refq = $ENV{'QUERY_STRING'};
	my $pagenum = $queries{'page'}+1;
	$refq =~ s/page=([\w+]*)/page=$pagenum/;
	print<< "HTML";
<a class="content" href="search.cgi?$refq" align="right">next</a>
HTML
}
    else{
	my $refq = $ENV{'QUERY_STRING'};
	$refq .= "&page=1";
	print<<"HTML";
<a class="content" align="right" href="search.cgi?$refq">next</a>
HTML
    }
}
