<?php



if ( ! isset( $content_width ) ) $content_width = 812;



if(!function_exists('book_rev_lite_theme_setup')) {



	function book_rev_lite_theme_setup() { 



		// Takes care of the <title> tag.
		add_theme_support('title-tag');
 
 

		// Add theme support for custom logo.
		add_theme_support( 'custom-logo' );



		// Make theme available for translation

		load_theme_textdomain('book-rev-lite', get_template_directory() . '/languages');



		// Add theme support for featured images.

		add_theme_support( 'post-thumbnails' ); 



		// Add theme support for automatic feed links in the header.

		add_theme_support( 'automatic-feed-links' );

		// register menus
		register_nav_menus( array(

		    'primary' => __( 'Primary Header Menu', 'book-rev-lite' ),
			'secondary' => __( 'Top Bar Menu', 'book-rev-lite' ),

		));


		// Setup theme customizer settings & controls.

		require_once(get_template_directory() . "/inc/cc_settings.php");

		require_once(get_template_directory() . '/inc/customizer-info/class/class-singleton-customizer-info-section.php' );
		

	}	

}



// Initialize the comments template function callback.

require_once(get_template_directory() . "/templates/bookrev_comments_cb_template.php");



require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';



add_action( 'tgmpa_register', 'book_rev_lite_required_plugins' );

function book_rev_lite_required_plugins() {



	/**

	 * Array of plugin arrays. Required keys are name and slug.

	 * If the source is NOT from the .org repo, then source is also required.

	 */

	$plugins = array(



		// This is an example of how to include a plugin from the WordPress Plugin Repository

		array(

			'name' 		=> 'WP Product Review',

			'slug' 		=> 'wp-product-review',

			'required' 	=> false,

		),

		array(

			'name' 		=> 'Orbit Fox',

			'slug' 		=> 'themeisle-companion',

			'required' 	=> false,

		)

		

	);



	/**

	 * Array of configuration settings. Amend each line as needed.

	 * If you want the default strings to be available under your own theme domain,

	 * leave the strings uncommented.

	 * Some of the strings are added into a sprintf, so see the comments at the

	 * end of each line for what each argument will be.

	 */

	$config = array(

		'domain'       		=> 'book-rev-lite',         	// Text domain - likely want to be the same as your theme.

		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins

		'menu'         		=> 'install-required-plugins', 	// Menu slug

		'has_notices'      	=> true,                       	// Show admin notices or not

		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not

		'message' 			=> '',							// Message to output right before the plugins table

		'strings'      		=> array(

			'page_title'                       			=> __( 'Install Required Plugins', 'book-rev-lite' ),

			'menu_title'                       			=> __( 'Install Plugins', 'book-rev-lite' ),

			'installing'                       			=> __( 'Installing Plugin: %s', 'book-rev-lite' ), // %1$s = plugin name

			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'book-rev-lite' ),

			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'book-rev-lite' ), // %1$s = plugin name(s)

			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','book-rev-lite' ), // %1$s = plugin name(s)

			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','book-rev-lite' ), // %1$s = plugin name(s)

			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','book-rev-lite' ), // %1$s = plugin name(s)

			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','book-rev-lite' ), // %1$s = plugin name(s)

			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','book-rev-lite' ), // %1$s = plugin name(s)

			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','book-rev-lite' ), // %1$s = plugin name(s)

			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','book-rev-lite' ), // %1$s = plugin name(s)

			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins','book-rev-lite' ),

			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins','book-rev-lite' ),

			'return'                           			=> __( 'Return to Required Plugins Installer', 'book-rev-lite' ),

			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'book-rev-lite' ),

			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'book-rev-lite' ), // %1$s = dashboard link

			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'

		)

	);



	tgmpa( $plugins, $config );



}



/**

 * book_rev_lite_load_req_scripts loads the required scrips and enqueues the required theme styles.

 */

