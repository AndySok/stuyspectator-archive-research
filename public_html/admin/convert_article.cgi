#!/usr/bin/perl

use DBI;
use CGI qw/:param/;

require 'tools.pl';

$id=param(id);
$table=param(type);
$table.="_articles";
&connect_to_db;

$ids=&do_sql("select id from $table");

for($i=0; $i<scalar(@{$ids}); $i++){
    $id=$ids->[$i][0];

$ary= &do_sql("select headline,author,content,summary,type,date,pic_link from $table where id=$id");
$ary->[0][6]=~s/http:\/\/www\.stuyspectator\.org\/photos\///i;
$content  = $dbh->quote($ary->[0][2]);
$author   = $dbh->quote($ary->[0][1]);
$summary  = $dbh->quote($ary->[0][3]);
$type     = $dbh->quote($ary->[0][4]);
$headline = $dbh->quote($ary->[0][0]);
$date     = $dbh->quote($ary->[0][5]);
$pic_file = $dbh->quote($ary->[0][6]);
$section =  $dbh->quote($table);
$priority = 0;
$issue    = 0;

$rows = $dbh->do(qq|insert into articles (author,headline,date,content,summary,type,issue,pic_file,priority,section) values($author,$headline,$date,$content,$summary,$type,$issue,$pic_file,$priority,$section)|);

print<<HTML;
Content-type: text/html;

Done!<br>
$rows affected.
HTML

}
