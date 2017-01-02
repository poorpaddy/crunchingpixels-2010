			<section class="carousel">
				<script type="text/javascript">
					$(document).ready(	
						function() {
							$(".container1").wtRotator({
								width:902,
								height:238,
								thumb_width:24,
								thumb_height:24,
								button_width:24,
								button_height:24,
								button_margin:5,
								auto_start:true,
								delay:5000,
								play_once:false,
								transition:"block.fade",
								transition_speed:800,
								auto_center:true,
								easing:"",
								cpanel_position:"inside",
								cpanel_align:"BR",
								timer_align:"top",
								display_thumbs:false,
								display_dbuttons:false,
								display_playbutton:false,
								display_thumbimg:false,
								display_side_buttons:false,
								display_numbers:false,
								display_timer:true,
								mouseover_pause:true,
								cpanel_mouseover:false,
								text_mouseover:false,
								text_effect:"",
								text_sync:true,
								tooltip_type:"",
								lock_tooltip:false,
								shuffle:true,
								block_size:75,
								vert_size:55,
								horz_size:50,
								block_delay:25,
								vstripe_delay:75,
								hstripe_delay:180			
							});
						}
					);
				</script>
				<div class="container container1">
					<div class="wt-rotator load">
						<div class="screen">
							<noscript>
								<img src="<?php bloginfo('template_directory'); ?>/img/javascript-disabled.gif"/>
							</noscript>
						</div>
						<div class="c-panel">
							<div class="thumbnails">
								<ul>
									<?php
										$featuredPosts = array(
											'tax_query' => array(
											'relation' => 'OR',
											array('taxonomy' => 'category', 'field' => 'slug', 'terms' => array('featured')),
											array('taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => array('featured'))
										), 
										'post_type' => array('post', 'portfolio'),
										'showposts'=>5);
										$featured_query = new WP_Query($featuredPosts);
										while ($featured_query->have_posts()) : $featured_query->the_post();
									?>
									<li class="on">
										<a href="<?php echo get_post_meta($post->ID, 'Featured Image', true); ?>" title="<?php the_title();?>"><img src="<?php echo get_post_meta($post->ID, 'Featured Image', true); ?>"/></a>
										<a href="<?php the_permalink(); ?>"></a> 
									</li>
									<?php endwhile; ?>
								</ul>
							</div>     
						</div>
					</div>	
				</div>
			</section>
			<div class="shadow csdw"></div>