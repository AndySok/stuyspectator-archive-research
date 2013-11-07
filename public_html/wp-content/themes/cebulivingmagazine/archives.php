<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
   <div id="bd">
   	<div id="singlepanel">
   		<div class="yui-ge">
   			
    		<div class="yui-u first">
    			<div class="topdarkblue">
				<h1>Archives</h1>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
       <h2>Archives by Month:</h2>
	     <ul>
		      <?php wp_get_archives('type=monthly'); ?>
	     </ul><br />

       <h2>Archives by Subject:</h2>
	     <ul>
		      <?php wp_list_categories(); ?>
 	     </ul><br />

	<h2>PDF:</h2>
		<ul>
<li><a href="http://stuyspectator.com/pdf/TheSpectatorIssue1-2007.pdf">Issue 1-2007</a></li>
			<li><a href="http://stuyspectator.com/pdf/TheSpectatorIssue2-2007.pdf">Issue 2-2007</a></li>
			<li><a href="http://stuyspectator.com/pdf/TheSpectatorIssue3-2007.pdf">Issue 3-2007</a></li>			
		</ul>
	<p>Watch out: these files are large (~20 MB). </p>
	<p>If you're looking for the past, our <a href="http://stuyspectator.com/spectator/">previous site (2001-2006)</a> has <a href="http://stuyspectator.com/spectator/archives.cgi">extensive archives</a>. The Wayback Machine also has archives from <a href="http://web.archive.org/web/*/http://spectator.stuy.edu/">2002-2005</a> as well as from <a href="http://web.archive.org/web/*/http://stuyspectator.org/">2001</a>. </p>

				</div>
	    	</div>
			
<?php get_sidebar(); ?>
<?php get_footer(); ?>
