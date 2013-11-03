#!/usr/bin/perl

use DBI;
print "Content-type: text/html\n\n";
# script for updating crap
# crappy stuff by kevin \a"dun dun dun dunn!!!" \a teoh

# predefined subroutines by viclickdick
require "tools.pl";
&connect_to_db;
# some shiet to do
# 
%formdata = ();
&readData(*data);
&parseData(*data,*formdata);

$hometeam=$dbh->quote($formdata{"hometeam"});
$awayteam=$dbh->quote($formdata{"awayteam"});
$date=$dbh->quote($formdata{"date"});
$homescore=$dbh->quote($formdata{"homescore"});
$awayscore=$dbh->quote($formdata{"awayscore"});
$type=$dbh->quote($formdata{"type"});
$summary_link=$dbh->quote($formdata{"summary_link"});
$place=$dbh->quote($formdata{"place"});
$time=$dbh->quote($formdata{"time"});
$id=$formdata{"id"};



$rows = $dbh->do(qq|update gamesched set hometeam=$hometeam where id=$id|); 
$rows .= $dbh->do(qq|update gamesched set awayteam=$awayteam where id=$id|);
$rows .= $dbh->do(qq|update gamesched set date=$date where id=$id|);
$rows .= $dbh->do(qq|update gamesched set homescore=$homescore where id=$id|);
$rows .= $dbh->do(qq|update gamesched set awayscore=$awayscore where id=$id|);
$rows .= $dbh->do(qq|update gamesched set type=$type where id=$id|);
$rows .= $dbh->do(qq|update gamesched set summary_link=$summary_link where id=$id|);
$rows .= $dbh->do(qq|update gamesched set place=$place where id=$id|);
$rows .= $dbh->do(qq|update gamesched set time=$time where id=$id|);



$dbh->disconnect;
print "Done!";





