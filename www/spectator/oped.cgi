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

###########################################
### USER INPUT/SCRIPT KIDDIE PROTECTION ###
###########################################
$section=param(section);
if($section ne "diary" && $section ne "su"){ $section = ""; }

if($section eq ""){
######################
### DATA RETRIEVAL ###
######################
&connect_to_db;

$editorial=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"oped\" and type=\"editorial\" and priority>=0 order by priority desc, date desc limit 1");

$letters=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"oped\" and type=\"letter\" and priority>=0 order by priority desc, date desc limit 3");

$opinions=&do_sql("select headline,author,date_format(date,\"%b %e\"),content,summary,pic_file,id from articles where section=\"oped\" and type=\"opinion\" and priority>=0 order by priority desc, date desc limit 3");


###################
### HTML OUTPUT ###
###################
&print_top("Opinions","Opinions","oped.cgi");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;
&contenttable2_start;
&col2_start(270);

print<<Start_and_End;
<table width="270" border="0" cellspacing="0" cellpadding="0" class="content">
		    <tr> 
		     <td width="270" bgcolor="orange" colspan="2"> 
		      <div align="center"><b>Columns</b></div>
                     </td>
		     </tr>
                   </tr>
		   <tr> 
                  <td bgcolor="white" align="center" valign="top" width="137"> 
		      <a href="oped.cgi?section=diary"><img src="images/diary.gif" border="1"></a>
		       </td>
	          <td bgcolor="white" align="center" valign="top" width="137"> 
		      <a href="oped.cgi?section=su"><img src="images/su_60.gif" border="1"></a>
		</td></tr><tr>
	          <td bgcolor="white" align="center" valign="top" width="137"> 
			<p class="content"><a class="content" href="oped.cgi?section=diary"><font size="2"><b>Diary of a Mad Senior</b></font></a></p>
	</td>     <td bgcolor="white" align="center" valign="top" width="137"> 
		<p class="content"><a class="content" href="oped.cgi?section=su"><font size="2"><b>Inside the SU</b></font></a></p>
</td></tr></table>

Start_and_End

print "<br />";

print qq|<font class="content"><font color="red"><b>LETTER</b></font></font><br>|;
&headline_link($letters,2);
print "<br />";

print qq|<font class="content"><font color="red"><b>OPINION</b></font></font><br>|;
&headline_link($opinions,1);
print "<br />";

print qq|<font class="content"><font color="red"><b>OPINION</b></font></font><br>|;
&headline_link($opinions,2);
print "<br />";

print qq|<font class="content"><font color="red"><b>OPINION</b></font></font>|;
&generic_article(270,$opinions,0);

&col2_end;
&col1_start(350);
print qq|<font class="content"><font color="red"><b>EDITORIAL</b></font></font>|;
&generic_article(350,$editorial,0);
print "<hr>";

print qq|<font class="content"><font color="red"><b>LETTER</b></font></font>|;
&generic_article(350,$letters,0);
print "<hr>";
print qq|<font class="content"><font color="red"><b>LETTER</b></font></font>|;
&generic_article(355,$letters,1);
&col1_end;


&contenttable2_end;
&maincontent_end;
&wholepage_end;
&footer;

}

else{
    %sectionfull=("diary","Diary of a Mad Senior","su","Inside the SU");
&connect_to_db;
$ary=&do_sql("select headline,author,date_format(date,\"%M %e\"),content,summary,pic_file,id from articles where type=\"$section\" order by date desc,priority limit 10");

&print_top("Opinions: $sectionfull{$section}","Opinions","oped.cgi","$sectionfull{$section}","oped.cgi?section=$section");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;


    if($section eq "diary"){
#############################
### DIARY OF A MAD SENIOR ###
#############################

&contenttable1_start;

	print qq|<p class="content"><b>$ary->[0][1]</b> <i>$ary->[0][2]</i><br>|;
if($ary->[0][5] =~ /./){
print<<Start_and_End;
	<table width="550" cellpadding="5" cellspacing="5"><tr><td>
		<table align="left" width="145">
		<tr><td>
			<img border="1" src="http://spectator.stuy.edu/photos/$ary->[0][4]" align="left">
		</td></tr>
		<tr><td>
			<p class="content">$ary->[0][5]<br><i>$ary->[0][6]</i></p>
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


print qq|<hr><p class="headline">Past Diaries</p>|;
print qq|<table border="0" cellpadding="1" class="content"><tr><td>Date</td><td>Author</td></tr>|;
for($i=1; $i<scalar(@{$ary}); $i++){
    print qq|<tr><td><a class="content" href=\"display.cgi?id=$ary->[$i][6]\">$ary->[$i][2]</a></td><td>$ary->[$i][1]</td></tr>|;
} #end for
print qq|</table>|;
&contenttable1_end;

} #end if
else
{
    &contenttable2_start;
    &col1_start(355);
    &special_article(355,145,$ary,0);
    print qq|<hr>|;
    &special_article(355,145,$ary,1);
    print qq|<hr>|;
    &special_article(355,145,$ary,4);
    &col1_end;
    &col2_start(275);
    &special_article(275,145,$ary,2);
    print qq|<hr>|;
    &special_article(275,145,$ary,3);
    print qq|<hr>|;
    &special_article(275,145,$ary,5);
    &col2_end;
    &contenttable2_end;
}

&maincontent_end;
&wholepage_end;
&footer;


}

