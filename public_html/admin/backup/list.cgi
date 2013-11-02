#!/usr/bin/perl

use DBI;
use CGI qw/:param/;
require "tools.pl";
print "Content-type: text/html\n\n";

$section=param(section);
$db=param(db);
&connect_to_db;


if($db eq "articles"){
    $ary = &do_sql("select headline,author,date,id,type,priority,issue from articles where section=\"$section\" order by date desc limit 50");
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
    print qq|<td><a href="retrieve_info.cgi?id=$ary->[$i][3]&type=articles">Modify</a></td>|;
    print qq|<td><a href="delete.cgi?id=$ary->[$i][3]&type=articles">Delete</a></td>|;
    print "</tr>";
} #end $i forloop
}



if($db eq "gamesched"){
    $ary = &do_sql("select type,hometeam,awayteam,date,place,time,id,summary_link from articles where section=\"$section\" order by date desc limit 50");
    $rows = (!defined ($ary) ? 0 : scalar(@{$ary}));

print<<Start_and_End;
<html><head><title>Article listing: $section</title></head>
<body>
<table border="1" width="100%">

<tr> <td>Type</td> <td>Home</td> <td>Away</td> <td>Date</td> <td>Place</td> <td>Time</td> <td>ID</td> <td>Summary</td> <td>MODIFY</td> <td>DELETE</td> </tr>

Start_and_End

for($i=0; $i<$rows; $i++) {
    print qq|<tr>|;
    for($j=0; $j<=7; $j++) {
	print qq|<td>$ary->[$i][$j]</td>|;	
    } #end $j forloop
    print qq|<td><a href="retrieve_info.cgi?id=$ary->[$i][3]&type=gamesched">Modify</a></td>|;
    print qq|<td><a href="delete.cgi?id=$ary->[$i][3]&type=gamesched">Delete</a></td>|;
    print "</tr>";
} #end $i forloop

}
