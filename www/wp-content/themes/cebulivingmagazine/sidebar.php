		<div class="yui-u">
			<div class="topbrown">
				<?php include(TEMPLATEPATH . '/searchform.php') ; ?>
				<div class="curlycontainer">
				<div class="innerdiv">
        <h2>Recent Articles</h2>
        <ul>
        <?php query_posts('showposts=15'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
				<?php endwhile; endif; ?>
				</ul>
				</div>
				</div>
				<div class="topyellow">
				<?php include(TEMPLATEPATH . '/promobox.php') ; ?>
				</div>
				<div class="topdarkblue">
				<h2>Weather</h2>
<script src="http://netwx.accuweather.com/netweatherV2.asp?zipcode=10282&lang=eng&size=5&theme=1&metric=0"></script>
				</div>
		</div>
	    </div>

		</div>	
		</div>
	</div>