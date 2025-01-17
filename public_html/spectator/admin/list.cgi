#!/usr/bin/perl

use DBI;
use CGI qw/:param/;
require "tools.pl";
print "Content-type: text/html\n\n";

$section=param(section);
$db=param(db);
&connect_to_db;


if($db eq "articles"){
    if($section eq ""){
	$cond = "";
    }
    else{
	$cond = "where section=\"$section\"";
    }
    $ary = &do_sql("select headline,author,date,id,type,priority,issue from articles $cond order by date desc limit 50");
    $rows = (!defined ($ary) ? 0 : scalar(@{$ary}));
    
print<<Start_and_End;
<html><head><title>Article listing: $section</title></head>
<body>
<table border="1" width="100%">
	
<tr> <td>Headline</td> <td><b>Author</td> <td>Date</td> <td>ID</td> <td>Type</td> <td>Priority</td> <td>Issue</td> <td>MODIFY</td> <td>DELETE</td> </tr>
		    
Start_and_End
			
for($i=0; $i<$rows; $i++) {
    print qq|<tr>|;
    for($j=0; $j<=6; $j++) {
	print qq|<td>$ary->[$i][$j]</td>|;	
    } #end $j forloop
    print qq|<td><a href="retrieve_info.cgi?id=$ary->[$i][3]&db=articles">Modify</a></td>|;
    print qq|<td><a href="delete.cgi?id=$ary->[$i][3]&type=articles">Delete</a></td>|;
    print "</tr>";
} #end $i forloop
}



if($db eq "gamesched"){
    if($section eq ""){
	$cond = "";
    }
    else{
	$cond = "where type=\"$section\"";
    }
    $ary = &do_sql("select type,hometeam,awayteam,homescore,awayscore,date,place,time,id,summary_link from gamesched $cond order by date desc limit 50");
    $rows = (!defined ($ary) ? 0 : scalar(@{$ary}));

print<<Start_and_End;
<html><head><title>Article listing: $section</title></head>
<body>
<table border="1" width="100%">

<tr> <td>Type</td> <td>Home</td> <td>Away</td> <td>Home Score</td> <td>Away Score</td> <td>Date</td> <td>Place</td> <td>Time</td> <td>ID</td> <td>MODIFY</td> <td>DELETE</td> </tr>

Start_and_End

for($i=0; $i<$rows; $i++) {
    print qq|<tr>|;
    for($j=0; $j<=8; $j++) {
	print qq|<td>$ary->[$i][$j]</td>|;	
    } #end $j forloop
    print qq|<td><a href="retrieve_info.cgi?id=$ary->[$i][8]&db=gamesched">Modify</a></td>|;
    print qq|<td><a href="delete.cgi?id=$ary->[$i][8]&type=gamesched">Delete</a></td>|;
    print "</tr>";
} #end $i forloop

}
