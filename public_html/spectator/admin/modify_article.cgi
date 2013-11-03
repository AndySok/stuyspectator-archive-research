#!/usr/bin/perl

# Subroutine for decoding form data

use DBI;

require "tools.pl";

&connect_to_db;

print "Content-type: text/html\n\n";

%dataDict = ();
&readData(*data);
&parseData(*data,*dataDict);


$author=$dbh->quote($dataDict{"author"});

$summary=$dbh->quote($dataDict{"summary"});
$headline=$dbh->quote($dataDict{"headline"});
$sctn=$dbh->quote($dataDict{"sctn"});
$type=$dbh->quote($dataDict{"type"});
$pic_file=$dbh->quote($dataDict{"pic_file"});
$pic_author=$dbh->quote($dataDict{"pic_author"});
$pic_caption=$dbh->quote($dataDict{"pic_caption"});
$date=$dbh->quote($dataDict{"date"});
$priority=$dataDict{"priority"};
$issue=$dataDict{"issue"};
$extra=$dbh->quote($dataDict{"extra"});

$id = $dataDict{"id"};
$section = $dataDict{"section"};
$content=$dbh->quote($dataDict{"content"});
$summary=$dbh->quote($dataDict{"summary"});

print "Updating article $id..<br> $content, $summary<br>$author";

$rows = $dbh->do (qq{ update articles set summary=$summary where id=$id });
$rows = $dbh->do (qq{ update articles set content=$content where id=$id });
$rows = $dbh->do (qq{ update articles set headline=$headline where id=$id });

$rows = $dbh->do (qq{ update articles set section=$sctn where id=$id });
$rows = $dbh->do (qq{ update articles set type=$type where id=$id });
$rows = $dbh->do (qq{ update articles set pic_file=$pic_file where id=$id });
$rows = $dbh->do (qq{ update articles set pic_author=$pic_author where id=$id });
$rows = $dbh->do (qq{ update articles set pic_caption=$pic_caption where id=$id });
$rows = $dbh->do (qq{ update articles set date=$date where id=$id });
$rows = $dbh->do (qq{ update articles set priority=$priority where id=$id });
$rows = $dbh->do (qq{ update articles set issue=$issue where id=$id });
$rows = $dbh->do (qq{ update articles set author=$author where id=$id });
$rows = $dbh->do (qq{ update articles set extra=$extra where id=$id });

print "Done!";

$dbh->disconnect();
