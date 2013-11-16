<?php
$title = "Home";
require_once('header.php');

if (@isset($_REQUEST["email"]) and @isset($_REQUEST["password"]))
{
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    if ($email == null or $password == null)
    {
        print "You did not fill in the email and password fields.<a href='index.php'>Back</a>";
    }
    else
    {
        if (login_user($email, $password))
        {
            print "Welcome to The Spectator pasteup.";
        }
    }
}
else
{
    print "<form name='login' action='index.php' method='post'>
           Email: <input type='text'  name='email' /> <br />
           Password: <input type='password' name='password' /> <br />
           <input type='submit' value='Submit'> </form> <br /> Or <a href='register.php'>register</a>...";
}

require_once('footer.php');
?>