#! /usr/bin/perl -w

##########################
### INCLUDES AND STUFF ###
##########################
use CGI qw/:param/;
require "templates2.pl";
require "tools.pl";
print "Content-type: text/html\n\n";

use DBI;
&connect_to_db;


############################
### USER INPUT RETRIEVAL ###
############################
$section=param(section);
$page=param(page);

################################
### SCRIPT KIDDIE PROTECTION ###
################################
if($section ne "talk" && $section ne "charter" && $section ne "manual" && $section ne "about" && $section ne "sitemap"){
    $section="";
}

$page=int($page);
if($section eq "charter" && ($page < 1 || $page > 6)){ $page=1; }
if($section eq "manual" && ($page < 1 || $page > 14)){ $page=1; }

###############################
### GLOBAL VAR DECLARATIONS ###
###############################
%names=("talk", "Talk to us", "charter", "Our Charter","manual","Our Manual","about","About us","sitemap","Sitemap");
@charterpages=("NULL","Manual of Ethics and Procedures","Operating Procedures","Operating Procedures, cont'd","The Spectator is Committed to..","Policies","Policies, cont'd");
@manualpages=("NULL","How to Use This Manual",
"Mission Statement, Ethical Practices, and Policies",
"The Departments",
"News Department",
"Features Department",
"Opinions Department",
"Arts and Entertainment Department",
"Sports Department",
"Art Department",
"Layout Department",
"Photography Department",
"Assignments",
"Laws, Ethics, Codes and Morality",
	      "Business Department");

%fallfull=(	"b_basketball","Boys' Basketball",
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
		 "g_gymnastics","Girls' Gymnastics");

