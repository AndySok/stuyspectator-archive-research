<?php

class Upload extends Controller {
	
	function Upload()
	{
		parent::Controller();
		$this->load->helper(array('form', 'url'));
		if (!$this->spectator->check_level(2))
		{
			redirect('account/login','location');
		}
	}
	
	
	function index()
	{	
		$this->load->view('upload/upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
			
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload())
		{
			print $this->upload->display_errors();
			
		}
		else
		{
			
			$image_info = $this->upload->data();
			
			$name = $image_info['raw_name'];
			$file_name = $image_info['file_name'];
			$file_path = $image_info['file_path'];
			
			#Image thumbnail
			$config['image_library'] = 'GD';
			$config['source_image']	= $file_path.$file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 300;
			$config['height']	= 200;

			$this->load->library('image_lib', $config); 
			$this->image_lib->resize();
			
			#...and back to variable assignment
			$caption = $this->input->post('caption');
			$comment = $this->input->post('comment');		
		
			$user_id= $this->session->userdata('id');
			
			$this->load->helper('date');
			$ts = now();
		
			$sql = "insert into images (name, file_name, file_path, creator_id, caption, comment,ts) values(?,?,?,$user_id, ?, ?, $ts)";
			
			$query = $this->db->query($sql, array($name, $file_name, $file_path, $caption, $comment));
			
			if ($query)
			{
				$data = array('upload_data' => $this->upload->data());

				$this->load->view('upload/upload_success', $data);		
			} 
		}
	}
	
	function my_uploads()
	{
		$user_id = $this->session->userdata('id');
		
		$sql = "select * from images where creator_id = $user_id";
		$query = $this->db->query($sql);
		$data['images'] = $query->result_array();
		
		$current_issue = $this->spectator->get_current_issue();
		$sql = "select * from articles where issue = $current_issue";
		$query = $this->db->query($sql);
		$data['assignments'] = $query->result_array();
		
		$this->load->view('upload/my_uploads', $data);
	}
	
	function attach()
	{
		$article_id = $this->input->post('article_id');
		$photo_id = $this->input->post('photo_id');
		
		$sql = "update images set article_id = ? where id = ?";
		
		$query =  $this->db->query($sql, array($article_id, $photo_id));
		
		if($query)
		{
			redirect('upload/my_uploads','location');
		}
	}
	
	function delete($id)
	{
		$id = $this->input->xss_clean($id);
		$sql = "delete from images where id = ?";
		$query = $this->db->query($sql, array($id));
		
		if ($query)
		{
			redirect('upload', 'location');
		}
	}
}
?>