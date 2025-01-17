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
$ary=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"news\" and priority >= 0 order by priority desc, date desc limit 10");

###################
### HTML OUTPUT ###
###################
&print_top("News","News","news.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;

&col2_start();
&print_with_logo('Further News');
&headline_link($ary,1);
print "<br>";
&headline_link($ary,5);
print "<br>";
&headline_link($ary,6);
print "<br>";
&headline_link($ary,4);
=pod
&generic_article(270,$ary,7);
print "<br>";
&generic_article(270,$ary,8);

=cut

&col2_end;

&col1_start(350);
&print_with_logo('News');
&special_article(100,145,$ary,0);
&generic_article(100,$ary,2);
&generic_article(100,$ary,3);
&col1_end;


&maincontent_end;
&wholepage_end;
&footer;









