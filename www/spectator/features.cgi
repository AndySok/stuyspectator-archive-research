#!/usr/bin/perl

##########################
### INCLUDES AND STUFF ###
##########################
use CGI qw/:param/;
#require "templates.pl";
require "templates2.pl";
require "tools.pl";
print "Content-type: text/html\n\n";
use DBI;

######################
### DATA RETRIEVAL ###
######################
&connect_to_db;
$ary=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"features\" and type!=\"creative\" and priority>=0 order by priority desc, date desc limit 8");

$creative=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"ae\" and type=\"creative\" and priority>=0 order by priority desc, date desc limit 2");

###################
### HTML OUTPUT ###
###################
&print_top("Features","Features","features.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;

&col2_start(270);
&print_with_logo('Features Headlines');

&headline_link($ary,0);
print "<br />";


&headline_link($ary,1);
print "<br />";

&headline_link($ary,1);
print "<br />";

&headline_link($ary,5);
print "<br />";


#&generic_article(270,$ary,4);

&col2_end;
&col1_start();
&print_with_logo('Features');
&special_article(350,145,$ary,0);

&generic_article(350,$ary,2);

&generic_article(350,$ary,3);
&col1_end;

&maincontent_end;
&wholepage_end;
&footer;
