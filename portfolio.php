<?php
/*
Template Name: Portfolio List Format
*/
?>
<?php get_header(); ?>
<?php $myvars = get_query_var('port_cat'); ?>
<?php
	global $wpdb;  // Bring our DB connection in scope
	$table_name2 = "terms"; // Assign the table name we wish to query
	$table_name3 = "term_taxonomy";
	$table2 = $table_prefix . $table_name2; // Put it all together
	$table3 = $table_prefix . $table_name3;

	//echo get_query_var('cpage')."test..............";
	global $wp_query;
	$myarr = $wp_query->query_vars;
	//print_r($myarr);
	$queryresult2 = $wpdb->get_results("SELECT * FROM $table2 JOIN $table3 WHERE $table3.term_id=$table2.term_id and $table2.slug='$myvars' and $table3.taxonomy='category'");
	$category_id=1;
	foreach($queryresult2 as $result2){
		$category_id=$result2->term_id;
	}
?>
		<div class="wrapper portfolio-list">
		<?php
		   // global $wp_query;
		   if($category_id!='' && $category_id!=1){
			   $my_query = new WP_Query( array(
				   'paged'=> get_query_var('paged'),
				   'post_type'=>'portfolio',
				   'cat'=>$category_id
				));
			}
		   else {
			   $category_id=1;
			   $my_query = new WP_Query( array(
				   'post_type'=>'portfolio',
				   'paged'=> get_query_var('paged')
				));
			  }
			?>
		  
<h1><?php
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
	} ?></h1>
			<div class="lcol">
			<?php 

				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				if($category_id!='' && $category_id!=1){
			   		$port_query = new WP_Query( array(
					   'paged'=> $paged,
					   'post_type'=>'portfolio',
					   'cat'=>$category_id,
					   'post_per_page' => 8
					));
				}
			   	else {
					$port_query = new WP_Query(array(
						'post_type' => 'portfolio',
						'paged' => $paged,
						'post_per_page' => 8)
					);
				}			  	
			
			if ($port_query->have_posts()): while($port_query->have_posts()): $port_query->the_post();?>
		
				<?php
					$custom = get_post_custom($post->ID);
					$project_image = $custom["project_image"][0];
				?>
				<?php $param = get_permalink($post->ID); ?>
				<div class="group">
					<div class="project">
						 <a href="<?php the_permalink(); ?>" class="figlink" title="<?php the_title();?>">
							<figure class="load">
								<img src="<?=$project_image?>" />
							</figure>
						</a>
					</div>
					<div class="shadow plsdw"></div>
				</div>
					<?php endwhile; endif;?>
					<div class="pagination">
					<div class='wp-pagenavi'>
					<?php wp_pagenavi( array( 'query' => $port_query ) ); ?>
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
								foreach($queryresult as $result) {
									$table_name1 = "terms"; // Assign the table name we wish to query
									$table1 = $table_prefix . $table_name1; // Put it all together
									$queryresult1 = $wpdb->get_results("SELECT * FROM " . $table1." WHERE term_id='".$result->term_id."'");
									foreach($queryresult1 as $result1) {
										if($result1->name=='Uncategorized') {
											$result1->name='all topics';
										}
										if($category_id=='') {
											$get_catid=1;
										}
									else {
										$get_catid=$category_id;
									}
									if($result1->term_id!='' && $result1->term_id!=1) {
										$bb='eta te';
										$my_query1 = new WP_Query( array(
											'post_type'=>'portfolio',
											'cat'=>$result1->term_id,
											'post_status'=>'publish'
										));
									}
									else {
										$bb='ota te noy';
										$my_query1 = new WP_Query( array(
											'post_type'=>'portfolio',
											'post_status'=>'publish'
										));
									}
									if($my_query1->post_count>0) { ?>
									<li <?php echo $result->term_id==$get_catid?'class="current"':'';?>><a href="<?php echo site_url(); ?>/portfolio/topic/<?php echo $result1->slug;?>" ><?php echo $result1->name;?> </a></li>
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