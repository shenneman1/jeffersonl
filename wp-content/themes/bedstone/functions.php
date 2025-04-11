<?php
/**
 * project-specific functions
 *
 * @package Bedstone
 */

require TEMPLATEPATH . '/functions/env.php';
require TEMPLATEPATH . '/functions/constants.php';
require TEMPLATEPATH . '/functions/bedstone/master.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 * @link http://codex.wordpress.org/Content_Width
 */
if (!isset($content_width)) {
	$content_width = 640; /* pixels */
}

/**
 * Set theme support.
 */
add_action('after_setup_theme', 'custom_theme_setup');
function custom_theme_setup()
{
	add_theme_support( 'menus' );
	add_theme_support('title-tag');
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
	add_post_type_support('page', array('excerpt'));
}

// Register navigation menus.
register_nav_menus(
	array(
		'mobile'    => esc_html__( 'Mobile Menu', 'jefferson' ),
	)
);

/**
 * Enqueue scripts and styles.
 */
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');
function custom_enqueue_scripts()
{
	/**
	 * Version variable
	 */
	$version = '1.0.106';
	$id = get_the_ID(); // use for testing page-specific styles and scripts
	$template = get_page_template_slug();
	$cache_buster = defined('CACHE_BUSTER') ? CACHE_BUSTER : 'CBzz';

	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,400italic,700,700italic|Roboto:400,300,300italic,400italic,700,700italic');
	wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0');
	wp_enqueue_style( 'new-fontawesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css', array(), '5.2.0' );
	wp_enqueue_style('black-tie', get_template_directory_uri() . '/black-tie/css/black-tie.min.css');
	wp_enqueue_style('wd-grid', get_template_directory_uri() . '/css/wd-grid.css', array(), $cache_buster);

	//Individual Stylesheets
	if (is_page_template('tpl-hundred-years.php')){
		wp_enqueue_style( 'hundred-years-template-styles', get_template_directory_uri() . '/css/custom/hundred-years-template.css', array(), '1.0.8' );
		}
	if (is_page_template('tpl-charter.php')) {
		wp_enqueue_style( 'jefferson-charter-styles', get_template_directory_uri() . '/css/custom/charter.css', array(), $version );
	}
	wp_enqueue_style( 'jefferson-footer-styles', get_template_directory_uri() . '/css/custom/footer.css', array(), $version );
	wp_enqueue_style( 'jefferson-forms-styles', get_template_directory_uri() . '/css/custom/forms.css', array(), $version );
	if (is_front_page()){
		wp_enqueue_style( 'jefferson-front-page-styles', get_template_directory_uri() . '/css/custom/front-page.css', array(), $version );
	}
	wp_enqueue_style( 'jefferson-header-styles', get_template_directory_uri() . '/css/custom/header.css', array(), $version );
	wp_enqueue_style( 'jefferson-navigation-styles', get_template_directory_uri() . '/css/custom/navigation.css', array(), $version );

	if (is_page_template('tpl-testimonials.php')) {
		wp_enqueue_style( 'jefferson-testimonials-styles', get_template_directory_uri() . '/css/custom/testimonials.css', array(), $version );
	}


	/**
	 * selectboxit
	 * remeber to add selectboxit-js to the init.js dependency array
	 * @link http://gregfranko.com/jquery.selectBoxIt.js/
	 */
	//wp_enqueue_style('selectboxit', '//cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.css', array(), '3.8.0');
	//wp_enqueue_script('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array('jquery'), '1.11.4', true);
	//wp_enqueue_script('selectboxit-js', '//cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.min.js', array('jquery', 'jquery-ui'), '3.8.0', true);

	// Enqueue Fancybox assets
	wp_enqueue_style( 'bedstone-fancybox-styles', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.min.css', array(), '1.0.0' );
	wp_enqueue_script( 'bedstone-fancybox-scripts', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.min.js', array( 'jquery' ), '1.0.0', true );

	// mmenu jquery
//	wp_enqueue_style('mmenu-css', get_stylesheet_directory_uri() . '/js/mmenu/jquery.mmenu.all.css', array());
//	wp_enqueue_script('mmenu-js', get_stylesheet_directory_uri() . '/js/mmenu/jquery.mmenu.all.min.js', array('jquery'), '', true);

	// iframe resizer
	wp_enqueue_script('iframe-resizer-js', 'https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.5.1/iframeResizer.min.js', array('jquery'), '', true);

	/**
	 * Conditionally enqueue on 100 year template
	 */
	if ( 'tpl-hundred-years.php' == $template ) {
		wp_enqueue_style( 'rocket55-aos-css', get_template_directory_uri() . '/js/wow/animate.css', array(), '1.0.0' );
		wp_enqueue_script( 'rocket55-aos-js', get_template_directory_uri() . '/js/wow/wow.min.js', array(), '1.0.0' );
		wp_enqueue_script( 'bedstone-countup-library', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js', array(), '1.0.0' );
		wp_enqueue_script( 'bedstone-countup-scripts', get_template_directory_uri() . '/js/countup.min.js', array( 'jquery' ), '1.0.0' );
	}

	$init_dependencies = array('jquery', 'iframe-resizer-js');

	if ('tpl-charter.php' == $template || 'tpl-testimonials.php' == $template) {
		$init_dependencies[] = 'unslider-js';
		wp_enqueue_script('unslider-js', 'https://cdnjs.cloudflare.com/ajax/libs/unslider/2.0.3/js/unslider-min.js', array('jquery'), '2.0.3', true);
		wp_enqueue_style('unslider', 'https://cdnjs.cloudflare.com/ajax/libs/unslider/2.0.3/css/unslider.css', array(), '2.0.3');
		wp_enqueue_style('unslider-dots', 'https://cdnjs.cloudflare.com/ajax/libs/unslider/2.0.3/css/unslider-dots.css', array('unslider'), '2.0.3');
	}



	/**
	 * Google API Key
	 */
	$google_api_key = get_field( 'google_api_key', 'option' );

	/**
	 * Register Google Maps API
	 */
	wp_register_script( 'jl_google_map_api', 'https://maps.googleapis.com/maps/api/js?key=' . $google_api_key, array( 'jquery' ), $version, true );

	/**
	 * Register Google Maps Render Script
	 */
	wp_register_script( 'jl_google_map_render', get_template_directory_uri() . '/js/google-map-render.js', array( 'jquery', 'jl_google_map_api' ), $version, true );

	/**
	 * Enqueue Google Maps Scripts
	 */
	if ( is_page_template( 'page-map.php' ) ) {
		wp_enqueue_script( 'jl_google_map_api' );
		wp_enqueue_script( 'jl_google_map_render' );
		wp_enqueue_style( 'jl_map_css', get_template_directory_uri() . '/css/map.css', array(), $version );
	}

	wp_enqueue_script('init-js', get_template_directory_uri() . '/js/init.js', $init_dependencies, $version, true);

	wp_enqueue_style('bedstone', get_template_directory_uri() . '/style.css', array('wd-grid'), $version);
	wp_enqueue_style('bedstone-responsive', get_template_directory_uri() . '/css/style-responsive.css', array('wd-grid', 'bedstone'), $version);


}

/**
 * Google Maps API & Geolocation Functionality
 */
require get_template_directory() . '/functions/map-api.php';

/**
 * Location Search Functions
 */
require get_template_directory() . '/functions/location-search-api.php';

/**
 * Register custom editor style formats
 * @link http://codex.wordpress.org/TinyMCE_Custom_Styles
 */
add_filter('tiny_mce_before_init', 'add_style_formats');
function add_style_formats($init)
{
	$style_formats = array(
		array(
			'title' => 'Lead',
			'selector' => 'p',
			'classes' => 'lead',
		),
		array(
			'title' => 'Callout',
			'selector' => 'p',
			'classes' => 'callout',
		),
		array(
			'title' => 'Call-to-Action',
			'selector' => 'p',
			'classes' => 'call-to-action',
		),
		array(
			'title' => 'Footnote',
			'selector' => 'p',
			'classes' => 'footnote',
		)
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init['style_formats'] = json_encode($style_formats);
	return $init;
}

/**
 * Custom mce editor styles
 */
add_action('init', 'do_add_editor_styles');
function do_add_editor_styles()
{
	add_editor_style('css/style-editor-06.css'); // cached, update revision as needed
}

/**
 * [optional] custom post types
 */
//add_action('init', 'wd_register_custom_post_types', 0);
function wd_register_custom_post_types()
{
	$arr_custom_post_type_options = array(
		/*
		 array(
			'label' => 'lowercase_name' // ** 20 char max, no spaces or caps
			'singlar' => 'Human-Readable Item' // singular name
			'plural' => 'Human-Readable Items' // plural name
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats')
		 ),
		 */
		array(
			'label' => 'staff',
			'singular' => 'Staff Profile',
			'plural' => 'Staff Profiles',
			'supports' => array('title', 'editor', 'custom-fields', 'page-attributes'),
		),
	);
	foreach ($arr_custom_post_type_options as $cpt_opts) {
		$label = $cpt_opts['label'];
		$labels = array(
			'name'                => $cpt_opts['plural'],
			'singular_name'       => $cpt_opts['singular'],
			'menu_name'           => $cpt_opts['plural'],
			'parent_item_colon'   => 'Parent:',
			'all_items'           => $cpt_opts['plural'],
			'view_item'           => 'View',
			'add_new_item'        => 'Add New',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit',
			'update_item'         => 'Update',
			'search_items'        => 'Search ' . $cpt_opts['plural'],
			'not_found'           => 'None found',
			'not_found_in_trash'  => 'None found in Trash',
		);
		$args = array(
			'label'               => $label,
			'description'         => 'Custom Post Type: ' . $cpt_opts['plural'],
			'labels'              => $labels,
			'supports'            => $cpt_opts['supports'],
			'hierarchical'        => true,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25.3,
			//'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);
		register_post_type($label, $args);
	}
}

/**
 * [optional] ACF Options Pages
 */
add_action('init', 'enable_acf_options_page');
function enable_acf_options_page()
{
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page();
		acf_add_options_sub_page('Global Options');
		acf_add_options_sub_page('Navigation');
		acf_add_options_sub_page('Header Alert');
		acf_add_options_sub_page('Booking Banner');
		acf_add_options_sub_page('Footer Options');
	}
}


/**
 * [optional] Change excerpt length
 */
add_filter('excerpt_length', 'modify_excerpt_length');
function modify_excerpt_length($length)
{
	return 30; // number of words
}


/**
 * ACF options page fields stored in object
 */
$acf_options = new stdClass();
add_action('get_header', 'get_acf_options', 1);
function get_acf_options()
{
	global $acf_options;
	$acf_options = (object) get_fields('options');
}


/**
 * Create <li>'s of page link & title from ACF SIMPLE repeater of post objects
 */
function post_obj_repeater_list($post_obj_repeater)
{
	global $acf_options;
	$post_list_html = '';
	$post_obj_repeater_arr = $acf_options->$post_obj_repeater;

	foreach ($post_obj_repeater_arr as $post_obj) {
		$post_id = $post_obj['footer_nav_post_obj'];

		$post_list_html .= '<li>';
		$post_list_html .= '<a href="' . get_permalink($post_id) . '">';
		$post_list_html .= get_the_title($post_id);
		$post_list_html .= '</a>';
		$post_list_html .= '</li>';
	}

	return $post_list_html;
}


/**
 * Create <li>'s of Nav Links from A PARTICULAR SET ACF Navigation repeaters
 */
function nav_repeater_list($nav_repeater)
{
	global $acf_options;
	$list_html = '';
	$nav_repeater_arr = $acf_options->$nav_repeater;

	foreach ($nav_repeater_arr as $nav_item) {
		$is_internal = ( $nav_item["link_type"] == 'internal' ) ? true : false;
		$url;
		$label;

		if ( $is_internal ) {
			$url = get_permalink($nav_item["page_link"]);
			$label = get_the_title($nav_item["page_link"]);
		} else {
			$url = $nav_item["external_dest"];
			$label = $nav_item["external_label"];
		}

		$list_html .= '<li>';
		$list_html .= '<a href="' . $url . '"';
		$list_html .= ( !$is_internal ) ? 'rel="external"' : '';
		$list_html .= '>';
		$list_html .= $label;
		$list_html .= '</a>';
		$list_html .= '</li>';
	}

	return $list_html;
}





/**
 * Create html for advanced repeater list used in the mega dropdown
 */
function advanced_repeater_list($nav_repeater)
{
	global $acf_options;
	$col_max = 3;
	$col_count = 0;
	$list_open = false;
	$full_html = '';

	$mixed_arr = $acf_options->$nav_repeater;

	$full_html .= '<div class="columns submenu__advanced-nav-list">'; // start coulmns div

	foreach ($mixed_arr as $mixed_item) {
		$type = $mixed_item['item_type'];

		switch ( $type ) {
			case 'col-start' :
				$col_count++;

				// if there is an open <ul>, close it
				if ( $list_open ) {
					$full_html .= '</ul>';
					$list_open = false;
				}
				if ( $col_count > 1 ) {
					$full_html .= '</div>'; // close previous .col
				}
				if ( $col_count >= 1 && $col_count <= $col_max ) {
					$full_html .= '<div class="col col-4">'; // open new .col
				}
				break;

			case 'heading' :
				// if there is an open <ul>, close it
				if ( $list_open ) {
					$full_html .= '</ul>';
					$list_open = false;
				}

				$full_html .= '<h4 class="nav-group__heading">';
				$full_html .= $mixed_item['group_heading'];
				$full_html .= '</h4>';
				break;

			case 'page' :
				$post_id = $mixed_item['page_link'];

				if ( !$list_open ) {
					$full_html .= '<ul class="submenu__nav-list">';
					$list_open = true;
				}

				if ( $list_open ) {
					$full_html .= '<li>';
					$full_html .= '<a href="' . get_permalink($post_id) . '">';
					$full_html .= get_the_title($post_id);;
					$full_html .= '</a>';
					$full_html .= '</li>';
				}
				break;
		}
	}

	if ( $list_open ) {
		$full_html .= '</ul>';
		$list_open = false;
	}

	$full_html .= '</div>'; // end .columns div
	return $full_html;

}




/**
 * Create html for advanced repeater list used in the mobile mmenu
 */
function mobile_advanced_repeater_list($nav_repeater)
{
	global $acf_options;
	$list_open = false;
	$full_html = '';

	$mixed_arr = $acf_options->$nav_repeater;

	$full_html .= '<ul>';

	foreach ( $mixed_arr as $mixed_item) {
		$type = $mixed_item['item_type'];

		switch ( $type ) {
			case 'heading' :
				// if there is an open <ul>, close it and its <li>
				if ( $list_open ) {
					$full_html .= '</ul>';
					$full_html .= '</li>';
					$list_open = false;
				}

				$full_html .= '<li>';
				$full_html .= '<span>' . $mixed_item['group_heading'] . '</span>';
				break;

			case 'page' :
				$post_id = $mixed_item['page_link'];

				if ( !$list_open ) {
					$full_html .= '<ul>';
					$list_open = true;
				}

				if ( $list_open ) {
					$full_html .= '<li>';
					$full_html .= '<a href="' . get_permalink($post_id) . '">';
					$full_html .= get_the_title($post_id);;
					$full_html .= '</a>';
					$full_html .= '</li>';
				}
				break;
		}
	}

	if ( $list_open ) {
		$full_html .= '</ul>';
		$full_html .= '</li>';
		$list_open = false;
	}

	$full_html .= '</ul>';
	return $full_html;
}




/**
 * i-contact wysiwyg shortcode
 * [icontact]
 */
add_shortcode('icontact', 'shortcode_icontact');
function shortcode_icontact()
{
	ob_start();
	get_template_part('inc', 'icontact-popup');
	return ob_get_clean();
}




/**
 * i-contact WiFi wysiwyg shortcode
 * [icontact-wifi]
 */
add_shortcode('icontact-wifi', 'shortcode_icontact_wifi');
function shortcode_icontact_wifi()
{
	ob_start();
	get_template_part('inc', 'wifi-popup');
	return ob_get_clean();
}




/**
 * Site Map shortcode
 * [sitemap]
 */
add_shortcode('sitemap', 'shortcode_sitemap');
function shortcode_sitemap()
{
	// return '<h2>hello from shortcode</h2>';
	ob_start();
	wp_list_pages();
	return ob_get_clean();
}

/**
 * Arrow Link Shortcode
 */
add_shortcode( 'arrowLink', 'jl_arrow_link_shortcode' );
function jl_arrow_link_shortcode( $atts, $content = '' ) {

	extract(
		shortcode_atts(
			array(
				'link'  => '#',
				'color' => '',
			), $atts
		)
	);

	if ( ! empty( $color ) ) {
		$color = ' ' . $color;
	} else {
		$color = '';
	}

	return '<a class="arrow-link'. $color . '" href="' . $link . '">' . $content . '</a>';
}





// ===========================================================================
//  ACF Search
// ===========================================================================
/**
 * Extend WordPress search to include custom fields
 *
 * http://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
	global $wpdb;

	if ( is_search() ) {
		$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}

	return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
	global $pagenow, $wpdb;

	if ( is_search() ) {
		$where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
	}

	return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
	global $wpdb;

	if ( is_search() ) {
		return "DISTINCT";
	}

	return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


/*
 * Add Image Size
 */
add_image_size( 'desktop-nav', 285, 210, true );

/**
 * [optional] Gravity Forms
 */

// Allow visibility setting for input labels
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// filter the Gravity Forms button type
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
	return "<button class='btn btn--fancy' id='gform_submit_button_{$form['id']}'><span>Submit</span></button>";
}
add_filter( 'gform_submit_button_2', 'form_submit_button_2', 99, 2 );
function form_submit_button_2( $button, $form ) {
	return "<button class='btn btn--fancy' id='gform_submit_button_{$form['id']}'><span>Request a Quote <i class='fa fa-chevron-circle-right'></i></span></button>";
}
