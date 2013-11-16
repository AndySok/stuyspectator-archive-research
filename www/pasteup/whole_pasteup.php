<?php
require_once('header.php');


if ($_SESSION['access_level'] >= 4)
{
    print "Below is the entire current pasteup. Make any changes you would like. To go back to viewing only, click <a href='pasteup.php'>here</a>.";
     print "<form name='update_pasteup' action='update_pasteup.php' method='post'>";
        print "<table border='1'><tr><td>Article</td><td>Word count</td><td>Photo</td><td>Art</td><td>Lede</td><td>Comments</td><td>Modify</td><td>Delete</td></tr>";
     $sql = pull_whole_pasteup();

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
}

require_once('footer.php');
?>