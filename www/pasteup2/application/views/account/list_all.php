<?php $this->load->view('desk/header'); ?>
<table border='1'><tr><td>Name</td><td>Email</td><td>Status</td><td>Departments</td><td>Edit</td><td>Delete</td>
<?php
	foreach ($accounts as $account)
	{
		print "<tr><td>". $account['name'] ."</td>";
		print "<td>". $account['email'] ."</td>";
		print "<td>". $account['status'] ."</td>";
		print "<td>";
		if (is_array($account['departments']))
		{
			foreach ($account['departments'] as $department)
			{
				print $department;
			}
		}
	
		print "</td>";
		print "<td><a href='edit/". $account['id'] ."'>Edit</a></td>";
		print "<td><a href='delete/". $account['id'] ."'>Delete</a></td>";
		print "</tr>";
	}
	print "</table>";
	print "<a href='signup'>New account</a>";
	$this->load->view('desk/footer');
?>