if(!function_exists('book_rev_lite_load_req_scripts')) {

	function book_rev_lite_load_req_scripts() {

		

		// Register and enqueue jQuery Superfish Plugin.

		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ) );



		// Register and enqueue jQuery Cycle Plugin.

		wp_enqueue_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.min.js', array( 'jquery' ) );



		// Register and enqueue jQuery Cycle Plugin.

		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array( 'jquery' ) );



		// Load the main JavaScript file.

		wp_enqueue_script( 'book-rev-lite-main-js', get_template_directory_uri() . '/js/master.js', array( 'jquery', "jquery-cycle" ));


		// Load html5.js only on IE.
		wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5.js');
		wp_script_add_data( 'html5shiv', 'conditional', 'IE' );


		// Load the css framework.

		wp_enqueue_style( 'book-rev-lite-css-framework', get_template_directory_uri() . '/css/framework.css'); 



		// Register and enqueue the main stylesheet.

		wp_enqueue_style( 'book-rev-lite-main-css', get_stylesheet_uri(), array(), '1.7.4' );



		wp_enqueue_style( 'book-rev-lite-arvo-font', '//fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic'); 



		wp_enqueue_style( 'book-rev-lite-titilium-font', '//fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic');  



		// Load the responsive css styles.

		wp_enqueue_style( 'book-rev-lite-css-responsive', get_template_directory_uri() . '/css/responsive.css'); 



		// Load FontAwesome Icon Pack.

		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');

	}

}



// Register theme specific sidebars.

if(!function_exists('book_rev_lite_register_sidebars')) {

	function book_rev_lite_register_sidebars() {

		register_sidebar( array(

			'name'          => 'Primary Sidebar',

			'id'            => 'book_rev_lite_primary_sidebar',

			'before_widget' => '<div class="widget">',

			'after_widget'  => '</div><!-- end .widget -->',

			'before_title'  => '<header><h2>',

			'after_title'   => '</h2></header>',

		));



		register_sidebar( array(

			'name'          => 'Footer Sidebar',

			'id'            => 'book_rev_lite_footer_sidebar',

			'before_widget' => '<div class="widget">',

			'after_widget'  => '</div><!-- end .widget -->',

			'before_title'  => '<header><h2>',

			'after_title'   => '</h2></header>',

		));

	}

}


// Custom recursive array search function

if(!function_exists('book_rev_lite_recursive_array_search')) {

	function book_rev_lite_recursive_array_search($needle,$haystack) {

	    foreach($haystack as $key=>$value) {

	        $current_key=$key;

	        if($needle===$value OR (is_array($value) && book_rev_lite_recursive_array_search($needle,$value) !== false)) {

	            return $current_key;

	        }

	    }

	    return false;

	}

}



// Replaces the title template with specific category or field

if(!function_exists("book_rev_lite_string_template_category_replace")) {

	function book_rev_lite_string_template_category_replace($title, $categ, $tpl) {

		$fcb_title = get_theme_mod($title);

		preg_match_all("/{{([^}]*)}}/", $fcb_title, $fcb_title_output);

			if(book_rev_lite_recursive_array_search("{{".$tpl."}}", $fcb_title_output) !== false) {

				$selected_category_id = get_theme_mod($categ);

				$fcb_title = str_replace("{{".$tpl."}}", get_cat_name($selected_category_id), $fcb_title);

				echo $fcb_title; 

			} else {

				echo $fcb_title;

			}

	}

}

// Display limited content

if(!function_exists('book_rev_lite_get_limited_content')) {

	function book_rev_lite_get_limited_content($id, $character_count, $after) {

		$content = get_the_excerpt();

		echo substr( $content, 0, $character_count ) . $after;

	}	

}



function book_rev_lite_excerpt_length($length) {

    return 200;

}

add_filter('excerpt_length', 'book_rev_lite_excerpt_length');


// Migrate favicon from theme favicon to core

function book_rev_lite_migrate_favicon(){
	if ( function_exists( 'wp_site_icon' ) ) {
		if ( get_theme_mod('favicon-image') ) {
			$id = attachment_url_to_postid( get_theme_mod('favicon-image') );
			if ( is_int( $id ) ) {
				update_option( 'site_icon', $id );
			}
			remove_theme_mod( 'favicon-image' );
		}
	}
}

