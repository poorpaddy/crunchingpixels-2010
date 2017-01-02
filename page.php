<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="wrapper portfolio-item">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	<?php endwhile;
	else: ?>
		<p>Sorry, the page you are looking for has been moved or deleted.</p>
	<?php endif; ?>
		<?php get_footer(); ?>
