<?php
session_start();

require_once('db.php');

function password_encrypt($password_pre)
{
    return crypt('STHeVNkdf432gHuTZ8d02srpf9JI9CzNYn', $password_pre);
}

function add_user($name, $email, $password, $cat, $access_level)
{
	$name = stripslashes($name);
	$email = stripslashes($email); 
	$password = password_encrypt(stripslashes($password)); 
	$active = 0;
	$cat = stripslashes($cat);
	$date = date('Y-m-d');
    
    $sql_email_check = mysql_query("SELECT email FROM users WHERE email='$email'");
    $email_check = mysql_num_rows($sql_email_check); 
    if($email_check > 0){ 
        print "<strong>Your email address has already been used by another member  
        in our database. Please submit a different email address!<br />";
     return false;
     }
     
	if( mysql_query("INSERT INTO users (name, email, password, access_level, active, cat, date) 
						VALUES ('$name', '$email', '$password', '$access_level', '$active', '$cat', '$date')") or die (mysql_error()))
	{
	   $message = "Success, you've been signed up for the Spectator website. Hold on until your account is verified.";
    	  mail($email, "You've been signed up!", $message,  
        "From: Webmaster<webmaster@stuyspectator.com>"); 
    print 'You\'re account has been created for the Spectator website. You won\'t be able to login until you have been confirmed by the webmaster. '; 
    	
    } 
    else 
    {	  
        print 'There has been an error creating your account. Please contact the webmaster.'; 
	}
}

function login_user($email, $password)
{
    session_start();
    $password = password_encrypt($password);
   
    $sql = mysql_query("SELECT * FROM users WHERE email='$email' AND password='$password' AND active='1'"); 
    $login_check = mysql_num_rows($sql);
    if($login_check > 0){ 
        while($row = mysql_fetch_array($sql)){  
        session_register('id'); 
        $_SESSION['id'] = $row['id'];
        
        session_register('email');
        $_SESSION['email'] = $row['email'];
        
        session_register('acess_level'); 
        $_SESSION['access_level'] = $row['access_level'];
        
        session_register('cat'); 
        $_SESSION['cat'] = $row['cat'];
        
        session_register('name'); 
        $_SESSION['name'] = $row['name'];
        return true;
        }
    }
    else 
    {
        print "Email and password combination does not exist. ";
    }
    
}

function check_credentials($level)
{
    if ($_SESSION['access_level'] >= $level)
    {
        return true;
    }
    else
    {
		print "Must login.";
        exit;
    }
}
function pull_whole_pasteup()
{
    return mysql_query("SELECT * FROM pasteup ORDER BY cat DESC");
}

function total_words()
{
    $sql = mysql_query("SELECT word_count FROM pasteup");
    while($row = mysql_fetch_array($sql)){
        $count = $count + $row['word_count'];
    }
    print 'Number of words: ' . $count;
}

function pull_div_pasteup($cat)
{
    return mysql_query("SELECT * FROM pasteup WHERE cat = '$cat' ORDER BY id DESC");
}

function pull_single_pasteup($id)
{
    return mysql_query("SELECT * FROM pasteup WHERE id = '$id' ORDER BY id DESC");
}

function new_pasteup()
{
    if (mysql_query("DELETE FROM pasteup"))
    {
        return true;
    }
}

function add_art($article, $word_count, $photo, $art, $lede, $comments)
{
    $date = date('Y-m-d');
    $cat = $_SESSION['cat'];
    mysql_query("INSERT INTO pasteup (article, cat, word_count, photo, art, lede, comments, date) VALUES ('$article', '$cat', '$word_count', '$photo', '$art', '$lede', '$comments', '$date')") or die (mysql_error());
    
    log_add_art($article, $word_count, $photo, $art, $lede, $comments);
    
    return true;

}

function mod_art($id, $article, $word_count, $photo, $art, $lede, $comments)
{
    mysql_query("UPDATE pasteup SET article = '$article', word_count = '$word_count', photo = '$photo', art = '$art', lede = '$lede', comments = '$comments' where id = $id") or die (mysql_error());
  
    log_mod_art($id,$article, $word_count, $photo, $art, $lede, $comments);

    return true;
    
  

}


function del_art($id)
{
    mysql_query("DELETE FROM pasteup WHERE id = '$id'");
    log_del_art($id);
    return true;
}

function pull_users()
{
    return mysql_query("SELECT * FROM users ORDER BY id DESC");
}

function pull_single_user($id)
{
    return mysql_query("SELECT * FROM users WHERE id = '$id' LIMIT 1");
}

function del_user($id)
{
    mysql_query("DELETE FROM users WHERE id = '$id'");
    return true;
}

function mod_user($id, $name, $email, $password, $access_level, $active, $contact, $comments, $cat)
{
    mysql_query("UPDATE users SET name = '$name', email = '$email', password = '$password', access_level = '$access_level', active = '$active', contact = '$contact', comments = '$comments', cat = '$cat' where id = $id") or die (mysql_error());
    return true;
}

function mod_my_user($id, $name, $email, $password, $cat, $contact)
{
    mysql_query("UPDATE users SET name = '$name', email = '$email', password = '$password', contact = '$contact', cat = '$cat' where id = $id") or die (mysql_error());
    $_SESSION['cat'] = $cat;
    return true;
}

function log_add_art($article, $word_count, $photo, $art, $lede, $comments)
{
    $date = date('Y-m-d');
    $changes = "\n $date : Article added. Title: $article | Word Count: $word_count | Photo: $photo | Art: $art | Lede: $lede | Comments $comments";
    
    write_changes($changes);
}

function log_mod_art($id, $article, $word_count, $photo, $art, $lede, $comments)
{
    $date = date('Y-m-d');
    $changes = "\n $date : Article modified. ID: $id | Title: $article | Word Count: $word_count | Photo: $photo | Art: $art | Lede: $lede | Comments $comments";
    write_changes($changes);
}

function log_del_art($id)
{
    $date = date('Y-m-d');
    $changes = "\n $date : Article deleted. ID: $id";
    write_changes($changes);
}

function write_changes($changes)
{
    $filename = 'log.txt';

    if (is_writable($filename)) {
        if (!$handle = fopen($filename, 'a')) {
            echo "Cannot open file ($filename)";
            exit;
        }
        if (fwrite($handle, $changes) == FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }
    
        fclose($handle);

    } else {
        echo "The file $filename is not writable";
    }
}

function get_messages($cat)
{
    $sql = mysql_query("SELECT * FROM messages WHERE to_cat = '$cat'");
	print "<table><tr><td>From</td><td>Date</td><td>Subject</td><td>Content</td></tr><tr>";
    while($row = mysql_fetch_array($sql)){
        print "<td>". $row['name'] . "(" . $row['email'] . ")</td>";
        print "<td>" . $row['date'] . "</td>";
        print "<td>" . $row['subject'] . "regarding" . $row['regarding'] . "</td>";
        print "<td>" . $row['body'] . "</td>";
		print "</tr></table><hr />";
    }
}

?>