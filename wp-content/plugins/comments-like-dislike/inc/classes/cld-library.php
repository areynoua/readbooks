<?php

if ( !class_exists( 'CLD_Library' ) ) {

	class CLD_Library {

		var $cld_settings;

		function __construct() {
			$this->cld_settings = get_option( 'cld_settings' );
		}

		function print_array( $array ) {
			echo "<pre>";
			print_r( $array );
			echo "</pre>";
		}

		/**
		 * Returns default settings array
		 *
		 * @return array
		 *
		 * @since 1.0.0
		 */
		function get_default_settings() {
			$default_settings = array();
			$default_settings['basic_settings']['status'] = 0;
			$default_settings['basic_settings']['like_dislike_position'] = 'after';
			$default_settings['basic_settings']['like_dislike_display'] = 'both';
			$default_settings['basic_settings']['like_dislike_resistriction'] = 'cookie';
			$default_settings['basic_settings']['display_order'] = 'like-dislike';
			$default_settings['basic_settings']['like_hover_text'] = '';
			$default_settings['basic_settings']['dislike_hover_text'] = '';
			$default_settings['design_settings']['template'] = 'template-1';
			$default_settings['design_settings']['like_icon'] = '';
			$default_settings['design_settings']['dislike_icon'] = '';
			$default_settings['design_settings']['icon_color'] = '';
			$default_settings['design_settings']['count_color'] = '';
			/**
			 * Filters deault settings
			 *
			 * @param type array $default_settings
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'cld_default_settings', $default_settings );
		}

		/**
		 * Returns visitors IP address
		 *
		 * @return string $ip
		 *
		 * @since 1.0.0
		 */
		function get_user_IP() {
			$client = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote = $_SERVER['REMOTE_ADDR'];

			if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
				$ip = $client;
			} elseif ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
				$ip = $forward;
			} else {
				$ip = $remote;
			}

			return $ip;
		}

	}

}