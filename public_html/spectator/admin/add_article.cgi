#!/usr/bin/perl

require "tools.pl";
use DBI;

print "Content-type: text/html\n\n";

%dataDict = ();
&readData(*data);
&parseData(*data,*dataDict);

&connect_to_db;	

$content=$dataDict{"content"};
$author=$dataDict{"author"};


$content = &newlines_to_paragraphs($content);
$summ = &paragraphs_to_summary($content);
$content =~ s/^<p>//i;
$summ =~ s/^<p>//i;

if ($author eq "" || $author eq " ")
{
    $author = "<br>";
}

elsif ($author =~ m/^(By |BY |bY |by )/)
{
    $author=~s/^(By |BY |bY |by )//;
    $author = "By $author";
}
else
{
    $author = "By $author";
}


@author_full = split(/\s+/,$author);
for($x=0;$x<scalar(@author_full);$x++)
{
    $author_full[$x]=ucfirst(lc($author_full[$x]));
}
$author=join(" ",@author_full);
$author = $dbh->quote($author);




$content  = $dbh->quote($content);
$summary  = $dbh->quote($summ);
$type     = $dbh->quote($dataDict{"type"});
$headline = $dbh->quote($dataDict{"headline"});
$date     = $dbh->quote($dataDict{"date"});
$type     = $dbh->quote($dataDict{"type"});
$pic_file = $dbh->quote($dataDict{"pic_file"});
$section =  $dbh->quote($dataDict{"section"});
$priority =             $dataDict{"priority"};
$issue    =             $dataDict{"issue"};

$priority = $priority eq "on" ? 1 : 0;

# NOTHING WITH HEADER_IMG YET!

# insert the article.

$rows = $dbh->do (qq|insert into articles (author,headline,date,content,summary,type,issue,pic_file,priority,section) 
		  values($author,$headline,$date,$content,$summary,$type,$issue,$pic_file,$priority,$section)|);





$dbh->disconnect();

if($rows){
    print "<b>Entry Successful</b><br>\n";
}
else{
    print "<b>Entry was NOT successful</b><br>Data dump:<br>\n";
}

print<<Start_and_End;
<table border="1">
<tr> <td>Content</td> <td>$content </td> </tr>
<tr> <td>Summary</td> <td>$summary </td> </tr>
<tr> <td>Author</td> <td>$author </td> </tr>
<tr> <td>Type</td> <td>$type </td> </tr>
<tr> <td>Issue</td> <td>$issue </td> </tr>
<tr> <td>Pic file</td> <td>$pic_file </td> </tr>



</table>
<br>
Rows affected: $rows<br>


Start_and_End


