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
&connect_to_db;


@sections=("news","oped","ae","sports","features");
%sectionfull=("news","News","oped","Opinions","ae","Arts and Entertainment","sports","Sports","features","Features");

$issue=param(issue);
$date=param(date);
$section=param(section);

if ($section ne "wtc"){
if(!&inlist($section,@sections)){
    $section="all";
}

if($issue eq "" || $issue==0){
    $issue="all";
}
}
if ($section eq "wtc"){
    &print_top("Archives","Archives","archives.cgi","Special 9/11 issue","archives.cgi?section=wtc","$sectionfull{$section}","archives.cgi?section=$section");
    &wholepage_start;
    &leftbar_start;
    &leftnavtable;
    &leftbar_end;
    &maincontent_start;
    &contenttable1_start;
    $ary=&do_sql("select headline,author,id from articles where date=\"2001-10-15\"");
    print qq|<p class="headline">$sectionfull{$section} Articles in the Special 9/11 Magazine Issue:</p>|;
	for($i=0; $i<scalar(@{$ary}); $i++){
	    last if $ary->[$i][3]==15;
	    $ary->[$i][1] =~ s/<br>//g;
	    print qq|<a class="content" href="display.cgi?id=$ary->[$i][2]"><b>$ary->[$i][0]</b> $ary->[$i][1]</a><br>|;
	    }

    &contenttable1_end;
   
}

elsif($issue eq "all" && $section eq "all"){
    &print_top("Archives","Archives","archives.cgi");
    &wholepage_start;
    &leftbar_start;
    &leftnavtable;
    &leftbar_end;
    &maincontent_start;
    &contenttable1_start;
    $ary=&do_sql("select distinct date_format(date,\"%M %D, %Y\"),issue,date from articles where issue>0 order by date desc");
    print qq|<p class="headline">Archives</p>|;
    print qq|<table cellpadding="0" cellspacing="4" border="0">|;
    for($i=0; $i<scalar(@{$ary}); $i++){
	print qq|<tr><td>|;
	print qq|<p class="content"><font size="2">Issue \#$ary->[$i][1]: $ary->[$i][0]</font></p>|;
	print qq|</td><td><p class="content"> \| |;
	foreach $sectionname (@sections){
	    print qq|<a href="archives.cgi?issue=$ary->[$i][1]&date=$ary->[$i][2]&section=$sectionname" class="content"><font size="1"><b>$sectionfull{$sectionname}</b></font></a> \| |;
	}
	print qq|<a href="archives.cgi?issue=$ary->[$i][1]&date=$ary->[$i][2]&section=all" class="content"><font size="1"><b>All sections</b></font></a> \| </td>|;
	print qq|</tr>|;
    }
    print qq|<tr><td><p class="content"><font size="2">All issues</font></p></td><td><p class="content">|;
    foreach $sectionname (@sections){
	print qq| \| <a href="archives.cgi?section=$sectionname" class="content"><font size="1"><b>$sectionfull{$sectionname}</b></font></a>|;
    }
    print qq|<tr><td><a href="archives.cgi?section=wtc" class="content"><big><b>Special 9/11 issue</b></big></a>|;    
    print qq|</td>|;
    print qq|</tr>|;


    print qq|</table>|;
    &contenttable1_end;
}
   
elsif($section eq "all" && $issue ne "all"){
    &print_top("Archives","Archives","archives.cgi","Issue \#$issue","archives.cgi?issue=$issue&date=$date");
    &wholepage_start;
    &leftbar_start;
    &leftnavtable;
    &leftbar_end;
    &maincontent_start;
    &contenttable1_start;
    print qq|<p class="headline">Issue \#$issue</p>|;
    foreach $sectionname (@sections){
  	$ary=&do_sql("select headline,author,id from articles where issue=$issue and date=\"$date\" and section=\"$sectionname\"");
  	print qq|<p class="headline"><font size="2">$sectionfull{$sectionname}</font></p>|;
  	for($i=0; $i<scalar(@{$ary}); $i++){
  	    $ary->[$i][1] =~ s/<br>//g;
  	    print qq|<a class="content" href="display.cgi?id=$ary->[$i][2]"><b>$ary->[$i][0]</b> $ary->[$i][1]</a><br>|;	    
  	}
  	print "<hr>";
      }
    &contenttable1_end;
  }

elsif($section ne "all" & $issue eq "all"){
    &print_top("Archives","Archives","archives.cgi","$sectionfull{$section}","archives.cgi?section=$section");
    &wholepage_start;
    &leftbar_start;
    &leftnavtable;
    &leftbar_end;
    &maincontent_start;
    &contenttable1_start;
    $ary=&do_sql("select headline,author,id,issue,date_format(date,\"%M %D, %Y\") from articles where date=\"2001-10-15\"");
    print qq|<p class="headline">$sectionfull{$section}</p>|;
    for($i=0; $i<scalar(@{$ary}); $i++){
  	last if $ary->[$i][3]==15;
  	$ary->[$i][1] =~ s/<br>//g;
  	print qq|<a class="content" href="display.cgi?id=$ary->[$i][2]">Issue #$ary->[$i][3] ($ary->[$i][4]): <b>$ary->[$i][0]</b> $ary->[$i][1]</a><br>|; 
	}
    &contenttable1_end;
}
elsif($section ne "all" && $issue ne "all"){
    &print_top("Archives","Archives","archives.cgi","Issue \#$issue","archives.cgi?issue=$issue&date=$date","$sectionfull{$section}","archives.cgi?section=$section");
    &wholepage_start;
    &leftbar_start;
    &leftnavtable;
    &leftbar_end;
    &maincontent_start;
    &contenttable1_start;
    $ary=&do_sql("select headline,author,id from articles where issue=$issue and date=\"$date\" and section=\"$section\"");
    print qq|<p class="headline">$sectionfull{$section} articles in issue #$issue</p>|;
	for($i=0; $i<scalar(@{$ary}); $i++){
	    last if $ary->[$i][3]==15;
	    $ary->[$i][1] =~ s/<br>//g;
	    print qq|<a class="content" href="display.cgi?id=$ary->[$i][2]"><b>$ary->[$i][0]</b> $ary->[$i][1]</a><br>|;
	    }
    &contenttable1_end;
}





&maincontent_end;
&wholepage_end;
&footer;



