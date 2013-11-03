#!/usr/bin/perl

##########################
### INCLUDES AND STUFF ###
##########################
use CGI qw/:param/;
require "templates.pl";
require "tools.pl";
print "Content-type: text/html\n\n";
use DBI;

######################
### DATA RETRIEVAL ###
######################
&connect_to_db;
#$ary=&do_sql("FILL THIS IN");

###################
### HTML OUTPUT ###
###################
&print_top("Past polls","Polls","polls.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;
&contenttable1_start;

##### POLLS ### by dumbass
$id=int(&lastid())-1;
print "Past polls: \n<br><br>\n";
for (;$id>=0;$id--){
  &get_info($id);
  if ($question){
  }
}

&contenttable1_end;
&maincontent_end;
&wholepage_end;
&footer;
