<?php
	$this->load->view('desk/header');
	
	$this->load->helper('form');
	print form_open('pasteup/new_volume_submit');
	
	$data = array(
	              'name'        => 'volume',
	              'id'          => 'volume',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:10%'
	            );
	print "Volume: " . form_input($data) . "Ex. 2006-2007 <br />";
	$data = array(
	              'name'        => 'comments',
	              'id'          => 'comments',
	              'maxlength'   => '255',
	              'rows'        => '5',
	              'cols'       => '20'
	            );
	print "Comments: " . form_textarea($data) . "<br />";
	
	
	
	print form_submit('new_volume_submit', 'Create volume');
	print form_close();

	
	$this->load->view('desk/footer');
?>