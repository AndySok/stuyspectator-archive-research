<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
		
	<div id="content_box">

		<div id="content" class="pages">
		
			<h2>Browse the Archives...</h2>
			<div class="entry">
				<h3 class="top">by month:</h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
				<h3>by Category:</h3>
				<ul>
					<?php wp_list_categories('title_li=0'); ?>
				</ul>
				<h3>PDF:</h3>
				<ul>
					<li><a href="http://stuyspectator.com/pdf/TheSpectatorIssue1-2007.pdf">Issue 1-2007</a></li>
					<li><a href="http://stuyspectator.com/pdf/TheSpectatorIssue2-2007.pdf">Issue 2-2007</a></li>
					<li><a href="http://stuyspectator.com/pdf/TheSpectatorIssue3-2007.pdf">Issue 3-2007</a></li>
					
				</ul>
				Watch out: these files are large (~20 MB).
			</div>
			<div class="clear rule"></div>
			
		</div>	
		
		<?php include (TEMPLATEPATH . '/sidebar.php'); ?>
		
		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>
			
	</div>
		
<?php get_footer(); ?>