<?php
$title = "My pasteup";
require_once('header.php');

check_credentials(3);
  
print "Viewing " . $_SESSION['cat'] . " pasteup.";
$sql = pull_div_pasteup($_SESSION['cat']);

print "<form name='update_pasteup' action='update_pasteup.php' method='post'>";
print "<table border='1'><tr><td>Article</td><td>Word count</td><td>Photo</td><td>Art</td><td>Lede</td><td>Comments</td><td>Modify</td><td>Delete</td></tr>";


 while($row = mysql_fetch_array($sql)){ 

    print "<tr>";
    print "<td>" . $row['article'] . "</td>";
    print "<td>" . $row['word_count'] . "</td>";
   print "<td>";
   if($row['photo'] == 'yes'){print 'X';} 
   print "</td><td>";
   if($row['art'] == 'yes'){print 'X';}
   print "</td><td>";
   if($row['lede'] == 'yes'){print 'X';} 
   print "</td>";
    print "<td>" . $row['comments'] . "</td>";
    print '<td><a href ="mod_art.php?id=' . $row['id'] . '">Modify</a>';
    print '<td><a href ="del_art.php?id=' . $row['id'] . '">Delete</a>';

 }
print "</table></form>";
     
print 'Want to add another article? Click <a href="mod_art.php">here</a>';

require_once('footer.php');
?>