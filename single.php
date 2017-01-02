<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php if($post->post_type=='post'):?>
			<div class="wrapper blog-list">
			<h1><?php the_title();?></h1>
			<div class="lcol">
				<div class="meta">
					<?php $categories1= get_the_category($post->ID);
					foreach($categories1 as $cat_new) {?>
					<a href="<?php echo site_url(); ?>/resources/topic/<?php echo $cat_new->slug;?>" class="category"><?php echo $cat_new->cat_name;?></a>
					<?php } ?>
					<span class="info"><?php echo get_the_date('F j, Y'); ?></span>
					<a href="#commentsSection" class="comments"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a>
				</div>
				<?php the_content();?>
				<div class="commentarea"><a name="commentsSection"></a><?php comments_template(); ?></div>
			</div>
			<div class="rcol">
				<aside class="categories">
					<section>
						<h3>Topics</h3>
						<ul class="list">
							<?php
								$table_name = "term_taxonomy"; // Assign the table name we wish to query
								$table = $table_prefix . $table_name; // Put it all together
								$queryresult = $wpdb->get_results("SELECT * FROM " . $table." WHERE parent='0' and taxonomy='category'");
								foreach($queryresult as $result) {
									$table_name1 = "terms"; // Assign the table name we wish to query
									$table1 = $table_prefix . $table_name1; // Put it all together
									$queryresult1 = $wpdb->get_results("SELECT * FROM " . $table1." WHERE term_id='".$result->term_id."'");
									foreach($queryresult1 as $result1) {
										if($result1->name=='Uncategorized') {
											$result1->name='All';
										}
									if($category_id=='') {
										$get_catid=1;
									}
									else {
										$get_catid=$category_id;
									}
									
									if($result1->term_id!='' && $result1->term_id!=1) {
										 $my_query = new WP_Query( array(
											 'post_type'=>'post',
											 'cat'=>$result1->term_id,
											 'post_status'=>'publish'
										 ));
									}
									else {
										$my_query = new WP_Query( array(
											'post_type'=>'post',
											'post_status'=>'publish'
										));
									}
									if($my_query->post_count>0) {
									?>
									<li <?php echo $result->term_id==$get_catid?'class="current"':'';?>><a href="<?php echo site_url(); ?>/resources/topic/<?php echo $result1->slug;?>" ><?php echo $result1->name;?></a></li>
									<?php
										}
									}
									}
								?>
						</ul>
						<div class="arrow slide4">&ensp;</div>
					</section>
				</aside>
			</div>
		</div>
	<?php else:?>
			<div class="wrapper portfolio-item">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<div class="commentarea"><a name="commentsSection"></a><?php comments_template(); ?></div>
		</div>
	<?php endif; endwhile; else: ?>
		<p>Sorry, the page you are looking for has been moved or deleted.</p>
	<?php endif; ?>
		<?php get_footer(); ?>
