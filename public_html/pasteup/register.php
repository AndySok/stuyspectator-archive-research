<?php
$title = "Register";
require_once('header.php');

if (@isset($_REQUEST["name"]) and
    @isset($_REQUEST["email"]) and
    @isset($_REQUEST["password"]) and
    @isset($_REQUEST["cat"]))
{
    add_user($_POST["name"],
             $_POST["email"],
             $_POST["password"],
             $_POST["cat"],
             3);
}
else
{
    print "<form name='register' action='register.php' method='post'>
    Name: <input type='text'  name='name' /> <br />
    Email: <input type='text'  name='email' /> <br />
    <select name='cat'>
  		<option>News</option>
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
	</select><br />
    Password: <input type='password'  name='password'  /> <br />
    <input type='submit' Value='Submit'>
    </form>";
}
require_once('footer.php');
?>