add_action( 'after_setup_theme', 'book_rev_lite_migrate_favicon' );


// Migrate logo from theme to core

function book_rev_lite_migrate_logo(){
	if ( get_theme_mod('header-logo') ) {
		$logo = attachment_url_to_postid( get_theme_mod( 'header-logo' ) );
		if ( is_int( $logo ) ) {
			set_theme_mod( 'custom_logo', $logo );
		}
		remove_theme_mod( 'header-logo' );
	}
}

add_action( 'after_setup_theme', 'book_rev_lite_migrate_logo' );


if ( ! function_exists( 'book_rev_lite_get_review_grade' ) ) {
    /**
     * Display Review Grade
     */
    function book_rev_lite_get_review_grade( $id ) {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $total = 0;
            $cwppos_options = get_post_meta( get_the_ID(), 'wppr_options', true );
            if ( ! empty( $cwppos_options ) ) {
                foreach ( $cwppos_options as $option ) {
                    if ( ! empty( $option['value'] ) ) {
                        $total += $option['value'];
                    }
                }
                return round( $total / count( $cwppos_options ), 0 ) / 10;
            }
        }
        return false;
    }
}





if(!function_exists('book_rev_lite_display_review_grade')) {

	function book_rev_lite_display_review_grade($grade) {

		echo $grade . "/10";

	}	

}



if ( ! function_exists( 'book_rev_lite_get_product_review_colors' ) ) {
    /**
     * Get the product review colors.
     *
     * @return mixed
     */
    function book_rev_lite_get_product_review_colors() {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $c = array();
            $cwppos_options = get_option( 'cwppos_options' );
            if ( ! empty( $cwppos_options ) ) {
                if ( ! empty( $cwppos_options['cwppos_rating_default'] ) ) {
                    $c['default'] = $cwppos_options['cwppos_rating_default'];
                } else {
                    $c['default'] = 'rgb(235, 235, 235)';
                }
                if ( ! empty( $cwppos_options['cwppos_rating_weak'] ) ) {
                    $c['weak'] = $cwppos_options['cwppos_rating_weak'];
                } else {
                    $c['weak'] = 'rgb(255, 127, 102)';
                }
                if ( ! empty( $cwppos_options['cwppos_rating_notbad'] ) ) {
                    $c['nb'] = $cwppos_options['cwppos_rating_notbad'];
                } else {
                    $c['nb'] = 'rgb(255, 206, 85)';
                }
                if ( ! empty( $cwppos_options['cwppos_rating_good'] ) ) {
                    $c['good'] = $cwppos_options['cwppos_rating_good'];
                } else {
                    $c['good'] = 'rgb(80, 193, 233)';
                }
                if ( ! empty( $cwppos_options['cwppos_rating_very_good'] ) ) {
                    $c['vg'] = $cwppos_options['cwppos_rating_very_good'];
                } else {
                    $c['vg'] = 'rgb(141, 193, 83)';
                }
            }
            return $c;
        }
    }
}

if ( ! function_exists( 'book_rev_lite_display_review_class' ) ) {
    /**
     * In case WP Product Review plugin is installed and active this function
     * is responsable for generating the required classes based on what grade
     * is passed.
     */
    function book_rev_lite_display_review_class( $grade ) {

        $class = 'default';

        if ( function_exists( 'cwppos_show_review' ) ) {

            if ( $grade <= 2.5 ) {
                $class = 'weak';
            }

            if ( $grade > 2.5 && $grade <= 5 ) {
                $class = 'nb';
            }

            if ( $grade > 5 && $grade <= 7.5 ) {
                $class = 'good';
            }

            if ( $grade > 7.5 && $grade <= 10 ) {
                $class = 'vg';
            }
        }

        return $class;
    }
}


/**

 * Function responsable for filtering the title in case its empty.

 * @return string [description]

 */

if(!function_exists('book_rev_lite_filter_default_title')) {

	function book_rev_lite_filter_default_title($title) {

		if($title == "") { $title = __("Default Title", "book-rev-lite"); }

		return $title;

	}	

}




