<?php
	$this->load->view('desk/header');
	
	$this->load->helper('form');

	foreach ($article as $article)
	{
	$id = $article['id'];
	$hidden = array('id' => "$id");
	print form_open('pasteup/edit_article_submit','', $hidden);
	print "Edit article<br />";
	print "Issue: " . $article['issue'] . "<br />";
	$data = array(
	              'name'        => 'title',
	              'id'          => 'title',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%',
				  'value'		=> $article['title']
	            );
	print "Title: ". form_input($data) ."<br />";
	$data = array(
	              'name'        => 'photo',
	              'id'          => 'photo',
	              'value'       => 1,
	              'checked'     => $article['photo']
	            );
	print "Photo: " . form_checkbox($data) . "<br />";
	$data = array(
	              'name'        => 'art',
	              'id'          => 'art',
	              'value'       => 1,
	              'checked'     => $article['art'],
	            );
	print "Art: " . form_checkbox($data) . "<br />";
	$data = array(
	              'name'        => 'lead',
	              'id'          => 'lead',
	              'value'       => 1,
	              'checked'     => $article['lead']
	            );
	print "lead: " . form_checkbox($data) . "<br />";
	$data = array(
	              'name'        => 'word_count',
	              'id'          => 'word_count',
	              'maxlength'   => '3',
	              'size'        => '3',
	              'style'       => 'width:30px',
				  'value'		=> $article['word_count']
	            );
	print "Word count: ". form_input($data) ."<br />";
	$data = array(
	              'name'        => 'comments',
	              'id'          => 'comments',
	              'maxlength'   => '100',
	              'size'        => '50',
	              'style'       => 'width:20%',
				  'value'		=> $article['comments']
	            );
	print "Comments: ". form_input($data) ."<br />";
	print form_submit('edit_article_submit', 'Submit');
	}
	print form_close();
	
	$this->load->view('desk/footer');
?>