<?php
	$this->load->view('desk/header');

	$this->load->helper('form');
	print form_open('pasteup/new_issue_submit');
	
	$options = array();
	foreach ($volumes as $volume)
	{
		$options[$volume->id] = $volume->volume;
	}

	print "Volume: ".form_dropdown('volume', $options) . "<br />";
	$data = array(
	              'name'        => 'issue_num',
	              'id'          => 'issue_num',
	              'maxlength'   => '3',
	              'size'        => '3',
	              'style'       => 'width:5%'
	            );
	print "Issue number: ".form_input($data) ."<br />";

	$data = array(
	              'name'        => 'comment',
	              'id'          => 'comment',
	              'maxlength'   => '255',
	              'rows'        => '5',
	              'cols'       => '20'
	            );
	print "Comments: " . form_textarea($data) . "<br />";
	
	print form_submit('new_issue_submit', 'Create issue');
	print form_close();

	$this->load->view('desk/footer');
?>