%springfull=(	"baseball","Baseball",
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




###################
### HTML OUTPUT ###
###################
if($section ne ""){
    &print_top($names{$section},$names{$section},"index.cgi?section=$section");
}
else{
    &print_top;
}

&wholepage_start;
&leftbar_start;
&leftnavtable;

&leftbar_end;
&maincontent_start;


if($section eq ""){

######################
### DATA RETRIEVAL ###
######################
    $first=&do_sql("SELECT headline,author,date,content,summary,pic_file,id,extra,issue from articles where section!=\"oped\" and priority>=0 order by priority desc, date desc limit 1");
    $news=&do_sql("select headline,author,date,content,summary,pic_file,id,extra,issue from articles where section=\"news\" and priority>=0 order by priority desc, date desc limit 6");
    $sports=&do_sql("select headline,author,date,content,summary,pic_file,id from articles where section=\"sports\" and priority>=0 order by priority desc, date desc limit 3");
    $oped=&do_sql("select headline,author,date,content,summary,pic_file,id from articles where section=\"oped\" and priority>=0  order by priority desc, date desc limit 1");
    $scores=&do_sql("select hometeam,homescore,awayteam,awayscore,type from gamesched where homescore>\"\" order by date desc limit 3");
    &contenttable2_start;

###############
## LEFT SECTION OF MAIN CONTENT
###############
    &col2_start();
    &print_with_logo('Online Content');
    print"MORE TO COME SOON";
    &col2_end();

    &col1_start();
    &print_with_logo('Headlines');

    &special_article(350,145,$first,0);
#    &special_article(350,145,$news,0);
    &generic_article(350,$news,1);
print qq|<font class="content"><font color="red"><b>EDITORIAL</b></font></font>|;
    &generic_article(350,$oped,0);
    &col1_end;
    
    
###############
## RIGHT SECTION OF MAIN CONTENT
###############

    
=pod
    &col2_start(270);
    print<<Start_and_End;

<!-- RECENT HEADLINES -->
		   <table width="270" border="1" cellspacing="0" cellpadding="0" class="content">
		    <tr> 
		     <td width="270" bgcolor="#AA0000"> 
		      <div align="center"><font color="white"><b>Recent Headlines</b></a></div>
                     </td>
		     </tr>
                   
                          <tr>
                            <td>
                              <ul align="left">
                                <li>
                                 <a class="content" href="display.cgi?id=$news->[2][6]">$news->[2][0]</a>
                                </li>
                                <li> 
                                 <a class="content" href="display.cgi?id=$news->[3][6]">$news->[3][0]</a>
                                </li>
                                <li> 
                                 <a class="content" href="display.cgi?id=$news->[4][6]">$news->[4][0]</a>
                                  </div>
                                </li>
                                <li> 
                                 <a class="content" href="display.cgi?id=$news->[5][6]">$news->[5][0]</a>
                                </li>
                                <li> 
                                 <a class="content" href="display.cgi?id=$sports->[1][6]">$sports->[1][0]</a>
                                </li>
                                <li> 
				    <a class="content" href="display.cgi?id=$sports->[2][6]">$sports->[2][0]</a>
                                </li>
                              </ul>
                            </td>
                          </tr>
                        </table>
<!-- END RECENT HEADLINES -->

<br>

<!-- COLUMNS/SCOREBOARD -->
            <table width="270" border="0" cellspacing="0" cellpadding="0" class="content">
	      <tr>

<!-- SCOREBOARD -->
	       <td width="129" align="left" valign="top">

	        <table width="129" border="1" cellspacing="0" cellpadding="1" class="content">
		  <tr>
		    <td width="129" bgcolor="$headercolor">
		    <div align="center"><font color="white"><b>Scoreboard</b></font></div>
		    </td>
		  </tr>
		  <tr>

Start_and_End

    
    print qq|<td width="123" bgcolor="white">|;
    
    for($i=0; $i<3; $i++){
	print qq|<b>$fullsportnames{$scores->[$i][4]}</b><br>|;
	print qq|$scores->[$i][0] $scores->[$i][1]<br>|;
	print &getscores($scores,$i,2,3);
	print qq|<br>|;
    }
		
    print<<Start_and_End;
		     </td>
		  </tr>		
		</table>
	

       </td>
<!-- END SCOREBOARD -->

    <td width="2">&nbsp;</td>

<!-- COLUMNS -->
<!-- columns header -->
               <td width="129" valign="top" align="right">
		   <table width="129" border="1" cellspacing="0" cellpadding="1" class="content">
		    <tr> 
		     <td width="129" bgcolor="$headercolor"> 
		      <div align="center"><font color="white"><b>Columns</b></font></div>
                     </td>
		     </tr>
                   </tr>

<!-- end of header, begin column stuff -->
		   <tr> 
                  <td bgcolor="white" align="left" valign="top" width="129"> 
		    <table width="129" class="content">
		      <tr>
		       <td width="60">
			   <a href="oped.cgi?section=diary"><img src="images/diary.gif" border="1"></a>
		       </td>
                       <td width="65"><a href="oped.cgi?section=diary" class="content">Diary of a Mad Senior</a></td></tr></table>


<br>		     <table width="129" class="content">
		      <tr>
		       <td width="60">
			   <a href="oped.cgi?section=su"><img src="images/su_60.gif" border="1"></a>
		       </td>
                       <td width="65"><a href="oped.cgi?section=su" class="content">Inside the SU</a></td></tr></table>
	       </td>
</td></tr></table>
<!-- END COLUMNS -->



                      </td>
                    </tr>
                  </table>
<!-- END COLUMNS/SCOREBOARD -->

Start_and_End



    print "<hr width=\"90%\" align=\"left\">";
    &generic_article(270,$sports,0);
    &col2_end;
    &contenttable2_end;
=cut
}

elsif($section eq "charter"){
    &contenttable1_start;
    print qq|<p class="content"><font class="headline">$charterpages[$page]</font><br><br>|;
    open(INFILE,"data/charter$page.txt");
    while(<INFILE>){
	print $_;
    }
    close(INFILE);
    print qq|<br><br><hr width="100%"><p class="content"><b>Charter Outline:</b><br>|;

    for($i=1; $i<=scalar(@charterpages); $i++){
	print qq|<a class="content" href="index.cgi?section=charter&page=$i">$charterpages[$i]</a><br>|;
    }
    &contenttable1_end;
}

elsif($section eq "manual"){
    &contenttable1_start;
    print qq|<p class="content"><font class="headline">$manualpages[$page]</font><br><br>|;
    open(INFILE,"data/manual$page.txt");
    while(<INFILE>){
	print $_;
    }
    close(INFILE);
    print qq|<br><br><hr width="100%"><p class="content"><b>Manual Outline:</b><br>|;
    for($i=1; $i<=scalar(@manualpages); $i++){
	print qq|<a class="content" href="index.cgi?section=manual&page=$i">$manualpages[$i]</a><br>|;
    }
    &contenttable1_end;
}

elsif($section eq "talk"){
    &contenttable1_start;
print<<Start_and_End;
<p class="content"><font class="headline">Talk to us</font><br><br>
Your feedback is very important to us. Feel free to e-mail one of our departments if you have something to say.<br><br>
<b>Comments, Questions, and Suggestions</b><br>
<table><tr><td width="30%">
<p class="content"><b><a class="content" href="mailto:teohk\@stuy.edu">teohk\@stuy.edu</a></b></td><td><p class="content">Web Department</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:stuyspecnews\@hotmail.com">StuySpecNews\@hotmail.com</a></b></td><td><p class="content">News</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:specfeatures\@hotmail.com">SpecFeatures\@hotmail.com</a></b></td><td><p class="content">Features</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:specopinions\@hotmail.com">SpecOpinions\@hotmail.com</a></b></td><td><p class="content">Opinions</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:specsports\@hotmail.com">SpecSports\@hotmail.com</a></b></td><td><p class="content">Sports</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:specae\@hotmail.com">SpecAE@\hotmail.com</a></b></td><td><p class="content">Arts & Entertainment</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:specbusiness\@hotmail.com">SpecBusiness\@hotmail.com</a></b></td><td><p class="content">Business</td></tr>
<tr><td><p class="content"><b><a class="content" href="mailto:specphoto\@hotmail.com">SpecPhoto\@hotmail.com</a></b></td><td><p class="content">Photos</td></tr>
</table>

Start_and_End
    &contenttable1_end;
}

elsif($section eq "about"){
    &contenttable1_start;
print<<Start_and_End;
<p class="headline">The Spectator Online</p>
<table><tr><td width="40%"><p class="content"><b>Brenden Eng</b></td><td><p class="content">Webmaster</td></tr>
<tr><td><p class="content"><b>John Lee, Jack Nguy</b></td><td><p class="content">System Administrators</td></tr>
<tr><td><p class="content"><b>Mohammad Khan</b></td><td><p class="content">Head of Design, Graphics, and Layout</td></tr>
<tr><td><p class="content"><b>Christopher Pak</b></td><td><p class="content">Content Manager</td></tr>
<tr><td><p class="content"><b>Vic Zhong</b></td><td><p class="content">Layout Manager</td></tr>
<tr><td><p class="content"><b>Peiran Guo</b></td><td><p class="content">Programmer</td></tr>
</table>

<hr width="300" align=left>
<p class="headline">The Spectator</p>

<table width="450" border="1" cellspacing="0" cellpadding="0" bgcolor="#dddddd">
<tr>
<td width="225" valign="top"><center>
<p class="content"><b>Editor in Chief</b><br>Jeremy Wooster<br><br>

<b>Managing Editor</b><br>Jane Sussman<br><br>

<b>News</b><br>Eliza Herschkowitz<br>Theresa Langschultz<br><br>

<b>Features</b><br>Yitian Liu<br>Naomi Sosner<br><br>

<b>Opinions</b><br>Sarah Outhwaite<br>Georgiana Popa<br><br>

<b>Arts & Entertainment</b><br>Lillian Gao<br>Perri Osattin<br><br>

<b>Photography</b><br>Naomi Gordon-Loebl<br>Anna Wiener<br><br>
</center>
</td>
<td width="225" valign="top"><center>
<p class="content" align="center" valign="top">

<b>Sports</b><br>William Aibinder<br>Gen Kazama<br><br>
<b>Layout</b><br>Cynthia Koo<br>Wai-Yean Leung<br><br>
<b>Art</b><br>Brigid Black<br>Nicole Singer<br><br>
<b>Copy</b><br>Sammi Krug<br>In Ho Lee<br><br>
<b>Business Managers</b><br>Alexandra Caccamo<br>Vivi Tao<br><br>
<b>Spectator Online</b><br>Brenden Eng<br><br>
<b>Faculty Advisor</b><br>Hugh Francis</p></center>
</td>
</tr></table>

<br><hr width="300" align=left>
<p class="headline">About Us</p>

<p class="content">In November, 1999, The Spectator started to advertise for a web coordinator, 
someone to help us archive and store our articles on the Internet. We ran 
this ad, with little response, until April, when someone had a better idea.<br><br>

Jack Rosenthal, President of the New York Times Foundation, had a vision that 
one day, high school newspapers across the country, in both wealthy and poor 
districts, would be able to publish stories and pictures daily on the 
Internet. One afternoon in April, he took a cab down to Chambers Street to 
meet with Stanley Teitel, Stuyvesant\'s Principal, and the editors of The 
Spectator, who he would call upon to help model his idea. Quickly the team 
formed: eight Spectator editors, two veteran journalists, and a visiting 
group of web journalism specialists working to create The Spectator Online, a 
daily electronic version of our print paper. The team would also create a 
how-to book the Times could publish and distribute to high schools around the 
country, to help them do the same.<br><br>

With the guidance of Steven Knowlton, an associate professor of journalism at Hofstra 
University, and Karen Freeman, a Circuits editor for The New York Times, we 
spent four summer weeks learning from online newspapers, creating prototype 
newspapers under specific budgets, studying the ethics of online journalism, 
and creating this website.<br><br>

We hope we can meet our goal of updating the site every day, providing the 
Stuyvesant community with breaking news, sports reports, events schedules, 
weekend movie reviews, discussion forums, etc. The Stuyvesant administration, 
with funding from The New York Times, has even created a class to enable us 
to devote a period each day to building and updating this site. We hope the 
Stuyvesant community will use The Spectator Online as a source of information 
and entertainment, and a forum for student and faculty opinion. We hope 
outside visitors, from other high schools, will use this site as a source of 
ideas and possibilities.
</p>
<hr width="300" align="left">
<p class="headline">Special thanks to:</p>
<p class="content">
Jack Rosenthal, President of the New York Times Foundation<br>
Steven Knowlton, Associate Professor of journalism, Hofstra University <br>
Karen Freeman, Staff Editor, Circuits, New York Times<br>
Sarah Holloway, Executive Director, MOUSE.com<br>
Julie Saltzman, Program Director, MOUSE.com<br>
Ed Summers, Engineer, CheetahMail<br>
Michael Zamansky, Computer Science, Stuyvesant High School<br>
Steven Kramer, AP Technology Services, Stuyvesant High School<br>
Dan DeVlieger, Senior Project Manager, WiredVines<br>
Kristin Murphy, Field Communications Specialist, InterWorld Corporation<br>
Sarra Mossoff, Vice President for Production, SmallWorld.com<br>
Ed Bringas, Computer Facilitator for the School of Communication, Hofstra University<br>
Noreen Wu, Director of Software Development, Times Digital<br>
Meredith Artley, Associate Editor, Times Digital<br>
Patty Byrne, Advertising Representative, Times Digital<br>
Rob Larson , Information Architect, Times Digital<br>
Alice Carter, Project Manager: Education Products, Times Digital<br>
Doug Goetsch, Former Spectator Faculty Advisor<br>
Steven Shapiro, English Department Chair, Stuyvesant High School<br>
Stanley Teitel, Principal, Stuyvesant High School<br>

Start_and_End
&contenttable1_end;
}

elsif($section eq "sitemap"){
&contenttable2_start;
&col1_start(310);
print<<Start_and_End;

<ul class="content">
<li><a class="content" href="news.cgi">News</a></li>
<li><a class="content" href="oped.cgi">Opinions</a></li>
	<ul>
	<li><a class="content" href="oped.cgi?section=diary">Diary of a Mad Senior</a></li>
	<li><a class="content" href="oped.cgi?section=su">Inside the SU</a></li>
	</ul>
<li><a class="content" href="ae.cgi">Arts & Entertainment</a></li>
<li><a class="content" href="sports.cgi">Sports</a></li>
	<ul>
	<li><a class="content" href="sports.cgi?sport=fall">Fall sports</a></li>
		<ul>

Start_and_End

foreach $key (keys(%fallfull)){
	print qq|<li><a class="content" href="sports.cgi?sport=$key">$fallfull{$key}</a></li>|;
}

print qq|</ul><li><a class="content" href="sports.cgi?sport=spring">Spring Sports</a></li><ul>|;


foreach $key (keys(%springfull)){
	print qq|<li><a class="content" href="sports.cgi?sport=$key">$springfull{$key}</a></li>|;
}

print qq|</ul></ul></ul>|;
&col1_end;
&col2_start(310);
print<<Start_and_End;

<ul class="content">
<li><a class="content" href="archives.cgi">Archives</a></li>
	<ul class="content">
	<li><a class="content" href="archives.cgi?section=news">News articles</a></li>
	<li><a class="content" href="archives.cgi?section=oped">Opinions articles</a></li>
	<li><a class="content" href="archives.cgi?section=ae">A&E articles</a></li>
	<li><a class="content" href="archives.cgi?section=sports">Sports articles</a></li>
</ul>
<li><a class="content" href="index.cgi?section=talk">Talk to us</a></li>
<li><a class="content" href="index.cgi?section=charter">Our Charter</a></li>
	<ul class="content">
	<li><a class="content" href="index.cgi?section=charter&page=1">Manual of Ethics and Procedures</a></li>
	<li><a class="content" href="index.cgi?section=charter&page=2">Operating Procedures</a></li>
	<li><a class="content" href="index.cgi?section=charter&page=4">Committment</a></li>
	<li><a class="content" href="index.cgi?section=charter&page=5">Policies</a></li>
	</ul>
<li><a class="content" href="index.cgi?section=manual">Our Manual</a></li>

	<ul class="content">
	<li><a class="content" href="index.cgi?section=manual&page=2">Mission Statement, Ethical Practices, and Policies</a></li>
	<li><a class="content" href="index.cgi?section=manual&page=3">The Departments</a></li>
		<ul class="content">
		<li><a class="content" href="index.cgi?section=manual&page=4">News</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=5">Features</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=6">Opinions</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=7">Arts and Entertainment</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=8">Sports</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=9">Art</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=10">Layout</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=11">Photography</a></li>
		<li><a class="content" href="index.cgi?section=manual&page=14">Business</a></li>
		</ul>
	<li><a class="content" href="index.cgi?section=manual&page=12">Assignments</a></li>
	<li><a class="content" href="index.cgi?section=manual&page=13">Laws, Ethics, Codes and Morality</a></li>
	</ul>


<li><a class="content" href="index.cgi?section=about">About us</a></li>
<li><a class="content" href="index.cgi?section=sitemap">Sitemap</a></li>
<li><a class="content" href="gallery/">Gallery</a></li>
<li><a class="content" href="advsearch.cgi">Search</a></li>
</ul>

Start_and_End

&col2_end;
&contenttable2_end;

}
&maincontent_end();
&wholepage_end();
&footer();

