#!/usr/bin/perl

use DBI;

# script for updating crap
# crappy stuff by kevin \a"dun dun dun dunn!!!" \a teoh

# predefined subroutines by viclickdick
require "tools.pl";
&connect_to_db;
# some shiet to do

%formdata = ();
&readData(*data);
&parseData(*data,*formdata);
$q="where id=" . $formdata{"id"};

# retrieve info from form
  @tomod={"author","headline","content","summary","section","type_article","header_img","pic_author","pic_caption","date","pic_file","priority","issue"};
  foreach $crap (@tomod){
    if($crap ne "issue" && $crap ne "priority"){  $formdata{$crap} = $dbh->quote($formdata{$crap}) }
    $rows = $dbh->do("update articles set $crap=".$formdata{$crap}." $q"); 
  }

$dbh->disconnect;
print<<HTML;
Content-type: text/html

$rows affected.

HTML

















