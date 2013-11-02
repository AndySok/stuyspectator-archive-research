<?php $this->load->view('header'); ?>


<?php 

	foreach ($top as $article)
	{
		print "<div class='articletitle'>".$article['title']."</div>";
		print "<div class='articleauthor'>".$article['author_name']."</div>	<p>";
		print "<img align='left' src='".base_url()."uploads/".$article['name']."_thumb.jpg' />";
		
		$text = $article['text_styled'];
		
		print substr($text,0,250)."...";
		print"<a href='index.php/home/article/".$article['id']."'>Read more</a>";
		print "</p>";
	}



	foreach ($bottom as $article)
	{
		print "<div class='articletitle'>".$article['title']."</div>";
		print "<div class='articleauthor'>".$article['author_name']."</div>	<p>";
		
		$text = $article['text_styled'];
		
		print substr($text,0,500)."...";
		print"<a href='index.php/home/article/".$article['id']."'>Read more</a>";
		print "</p>";
	}
?>

<?php $exclusive = 1; $this->load->view('footer'); ?>

