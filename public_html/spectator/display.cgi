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


##############################
### GLOBAL VAR DECLARATION ###
##############################
%sections=("b_basketball","Boys' Basketball",
	   "bowling","Bowling",
	   "b_soccer","Boys' Soccer",
	   "fencing","Fencing",
	   "b_swimming","Boys' Swimming",
	   "b_xcountry","Boys' Cross Country",
	   "b_track","Boys' Indoor Track",
	   "b_gymnastics","Boys' Gymnastics",
	   "wrestling","Wrestling",
	   "football","Football",
	   "g_basketball","Girls' Basketball",
	   "g_swimming","Girls' Swimming",
	   "g_volleyball","Girls' Volleyball",
	   "g_xcountry","Girls' Cross Country",
	   "g_track","Girls' Indoor Track",
	   "g_gymnastics","Girls' Gymnastics",
	   "baseball","Baseball",
	   "b_handball","Boys' Handball",
	   "b_outtrack","Boys' Outdoor Track",
	   "b_tennis","Boys' Tennis",
	   "b_volleyball","Boys' Volleyball",
	   "golf","Golf",
	   "g_handball","Girls' Handball",
	   "g_outtrack","Girls' Outdoor Track",
	   "g_soccer","Girls' Soccer",
	   "softball","Softball",
	   "g_tennis","Girls' Tennis",
	   "su","Inside the SU",
	   "diary","Diary of a Mad Senior"
	   );

############################
### USER INPUT RETRIEVAL ###
############################
$id=param(id);

################################
### SCRIPT KIDDIE PROTECTION ###
################################
$id=int($id);
if($id<0){ $id=0; }

%navshow=("oped","Opinions","news","News","sports","Sports","ae","Arts & Entertainment");
######################
### DATA RETRIEVAL ###
######################
&connect_to_db;
$ary=&do_sql("select headline,author,date_format(date,\"%M %D, %Y\"),content,pic_file,pic_caption,pic_author,extra,section,type from articles where id=$id");
$show_in_nav=ucfirst($navshow{$ary->[0][8]});
$type=$ary->[0][9];

###################
### HTML OUTPUT ###
###################

&print_top("$ary->[0][0]","$show_in_nav","$ary->[0][8].cgi",$sections{$type},"$ary->[0][8].cgi?section=$type");



&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;
&contenttable1_start;
&print_with_logo("$ary->[0][0]");
print<<Start_and_End;

<p class="content"><b>$ary->[0][2]</b><br>
<p class="author"><b>$ary->[0][1]</b><br>


Start_and_End

if($ary->[0][4] =~ /./){
print<<Start_and_End;
	<table width="550" cellpadding="5" cellspacing="5"><tr><td>
		<table align="left" width="145">
		<tr><td>
			<img border="0" src="http://www.stuyspectator.com/spectator/photos/$ary->[0][4]" align="left">
		</td></tr>
		<tr><td>
			<p class="content">$ary->[0][5]<br><i>$ary->[0][6]</i></p><hr>
		</td></tr></table>
		    <font size="-1">$ary->[0][3]</font>
	</td></tr></table>

Start_and_End
}
else
{
print<<Start_and_End;
<table width="550" cellpadding="5" cellspacing="5"><tr><td>
		    <font size="-1">$ary->[0][3]</font>
	</td></tr></table>

Start_and_End
}


#    print qq|</td></tr></table>|;
#Start_and_End

&contenttable1_end;
&maincontent_end;
&footer;
