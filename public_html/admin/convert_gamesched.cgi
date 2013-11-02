#!/usr/bin/perl

use DBI;

require 'tools.pl';


&connect_to_db;

$ids=&do_sql("select id from game_schedules");

for($i=0; $i<scalar(@{$ids}); $i++){
    $id=$ids->[$i][0];

$ary= &do_sql("select home_team, vs_team, date,home_score,vs_score,sport,summary_link,place,time from game_schedules where id=$id");

#    $hometeam     = $dbh->quote($ary->[0][0]);
#    $awayteam     = $dbh->quote($ary->[0][1]);
#    $date         = $dbh->quote($ary->[0][2]);
#    $homescore    = $dbh->quote($ary->[0][3]);
#    $awayscore    = $dbh->quote($ary->[0][4]);
    $type         = $dbh->quote($ary->[0][5]);
#    $summary_link = $dbh->quote($ary->[0][6]);
#    $place        = $dbh ->quote($ary->[0][7]);
#    $time         = $dbh->quote($ary->[0][8]);

    $hometeam=$ary->[0][0];
    $awayteam=$ary->[0][1];
    $date=$ary->[0][2];

#$rows = $dbh->do(qq|insert into gamesched (hometeam,awayteam,date,homescore,awayscore,type,summary_link,place,time) values($hometeam,$awayteam,$date,$homescore,$awayscore,type,$summary_link,$place,$time)|);

    $rows=$dbh->do(qq|update gamesched set type=$type where hometeam="$hometeam" and awayteam="$awayteam" and date="$date"|);

print<<HTML;
Content-type: text/html;

Done!<br>
$rows affected.
HTML

}
