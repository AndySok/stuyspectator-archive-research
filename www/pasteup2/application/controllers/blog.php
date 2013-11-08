<?php

class Blog extends Controller {

	function Blog()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	function index()
	{
		print "index of blog";
	}
	
	function manage()
	{
		$sql = "select * from blogs";
		#!!!!!!!!!!!!
	}
	
	function new_blog()
	{
		$this->load->view('blog/new_blog');
	}
	
	function new_blog_submit()
	{
		$name = $this->input->post('name');
		$authors = $this->input->post('authors');
		
		$this->load->helper('date');
		$ts = now();
		
		$sql = "insert into blogs (name, authors, ts) values(?,?, $ts)";
		
		$query = $this->db->query($sql, array($name, $authors));
		
		if ($query)
		{
			redirect('blog', 'location');
		}
	}

	function new_post()
	{
		$this->load->view('blog/new_post');
	}
	
	function new_post_submit()
	{
		$post = $this->input->post('post');
		
		$this->load->helper('typography');
		$post_styled = auto_typography($post);
	}
	
	function edit_post($id)
	{
		$id = $this->input->xss_clean($id);
		$sql = "select * from blog_posts where id = ?";
		$query = $this->db->query($sql, array($id));
		$data['blog_posts'] = $query->result();
	
		$this->load->view('blog/edit_post',$data);
	}
	
	function edit_post_submit()
	{
		$id = $this->input->post('id');
		
		$title = $this->input->post('title');
		$post = $this->input->post('post');
		$status = $this->input->post('status');
		
		$this->load->helper('date');
		$ts = now();
		
		$this->load->helper('typography');
		$post_styled = auto_typography($post);
		
		$sql = "update blog_posts set title = ?, post = ?, status = ?, ts = ?, post_style = ? where id = $id";

		$query = $this->db->query($sql, array($title,$post,$status,$ts,$post_style));
		
		if ($query)
		{
			redirect('blog','location');
		}
	}
	
	function view($blog_id)
	{
		$blog_id = $this->input->xss_clean($blog_id);
		$sql = "select * from blog_posts where blog_id = ?";
		$query = $this->db->query($sql, array($blog_id));
		$data['blog_posts'] = $query->result();
		
		$this->load->view('blog/view', $data);
	}

}

?>