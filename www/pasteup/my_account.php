<?php
$title = "My account";
require_once('header.php');

check_credentials(3);
if(isset($_REQUEST['name']) and 
   isset($_REQUEST['email']))
{
    if (strlen($_REQUEST['password']) == 0)
    {
        $id = $_SESSION['id'];
        $result = mysql_query("SELECT password FROM users WHERE id='$id' LIMIT 1");
        list($password) = mysql_fetch_array($result);   
    }
    else
    {
        $password = password_encrypt($_REQUEST['password']);
    }
    if (mod_my_user($_SESSION['id'], 
                $_REQUEST['name'], 
                $_REQUEST['email'], 
                $password,
                $_REQUEST['cat'],
                $_REQUEST['contact']))
    {
        header("Location: home.php");
    }
}
else
{
    $id = $_SESSION['id'];
    $sql = pull_single_user($id);
 while($row = mysql_fetch_array($sql)){
    switch ($row['cat'])
        {
            case "News":
                $select = " <option selected>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Features":
                 $select = " <option>News</option>
                            <option selected>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Opinions":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option selected>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "A&E":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option selected>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Sports":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option selected>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Business":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option selected>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Photos":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option selected>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Art":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option selected>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Web":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option selected>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Copy":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option selected >Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Layout":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option selected>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
            case "Other":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option selected>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
              case "Editor-in-Chief":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option selected>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
              case "Managing Editor":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option selected>Managing Editor</option>
                            <option>Faculty Advisor</option>";
            break;
              case "Faculty Advisor":
                 $select = " <option>News</option>
                            <option>Features</option>
                            <option>Opinions</option>
                            <option>A&E</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Photos</option>
                            <option>Art</option>
                            <option>Web</option>
                            <option>Copy</option>
                            <option>Layout</option>
                            <option>Other</option>
                            <option>Editor-in-Chief</option>
                            <option>Managing Editor</option>
                            <option selected>Faculty Advisor</option>";
            break;
            
        }
        if ($row['cat'] != 'yes') { $cat = 'selected'; }
    print "<form name='mod_user' action='my_account.php' method='post'>";
        if ($row['contact'] == 1) { $contact = 'checked'; }
        print "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        print "Name:<input type='text'  name='name' value='" . $row['name'] . "' /><br />";
        print "Email:<input type='text'  name='email' value='" . $row['email'] . "' /><br />";
        print "Password:<input type='password'  name='password' /><br />";
        print "Contact:<input type='checkbox' name='contact' " . $contact . " /><br />";
        print " <select name='cat'>$select</select>";
    }
    print "<input type='submit' Value='Submit'></form>";
}

require_once('footer.php');
?>