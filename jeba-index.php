<?php
/*
Plugin Name: Jeba Divas Slider
Plugin URI: http://prowpexpert.com
Description: This is Jeba full width Divas wordpress slider plugin really looking awesome sliding. Everyone can use the cute slider plugin easily like other wordpress plugin. Here everyone can slide image from post, page or other custom post. Also can use slide from every category. By using [jeba_pslider] shortcode use the slider every where post, page and template.
Author: Md Jahed
Version: 1.0
Author URI: http://prowpexpert.com/
*/
function jeba_wp_latest_jquery_d() {
	wp_enqueue_script('jquery');
}
add_action('init', 'jeba_wp_latest_jquery_d');

function plugin_function_jeba_slider() {
    wp_enqueue_script( 'jeba-js-d', plugins_url( '/js/jquery.divas-1.1.min.js', __FILE__ ), true);
    wp_enqueue_style( 'jeba-css-d', plugins_url( '/js/divas_free_skin.css', __FILE__ ));
    wp_enqueue_style( 'jebacss-d', plugins_url( '/js/jeba-css.css', __FILE__ ));
}

add_action('init','plugin_function_jeba_slider');
function jeba_script_slider_function () {?>
	<script type="text/javascript">
		jQuery(document).ready(function()
			{
				jQuery("#slider").divas({
					slideTransitionClass: "divas-slide-transition-left",
					titleTransitionClass: "divas-title-transition-left",
					titleTransitionParameter: "left",
					titleTransitionStartValue: "-999px",
					titleTransitionStopValue: "0px",
					wingsOverlayColor: "rgba(0,0,0,0.6)",
					start: "manual",
					slideInterval: 4000
				});
			});
	</script>
	

<?php
}
add_action('wp_head','jeba_script_slider_function');

function jeba_slider_shortcode_d($atts){
	extract( shortcode_atts( array(
		'category' => '',
		'post_type' => 'jeba-eitems',
		'count' => '5',
	), $atts) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $post_type, 'category_name' => $category)
        );		
		
		$plugins_url = plugins_url();
		
	$list = '  		<section id="slider_wrapper">
			<div id="slider" class="divas-slider">
				<ul class="divas-slide-container">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$jeba_img_large = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-portfolio' );
		
		$list .= '
			
			
			 <li class="divas-slide"><img src="'.plugins_url().'/js/images/placeholder.gif" alt="" data-src="'.$jeba_img_large[0].'" data-title="<h2>'.get_the_title().'</h2><p>'.get_the_excerpt().'</p>" /></li>
			
			
		
		';        
	endwhile;
	$list.= '</ul>
			    <div class="divas-navigation">
			        <span class="divas-prev">&nbsp;</span>
			        <span class="divas-next">&nbsp;</span>
			    </div>
                <div class="divas-controls">
                	<span class="divas-start"><i class="fa fa-play"></i></span>
			        <span class="divas-stop"><i class="fa fa-pause"></i></span>
                </div>
			</div>
		</section>';
	wp_reset_query();
	return $list;
}
add_shortcode('jeba_pslider', 'jeba_slider_shortcode_d');



add_action( 'init', 'jeba_siler_custom_post_d' );
function jeba_siler_custom_post_d() {

	register_post_type( 'jeba-eitems',
		array(
			'labels' => array(
				'name' => __( 'JebaSliders' ),
				'singular_name' => __( 'JebaSlider' )
			),
			'public' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'jeba-slider'),
			'taxonomies' => array('category', 'post_tag') 
		)
	);	
	}

add_theme_support( 'post-thumbnails', array( 'post', 'jeba-eitems' ) );

add_image_size( 'large-portfolio', 1140, 682, true );
?>