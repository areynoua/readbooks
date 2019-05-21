<?php

if ( !class_exists( 'CLD_Enqueue' ) ) {

    class CLD_Enqueue {

        /**
         * Includes all the frontend and backend JS and CSS enqueues
         * 
         * @since 1.0.0
         */
        function __construct() {
            add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_assets' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_backend_assets' ) );
        }

        function register_frontend_assets() {
            /**
             * Fontawesome 5 support 
             * 
             * @version 1.0.6
             */
            wp_enqueue_style( 'cld-font-awesome', CLD_CSS_DIR . '/fontawesome/css/all.min.css', array(), CLD_VERSION );
            wp_enqueue_style( 'cld-frontend', CLD_CSS_DIR . '/cld-frontend.css', array(), CLD_VERSION );
            wp_enqueue_script( 'cld-frontend', CLD_JS_DIR . '/cld-frontend.js', array( 'jquery' ), CLD_VERSION );
            $ajax_nonce = wp_create_nonce( 'cld-ajax-nonce' );

            $js_object = array( 'admin_ajax_url' => admin_url( 'admin-ajax.php' ), 'admin_ajax_nonce' => $ajax_nonce );
            wp_localize_script( 'cld-frontend', 'cld_js_object', $js_object );
        }

        function register_backend_assets( $hook ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_media();
            wp_enqueue_style( 'cld-admin-css', CLD_CSS_DIR . '/cld-backend.css', array(), CLD_VERSION );
            wp_enqueue_script( 'cld-admin-js', CLD_JS_DIR . '/cld-backend.js', array( 'jquery', 'wp-color-picker' ), CLD_VERSION );
            $ajax_nonce = wp_create_nonce( 'cld-backend-ajax-nonce' );
            $messages = array( 'wait' => __( 'Please wait', CLD_TD ), 'restore_confirm' => __( 'Are you sure you want to restore default settings?', CLD_TD ) );
            $js_object = array( 'admin_ajax_url' => admin_url( 'admin-ajax.php' ), 'admin_ajax_nonce' => $ajax_nonce, 'messages' => $messages );
            wp_localize_script( 'cld-admin-js', 'cld_admin_js_object', $js_object );
        }

    }

    new CLD_Enqueue();
}