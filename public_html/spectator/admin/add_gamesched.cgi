#!/usr/bin/perl

require "tools.pl";
use DBI;

print "Content-type: text/html\n\n";

%dataDict = ();
&readData(*data);
&parseData(*data,*dataDict);

	

&connect_to_db;


$type=$dbh->quote($dataDict{"type"});
$hometeam=$dbh->quote($dataDict{"hometeam"});
$homescore=$dbh->quote($dataDict{"homescore"});
$awayscore=$dbh->quote($dataDict{"awayscore"});
$awayteam=$dbh->quote($dataDict{"awayteam"});
$date=$dbh->quote($dataDict{"date"});
$place=$dbh->quote($dataDict{"place"});
$time=$dbh->quote($dataDict{"time"});



# insert the game schedule.

$rows = $dbh->do (qq|
		  insert into gamesched (type,hometeam,awayteam,date,place,time,homescore,awayscore)
		  values($type,$hometeam,$awayteam,$date,$place,$time,$homescore,$awayscore)|);

$dbh->disconnect();

if($rows){
    print "<b>Entry Successful</b><br>\n";
    print<<Start_and_End;

<table border="1">
<tr> <td>Type</td> <td>$type</td> </tr>
<tr> <td>Home team</td> <td>$hometeam</td> </tr>
<tr> <td>Away team</td> <td>$awayteam</td> </tr>
<tr> <td>Date</td> <td>$date</td> </tr>
<tr> <td>Place</td> <td>$place</td> </tr>
<tr> <td>Time</td> <td>$time</td> </tr>
</table>


Start_and_End
}

else{
    print "<b>Entry was NOT successful!</b><br>Data dump:\n";
        print<<Start_and_End;

<table border="1">
<tr> <td>Type</td> <td>$type</td> </tr>
<tr> <td>Home team</td> <td>$hometeam</td> </tr>
<tr> <td>Away team</td> <td>$awayteam</td> </tr>
<tr> <td>Date</td> <td>$date</td> </tr>
<tr> <td>Place</td> <td>$place</td> </tr>
<tr> <td>Time</td> <td>$time</td> </tr>
</table>


Start_and_End


}

print "<br>Rows affected: $rows\n"
