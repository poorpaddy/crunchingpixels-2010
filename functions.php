<?php

//Create Custom Postype
	add_action('init', 'create_portfolio');
	function create_portfolio() {
    	$portfolio_args = array(
        	'label' => __('Portfolio'),
        	'singular_label' => __('Portfolio'),
        	'public' => true,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => false,
			'query_vars'=>false,
        	'supports' => array('title', 'editor', 'custom-fields', 'comments'),
			'taxonomies' => array('category', 'post_tag')
        );
    	register_post_type('portfolio',$portfolio_args);
		register_taxonomy_for_object_type( 'category', 'portfolio');
	}

	//Add Portfolio Image field to Custom Post Type
	add_action("admin_init", "add_portfolio");
	add_action('save_post', 'update_project_image');
	function add_portfolio(){
		add_meta_box("portfolio_details", "Portfolio Options", "portfolio_options", "portfolio", "normal", "low");
		
	}
	function portfolio_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$project_image = $custom["project_image"][0];
?>
	<div id="portfolio-options">
		<label>Project Image:</label><input name="project_image" value="<?php echo $project_image; ?>" />		
	</div>
<?php
	}
	function update_project_image(){
		global $post;
		update_post_meta($post->ID, "project_image", $_POST["project_image"]);
	}

add_action("manage_posts_custom_column",  "portfolio_columns_display");

// Add info to Custom Post Type List
function portfolio_edit_columns($portfolio_columns){
	$portfolio_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Project Title",
		"description" => "Description",
	);
	return $portfolio_columns;
}
function portfolio_columns_display($portfolio_columns){
	switch ($portfolio_columns)
	{
		case "description":
			the_excerpt();
			break;				
	}
}

//Change URL structure
// FOF Htaccess rewrite..........................
function add_query_vars($aVars) {
    $aVars[] = "port_cat";
	$aVars[] = "port_cat1";
	// represents the name of the product category as shown in the URL
    return $aVars;
}
 
// hook add_query_vars function into query_vars
global $wp_rewrite;
$portfolio_structure = '/portfolio/%year%/%monthnum%/%portfolio%';
$wp_rewrite->add_rewrite_tag("%portfolio%", '([^/]+)', "portfolio=");
$wp_rewrite->add_permastruct('portfolio', $portfolio_structure, false);

function photo_details_vars(){
	add_rewrite_rule('^portfolio/topic/([^/]+)/page/([^/]+)/?$','index.php?page_id=1257&port_cat=$matches[1]&paged=$matches[2]','top');
	add_rewrite_rule('^portfolio/topic/([^/]+)/?$','index.php?page_id=1257&port_cat=$matches[1]','top');
	add_rewrite_rule('^resources/topic/([^/]+)/page/([^/]+)/?$','index.php?page_id=1284&port_cat1=$matches[1]&paged=$matches[2]','top');
	add_rewrite_rule('^resources/topic/([^/]+)/?$','index.php?page_id=1284&port_cat1=$matches[1]','top');
}
add_action('init', 'photo_details_vars');
add_filter('query_vars', 'add_query_vars');
add_filter('init', 'flush_rules');
function flush_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

// Add filter to plugin init function
add_filter('post_type_link', 'portfolio_permalink', 10, 3);	
// Adapted from get_permalink function in wp-includes/link-template.php
function portfolio_permalink($permalink, $post_id, $leavename) {
	$post = get_post($post_id);
	$rewritecode = array(
		'%year%',
		'%monthnum%',
		'%day%',
		'%hour%',
		'%minute%',
		'%second%',
		$leavename? '' : '%postname%',
		'%post_id%',
		'%category%',
		'%author%',
		$leavename? '' : '%pagename%',
	);
 
	if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
		$unixtime = strtotime($post->post_date);
 
		$category = '';
		if ( strpos($permalink, '%category%') !== false ) {
			$cats = get_the_category($post->ID);
			if ( $cats ) {
				usort($cats, '_usort_terms_by_ID'); // order by ID
				$category = $cats[0]->slug;
				if ( $parent = $cats[0]->parent )
					$category = get_category_parents($parent, false, '/', true) . $category;
			}
			// show default category in permalinks, without
			// having to assign it explicitly
			if ( empty($category) ) {
				$default_category = get_category( get_option( 'default_category' ) );
				$category = is_wp_error( $default_category ) ? '' : $default_category->slug;
			}
		}
 
		$author = '';
		if ( strpos($permalink, '%author%') !== false ) {
			$authordata = get_userdata($post->post_author);
			$author = $authordata->user_nicename;
		}
 
		$date = explode(" ",date('Y m d H i s', $unixtime));
		$rewritereplace =
		array(
			$date[0],
			$date[1],
			$date[2],
			$date[3],
			$date[4],
			$date[5],
			$post->post_name,
			$post->ID,
			$category,
			$author,
			$post->post_name,
		);
		$permalink = str_replace($rewritecode, $rewritereplace, $permalink);
	} else { // if they're not using the fancy permalink option
	}
	return $permalink;
}

//Shorten Title for Home Page Posts
function short_title() {
	$title = get_the_title();
	$count = strlen($title);
	if ($count >= 38) {
	$title = substr($title, 0, 38);
	$title .= '&hellip;';
}
	echo $title;
}

//Rewrite Excerpts
function new_excerpt_more($more) {return '&hellip;';}
add_filter('excerpt_more', 'new_excerpt_more');

// Add custom taxonomies and custom post types counts to dashboard
add_action( 'right_now_content_table_end', 'my_add_counts_to_dashboard' );
function my_add_counts_to_dashboard() {
    // Custom taxonomies counts
    $taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
    foreach ( $taxonomies as $taxonomy ) {
        $num_terms  = wp_count_terms( $taxonomy->name );
        $num = number_format_i18n( $num_terms );
        $text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, $num_terms );
        $associated_post_type = $taxonomy->object_type;
        if ( current_user_can( 'manage_categories' ) ) {
            $num = '<a href="edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $associated_post_type[0] . '">' . $num . '</a>';
            $text = '<a href="edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $associated_post_type[0] . '">' . $text . '</a>';
        }
        echo '<td class="first b b-' . $taxonomy->name . 's">' . $num . '</td>';
        echo '<td class="t ' . $taxonomy->name . 's">' . $text . '</td>';
        echo '</tr><tr>';
    }

    // Custom post types counts
    $post_types = get_post_types( array( '_builtin' => false ), 'objects' );
    foreach ( $post_types as $post_type ) {
        $num_posts = wp_count_posts( $post_type->name );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( $post_type->labels->singular_name, $post_type->labels->name, $num_posts->publish );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . '</a>';
            $text = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';
        }
        echo '<td class="first b b-' . $post_type->name . 's">' . $num . '</td>';
        echo '<td class="t ' . $post_type->name . 's">' . $text . '</td>';
        echo '</tr>';

        if ( $num_posts->pending > 0 ) {
            $num = number_format_i18n( $num_posts->pending );
            $text = _n( $post_type->labels->singular_name . ' pending', $post_type->labels->name . ' pending', $num_posts->pending );
            if ( current_user_can( 'edit_posts' ) ) {
                $num = '<a href="edit.php?post_status=pending&post_type=' . $post_type->name . '">' . $num . '</a>';
                $text = '<a href="edit.php?post_status=pending&post_type=' . $post_type->name . '">' . $text . '</a>';
            }
            echo '<td class="first b b-' . $post_type->name . 's">' . $num . '</td>';
            echo '<td class="t ' . $post_type->name . 's">' . $text . '</td>';
            echo '</tr>';
        }
    }
}

?>