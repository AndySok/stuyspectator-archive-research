#!/usr/bin/perl

#!/usr/bin/perl

use DBI;
use CGI qw/:param/;
require "tools.pl";
print "Content-type: text/html\n\n";

$id=param(id);
$db=param(db);

&connect_to_db;

if($db eq "articles"){
    $ary = &do_sql("select headline,author,date,section,type,priority,issue,content,summary,pic_file,extra,pic_author,pic_caption from articles where id=$id");
    if($ary->[0][3] eq "news"){ $chnews="CHECKED"; }
    if($ary->[0][3] eq "sports"){ $chsports="CHECKED"; }
    if($ary->[0][3] eq "oped"){ $choped="CHECKED"; }
    if($ary->[0][3] eq "ae"){ $chae="CHECKED"; }
    print<<Start_and_End;
<html>
<head>
<title>Add an Article</title>
</head>
<body>
<form name="form1" method="post" action="modify_article.cgi">
  <p>

    Article Modification:</p>
<p>Section: <input type="text" name="sctn" size="20" value="$ary->[0][3]"> </p>
  <p>Type: 
    <input type="text" name="type" size="20" value="$ary->[0][4]">
  </p>
  <p>Author(s): 
    <input type="text" name="author" size="60" value="$ary->[0][1]">
  </p>
  <p>Headline:
    <input type="text" name="headline" size="100" value="$ary->[0][0]">
  </p>
  <p>Date(YYYY-MM-DD)
    <input type="text" name="date" size="10" value="$ary->[0][2]">
  </p>
  <p>Content (newlines !-> paragraphs! PURE HTML HERE):<br>
    <textarea name="content" rows="25" cols="90">$ary->[0][7]</textarea>
  </p>
<p>Summary:<br>
    <textarea name="summary" rows="10" cols="90">$ary->[0][8]</textarea>
</p>
  <p>Issue #:
  <input type="text" name="issue" size="3" value="$ary->[0][6]">
  </p>
  <p>name of picture file (sans the http://www.stuyspectator.org/images, only the filename):
<input type="text" name="pic_file" size="20" value="$ary->[0][9]">
</p>
<p>pic author: <input type="text" name="pic_author" size="20" value="$ary->[0][11]"></p>
<p>pic caption: <input type="text" name="pic_caption" size="35" value="$ary->[0][12]"></p>
<p>Priority
<input type="text" name="priority" value="$ary->[0][5]"></p>
<input type="hidden" value="$id" name="id">
<p>Extra info:<br><textarea name="extra" rows="10" cols="90">$ary->[0][10]</textarea></p>
    <input type="submit" name="Submit" value="Submit"><input type="reset">
  </p>
</form>

</body>
</html>


Start_and_End
    

	
}	

else {
    $ary = &do_sql("select hometeam,awayteam,date,homescore,awayscore,type,summary_link,place,time from gamesched where id=$id");
    print<<Start_and_End;
<html>
<head>
<title>Modify a game schedule</title>
</head>
<body>
<form name="form1" method="post" action="modify_gamesched.cgi">
  <p>

    Game schedule modification:</p>
  <p>Type:
    <input type="text" name="type" size="20" value="$ary->[0][5]">
  </p>
  <p>Home team:
    <input type="text" name="hometeam" size="100" value="$ary->[0][0]">
  </p>
  <p>Away team:
    <input type="text" name="awayteam" size="100" value="$ary->[0][1]">
  </p>
  <p>Home score:
    <input type="text" name="homescore" size="20" value="$ary->[0][3]">
  </p>
  <p>Away score:
    <input type="text" name="awayscore" size="20" value="$ary->[0][4]">
  </p>
  <p>Summary link:
    <input type="text" name="summary_link" size="10" value="$ary->[0][6]">
  </p>
  <p>Place:
    <input type="text" name="place" size="30" value="$ary->[0][7]">
  </p>
  <p>Time:
    <input type="text" name="time" size="20" value="$ary->[0][8]">
  </p>
  <p>Date(YYYY-MM-DD)
    <input type="text" name="date" size="10" value="$ary->[0][2]">
  </p>
   <input type="hidden" value="$id" name="id">
   <input type="submit" name="Submit" value="Submit"><input type="reset">
  </p>
</form>

</body>
</html>


Start_and_End


}







