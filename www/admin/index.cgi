#!/usr/bin/perl

print "Content-type: text/html\n\n";
open(INFILE,"index.htm");
print $_ while <INFILE>;
close INFILE;