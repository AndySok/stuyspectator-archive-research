<?php
	$this->load->view('desk/header');
	foreach($images as $image)
	{
		print "<img src='/spec/uploads/".$image['file_name']."' />";
		print "<br />Name: ".$image['name'];
		print "<br />Caption: ".$image['caption'];
		print "<br />Comment: ".$image['comment'];
		print "<br />Attach to: ";
		print "<form action='attach' method='post'><select name='article_id'>";
		
		#this is temporarily articles, not assignments
		foreach ($assignments as $assignment)
		{
			print "<option value='".$assignment['id'] ."'>".$assignment['title']."</option>";
		}
		print "</select>";
		print "<input type='hidden' name='photo_id' value='".$image['id']."' />";
		print "<input type='submit' name='attach_photo' value='Attach'  /> </form><br />";
		print "<a href='delete/".$image['id']."'>Delete</a>";
	}
	
	$this->load->view('desk/footer');
?>
