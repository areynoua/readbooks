<?php
/**
* Plugin Name: WP Post Rating 
* Plugin URI: https://wordpress.org/plugins/wpcr-comment-rating/
* Description: A simple plugin for adding rating functionality to WordPress Posts, Pages with comments.
* Version: 2.1.6
* Author: Shoaib Saleem
* Author URI: https://profiles.wordpress.org/shoaib88/
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       wp-post-comment-rating
* Domain Path:       /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
	/** 
	***include necessary files
	**/
	require_once(  plugin_dir_path( __FILE__ ) . 'inc/setting.php');	
	require_once(  plugin_dir_path( __FILE__ ) . 'inc/function.php');
	include_once(  plugin_dir_path( __FILE__ ) . 'inc/richschema.php');
    include_once(  plugin_dir_path( __FILE__ ) . 'inc/shortcodes.php');
		
	/**
	*** necessary hooks 
	**/
	add_action( 'admin_init', 'wpcr_register_options');  // register options for the form
	add_action( 'admin_menu', 'wpcr_admin_links');  // register admin menu hyperlinks
	add_action( 'admin_enqueue_scripts', 'wpcr_admin_enqueue' );
	add_action( 'wp_enqueue_scripts', 'wpcr_enqueue_style' );
	add_action( 'plugins_loaded', 'wppr_rating_load_textdomain');
	
	
	/**
	 * Load plugin textdomain.
	 *
	 */
	
	function wppr_rating_load_textdomain() {
		$plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages';
		load_plugin_textdomain( 'wp-post-comment-rating', false, $plugin_rel_path );
	}

	
	/**
	*** admin enqueue scripts
	**/
	function wpcr_admin_enqueue() {
		wp_enqueue_style( 'wpcr_custom_style', plugin_dir_url( __FILE__ ) . 'assets/css/adminstyle.css' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wpcr-script-handle', plugin_dir_url( __FILE__ ).'assets/js/admin-script.js', array( 'wp-color-picker' ), false, true );
	}
	
	/**
	*** wp enqueue scripts
	**/
	function wpcr_enqueue_style() {
		wp_enqueue_script( 'wpcr_js', plugin_dir_url( __FILE__ ) . 'assets/js/custom.js', array('jquery'),'1.0' , true );
		wp_enqueue_style( 'wpcr_style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	}
	
	/**
	*** Function to register form fields
	**/
	function wpcr_register_options(){
		register_setting('wpcr_options_group', 'wpcr_settings', 'wpcr_validate');
	}

	/**
	*** Function to add hyperlinks to the admin menus using hooks and filters
	**/
	function wpcr_admin_links() {
	  $option_page = add_options_page('Rating Setup', 'Post Rating', 'manage_options', 'commentrating', 'wpcr_admin_page' );  // add link to settings page
		// Load the JS/CSS conditionally
        add_action( 'load-' . $option_page, 'wpcr_load_admin_js_css' );
	}
	// This function is only called when our plugin's page loads!
    function wpcr_load_admin_js_css(){
        add_action( 'admin_enqueue_scripts', 'wpcr_enqueue_admin_js_css' );
    }
	// This function is only called when our plugin's page loads!
    function wpcr_enqueue_admin_js_css(){
        wp_enqueue_style( 'wpcr_min_css', plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap.min.css' );
		wp_enqueue_script( 'wpcr_min_js', plugin_dir_url( __FILE__ ) . 'assets/js/bootstrap.min.js' );
    }
	/**
	*** Validate User Input
	**/
	function wpcr_validate($input) {
	  return array_map('wp_filter_nohtml_kses', (array)$input);
	}

	/**
	*** Load the (Admin setting) file
	**/
	load_template( dirname( __FILE__ ) . '/inc/admin-setting.php' );