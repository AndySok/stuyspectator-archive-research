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
$sport=param(section);

###############################
### GLOBAL VAR DECLARATIONS ###
###############################
@b_fallsports=("bowling","b_basketball","b_soccer","fencing","b_swimming","b_xcountry","b_track","b_gymnastics","wrestling","football");
@g_fallsports=("g_basketball","g_swimming","g_volleyball","g_xcountry","g_track","g_gymnastics");
@b_springsports=("baseball","b_handball","b_outtrack","b_tennis","b_volleyball","golf");
@g_springsports=("g_handball","g_outtrack","g_soccer","softball","g_tennis");

@b_fullfall=("Bowling","Boys' Basketball","Boys' Soccer","Fencing","Boys' Swimming","Boys' Cross Country","Boys' Indoor Track","Boys' Gymnastics","Wrestling","Football");
@g_fullfall=("Girls' Basketball","Girls' Swimming","Girls' Volleyball","Girls' Cross Country","Girls' Indoor Track","Girls' Gymnastics");
@b_fullspring=("Baseball","Boys' Handball","Boys' Outdoor Track","Boys' Tennis","Boys' Volleyball","Golf");
@g_fullspring=("Girls' Handball","Girls' Outdoor Track","Girls' Soccer","Softball","Girls' Tennis");
%fullsportnames=("b_basketball","Boys' Basketball",
		 "bowling","Bowling",
		 "b_soccer","Boys' Soccer",
		 "fencing","Fencing",
		 "b_swimming","Boys' Swimming",
		 "b_xcountry","Boys' Cross Country",
		 "b_track","Boys' Indoor Track",
		 "b_gymnastics","Boys' Gymnastics",
		 "wrestling","Wrestling",
		 "football","Football",
		 "Football","Football", # backwards compatibility hack
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
		 "g_tennis","Girls' Tennis");

################################
### SCRIPT KIDDIE PROTECTION ###
################################
if(!&inlist($sport,@b_fallsports) &&
   !&inlist($sport,@g_fallsports) &&
   !&inlist($sport,@b_springsports) &&
   !&inlist($sport,@g_springsports) && $sport ne "fall" && $sport ne "spring")
{
    $sport="fall";
}


if($sport eq "fall" || $sport eq "spring"){
######################
### DATA RETRIEVAL ###
######################
&connect_to_db;
$ary=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"sports\" and priority>=0  order by priority desc, date desc limit 5");

