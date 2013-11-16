<?php
require_once('header.php');

if (@isset($_REQUEST["article"]) and
        @isset($_REQUEST["word_count"]) and
        @isset($_REQUEST["photo"]) and
        @isset($_REQUEST["art"]) and
        @isset($_REQUEST["lede"]) and
        @isset($_REQUEST["comments"]) and
        @isset($_SESSION['email']) and
        @isset($_REQUEST['id']))
{
    if (mod_art($_REQUEST["id"],$_REQUEST["article"],$_REQUEST["word_count"],$_REQUEST["photo"],$_REQUEST["art"],$_REQUEST["lede"],$_REQUEST["comments"]))
    {
		print "Article modified";
        /*if ($_SESSION['access_level'] >= 4)
        {
            header("Location: whole_pasteup.php");  
        }
        else
        {
            header("Location: my_pasteup.php");
        } */
    }
}
elseif (@isset($_REQUEST["article"]) and
        @isset($_REQUEST["word_count"]) and
        @isset($_REQUEST["photo"]) and
        @isset($_REQUEST["art"]) and
        @isset($_REQUEST["lede"]) and
        @isset($_REQUEST["comments"]) and
        $_SESSION['access_level'] >= 3)
{
    if (add_art($_REQUEST["article"],$_REQUEST["word_count"],$_REQUEST["photo"],$_REQUEST["art"],$_REQUEST["lede"],$_REQUEST["comments"]))
    {
		print "Article added";
        /*if ($_SESSION['access_level'] >= 4)
        {
            header("Location: whole_pasteup.php");  
        }
        else
        {
            header("Location: my_pasteup.php");
        }*/
    }
}
elseif ($_SESSION['access_level'] >= 3 and @isset($_REQUEST['id']))
{
    $id = $_REQUEST['id'];
    $sql = pull_single_pasteup($id);
    print "<form name='add_art' action='mod_art.php' method='post'>";
    print "<table><tr>";
    while($row = mysql_fetch_array($sql))
    {  
        if ($row['photo'] != 'yes') { $photo = 'selected'; }
        if ($row['art'] != 'yes') { $art = 'selected';}
        if ($row['lede'] != 'yes') { $lede = 'selected';} 
        print "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        print "<td>Title:<input type='text'  name='article' value='" . $row['article'] . "' /></td>";
        print "<td>Word Count:<input type='text'  name='word_count' value='" . $row['word_count'] . "' /></td>";
        print "<td>Photo:<select name='photo'> <option>yes</option><option " . $photo .">no</option></select></td>";
        print "<td>Art:<select name='art'> <option>yes</option><option " . $art .">no</option></select></td>";
        print "<td>Lede:<select name='lede'> <option>yes</option><option " . $lede .">no</option></select></td>";
        print "<td>Comments:<input type='text'  name='comments' value='" . $row['comments'] . "' /></td></tr>";
    }
print "</table><br /><input type='submit' Value='Submit'></form></form>";
    
}
elseif($_SESSION['access_level'] >= 3)
{
    print "<form name='add_art' action='mod_art.php' method='post'>";
    print "<table><tr>";
    print "<td>Title:<input type='text'  name='article' /></td>";
    print "<td>Word Count:<input type='text'  name='word_count' /></td>";
    print "<td>Photo:<select name='photo'> <option>yes</option><option>no</option></select></td>";
     print "<td>Art:<select name='art'> <option>yes</option><option>no</option></select></td>";
      print "<td>Lede:<select name='lede'> <option>yes</option><option>no</option></select></td>";
    print "<td>Comments:<input type='text'  name='comments' /></td></table><br /><input type='submit' Value='Submit'></form>";

}

else
{
    print "Error must be logged in";
}

require_once('footer.php');
?>