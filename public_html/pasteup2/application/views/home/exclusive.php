<?php $this->load->view('header'); ?>


<?php 
	print "<h1> Web Exclusive</h1>";
	foreach ($articles as $article)
	{
		print "<div class='articletitle'>".$article['title']."</div>";
		print "<div class='articleauthor'>".$article['author_name']."</div>	<p>";
		
		$text = $article['text_styled'];
		
		print substr($text,0,100)."...";
		print"<a href='".base_url()."index.php/home/article/".$article['id']."'>Read more...</a>";
		print "<br />";
	}

?>

<?php $this->load->view('footer'); ?>
