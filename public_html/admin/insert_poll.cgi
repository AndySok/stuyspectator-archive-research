#!/usr/bin/perl

use DBI;
require 'tools.pl';
&connect_to_db;
$question=$dbh->quote("How do you feel about the Physics Regents policy?");
$results=$dbh->quote("0|0|0|0");
$answers=$dbh->quote("Glad they changed the grade|Upset that they changed the grade|Do not care|Was not affected");
$rows=$dbh->do(qq|insert into poll (question,results,answers) values($question,$results,$answers)|);


&disconnect;
