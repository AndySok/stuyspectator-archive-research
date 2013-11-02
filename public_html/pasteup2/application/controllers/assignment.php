<?php

class Assignment extends Controller {

	function Assignment()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		if (!$this->spectator->check_level(2))
		{
			redirect('account/login','location');
		}
	}
	
	function index()
	{
		$user_id = $this->session->userdata('id');
		$issue_num = $this->spectator->get_current_issue();
		
		$sql = "select assignments.*,departments.department_name from assignments, departments where assignments.assigned_to = $user_id and assignments.status = 0 and assignments.issue_num = $issue_num and assignments.department = departments.id";
		print $sql;
		$query = $this->db->query($sql);
		$data['my_assignments'] = $query->result();
		
		$department = $this->spectator->get_editor_department();
		
		if ($department)
		{
			$sql = "select assignments.*, departments.department_name from assignments, departments where department = $department and status = 0 and issue_num = $issue_num and assignments.department = departments.id";
			$query = $this->db->query($sql);
			$data['department_assignments'] = $query->result();
			
			$sql = "select accounts.*, dept_level.department from accounts, dept_level where dept_level.department = $department and accounts.id = dept_level.user_id";
			$query = $this->db->query($sql);
			$data['department_accounts'] = $query->result();
		}

		
		$this->load->view('assignment/my_assignments', $data);
	}
	
	function new_assignment($article_id)
	{
		$data["article_id"] = $article_id;
		$this->load->view('assignment/new_assignment', $data);
	}
	
	function new_assignment_submit()
	{
		$issue_num = $this->spectator->get_current_issue();
		$article_id = $this->input->post('article_id');
		$type = $this->input->post('type');
		$title = $this->input->post('title');
		$details = $this->input->post('details');
		$department = $this->spectator->get_editor_department();
		
		$sql = "insert into assignments (issue_num, article_id, department, title, details, status) values (?,?,?,?,?,0)";
		
		$query = $this->db->query($sql, array($issue_num,$article_id, $department, $title, $details));
		
		if ($query)
		{
			redirect('assignment', 'location');
		}
		
	}
	
	function my_department_assignments()
	{
		
	}
	
	function request_assignment($id)
	{
		
	}
	

}

?>