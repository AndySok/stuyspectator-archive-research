#!/usr/bin/perl

print "Content-type: text/html\n\n";
open(INFILE,"index2.htm");
print $_ while <INFILE>;
close INFILE;
