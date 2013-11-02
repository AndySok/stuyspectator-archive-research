	<div id="rightcontent">
		<h1>Web Exclusives </h1>
		<ul>
		
			<?php
				foreach ($web as $web)
				{
					print "<li><div class='articletitle'>".$web['title']."</div>";

					$text = $web['text_styled'];

					print substr($text,0,30)."...";
					print"<a href='".base_url()."index.php/home/article/".$web['id']."'>Read more</a></li>";
				}
			?>
		</ul>
		
	
		
	</div>

</div>

</div>



<div id="footer"></div>
</div>

</div>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2442364-1";
urchinTracker();
</script>
</body>

</html> 
