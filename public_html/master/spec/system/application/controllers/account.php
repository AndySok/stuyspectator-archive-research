<?php

class Account extends Controller {

	function Account()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('spectator');
	}
	
	function index()
	{
		
		if ($this->session->userdata('logged_in'))
		{
			$this->load->view('account/profile');
			$this->load->library('newspaper');
			$this->newspaper->get_current_issue();
		}
		else
		{
			redirect('account/login', 'location');
		}
		
	}
	
	#Sign up form
	function signup()
	{
		$data['departments'] = $this->spectator->get_all_departments();
		$this->load->view('account/signup', $data);
	}
	
	#On sign up submission
	function signup_submit()
	{
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$department = $this->input->post('department');
		
		$password = $this->input->post('password');
		if ($password)
		{
			$this->load->library('encrypt');
			$password = $this->encrypt->encode($password);
		}
		$level = 1;
		$status = 1;
		
		$this->load->helper('date');
		$ts = now();
		
		$sql = "INSERT INTO accounts (first_name, last_name, email, password, department, level, status, ts) 
				VALUES (?, ?, ?, ?, ?, $level, $status, $ts)";
		
		if ($first_name && $last_name && $email && $password)
		{
			$query = $this->db->query($sql, array($first_name, $last_name, $email, $password, $department));
			if ($query)
			{
				print "Success";
			}
			else
			{
				print "Failure";
			}
		}
		else
		{
			print "You forgot to fill in a field.";
		}
	}
	
	#Login form
	function login()
	{
		$this->load->view("account/login");
	}
	
	#On login submission
	function login_submit()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if ($email && $password)
		{
			$this->load->library('encrypt');
			
			$query = $this->db->get('accounts');
			$login_result = false;
			foreach ($query->result() as $row)
			{
				if($row->email == $email && $this->encrypt->decode("$row->password") == $password)
				{
					$login_result = true;
					$id = $row->id;
					$level = $row->level;
					
					$department = $this->$spectator->get_department($row->department);
				}
			}
			
			if($login_result == true)
			{
				
				$userdata = array(
				                   'id'    	   => $id,
				                   'level'  => $level,
								   'department' => $department,
				                   'logged_in' => TRUE
				               );

				$this->session->set_userdata($userdata);
				redirect('','location');
			}
			else
			{
				redirect('account/login_fail/', 'location');
			}
		}
		else
		{
			print "You forgot to fill in a field.";
		}
	}
	
	#When a login goes bad...
	function login_fail()
	{
		$this->load->view('account/login_fail');
	}
	
	#To logout
	function logout()
	{
		$this->session->sess_destroy();
		redirect('', 'location');
	}
}
?>