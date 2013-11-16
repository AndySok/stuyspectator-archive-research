<?php
$this->load->view('header');
?>
<?php 
	$this->load->helper('form');
	print form_open('account/login_submit');
	$data = array(
	              'name'        => 'email',
	              'id'          => 'email',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Email: ". form_input($data) ."<br />";
	$data = array(
	              'name'        => 'password',
	              'id'          => 'password',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Password: " . form_password($data) ."<br />";
	print form_submit('login_submit', 'Login');
	print form_close();
?>
<?php
$this->load->view('footer');
?>