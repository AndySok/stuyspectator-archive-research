<?php
	$this->load->view('desk/header');
print "<form action='".base_url()."index.php/pasteup/article_text_submit' method='post'>";
if ($articles) {
	foreach ($articles as $article) {
		print "<input type='hidden' name ='id' value='".$article['id']."' />";
		print "<textarea cols='80' rows ='30' name='article_text'>".$article['text']."</textarea><br />";

		print "Written by: <input type='text' name='author_name' value='".$article['author_name']."' />";
	}
}
else {
	print "<input type='hidden' name ='new' value='true' />";
	print "<input type='hidden' name ='article_id' value='$article_id' />";
	print "<textarea cols='80' rows ='30' name='article_text'></textarea><br />";

	print "Written by: <input type='text' name='author_name' value='' />";
}

	print "<input type='submit' value='Submit'  /> </form>";
	
	$this->load->view('desk/footer');
?>