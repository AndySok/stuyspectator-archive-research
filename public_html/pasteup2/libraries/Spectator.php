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
		$id = $CI->session->userdata('id');
	
		if ($id)
		{
			$sql = "select * from dept_level where id = $id";
			#FIX THIS HERE
			foreach($CI->session->userdata('department') as $department)
			if ($department['level'] < $level)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	function get_all_departments()
	{
		$CI =& get_instance();
		$query = $CI->db->query("select id,department from departments");
		return $query->result();
	}

	
	function get_my_department($level)
	{
		
		$sql = "select * from dept_level where user_id = $user_id and level = $level";
		$query = $CI->db->query($sql);	
	}
	
	function get_editor_department()
	{
		$CI =& get_instance();
		$user_id = $CI->session->userdata('id');
		$sql = "select * from dept_level where user_id = $user_id and level = 3 limit 1";
		$query = $CI->db->query($sql);
		$result = $query->row();
		
		if ($query->num_rows() == 0)
		{
			return false;
		}
		else
		{
			return $result->department;
		}	
	}
	
	function get_managing_department()
	{
		$CI =& get_instance();
		$user_id = $CI->session->userdata('id');
		$sql = "select * from dept_level where user_id = $user_id and level >= 4 limit 1";
		$query = $CI->db->query($sql);
		$result = $query->row();
		
		if ($query->num_rows() == 0)
		{
			return false;
		}
		else
		{
			return $result->department;
		}	
	}
	
	function get_users_in_department($id)
	{
		$CI =& get_instance();
		$sql = "select accounts.* from accounts,dept_level where dept_level.department = ? and dept_level.user_id = accounts.id";
		$query = $CI->db->query($sql, array($id));
		
		return $query->result_array();
	}

	/**
	 * Newspaper functions
	 */
	
	function get_current_issue()
	{
		$CI =& get_instance();
		$query = $CI->db->query("select id from issues order by id desc limit 1");
		$row = $query->row();
		return $row->id;
	}
	
	function get_all_issues()
	{
		$CI =& get_instance();
		$query = $CI->db->query("select * from issues");
		return $query->result();
	}
	
	function get_current_volume()
	{
		$query = $CI->db->query("select * from volumes order by volume desc limit 1");
		$row = $query->row();
		return $row->issue_num;
	}
	
	function get_all_volumes()
	{
		$CI =& get_instance();
		$query = $CI->db->query("select * from volumes");
		return $query->result();
	}

	function convert_smart_quotes($string) 
	{     
	    $search = array(chr(145),chr(146),chr(147),chr(148));  
	    // OR   $search = array('‘','’','“','”');   
	    $replace = array('&lsquo;','&rsquo;','&ldquo;','&rdquo;');     
	    return str_replace($search, $replace, $string); 
	}
}


?>
