<?php

class Staff extends Controller {

	function Staff()
	{
		parent::Controller();
		$this->load->helper('url');
		$this->load->library('spectator');
		$this->spectator->check_level(5);
	}
	
	function index()
	{
		print "bla";
	}
	
	function view_pasteup($alpha, $beta)
	{
		print $alpha;
		print $beta;
	}
	
	function add_article()
	{
		$this->load->view('staff/add_article');
	}
	
	function add_article_submit()
	{
		$issue = $this->input->post('issue');
		$title = $this->input->post('title');
		$photo = $this->input->post('photo');
		$art = $this->input->post('art');
		$lede = $this->input->post('lede');
		$word_count = $this->input->post('word_count');
		$comments = $this->input->post('comments');
	}
}
?>