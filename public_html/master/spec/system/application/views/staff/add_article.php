<?php
$this->load->view('header');
?>
<?php 
	$this->load->helper('form');
	print form_open('staff/add_article_submit');
	$options = array();
	foreach ($issues as $issue)
	{
		$options[$issue->id] = $issue->department;
	}

	print "Issue: ".form_dropdown('issue', $options, '0') ."<br />";
	$data = array(
	              'name'        => 'title',
	              'id'          => 'title',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
	            );
	print "Title: ". form_input($data) ."<br />";
	$data = array(
	              'name'        => 'authors',
	              'id'          => 'authors',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%'
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
	              'name'        => 'lede',
	              'id'          => 'lede',
	              'value'       => 1,
	              'checked'     => FALSE,
	            );
	print "Lede: " . form_checkbox($data) . "<br />";
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
	print form_submit('add_article_submit', 'Submit');
	print form_close();
?>
<?php
$this->load->view('footer');
?>