if(!function_exists("book_rev_lite_excerpt_filter")) {

	function book_rev_lite_excerpt_filter() {

		return '...';

	}

}



/**

 * If WP Product Review plugin is installed and active define the required template

 * specific functions in order for the review wrap up template part of the theme to 

 * function properly.  

 */


	if(!function_exists("book_rev_lite_wpr_get_title")) {

	    function book_rev_lite_wpr_get_title() {

	        if(function_exists('cwppos_show_review')) {
				$product_name = get_post_meta(get_the_ID(), "cwp_rev_product_name", true);
	            return esc_html($product_name);
	        }

	    }

	}



	if(!function_exists("book_rev_lite_wpr_get_status")) {

	    function book_rev_lite_wpr_get_status() {

	        if(function_exists('cwppos_show_review')) {

	            return get_post_meta(get_the_ID(), "cwp_meta_box_check", true);

	        }

	    }

	}



	if(!function_exists("book_rev_lite_wpr_get_product_image")) {

	    function book_rev_lite_wpr_get_product_image() {

	    	if(get_post_meta(get_the_ID(), 'cwp_rev_product_image', 'true')) {

	    		return get_post_meta(get_the_ID(), 'cwp_rev_product_image', true);

	    	} elseif( has_post_thumbnail() ) {

	    		return wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));

	    	} else {

	    		return get_theme_mod('default-product-image-upload');
	    		
	    	}
	    }		

	}



if ( ! function_exists( 'book_rev_lite_wpr_get_review_options' ) ) {
    /**
     * Show review.
     *
     * @return mixed
     */
    function book_rev_lite_wpr_get_review_options() {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $nr_cwppos_options = 5;
            $cwppos_options = get_post_meta( get_the_ID(), 'wppr_options', true );
            if ( ! empty( $cwppos_options ) ) {
                return array_slice( $cwppos_options, 0, $nr_cwppos_options );
            }
        }
        return array();
    }
}



if ( ! function_exists( 'book_rev_lite_wpr_get_pros' ) ) {
    /**
     * Get pros.
     *
     * @return mixed
     */
    function book_rev_lite_wpr_get_pros() {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $nr_cwppos_options = 5;
            $cwppos_options = get_post_meta( get_the_ID(), 'wppr_pros', true );
            if ( ! empty( $cwppos_options ) ) {
                return array_slice( $cwppos_options, 0, $nr_cwppos_options );
            }
        }
        return array();
    }
}



if ( ! function_exists( 'book_rev_lite_wpr_get_cons' ) ) {
    /**
     * Get cons.
     *
     * @return mixed
     */
    function book_rev_lite_wpr_get_cons() {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $nr_cwppos_options = 5;
            $cwppos_options = get_post_meta( get_the_ID(), 'wppr_cons', true );
            if ( ! empty( $cwppos_options ) ) {
                return array_slice( $cwppos_options, 0, $nr_cwppos_options );
            }
        }
        return array();
    }
}



if ( ! function_exists( 'book_rev_lite_wpr_get_affiliate_text' ) ) {
    /**
     * Get affiliate text.
     *
     * @return mixed
     */
    function book_rev_lite_wpr_get_affiliate_text() {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $links = get_post_meta( get_the_ID(), 'wppr_links' );
            if ( is_array( $links ) && is_array( $links[0] ) ) {
                $texts = array_keys( $links[0] );
                if ( ! empty( $texts ) ) {
                    return $texts[0];
                }
            }
        }
        return '';
    }
}


if ( ! function_exists( 'book_rev_lite_wpr_get_affiliate_link' ) ) {
    /**
     * Get affiliate link.
     *
     * @return mixed
     */
    function book_rev_lite_wpr_get_affiliate_link() {
        if ( function_exists( 'cwppos_show_review' ) ) {
            $links = get_post_meta( get_the_ID(), 'wppr_links' );
            if ( is_array( $links ) && is_array( $links[0] ) ) {
                $urls = array_values( $links[0] );
                if ( ! empty( $urls ) ) {
                    return $urls[0];
                }
            }
        }
        return '';
    }
}

