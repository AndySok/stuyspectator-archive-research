Sign up
<?php 
	$this->load->helper('form');
	print form_open('account/signup_submit');
	$data = array(
	              'name'        => 'first_name',
	              'id'          => 'first_name',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "First name: " . form_input($data) . "<br />";
	$data = array(
	              'name'        => 'last_name',
	              'id'          => 'Lastname',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Last name: " . form_input($data) . "<br />";
	$data = array(
	              'name'        => 'email',
	              'id'          => 'email',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Email: " . form_input($data) . "What you use to login. Must be real, we don't spam.<br />";
	$data = array(
	              'name'        => 'password',
	              'id'          => 'password',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Password: " . form_password($data) . "One shot! Get it right.<br />";
	$options = array();
	foreach ($departments as $department)
	{
		$options[$department->id] = $department->department;
	}

	print "Department: ".form_dropdown('department', $options, '0') . "Are you part of the Spectator? If not just leave it as it is. <br />";
	print form_submit('signup_submit', 'Sign up');
	print form_close();
?>
