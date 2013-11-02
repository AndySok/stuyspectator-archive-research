
<?php
$this->load->view('desk/header');

	print "<form action='signup_submit' method='post'>";
	print "Name: <input type='text' name='name' id='name' /><br />";
	print "Email: <input type='text' name='email' id='email' />What you use to login. Must be real, we don't spam.<br />";
	print "Password: <input type='password' name='password' id='password' />One shot! Get it right.<br />";

	print "Are you on the staff?  <input type='checkbox' name='is_staff'><br />";
	print "Year of graduation:<input type='text' name='grad_year'>  <br />";
	
	print "<input type='submit' name='signup_submit' value='Sign up'  />
	</form>";
$this->load->view('desk/footer');

?>
