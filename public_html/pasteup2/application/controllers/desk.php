<?php

class Desk extends Controller {

	function Welcome()
	{
		parent::Controller();
	}
	
	function index()
	{
		if (!$this->spectator->check_level(2))
		{
			redirect('account/login','location');
		}
		$this->load->view('desk/home');
	}
}
?>