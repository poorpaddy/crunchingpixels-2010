		<?php if ( function_exists( 'dynamic_sidebar' ) ) : ?>
			 <aside class="home">
				<section class="think">
					<h2>think tank</h2>
					<ul class="list">
					<?php query_posts('cat=99&posts_per_page=5'); while ( have_posts() ) : the_post(); ?>
						<li><a href="<?php echo the_permalink();?>"><?php echo the_title();?></a></li>
					<?php endwhile; wp_reset_query();?>
					</ul>
					<div class="arrow slide1">&ensp;</div>
				</section>
				<section class="fun">
					<h2>fun stuff</h2>
					<ul class="list">
					<?php query_posts( 'cat=3&posts_per_page=5'); while ( have_posts() ) : the_post(); ?>
						<li><a href="<?php echo the_permalink();?>"><?php echo the_title();?></a></li>
					<?php endwhile; wp_reset_query();?>
					</ul>
					<div class="arrow slide2">&ensp;</div>
				</section>
				<section class="portfolio">
					<h2>portfolio</h2>
					<ul class="list">
					<?php query_posts('post_type=portfolio&posts_per_page=5'); while ( have_posts() ) : the_post(); ?>
						<li><a href="<?php echo the_permalink();?>"><?php echo the_title();?></a></li>
					<?php endwhile; wp_reset_query();?>
					</ul>
					<div class="arrow slide3">&ensp;</div>
				</section>
			</aside>
		<?php endif; ?>
			