<?php
	$this->load->view('desk/header');


	print "<form action='manual_submit' method='post'>";
	
	print "Title: <input type='text' name='title' id='title'></input><br />";
	print "Lead:  <input type='checkbox' name='lead' value='lead'><br />";
	print "Author: <input type='text' name='author_name' id='author_name'></input><br /";
	print "Article: <textarea cols='50' rows ='10' name='article_text' id='article_text' /></textarea><br />";
	

	
	if ($managing_department)
	{
		print "Department:";
		print "<select name='department'>";
		foreach ($departments as $department)
		{
			print "<option value='".$department['id'] ."'>".$department['department_name']."</option>";
		}
		print "</select><br />";
	}
	else
	{
		print "<input type='hidden' value='".$editor_department."' name='department'>";
		
	}
	
	
	print "Type: <select name='type'>";
	print "<option value='print'>Print</option>";
	print "<option value='web'>Web</option>";
	print "</select><br />";
	
	print "<input type='submit' name='article_text_submit' value='Submit'  />
	</form>";
	
	$this->load->view('desk/footer');
?>