###################
### HTML OUTPUT ###
###################
&print_top("Sports","Sports","sports.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;


&col2_start(270);


if($sport eq "fall"){

print<<Start_and_End;
   <table width="270" border="0" cellspacing="0" cellpadding="0" class="content">
       <tr> 
	   <td width="270" bgcolor="$headercolor" colspan="2"> 
	       <div align="center"><font color="white"><b>Fall Sports</b></font></div>
	   </td>
      </tr>
	  <tr>
	     <td width="50%">
Start_and_End

    for($i=0; $i<scalar(@b_fallsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$b_fallsports[$i]">$b_fullfall[$i]</a></li>|;
    }

print qq|</li></td><td width="50%" valign="top">|;

    for($i=0; $i<scalar(@g_fallsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$g_fallsports[$i]">$g_fullfall[$i]</a></li>|;
    }

print qq|</td><tr><td colspan="2" valign="bottom"><center><a class="content" href="sports.cgi?section=spring">Spring Sports</a></center></td></tr></table>|;
}

elsif($sport eq "spring"){
print<<Start_and_End;
   <table width="270" border="0" cellspacing="0" cellpadding="0" class="content">
       <tr> 
	   <td width="270" bgcolor="$headercolor" colspan="2"> 
	       <div align="center"><font color="white"><b>Spring Sports</b></font></div>
	   </td>
      </tr>
	  <tr>
	     <td width="50%">
Start_and_End
    for($i=0; $i<scalar(@b_springsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$b_springsports[$i]">$b_fullspring[$i]</a></li>|;
    }

print qq|</li></td><td width="50%" valign="top">|;

    for($i=0; $i<scalar(@g_springsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$g_springsports[$i]">$g_fullspring[$i]</a></li>|;
    }

print qq|</td><tr><td colspan="2" valign="bottom"><center><a class="content" href="sports.cgi?section=fall">Fall Sports</a></center></td></tr></table>|;

}

print "<hr>";
&generic_article(270,$ary,3);
print "<hr>";
&generic_article(270,$ary,4);
&col2_end;

&col1_start(350);
&special_article(350,145,$ary,0);
print "<hr>";
&generic_article(350,$ary,1);
print "<hr>";
&generic_article(350,$ary,2);
&col1_end;


&maincontent_end;
&wholepage_end;
&footer;


}

else{
######################
### DATA RETRIEVAL ###
######################
&connect_to_db;
$scores=&do_sql("select hometeam,homescore,awayteam,awayscore,type,date_format(date,\"%b %e\") from gamesched where type=\"$sport\" order by date desc limit 10");
$ary=&do_sql("select headline,author,date,content,summary,pic_file,id from articles where section=\"sports\" and type=\"$sport\" order by date desc,priority limit 2");

###################
### HTML OUTPUT ###
###################
&print_top("Sports","Sports","sports.cgi",$fullsportnames{$sport},"sports.cgi?section=$sport");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;
&contenttable2_start;

&col2_start(270);

if(&inlist($sport,@b_fallsports) || &inlist($sport,@g_fallsports)){

print<<Start_and_End;
   <table width="270" border="1" cellspacing="0" cellpadding="0" class="content">
       <tr> 
	   <td width="270" bgcolor="$headercolor" colspan="2"> 
	       <div align="center"><font color="white"><b>Fall Sports</b></font></div>
	   </td>
      </tr>
	  <tr>
	     <td width="50%">
Start_and_End

    for($i=0; $i<scalar(@b_fallsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$b_fallsports[$i]">$b_fullfall[$i]</a></li>|;
    }

print qq|</li></td><td width="50%" valign="top">|;

    for($i=0; $i<scalar(@g_fallsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$g_fallsports[$i]">$g_fullfall[$i]</a></li>|;
    }

print qq|</td><tr><td colspan="2" valign="bottom"><center><a class="content" href="sports.cgi?section=spring">Spring Sports</a></center></td></tr></table>|;
}

elsif(&inlist($sport,@b_springsports) || &inlist($sport,@g_springsports)){
print<<Start_and_End;
   <table width="270" border="1" cellspacing="0" cellpadding="0" class="content">
       <tr> 
	   <td width="270" bgcolor="$headercolor" colspan="2"> 
	       <div align="center"><font color="white"><b>Spring Sports</b></font></div>
	   </td>
      </tr>
	  <tr>
	     <td width="50%">
Start_and_End
    for($i=0; $i<scalar(@b_springsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$b_springsports[$i]">$b_fullspring[$i]</a></li>|;
    }

print qq|</li></td><td width="50%" valign="top">|;

    for($i=0; $i<scalar(@g_springsports); $i++){
	print qq|<li><a class="content" href="sports.cgi?section=$g_springsports[$i]">$g_fullspring[$i]</a></li>|;
    }

print qq|</td><tr><td colspan="2" valign="bottom"><center><a class="content" href="sports.cgi?section=fall">Fall Sports</a></center></td></tr></table>|;

}

&special_article(270,130,$ary,1);
&col2_end;

&col1_start(350);
&special_article(350,145,$ary,0);
print "<hr>";
print<<Start_and_End;
		   <table width="350" border="1" cellspacing="0" cellpadding="0" class="content">
		    <tr> 
		     <td width="350" bgcolor="#0066CC" colspan="5"> 
		      <div align="center"><font color="white"><b>Game Schedule</b></font></div>
                     </td>
		     </tr>
			 <tr><td><center>Date</center></td><td><center>Home</center></td><td><center>Score</center><td><center>Away</center></td><td><center>Score</td></tr>

Start_and_End

    for($i=0; $i<scalar(@{$scores}); $i++){
	$awayteam = $scores->[$i][2];
	$awayteam=~s/\|/,\ /g;
	$awayscore = $scores->[$i][3];
	$awayscore=~s/\|/,\ /g;
	$homescore=$scores->[$i][1];
	if($homescore eq ""){ $homescore="-"; }
	if($awayscore eq ""){ $awayscore="-"; }
	print qq|<tr><td>$scores->[$i][5]</td><td>$scores->[$i][0]</td><td>$homescore</td><td>$awayteam</td><td>$awayscore</td></tr>|;
	print qq|</td></tr>|;
    }
print qq|</table>|;
&col1_end;





&maincontent_end;


&wholepage_end;
&footer;

}








