#!/usr/bin/perl

use CGI qw/:param/;
use DBI;
require 'tools.pl';

&connect_to_db;

print "Content-type: text/html\n\n";
    print<<Start_and_End;
    <html><head><title>Stuyvesant Spectator Online: poll</title></head>
    <body bgcolor="white" leftmargin="5" topmargin="5">

Start_and_End

$vote=param(choice);
$vote=int($vote);
$poll=param(poll);

if (!$poll){
    $poll=&lastid();
}


&update_poll($poll,$vote);
&print_results($poll);

&disconnect();

































