<?php
/*
Template Name: Archive Page
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="breadcrumb">
			<?php if (class_exists('breadcrumb_navigation_xt')) {
			echo 'Browse > ';
			// New breadcrumb object
			$mybreadcrumb = new breadcrumb_navigation_xt;
			// Options for breadcrumb_navigation_xt
			$mybreadcrumb->opt['title_blog'] = 'Home';
			$mybreadcrumb->opt['separator'] = ' / ';
			$mybreadcrumb->opt['singleblogpost_category_display'] = true;
			// Display the breadcrumb
			$mybreadcrumb->display();
			} ?>	
		</div>
		
		<h1>Site Archives</h1><br />
		
		<div class="archive">

			<b>by page:</b>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
		
			<b>by month:</b>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
					
			<b>by category:</b>
				<ul>
					<?php wp_list_categories('sort_column=name&title_li='); ?>
				</ul>

		</div>
		
		<div class="archive">
			
			<b>by post:</b>
				<ul>
					<?php get_archives('postbypost', 100); ?>
				</ul>
		</div>
		
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>