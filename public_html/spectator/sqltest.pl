#!/usr/bin/perl

use DBI;
use CGI qw(:standard);

print header;
print start_html("HMM");
 $dbh = DBI->connect("DBI:mysql:stuyspec_specold:localhost","stuyspec_sepcold","test");

print $dbh;
print "Working?<br>\n";

print end_html;
