<?php
require_once('header.php');

if ($_SESSION['access_level'] >= 3 and isset($_REQUEST['id']))
{
    $id = $_REQUEST['id'];
    if (del_art($id))
    {
        if ($_SESSION['access_level'] >= 4)
        {
            header("Location: whole_pasteup.php");  
        }
        else
        {
            header("Location: my_pasteup.php");
        }
    }
}
else
{
    print "Error: not logged in or variable not specified.";
}

require_once('footer.php');
?>