		<?php if ( function_exists( 'dynamic_sidebar' ) ) : ?>
			 <aside class="home">
				<section class="think">
					<h2>think tank</h2>
					<ul class="list">
					<?php query_posts('cat=99&posts_per_page=5'); while ( have_posts() ) : the_post(); ?>
						<li><a href="<?php echo the_permalink();?>" title="<?php the_title();?>"><?php short_title(); ?></a></li>
					<?php endwhile; wp_reset_query(); ?>
					</ul>
					<div class="arrow slide1">&ensp;</div>
				</section>
				<section class="fun">
					<h2>fun stuff</h2>
					<ul class="list">
					<?php 
						$forfun = array(
							'tax_query' => array(
							'relation' => 'OR',
							array('taxonomy' => 'category', 'field' => 'slug', 'terms' => array('for-fun')),
							array('taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => array('for-fun'))
						), 'showposts'=>5);
						$fun_query = new WP_Query($forfun);
						while ($fun_query->have_posts()) : $fun_query->the_post();
						?>
						<li><a href="<?php echo the_permalink();?>" title="<?php the_title();?>"><?php short_title(); ?></a></li>
						<?php endwhile; wp_reset_query(); ?>
					</ul>
					<div class="arrow slide2">&ensp;</div>
				</section>
				<section class="portfolio">
					<h2>portfolio</h2>
					<ul class="list">
					<?php query_posts('post_type=portfolio&posts_per_page=5'); while ( have_posts() ) : the_post(); ?>
						<li><a href="<?php echo the_permalink();?>" title="<?php the_title();?>"><?php short_title(); ?></a></li>
					<?php endwhile; wp_reset_query(); ?>
					</ul>
					<div class="arrow slide3">&ensp;</div>
				</section>
			</aside>
		<?php endif; ?>
			