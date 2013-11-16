<?php
$title ="Pasteup";
require_once('header.php');

check_credentials(3);

if ($_SESSION['access_level'] == 3){
print ' <a href="my_pasteup.php">View/edit my pasteup</a>';
}

if ($_SESSION['access_level'] >= 4 and @isset($_REQUEST['new']))
{
    print ' <a href="whole_pasteup.php">Edit pasteup</a>';
    if (new_pasteup())
    {
        print " New pasteup created";
    }
}
elseif ($_SESSION['access_level'] >= 4)
{
    print ' <a href="whole_pasteup.php">Edit pasteup</a>';
    print " <a href='pasteup.php?new=yes'>New pasteup</a> (Careful, this will delete the current pasteup)";
}



$sql = pull_whole_pasteup();
   print "<table border='1'><tr><td><b>Division</b></td><td><b>Article</b></td><td><b>Word count</b></td><td><b>Photo</b></td><td><b>Art</b></td><td><b>Lede</b></td><td><b>Comments</b></td></tr></b>";
while($row = mysql_fetch_array($sql)){ 

   print "<tr>";
   print "<td>" . $row['cat'] . "</td>";
   print "<td>" . $row['article'] . "</td>";
   print "<td>" . $row['word_count'] . "</td>";
   print "<td>";
   if($row['photo'] == 'yes'){print 'X';} 
   print "</td><td>";
   if($row['art'] == 'yes'){print 'X';}
   print "</td><td>";
   if($row['lede'] == 'yes'){print 'X';} 
   print "</td>";
   print "<td>" . $row['comments'] . "</td></tr>";

}
print "</table>";

total_words();

require_once('footer.php');
?>