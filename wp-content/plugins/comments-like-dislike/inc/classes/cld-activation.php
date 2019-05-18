<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );
if ( !class_exists( 'CLD_Activation' ) ) {

	class CLD_Activation extends CLD_Library {

		/**
		 * Includes all the activation tasks
		 * 
		 * @since 1.0.0
		 */
		function __construct() {
			register_activation_hook( CLD_PATH . 'comments-like-dislike.php', array( $this, 'activation_tasks' ) );
		}
		
		/**
		 * Store default settings in database on activation
		 * 
		 * @since 1.0.0
		 */
		function activation_tasks() {
			$default_settings = $this->get_default_settings();
			if(!get_option('cld_settings')){
				update_option('cld_settings',$default_settings);
			}
		}

		

	}

	new CLD_Activation();
}