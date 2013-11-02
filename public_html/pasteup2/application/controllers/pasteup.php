<?php

class Pasteup extends Controller {

	function Pasteup()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		if (!$this->spectator->check_level(3))
		{
			redirect('account/login','location');
		}
	}
	
	function index()
	{ 
		$current = $this->spectator->get_current_issue();

		if (func_num_args() >= 1)
		{
			$department = $this->input->xss_clean(func_get_arg(0));
		}

		if (isset($department))
		{
			$sql = "select articles.*, departments.department_name from articles,departments where articles.department = $department and articles.issue = $current and articles.department = departments.id";
			$query = $this->db->query($sql, array ($department));
		}
		else
		{
			$sql ="select articles.*, departments.department_name from articles,departments where  articles.issue = $current and articles.department = departments.id order by departments.department_name asc";
			$query = $this->db->query($sql);
		}
		$data['articles'] = $query->result();
		$this->load->view('pasteup/index', $data);
	}
	
	function new_article()
	{
		$data['issue'] = $this->spectator->get_current_issue();
		$this->load->view('pasteup/new_article', $data);
	}
	
	function new_article_submit()
	{
		$issue = $this->input->post('issue');
		$title = $this->input->post('title');
		$photo = $this->input->post('photo');
		$art = $this->input->post('art');
		$lead = $this->input->post('lead');
		$word_count = $this->input->post('word_count');
		$comments = $this->input->post('comments');
		
		$department = $this->spectator->get_editor_department();
		$status = 1;
		$this->load->helper('date');
		$ts = now();
		
		
		$sql = "insert into articles (issue,title, photo, art, lead, word_count, department, comments, status, ts) values (?,?,?,?,?,?,$department,?,$status,$ts)";
		$query = $this->db->query($sql, array($issue,
											  $title,
											  $photo,
											  $art,
											  $lead,
											  $word_count,
											  $comments));
		if ($query)
		{
			redirect('pasteup', 'location');
		}
		else
		{
			print "Failure adding article";
		}
	}
	
	function edit_article($id) 
	{
		$id = $this->input->xss_clean($id);
		$sql = "select * from articles where id = ? limit 1";
		$query = $this->db->query($sql, array($id));
		$data['article'] = $query->result_array();
		$this->load->view('pasteup/edit_article', $data);
	}
	
	function edit_article_submit()
	{
			$id = $this->input->post('id');
			$title = $this->input->post('title');
			$photo = $this->input->post('photo');
			$art = $this->input->post('art');
			$lead = $this->input->post('lead');
			$word_count = $this->input->post('word_count');
			$comments = $this->input->post('comments');

			$department = $this->spectator->get_editor_department();
			$status = 1;
			$this->load->helper('date');
			$ts = now();

			$sql = "update articles set title = ?, photo = ?, art = ?, lead = ?, word_count = ?,department = $department, comments = ?, status = $status, ts = $ts where id = $id";
			$query = $this->db->query($sql, array($title,
												  $photo,
												  $art,
												  $lead,
												  $word_count,
												  $comments));
			if ($query)
			{
				redirect('pasteup', 'location');
			}
			else
			{
				print "Failure adding article";
			}
	}
	
	function delete_article($id)
	{
		$id = $this->input->xss_clean($id);
		$sql = "delete from articles where id = ?";
		$query = $this->db->query($sql, array($id));
		
		if ($query)
		{
			redirect('pasteup','location');
		}
	}
	
	function new_volume()
	{
		if (!$this->spectator->check_level(4))
		{
			redirect('account/login','location');
		}
		$this->load->view('pasteup/new_volume');
	}
	
	function new_volume_submit()
	{
		if (!$this->spectator->check_level(4))
		{
			redirect('account/login','location');
		}
		$volume = $this->input->post('volume');
		$comment = $this->input->post('comment');

		$sql = "insert into volumes (volume, comment) values (?,?)";
		$query = $this->db->query($sql, array($volume, $comment));
		if ($query)
		{
			redirect('pasteup', 'location');
		}
		{
			print "Error creating new volume.";
		}
	}
	
	function issue_manager()
	{
		if (!$this->spectator->check_level(4))
		{
			redirect('account/login','location');
		}
		
		$sql = "select * from volumes";
		$query = $this->db->query($sql);
		foreach ($query->result() as $volume) {
			$volume_id = $volume->id;
			$volume_name = $volume->volume;
			$sql2 = "select * from issues where volume = $volume_id";
			$query2 = $this->db->query($sql2);
			$volume_array[$volume_name] = $query2->result_array();
		}
		$data['volume_array'] = $volume_array;
		$this->load->view('pasteup/issue_manager',$data);
	}
	
	function new_issue()
	{
		if (!$this->spectator->check_level(4))
		{
			redirect('account/login','location');
		}
		$data['volumes'] = $this->spectator->get_all_volumes();
		$this->load->view('pasteup/new_issue', $data);
	}
	
	function new_issue_submit()
	{
		if (!$this->spectator->check_level(4))
		{
			redirect('account/login','location');
		}
		$issue_num = $this->input->post('issue_num');
		$volume = $this->input->post('volume');
		$comment = $this->input->post('comment');
		
		$sql = "insert into issues (issue_num, volume, comment) values (?,?,?)";
		$query = $this->db->query($sql, array($issue_num, $volume, $comment));
		if ($query)
		{
			redirect('pasteup', 'location');
		}
		{
			print "Error creating new issue.";
		}
	}

	function article_text($id)
	{
		// $department_id = $this->spectator->get_editor_department();
		// $data['accounts'] = $this->spectator->get_users_in_department($department_id);
		
		$id = $this->input->xss_clean($id);
		$sql = "select * from article_text where article_id = ?";
		$query = $this->db->query($sql, array($id));
		$data['article_id'] = $id;
		$data['articles'] = $query->result_array();
		
		if ($query)
		{
			$this->load->view('pasteup/article_text', $data);
		}
	}
	
	function article_text_submit()
	{
		$author_name = $this->input->post('author_name');
		$text = $this->input->post('article_text');
		
		$this->load->helper('typography');
		$text_styled = auto_typography($text);
		
		$this->load->helper('date');
		$ts = now();
		
		if ($this->input->post('new')) {
			$article_id = $this->input->post('article_id');
			$sql = "insert into article_text (article_id, author_name, text, text_styled, ts, status) values (?,?,?,?, $ts, 1)";
			$query = $this->db->query($sql, array($article_id, $author_name, $text, $text_styled));
		}
		else {
			$id = $this->input->post('id');
			$sql = "update article_text set author_name = ?, text = ?, text_styled = ?, ts = $ts where id = ?";
			$query = $this->db->query($sql, array($author_name, $text, $text_styled, $id));
		}

			
		if ($query)
		{
			redirect('pasteup','location');
		}
		
	}
	
	function manual()
	{
		$sql = "select * from departments";
		$query = $this->db->query($sql);
		$data['departments'] = $query->result_array();
		$data['editor_department'] = $this->spectator->get_editor_department();
		$data['managing_department'] = $this->spectator->get_managing_department();
		$this->load->view('pasteup/manual', $data);
	}
	
	function manual_submit()
	{
		$title = $this->input->post('title');
		$lead = $this->input->post('lead');
		if ($lead == "lead")
		{
			$lead = 1;
		}
		else
		{
			$lead = 0;
		}
		$issue = $this->spectator->get_current_issue();
		$department = $this->input->post('department');
		$type = $this->input->post('type');
		$this->load->helper('date');
		$ts = now();
		
		$author_name = $this->input->post('author_name');
		$text = $this->input->post('article_text');
		
		$this->load->helper('typography');
		$text_styled = auto_typography($text);
		
		
		$sql = "insert into articles (title,lead,department,issue,status,type,ts) values (?,?,?,?,1,?,$ts)";
		$query = $this->db->query($sql, array($title,$lead,$department,$issue, $type));
		if ($query)
		{
			#the following line does not work in multiuser enviroments because of a codeigniter bug. instead we use the native postgresql.
			#$id = $this->db->insert_id();
			$sql = "insert into article_text (article_id,author_name,text,text_styled, status, ts) values (currval('articles_id_seq'),?,?,?,1,$ts)";

			$query = $this->db->query($sql, array($author_name,$text, $text_styled));
			
			print $this->db->last_query();
			#if ($query)
			#{
			#	redirect('pasteup/manual','location');
			#}
		}
	}
	

}
?>