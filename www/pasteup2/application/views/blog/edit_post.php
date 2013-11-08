<?php
print "<form action='edit_post_submit' method='post'>";

print "Title: <input type='text' name='title' maxlength='100' size='50' id='title' style='width:20%'  /><br />";
print "Post: <input type='text' name='post' maxlength='100' size='50' id='post' style='width:20%'  /> <br />";
print "Status: <input type='text' name='status' maxlength='100' size='50' id='status' style='width:20%'  /> <br />";
print "<input type='submit' name='edit_post_submit' value='Edit post'  />";
print "</form>";
?>