/**

 * Hooks & Filters

 */



// Default Widget Title Filter.

add_filter('widget_title', 'book_rev_lite_filter_default_title');



// Default Post Title Filter.

add_filter('the_title', 'book_rev_lite_filter_default_title');



// Excerpt "[...]" filter.

add_filter('excerpt_more', 'book_rev_lite_excerpt_filter');



// After theme setup hook.

add_action( 'after_setup_theme', 'book_rev_lite_theme_setup' ); 



// Enqueue required scripts hook.

add_action( 'wp_enqueue_scripts', 'book_rev_lite_load_req_scripts' );



// Hook Customizer. 

add_action( 'customize_register', 'book_rev_lite_theme_customizer' );



// Register theme specific sidebars.

add_action( 'widgets_init', 'book_rev_lite_register_sidebars' );


/* customizer styles */

add_action('wp_print_scripts','book_rev_lite_php_style');

function book_rev_lite_php_style() {

	echo "<style type='text/css'>";

	// If CWP Product Review plugin is active and running set up the special classes.

	if(function_exists('cwppos_show_review')) {

		$setColors = book_rev_lite_get_product_review_colors();

		foreach($setColors as $key => $value) echo ".grade." . $key . " { background: " . $value . " !important;} ";	

	}

	// Set lower footer background color.

	$cwp_wpc_upper_footer_bg_color = get_theme_mod("lower-footer-background-color");

	if( !empty($cwp_wpc_upper_footer_bg_color) ) {

		echo "#main-footer .lower-footer { background:" .  esc_html($cwp_wpc_upper_footer_bg_color) . "; }";

	}

	// Set upper footer background color.

	$cwp_wpc_footer_bg_color = get_theme_mod("footer-background-color");

	if( !empty($cwp_wpc_footer_bg_color) ) {

		echo "#main-footer .upper-footer { background:" .  esc_html($cwp_wpc_footer_bg_color) . "; }";

	}

	// Set header background color.

	$cwp_wpc_header_bg_color = get_theme_mod("header-background-color");

	if( !empty($cwp_wpc_header_bg_color) ) {

		echo "#inner-header { background:" .  esc_html($cwp_wpc_header_bg_color) . "; }";

	}

	// Set header menu background color.

	$cwp_wpc_header_menu_bg_color = get_theme_mod("header-menu-background-color");

	if( !empty($cwp_wpc_header_menu_bg_color) ) {

		echo "#main-menu { background:" .  esc_html($cwp_wpc_header_menu_bg_color) . "; }";

	}

	// Set header logo.

	$cwp_wpc_header_logo_width = get_theme_mod("logo-width",'176');

	$cwp_wpc_header_logo_height = get_theme_mod("logo-height",'56');

	if( has_custom_logo() ) {

		echo ".custom-logo-link img { width: " . (int)$cwp_wpc_header_logo_width . "px !important; height: " . (int)$cwp_wpc_header_logo_height . "px !important;}";

	}

	// Set the main page layout styles.

	$cwp_wpc_layout_style = get_theme_mod("mp_layout_type");

	if( isset($cwp_wpc_layout_style) && ($cwp_wpc_layout_style == "sidebarleft") ) {

		echo ".article-container { margin-right: 0; margin-left: 1.4%; }";

	}

	elseif ( isset($cwp_wpc_layout_style) && ($cwp_wpc_layout_style == "fullwidth") ) {

		echo ".article-container { margin: 0; width: 100%; }";

	}

	// Set the featured category block background color.

	$cwp_featured_categ_block_bg_color = get_theme_mod("featured-category-block-bgcolor");

	if( !empty($cwp_featured_categ_block_bg_color) ) {

		echo ".featured-carousel { background:" . esc_html($cwp_featured_categ_block_bg_color) . ";}";	

	}

	// Set the latest articles block background color.

	$cwp_la_block_bgcolor = get_theme_mod("latest-articles-block-bgcolor");

	if( !empty($cwp_la_block_bgcolor) ) {

		echo "#latest-reviews-block .lrb-inner { background:" . esc_html($cwp_la_block_bgcolor) . ";}";

		echo "#latest-reviews-block .article-display .article-text { background: " . esc_html($cwp_la_block_bgcolor) . ";}";

	}

	// Set the latest articles item hover background color.

	$cwp_lab_item_bgcolor = get_theme_mod("lab-article-hover-bgcolor");

	if( !empty($cwp_lab_item_bgcolor) ) {

		echo "#latest-reviews-block .article-link.active, #latest-reviews-block .article-link:hover { background:" . esc_html($cwp_lab_item_bgcolor) . " !important; }";

	}

	// Set the highlight of the Day block background color.

	$cwp_hotd_block_bgcolor = get_theme_mod("hotd-bg-color");

	if( !empty($cwp_hotd_block_bgcolor) ) {

		echo "#highlight-day .highlight-inner { background:".esc_html($cwp_hotd_block_bgcolor).";}";

	}

	// Set the article background color.

	$cwp_article_bgcolor = get_theme_mod("article-bgcolor");

	if( !empty($cwp_article_bgcolor) ) {

		echo ".article-container article { background:".esc_html($cwp_article_bgcolor)." ;}";

	}

	// Set the pagination background color.

	$cwp_pagination_bgcolor = get_theme_mod("pagination-bgcolor");

	if( !empty($cwp_pagination_bgcolor) ) {

		echo "nav#pagination { background: " . esc_html($cwp_pagination_bgcolor) . " ;}";

	}

	// Block Header Background color.

	$cwp_blockheader_bgcolor = get_theme_mod("block-header-bgcolor");

	if( !empty($cwp_blockheader_bgcolor) ) {

		echo ".article-container .newsblock > header { background:" . esc_html($cwp_blockheader_bgcolor) . ";}";

	}

	// Widget Header Background Color.

	$cwp_widget_header_bgcolor = get_theme_mod("widget-header-bgcolor");

	if( !empty($cwp_widget_header_bgcolor) ) {

		echo "#main-sidebar .widget header { background:" . esc_html($cwp_widget_header_bgcolor) . ";}";	

	}

	// Widget Header Top Border Color.

	$cwp_widget_header_border_bgcolor = get_theme_mod("widget-header-border-color");

	if( !empty($cwp_widget_header_border_bgcolor) ) {

		echo "#main-sidebar .widget header { border-color:" . esc_html($cwp_widget_header_border_bgcolor) . ";}";	

	}

	// Pagination Button Color.

	$cwp_pagination_button_color = get_theme_mod("pagination-button-color");

	if( !empty($cwp_pagination_button_color) ) {

		echo "nav#pagination ul li a { background:" . esc_html($cwp_pagination_button_color) . ";}";	

	}

	// Pagination Button Color Hover

	$cwp_pagination_button_color = get_theme_mod("pagination-button-color-hover");

	if( !empty($cwp_pagination_button_color) ) {

		echo "nav#pagination ul li a:hover { background:" . esc_html($cwp_pagination_button_color) . ";}";	

	}

	// Pagination Button Color Active

	$cwp_pagination_button_active = get_theme_mod("pagination-button-color-active");

	if( !empty($cwp_pagination_button_active) ) {

		echo "nav#pagination ul li.active a { background:" . esc_html($cwp_pagination_button_active) . ";}";	

	}

	// Articles Title Fonts

	$cwp_article_title_font = get_theme_mod("article-title-font");

	if( !empty($cwp_article_title_font) ) {

		echo "
		
		article a.title, .article-title a, .title a, .sd-title a, .featured-carousel .slide .article-content header h3,

		.article-container.post > header .title,

		.article-container.post #wrap-up .review-header h3,

		#main-menu nav ul li a,

		#top-bar-menu ul li a,

		.widget header h2

		{ font-family: " . '"' .  esc_html($cwp_article_title_font). '"' . ", sans-serif !important; }

		";

	}

	// Articles Content Font

	$cwp_article_content_font = get_theme_mod('article-content-font');

	if( !empty($cwp_article_content_font) ) {

		echo "

			#slider .slide .sd-body p,

			.featured-carousel .slide .article-content .content p,

			#latest-reviews-block .article-display .article-text,

			.widget.latest-comments p,

			#highlight-day p,

			.widget.text p,

			.article-container article p,

			#main-footer .widget .comment,

			#main-footer .widget .article,

			.textwidget,

			.widget,

			.widget a,

			.review-body .option-name,

			.article-container.post #wrap-up .proscons li

			{ font-family: " . '"' .  esc_html($cwp_article_content_font) . '"' . ", sans-serif !important; }

		";

	}

	$cwp_meta_info_font = get_theme_mod('meta-info-font');

	if( !empty($cwp_meta_info_font) ) {

	echo "

		.featured-carousel .slide .article-content header .meta .category a,

		.featured-carousel .slide .article-content header .meta .date,

		#slider .sd-meta .read-more,

		#slider .sd-meta span a,

		#latest-reviews-block .article-link .article-meta .categ a,

		#latest-reviews-block .article-link .article-meta .date,

		#latest-reviews-block .article-display .a-details .category a,

		#latest-reviews-block .article-display .a-details .date,

		.widget.topbooks .meta .categ a,

		.widget.topbooks .meta .date,

		.featured-carousel .slide .feat-img .comment-count a,

		.article-container article .feat-img .comment-count a,

		#latest-reviews-block .article-display .featured-image .a-meta .grade,

		#latest-reviews-block .article-display .featured-image .a-meta .no-comments a,

		.widget.topbooks .grade,

		.widget.latest-comments h4,

		#highlight-day .meta .categ a,

		#highlight-day .meta .date,

		.article-container article header .meta .categ a,

		.article-container article header .meta .date,

		.widget.topbooks .meta .categ a,

		.widget.topbooks .meta .date,

		.widget.topbooks .grade,

		.featured-carousel .slide .feat-img .grade,

		.article-container article .feat-img .grade,

		#slider .slide .slide-description .top-sd-head .grade,

		#slider .sd-meta span,

		.article-container.post > header .article-details .date

		{ font-family: " . '"' .  esc_html($cwp_meta_info_font) . '"' . ", sans-serif !important; }

	";
	
	}

	echo "</style>";
}

