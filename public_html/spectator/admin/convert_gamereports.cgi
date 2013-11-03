#!/usr/bin/perl

use DBI;

require 'tools.pl';


&connect_to_db;

$ids=&do_sql("select id from game_reports");

for($i=0; $i<scalar(@{$ids}); $i++){
    $id=$ids->[$i][0];
    $section=$dbh->quote("sports");
$ary= &do_sql("select title,author,content,sport,date from game_reports where id=$id");
 
    $headline=$dbh->quote($ary->[0][0]);
    $author=$dbh->quote($ary->[0][1]);
    $content=$dbh->quote($ary->[0][2]);
    $type=$dbh->quote($ary->[0][3]);
    $date=$dbh->quote($ary->[0][4]);

$rows = $dbh->do(qq|insert into articles (headline,author,content,summary,section,type,date) values($headline,$author,$content,$content,$section,$type,$date)|);

print<<HTML;
Content-type: text/html;

Done!<br>
$rows affected.
HTML

}
