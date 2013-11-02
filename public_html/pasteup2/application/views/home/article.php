<?php $this->load->view('header'); ?>


<?php 


foreach ($article as $article)
{
	
	print "<div class='articletitle'>".$article['title']."</div>";
	print "<div class='articleauthor'>".$article['author_name']."</div>	<p>";
	foreach ($image as $image)
	{
		print "<img src='".base_url()."uploads/".$image['name']."_thumb.jpg' />";
	}
	$text = $article['text_styled'];
	
	print $text;
	print "</p>";
}

?>

<?php $this->load->view('alt_footer'); ?>