/* enqueue google fonts */

add_action( 'wp_enqueue_scripts', 'book_rev_lite_options_typography_google_fonts' );

function book_rev_lite_options_typography_google_fonts() {

	$article_title_font = get_theme_mod('article-title-font');
	
	if( !empty($article_title_font) ):
	
		$article_title_font = str_replace(" ", "+", $article_title_font);

		wp_enqueue_style( "book_rev_lite_options_typography_$article_title_font", "//fonts.googleapis.com/css?family=$article_title_font", false, null, 'all' );
		
	endif;	
	
	$meta_info_font = get_theme_mod('meta-info-font');
	
	if( !empty($meta_info_font) ):
	
		$meta_info_font = str_replace(" ", "+", $meta_info_font);

		wp_enqueue_style( "book_rev_lite_options_typography_$meta_info_font", "//fonts.googleapis.com/css?family=$meta_info_font", false, null, 'all' );
	
	endif;	
	
	$article_content_font = get_theme_mod('article-content-font');
	
	if( !empty($article_content_font) ):
	
		$article_content_font = str_replace(" ", "+", $article_content_font);

		wp_enqueue_style( "book_rev_lite_options_typography_$article_content_font", "//fonts.googleapis.com/css?family=$article_content_font", false, null, 'all' );
	
	endif;
}

/* WooCommerce Support */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/* Add container on Shop Page*/
function book_rev_lite_before_shop_loop() {
	?>
	<div class="container">
	<?php
}
add_action( 'woocommerce_before_main_content', 'book_rev_lite_before_shop_loop', 10 );

/* Close container on Shop Page */
function book_rev_lite_after_shop_loop() {
	?>
	</div>
	<?php
}
add_action( 'woocommerce_after_main_content', 'book_rev_lite_after_shop_loop', 10 );
