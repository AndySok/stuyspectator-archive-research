<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Spectator Library
 *
 * Various newspaper related functions.
 *
 * @package		CodeIgniter
 * @subpackage	Library
 * @category	Library
 * @author		Sam Gerstenzang
 * @link		http://www.stuyspectator.com
 */

class Spectator {
	function Spectator()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->helper('url');
		$CI->load->library('session');
	}
	
	/**
	 * User functions
	 */	
	function check_level($level)
	{
		$CI =& get_instance();
		if ($level >= $CI->session->userdata('level'))
		{
			return true;
		}
		else
		{
			redirect('account/login', 'location');
		}
	}
	
	function get_all_departments()
	{
		$CI =& get_instance();
		$query = $CI->db->query("select id,department from departments");
		return $query->result();
	}
	
	function get_department($id)
	{
		$CI =& get_instance();
		$query = $CI->db->query("select department from departments where id = $id");
	 	$result = $query->row();
		return $result->department;
	}

	/**
	 * Newspaper functions
	 */
	
	function get_current_issue()
	{
		$current_issue = get_current_issue();
		$query = $this->db->query("select * from issues order by id desc limit 1");
		$row = $query->row();
		return $row->issue_num;
	}
}


?>
