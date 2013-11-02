#!/usr/bin/perl

use DBI;

# script for updating crap
# crappy stuff by john, and not kevin because he can't write code that WORKS

require "tools.pl";
&connect_to_db;
print "Content-type: text/html\n\n";

%formdata = ();
&readData(*data);
&parseData(*data,*formdata);


$author=$dbh->quote($formdata{"author"});
$content=$dbh->quote($formdata{"content"});
$summary=$dbh->quote($formdata{"summary"});
$section=$dbh->quote($formdata{"section"});
$type=$dbh->quote($formdata{"type"});
$pic_file=$dbh->quote($formdata{"pic_file"});
$pic_author=$dbh->quote($formdata{"pic_author"});
$pic_caption=$dbh->quote($formdata{"pic_caption"});
$date=$dbh->quote($formdata{"date"});
$priority=$formdata{"priority"};
$issue=$formdata{"issue"};
$id=$formdata{"id"};


$rows = $dbh->do(qq|update articles set author=$author where id=$id|); 
#$rows .= $dbh->do(qq|update articles set headline=$headline where id=$id|); 
$rows .= $dbh->do(qq|update articles set content=$content where id=$id|); 
$rows .= $dbh->do(qq|update articles set summary=$summary where id=$id|); 
$rows .= $dbh->do(qq|update articles set section=$section where id=$id|); 
$rows .= $dbh->do(qq|update articles set type=$type where id=$id|); 
$rows .= $dbh->do(qq|update articles set pic_file=$pic_file where id=$id|); 
$rows .= $dbh->do(qq|update articles set pic_author=$pic_author where id=$id|); 
$rows .= $dbh->do(qq|update articles set pic_caption=$pic_caption where id=$id|); 
$rows .= $dbh->do(qq|update articles set date=$date where id=$id|); 

$rows .= $dbh->do(qq|update articles set priority=$priority where id=$id|); 
$rows .= $dbh->do(qq|update articles set issue=$issue where id=$id|); 


$dbh->disconnect;
print<<HTML;
Content-type: text/html

updated.
$content<br>$summary<br>$author

HTML

















