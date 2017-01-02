<!doctype html>
<!--[if lt IE 7]><html class="no-js ie6 oldie" lang="en"><![endif]--><!--[if IE 7]><html class="no-js ie7 oldie" lang="en"><![endif]--><!--[if IE 8]><html class="no-js ie8 oldie" lang="en"><![endif]--><!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
	<?php
		if (is_home() || is_front_page() ) : $descrip = get_bloginfo('description');
		echo '<meta name="description" content="'.get_bloginfo('description').'" />';
		else :
		$post = $wp_query->post;
		$descrip = strip_tags($post->post_content);
		$descrip_more = '';
		if (strlen($descrip) > 140) {
			$descrip = substr($descrip,0,140);
			$descrip_more = '...';
		}
		$descrip = str_replace('"', '', $descrip);
		$descrip = str_replace("'", '', $descrip);
		$descripwords = preg_split('/[\n\r\t ]+/', $descrip, -1, PREG_SPLIT_NO_EMPTY);
		array_pop($descripwords);
		$descrip = implode(' ', $descripwords) . $descrip_more;
		echo '<meta name="description" content="'.$descrip.'" />';
		endif;
	?>
	<meta name="author" content="Dave Bergschneider">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="shortcut icon" href="<?php echo get_bloginfo('template_directory'); ?>/img/favicon.ico">
	<link href="<?php echo get_bloginfo('template_directory'); ?>/css/mini.php?files=style" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]><script src="<?php echo get_bloginfo('template_directory'); ?>/js/html5.js"></script><![endif]-->
	<script src="<?php echo get_bloginfo('template_directory'); ?>/js/mini.php?files=jquery.min,jquery.easing,jquery-ui.min,jquery.wt-rotator.min,script"></script>
	<?php wp_head(); ?>
</head>
<body>

<div class="container">
		<header>
			<a href="<?php bloginfo('wpurl'); ?>/" class="logo" title="Crunching Pixels: Home Page"></a>
			<nav class="smedia">
				<ul>
					<li><a href="http://www.linkedin.com/in/daveb" class="social li" title="LinkedIn"></a></li>
					<li><a href="http://twitter.com/poorpaddy" class="social tw" title="Twitter"></a></li>
					<li><a href="http://www.facebook.com/poorpaddy" class="social fb" title="Facebook"></a></li>
					<li><a href="http://wordpress.org/extend/plugins/profile/dave-bergschneider" class="social wp" title="Wordpress"></a></li>
					<li><a href="skype:poorpaddy619?call" class="social sk" title="Call me on Skype"></a></li>
					<li><a href="http://foursquare.com/poorpaddy" class="social fq" title="Foursquare"></a></li>
					<li><a href="http://poorpaddy.yelp.com" class="social yp" title="Yelp"></a></li>
					<li><a href="http://vimeo.com/poorpaddy" class="social vm" title="Vimeo"></a></li>
				</ul>
			</nav>
			<nav class="primary">
				<ul>
					<li><a href="<?php bloginfo('wpurl'); ?>/" class="home" title="Home"><span>Home</span></a></li>
					<li><a href="<?php echo get_permalink( 1257 ); ?>" class="portfolio" title="Portfolio"><span>Portfolio</span></a></li>
					<li><a href="<?php echo get_permalink( 1284 ); ?>" class="about" title="Resources"><span>Resources</span></a></li>
					<li><a href="<?php echo get_permalink( 1465 ); ?>" class="contact" title="Contact"><span>Contact</span></a></li>
				</ul>
			</nav>
			<a href="http://www.cmscode.com" class="hireme" title="Hire Me" target="_blank"></a>
		</header>