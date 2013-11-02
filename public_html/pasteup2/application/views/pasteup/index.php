<?php
	$this->load->view('desk/header');
	
	print "<table border='1'><tr><td>Title</td><td>Photo</td><td>Art</td><td>Lead</td><td>Word count</td><td>Department</td><td>Comments</td><td>Assignments</td><td>Edit</td><td>Delete</td><td>Article text</td>";
	foreach ($articles as $article)
	{
		print "<tr><td>". $article->title ."</td>";
		print "<td>";
		if($article->photo) print 'Photo'; else print 'nada';
		print "</td>";
		print "<td>";
		if($article->art) print 'Art'; else print 'nope';
		print "</td>";
		print "<td>";
		if($article->lead) print 'Lead'; else print 'no way';
		print "</td>";
		print "<td>". $article->word_count ."</td>";
		print "<td>". $article->department_name ."</td>";
		print "<td>". $article->comments ."</td>";
		print "<td><a href='assignment/new_assignment/".$article->id."'>New</a></td>";
		$department = $this->spectator->get_editor_department();
		$managing_department = $this->spectator->get_managing_department();
		if ($article->department == $department or $managing_department)
		{
			print "<td><a href='pasteup/edit_article/". $article->id ."'>Edit</a></td>";
			
			print "<td><a href='pasteup/delete_article/". $article->id ."'>Delete</a></td>";
			print "<td><a href='pasteup/article_text/". $article->id ."'>View</a></td>";
		}
		
		print "</tr>";
	}
	print "</table>";
	print "<a href='pasteup/new_article'>New article</a>";
	$this->load->view('desk/footer');
?>