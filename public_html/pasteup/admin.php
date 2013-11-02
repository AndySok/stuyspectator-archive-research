<?php
require_once('header.php');

if ($_SESSION['access_level'] == 5)
{
    if (@isset($_REQUEST['active']))
    {
        make_active($_REQUEST['id'], $_REQUEST['active']);
    }
    print "<form name='admin' action='admin.php' method='post'>";
    print "<table border='1'><tr><td>Name</td><td>Email</td><td>Access Level</td><td>Active</td><td>Contact</td><td>Category (if editor)</td><td>Comments</td><td>Modify</td><td>Delete</td></tr>";

    $sql = pull_users();
    while($row = mysql_fetch_array($sql)){ 

        print "<tr>";
        print "<td>" . $row['name'] . "</td>";
        print "<td>" . $row['email'] . "</td>";
        print "<td>". $row['access_level'] . "</td>";
        print "<td>" . $row[ 'active' ] . "</td>";
        print "<td>". $row['contact'] . "</td>";
        print "<td>". $row['cat'] . "</td>";
        print "<td>" . $row['comments'] . "</td>";
        print '<td><a href ="mod_user.php?id=' . $row['id'] . '">Modify</a></td>';
        print '<td><a href ="mod_user.php?id=' . $row['id'] . '&delete=yes">Delete</a></td>';

    }
        print "</table></form>";
}
else
{
    header("Location: index.php");
}

require_once('footer.php');
?>