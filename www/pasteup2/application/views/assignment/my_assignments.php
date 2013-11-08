<?php
	$this->load->view('desk/header');

	print "<table border='1'><tr><td>Assignment</td><td>Details</td><td>Department</td><td>Assigned to</td><td>Done?</td>";
	foreach ($my_assignments as $my_assignment)
	{
		print "<tr><td>". $my_assignment->title ."</td>";
		print "<td>". $my_assignment->details ."</td>";
		print "<td>". $my_assignment->department_name ."</td>";
		print "<td>Me</td>";
		print "<td>". $my_assignment->status ."</td>";

		print "</tr>";
	}
	print "</table><br />";
	if ($this->spectator->get_editor_department())
	{
		print "My Staff's Assignments <br /><table border='1'><tr><td>Assignment</td><td>Details</td><td>Department</td><td>Assigned to</td><td>Done?</td>";
		foreach ($department_assignments as $assignment)
		{
			print "<tr><td>". $assignment->title ."</td>";
			print "<td>". $assignment->details ."</td>";
			print "<td>".$assignment->department_name."</td>";
			print "<td>".$assignment->assigned_to."</td>";
			print "<td>". $assignment->status ."</td>";

			print "</tr>";
		}
		print "</table>";
	}

	$this->load->view('desk/footer');
?>