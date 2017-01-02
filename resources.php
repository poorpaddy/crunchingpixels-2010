<?php
/*
Template Name: Blogging List
*/
?>
<?php get_header(); ?>
<?php $myvars = get_query_var('port_cat1');?>
<?php
	global $wpdb;  // Bring our DB connection in scope
	$table_prefix = $wpdb->prefix; // Get the WP table prefix
	$table_name2 = "terms"; // Assign the table name we wish to query
	$table_name3 = "term_taxonomy";
	$table2 = $table_prefix . $table_name2; // Put it all together
	$table3 = $table_prefix . $table_name3; //echo "SELECT term_id FROM $table2 JOIN $table3 WHERE $table2.name=$myvars and $table3.taxonomy='category'";
	$queryresult2 = $wpdb->get_results("SELECT * FROM $table2 JOIN $table3 WHERE $table3.term_id=$table2.term_id and $table2.slug='$myvars' and $table3.taxonomy='category'");
	$category_id=1;
	foreach($queryresult2 as $result2){
		$category_id=$result2->term_id;
	}
	
 //if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="wrapper blog-list">
			<h1>
			<?php
			$cat_name = "terms"; // Assign the table name we wish to query
			$cat_name1 = $table_prefix . $cat_name; // Put it all together
			$query_name = $wpdb->get_results("SELECT * FROM " . $cat_name1." WHERE term_id='".$category_id."'");
			foreach($query_name as $res) {
				if($res->name=='Uncategorized') {
					echo 'All Topics';
				}
				else {
					echo $res->name;
				}
			} ?>
			</h1>
			<div class="lcol">
			<?php
			   // global $wp_query;
			   if($category_id!='' && $category_id!=1){
			   $res_query = new WP_Query( array(
					'paged'=> get_query_var('paged'),
					'post_type'=>'post',
					'cat'=>$category_id
				));
			   }
			   else {
				   $res_query = new WP_Query( array(
					   'post_type'=>'post',
					   'paged'=> get_query_var('paged')
					));
				  }
			?>
		  
   <?php if ($res_query->have_posts()): while($res_query->have_posts()): $res_query->the_post();?>
		
				<a href="<?php the_permalink(); ?>" class="figlink blogtitle" style="text-decoration:none;" title="<?php the_title();?>"><h2><?php the_title();?></h2></a>
				<div class="meta">
					<?php $categories1= get_the_category($post->ID);
					foreach($categories1 as $cat_new) {?>
					<a href="<?php echo site_url(); ?>/resources/topic/<?php echo $cat_new->slug;?>" class="category"><?php echo $cat_new->cat_name;?></a>
					<?php } ?>
					<span class="info"><?php echo get_the_date('F j, Y'); ?></span>
					<a href="<?php the_permalink(); ?>#commentsSection" class="comments"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a>
				</div>
				<?php the_excerpt();?>
				<div class="moregutter"><a href="<?php the_permalink(); ?>" class="readmore">Read More</a></div>
				<?php endwhile; endif; ?>

		<div class="pagination">
					<div class='wp-pagenavi'>
						<?php wp_pagenavi( array( 'query' => $res_query ) ); ?>
					</div>
				</div>
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
								//echo "SELECT * FROM " . $table." WHERE parent='0'";
								foreach($queryresult as $result){
									$table_name1 = "terms"; // Assign the table name we wish to query
									$table1 = $table_prefix . $table_name1; // Put it all together
									$queryresult1 = $wpdb->get_results("SELECT * FROM " . $table1." WHERE term_id='".$result->term_id."'");
									foreach($queryresult1 as $result1){
										if($result1->name=='Uncategorized'){
											$result1->name='all topics';
										}
									if($category_id==''){
										$get_catid=1;
									}
									else { $get_catid=$category_id;}
									if($result1->term_id!='' && $result1->term_id!=1){
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
									if($my_query->post_count>0){
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
		<?php get_footer(); ?>