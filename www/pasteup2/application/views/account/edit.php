<?php
$this->load->view('desk/header');
	print "Profile:<br />";
	foreach ($account as $field)
	{
		$id = $field['id'];
		print "<form action='".base_url()."index.php/account/edit_submit' method='post'>";
		print "<input type='hidden' name='id' value='".$field['id']."' />";
		print "Name: <input type='text' name='name' id='name' value='".$field['name']."' /><br />";
		print "Email: <input type='text' name='email' id='email' value='".$field['email']."' /><br />";
		print "Password: <input type='password' name='password' id='password' /><br />";
		print "Year of graduation:<input type='text' name='grad_year' value='".$field['grad_year']."'>  <br />";
	
		print "<input type='submit' name='edit_submit' value='Edit'  />
		</form><br /><br />";
	}
	
	print "Departments:<br />";
	
	foreach ($dept_level as $dept_level)
	{
		print "<form action='".base_url()."index.php/account/modify_deptlevel' method='post'>";
		print "<input type='hidden' name='id' value='".$dept_level['id']."' />";
		print "<input type='hidden' name='user_id' value='".$dept_level['user_id']."' />";
		print "<select name='department'>";
		foreach ($departments as $department)
		{
			$selected = 0;
			if ($dept_level['department']==$department['id'])
			{
				$selected = "selected";
			}
		
			print "<option value='".$department['id']."'$selected>".$department['department_name']."</option>";
		}
		print "</select>";
		
		print "<select name='level'>";
		for ($i=1;$i<=5;$i++)
		{
			$selected = 0;
			if ($dept_level['level'] == $i)
			{
				$selected = "selected";
			}
			print "<option $selected value='$i'>$i</option>";
		} 
		print "</select>";
		
		print "<input type='submit' name='dept_level_submit' value='Edit'  />";

		print "<a href='".base_url()."index.php/account/remove_deptlevel/".$dept_level['user_id']."/".$dept_level['id']."'>Remove</a> </form>";	
		#link stays in the form so that it remains on the same line
	}
# this begins the new deptlevel form
	print "<form action='".base_url()."index.php/account/new_deptlevel' method='post'>";
	print "<input type='hidden' name='user_id' value='".$id."' />";
	print "<select name='department'>";
	foreach ($departments as $department)
	{
		print "<option value='".$department['id']."'>".$department['department_name']."</option>";
	}
	print "</select>";
	
	print "<select name='level'>";
	for ($i=1;$i<=5;$i++)
	{
		print "<option value='$i'>$i</option>";
	} 
	print "</select>";
	
	print "<input type='submit' name='dept_level_submit' value='New'  />";
	
$this->load->view('desk/footer');
?>
