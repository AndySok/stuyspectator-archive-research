<?php get_header(); ?>        
        
        <div id="topbanner" class="column span-14">   <!-- start top banner -->
            <div class="pagetitle">
                // uh oh!
            </div>
        </div>   <!-- end top banner -->
        
        
        <div id="arch_content" class="column span-14">   <!-- start home_content -->
        
           	<div class="column span-3 first">        
            	<h2 class="archive_name"><?php bloginfo('name'); ?></h2>        
            	
            	<div class="archive_meta">
            	
            		<div class="archive_feed">
            			<a href="<?php bloginfo('rss2_url'); ?>">RSS feed for <?php bloginfo('name'); ?></a>		
            		</div>
            	
            	</div>
            </div>
            
                        
            <div class="column span-8">
            
            	<p><strong>Oops! Easy, tiger.</strong></p>
            
		<p>You are <em>totally</em> in the wrong place. Do not pass GO; do not collect $200.</p>

            	<p>Looks like the page you're looking for has been moved or had its name changed. Or maybe it's just fate. Instead, you could use the search box in the header to search for what you're looking for, or begin again from the <a href="<?php echo get_option('home'); ?>/">home page</a>.
            	
				<p>Try one of the following:</p>
				<ul>
					<li>Hit the "back" button on your browser.</li>
					<li>Head on over to the <a href="http://stuyspectator.com/">frontpage</a>.</li>
					<li>Try searching using the box above or below.</li>
					<li>Click on a link in the sidebar.</li>
					<li>Use the navigation menu at the top of the page.</li>
					<li>Punt.</li>
				</ul>
				<p>We recently changed the structure of the PDF links. Please proceed to <a href="/archives/pdfs/">the listing</a>.</p>

<div id="cse" style="width: 100%;">Loading</div>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
   google.load('search', '1');
   google.setOnLoadCallback(function(){
      new google.search.CustomSearchControl('000339603842136090691:posfatx_cb0').draw('cse');
   }, true);
</script>

            </div>
            
            <?php get_sidebar(); ?>
        
        </div>   <!-- start home_content -->
        
        
<?php get_footer(); ?>
