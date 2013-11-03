<?php
	$this->load->view('desk/header');

	$this->load->helper('form');
	print form_open('pasteup/new_article_submit');


	print "Issue: $issue<br />";
	print "<input type='hidden' name='issue' value='$issue'>";
	$data = array(
	              'name'        => 'title',
	              'id'          => 'title',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Title: ". form_input($data) ."<br />";
	$data = array(
	              'name'        => 'photo',
	              'id'          => 'photo',
	              'value'       => 1,
	              'checked'     => FALSE,
	            );
	print "Photo: " . form_checkbox($data) . "<br />";
	$data = array(
	              'name'        => 'art',
	              'id'          => 'art',
	              'value'       => 1,
	              'checked'     => FALSE,
	            );
	print "Art: " . form_checkbox($data) . "<br />";
	$data = array(
	              'name'        => 'lead',
	              'id'          => 'lead',
	              'value'       => 1,
	              'checked'     => FALSE,
	            );
	print "lead: " . form_checkbox($data) . "<br />";
	$data = array(
	              'name'        => 'word_count',
	              'id'          => 'word_count',
	              'maxlength'   => '3',
	              'size'        => '3',
	              'style'       => 'width:30px'
	            );
	print "Word count: ". form_input($data) ."<br />";
	$data = array(
	              'name'        => 'comments',
	              'id'          => 'comments',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Comments: ". form_input($data) ."<br />";
	print form_submit('new_article_submit', 'Submit');
	print form_close();

	$this->load->view('desk/footer');
?>