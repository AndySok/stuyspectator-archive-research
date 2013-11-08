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
$scores=&do_sql("select hometeam,homescore,awayteam,awayscore,type,date_format(date,\"%b %e\") from gamesched where homescore IS NOT NULL order by date desc limit 10");
$scheds=&do_sql("select hometeam,homescore,awayteam,awayscore,type,date_format(date,\"%b %e\") from gamesched where homescore IS NULL and date>CURTIME\(\) order by date desc limit 10");

###################
### HTML OUTPUT ###
###################
&print_top("Scoreboard","Sports","sports.cgi","Scoreboard","scoreboard.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;

&leftbar_end;
&maincontent_start;
&contenttable1_start;

print<<Start_and_End;
		   <table width="90%" border="1" cellspacing="0" cellpadding="0" class="content">
		    <tr> 
		     <td width="90%" bgcolor="#0066CC" colspan="6"> 
		      <div align="center"><b>Recent scores</b></div>
                     </td>
		     </tr>
			 <tr><td><center>Sport</center></td><td><center>Date</center></td><td><center>Home</center></td><td><center>Score</center><td><center>Away</center></td><td><center>Score</td></tr>

Start_and_End

    for($i=0; $i<scalar(@{$scores}); $i++){
	$awayteam = $scores->[$i][2];
	$awayteam=~s/\|/,\ /g;
	$awayscore = $scores->[$i][3];
	$awayscore=~s/\|/,\ /g;
	$homescore=$scores->[$i][1];
	if($homescore eq ""){ $homescore="-"; }
	if($awayscore eq ""){ $awayscore="-"; }
	if($homescore < $awayscore){
	print qq|<tr><td><a href="sports.cgi?section=$scores->[$i][4]" class="content">$fullsportnames{$scores->[$i][4]}</a></td><td>$scores->[$i][5]</td><td>$scores->[$i][0]</td><td>$homescore</td><td bgcolor="#DDDDDD">$awayteam</td><td bgcolor="#DDDDDD">$awayscore</td></tr>\n|;
	print qq|</td></tr>|;
    }
	elsif( $homescore > $awayscore){
	    print qq|<tr><td><a href="sports.cgi?section=$scores->[$i][4]" class="content">$fullsportnames{$scores->[$i][4]}</a></td><td>$scores->[$i][5]</td><td bgcolor="#DDDDDD">$scores->[$i][0]</td><td bgcolor="#DDDDDD">$homescore</td><td>$awayteam</td><td>$awayscore</td></tr>\n|;

	}
    }
print qq|</table>|;


&contenttable1_end;
&maincontent_end;
&wholepage_end;
&footer;









