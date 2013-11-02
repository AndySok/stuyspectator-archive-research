<?php

class Account extends Controller {

	function Account()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->view('account/profile');
	}
	
	#Sign up form
	function signup()
	{
		$this->load->view('account/signup');
	}
	
	#On sign up submission
	function signup_submit()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$grad_year = $this->input->post('grad_year');
		$is_staff = 0;
		if ($this->input->post('is_staff'))
		{
			$is_staff =1;
		}
		$password = $this->input->post('password');
		if ($password)
		{
			$this->load->library('encrypt');
			$password = $this->encrypt->encode($password);
		}
		$status = 1;
		
		$this->load->helper('date');
		$ts = now();
		
		$sql = "insert into accounts (name, email, password, status, grad_year, is_staff, ts) 
				values (?, ?, ?, $status, ?, ?, $ts)";
		
		if ($name && $email && $password)
		{
			$query = $this->db->query($sql, array($name, $email, $password, $grad_year, $is_staff));
			if ($query)
			{
				print "Yay! Your account was created. Before you login, your account might have to be approved";
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
					$sql = "select * from dept_level where user_id = $id";
					$query = $this->db->query($sql);
					$department = $query->result_array();
				}
			}
			
			if($login_result == true)
			{
				
				$userdata = array(
				                   'id' => $id,
								   'department' => $department,
				                   'logged_in' => TRUE
				               );

				$this->session->set_userdata($userdata);
				redirect('desk','location');
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
	
	function edit_profile()
	{
		
	}
	
	#lists all department underlings, available for level 3 and higher
	function list_all()
	{
		if (!$this->spectator->check_level(3))
		{
			redirect('account/login', 'location');
		}
			$accounts = array();
			
			$sql = "select * from accounts  order by id";
			$query = $this->db->query($sql);
			$results = $query->result();
			
			foreach ($results as $result)
			{
				$account = array();
				
				$account['id'] = $result->id;
				$account['name'] = $result->name;
				$account['email'] = $result->email;
				$account['status'] = $result->status;
				$user_id = $result->id;
				$sql = "select dept_level.*, departments.department_name from dept_level,departments where user_id = $user_id and dept_level.department = departments.id";
				$query = $this->db->query($sql);
				$results2 = $query->result();
				
				$departments = array();
				foreach ($results2 as $result2)
				{
					$departments[] = $result2->department_name."(".$result2->level.")";
				}
				$account['departments'] = $departments;
				
				$accounts[] = $account;
			}
			
			$data['accounts'] = $accounts;
			$this->load->view('account/list_all', $data);
	}
	
	function edit($id)
	{
		$id = $this->input->xss_clean($id);
		
		$sql = "select * from accounts where id = ?";
		$query = $this->db->query($sql,array($id));
		$result = $query->result_array();
		$data['account'] = $result;
		
		$sql = "select dept_level.*,departments.department_name from dept_level,departments where user_id = $id and dept_level.department = departments.id";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$data['dept_level'] = $result;
		
		$sql = "select * from departments";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$data['departments'] = $result;
		
		$this->load->view('account/edit', $data);
	}
	
	function edit_submit()
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$grad_year = $this->input->post('grad_year');
		
		
		if ($password)
		{
			$this->load->library('encrypt');
			$password = $this->encrypt->encode($password);
			$sql = "update accounts set name = ?, email = ?, password = ?, grad_year = ? where id = ?";
			$query = $this->db->query($sql, array($name, $email, $password, $grad_year, $id));
		}
		else
		{
			$sql = "update accounts set name = ?, email = ?, grad_year = ? where id = ?";
			$query = $this->db->query($sql, array($name, $email, $grad_year, $id));
		}
		
		if ($query)
		{
			redirect("account/edit/$id",'location');
		}
	}
	
	function delete($id)
	{
		$id = $this->input->xss_clean($id);
		$sql= "delete from accounts where id = ?";
		
		$query = $this->db->query($sql,array($id));
		
		if ($query)
		{
			redirect('account/list_all','location');
		}
	}
	
	#The following functions deal with department-level associations
	
	function remove_deptlevel($user_id,$id)
	{
		$id = $this->input->xss_clean($id);
		$sql= "delete from dept_level where id = ?";

		$query = $this->db->query($sql,array($id));

		if ($query)
		{
			redirect("account/edit/$user_id",'location');
		}
	}
	
	function modify_deptlevel()
	{
		$id = $this->input->post('id');
		$user_id = $this->input->post('user_id');
		$department = $this->input->post('department');
		$level = $this->input->post('level');
		
		$sql = "update dept_level set department = ?, level = ? where id = ?";
		$query = $this->db->query($sql,array($department, $level, $id));
		if ($query)
		{
			redirect("account/edit/$user_id",'location');
		}
	}
	
	function new_deptlevel()
	{
		$user_id = $this->input->post('user_id');
		$department = $this->input->post('department');
		$level = $this->input->post('level');
		$this->load->helper('date');
		$ts = now();
		
		$sql = "insert into dept_level(user_id,department,level,ts) values (?,?,?, $ts)";
		$query = $this->db->query($sql,array($user_id,$department,$level));
		if ($query)
		{
			redirect("account/edit/$user_id",'location');
		}
	}
}
?>