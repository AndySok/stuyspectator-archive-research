<?php
require_once('header.php');

check_credentials(5);
 if (@isset($_REQUEST['delete']) and isset($_REQUEST['id']))
 {
     if (del_user($_REQUEST['id']))
     {
		print "user deleted";
         #header("Location: admin.php");  
     }
 }
 elseif(isset($_REQUEST['id']) and 
        isset($_REQUEST['name']) and 
        isset($_REQUEST['email']) and 
        isset($_REQUEST['access_level']))
 {
     if (strlen($_REQUEST['password']) == 0)
     {
         $id = $_REQUEST['id'];
         $result = mysql_query("SELECT password FROM users WHERE id='$id' LIMIT 1");
         list ($password) = mysql_fetch_array ($result);   
     }
     else
     {
         $password = password_encrypt($_REQUEST['password']);
     }
     
     if (isset($_REQUEST['contact']))
     {
         $contact = 1;
     }
     else
     {
         $contact = 0;
     }
     if (isset($_REQUEST['active']))
     {
         $active = 1;
     }
     else
     {
         $active = 0;
     }

     if (mod_user($_REQUEST['id'], 
                 $_REQUEST['name'], 
                 $_REQUEST['email'], 
                 $password, 
                 $_REQUEST['access_level'], 
                 $active,
                 $contact,
                 $_REQUEST['comments'],
                 $_REQUEST['cat']))
     {
		print "user modified";
         #header("Location: admin.php");
     }
 }
      elseif (@isset($_REQUEST['id']))
 {
     $id = $_REQUEST['id'];
     $sql = pull_single_user($id);
 
     print "<form name='mod_user' action='mod_user.php' method='post'>";
     while($row = mysql_fetch_array($sql))
     {
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
         if ($row['active'] == 1) { $active = 'checked'; }
         if ($row['contact'] == 1) { $contact = 'checked'; }
         print "<input type='hidden' name='id' value='" . $row['id'] . "'>";
         print "Name:<input type='text'  name='name' value='" . $row['name'] . "' /><br />";
         print "Email:<input type='text'  name='email' value='" . $row['email'] . "' /><br />";
         print "Password:<input type='password'  name='password' /><br />";
         print "Active:<input type='checkbox' name='active' " . $active . " /><br />";
         print "Contact:<input type='checkbox' name='contact' " . $contact . " /><br />";
          print "Access Level:<input type='text'  name='access_level' value='" . $row['access_level'] . "' /><br />";
         print "Comments:<input type='text'  name='comments' value='" . $row['comments'] . "' /><br />";
         print " <select name='cat'>$select</select>";
     }
     print "<input type='submit' Value='Submit'></form>";    
 }
 
 else
 {
     print "Error";
 }

require_once('footer.php');
?>