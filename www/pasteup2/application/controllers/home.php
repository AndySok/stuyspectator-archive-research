<?php

class home extends Controller {

	function home()
	{
		parent::Controller();
	}
	### bug here where when no image is attached to article, sql returns null
	function index()
	{
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.status,articles.type,article_text.author,article_text.author_name,article_text.text_styled, images.name, images.file_path, images.caption, issues.active from articles, article_text, images,issues where articles.lead = 1 and articles.department = 12 and articles.id = article_text.article_id and articles.id = images.article_id and articles.issue = issues.issue_num and issues.active = 1 limit 1";
		$query = $this->db->query($sql);
		$data['top'] = $query->result_array();
		
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.status,articles.type,article_text.author,article_text.author_name,article_text.text_styled from articles, article_text,issues where articles.issue = issues.issue_num and issues.active != 0 and articles.lead = 1 and articles.department = 9 and articles.id = article_text.article_id limit 1";
		$query = $this->db->query($sql);
		$data['bottom'] = $query->result_array();
		
		
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.status,articles.type,article_text.author,article_text.author_name,article_text.text_styled from articles, article_text,issues where issues.active != 0 and articles.issue = issues.issue_num and articles.department = 2 and articles.id = article_text.article_id limit 5";
		
		$query = $this->db->query($sql);
		$data['web'] = $query->result_array();
		
		$this->load->view('home/home',$data);
		
	}
	
	function article($id)
	{
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.type,article_text.author,article_text.author_name,article_text.text_styled from articles, article_text,issues where issues.active != 0 and articles.issue = issues.issue_num and articles.id = $id and articles.id = article_text.article_id";
		$query = $this->db->query($sql);
		$data['article'] = $query->result_array();
		
		$sql ="select images.name, images.file_path, images.caption from images where images.article_id = $id";
		$query = $this->db->query($sql);
		$data['image'] = $query->result_array();
		
		
		$this->load->view('home/article', $data);
	}
	
	function browse($id)
	{
		$id = $this->input->xss_clean($id);
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.status,articles.type,article_text.author,article_text.author_name,article_text.text_styled from articles, article_text,issues where issues.active != 0 and articles.issue = issues.issue_num and articles.department = $id and articles.id = article_text.article_id";
		$query = $this->db->query($sql);
		$data['articles'] = $query->result_array();
		
		$this->load->view('home/browse', $data);
	}
	
	function exclusive()
	{
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.status,articles.type,article_text.author,article_text.author_name,article_text.text_styled from articles, article_text,issues where issues.active != 0 and articles.issue = issues.issue_num and articles.type = 'web' and articles.id = article_text.article_id";
		$query = $this->db->query($sql);
		$data['articles'] = $query->result_array();
		
		$this->load->view('home/exclusive', $data);
	}
	
	function featured()
	{
		$sql = "select articles.id,articles.title,articles.department,articles.issue,articles.status,articles.type,article_text.author,article_text.author_name,article_text.text_styled from articles, article_text,issues where issues.active != 0 and articles.issue = issues.issue_num and articles.lead = 1 and articles.id = article_text.article_id";
		$query = $this->db->query($sql);
		$data['articles'] = $query->result_array();
		
		$this->load->view('home/featured', $data);
	}
	
	function charter()
	{
		$this->load->view('home/charter');
	}
	
	function contact()
	{
		$this->load->view('home/contact');
	}
	
	function masthead()
	{
		$this->load->view('home/masthead');
	}
}
?>