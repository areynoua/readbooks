<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );

if ( !class_exists( 'CLD_Admin' ) ) {

    class CLD_Admin extends CLD_Library {

        function __construct() {
            parent::__construct();
            add_action( 'admin_menu', array( $this, 'cld_admin_menu' ) );

            /**
             * Plugin Settings link in plugins screen
             *
             */
            add_filter( 'plugin_action_links_' . CLD_BASENAME, array( $this, 'add_setting_link' ) );

            /**
             * Settings save action
             */
            add_action( 'wp_ajax_cld_settings_save_action', array( $this, 'save_settings' ) );
            add_action( 'wp_ajax_nopriv_cld_settings_save_action', array( $this, 'no_permission' ) );

            /**
             * Settings restore action
             */
            add_action( 'wp_ajax_cld_settings_restore_action', array( $this, 'restore_settings' ) );
            add_action( 'wp_ajax_nopriv_cld_settings_restore_action', array( $this, 'no_permission' ) );

            /**
             * Add like dislike columns in comments section
             *
             * @since 1.0.5
             */
            add_filter( 'manage_edit-comments_columns', array( $this, 'add_like_dislike_column' ) );

            /**
             * Display Like Dislike count in each column
             *
             * @since 1.0.5
             */
            add_filter( 'manage_comments_custom_column', array( $this, 'display_like_dislike_values' ), 10, 2 );
        }

        function cld_admin_menu() {
            add_comments_page( __( 'Comments Like Dislike', 'comments-like-dislike' ), __( 'Comments Like Dislike', 'comments-like-dislike' ), 'manage_options', 'comments-like-dislike', array( $this, 'cld_settings' ) );
        }

        function cld_settings() {
            include(CLD_PATH . 'inc/views/backend/settings.php');
        }

        function save_settings() {
            if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'cld-backend-ajax-nonce' ) ) {
                $_POST = stripslashes_deep( $_POST );
                parse_str( $_POST['settings_data'], $settings_data );
                foreach ( $settings_data['cld_settings'] as $key => $val ) {
                    $cld_settings[$key] = array_map( 'sanitize_text_field', $val );
                }
                /**
                 * Fires before storing the settings array into database
                 *
                 * @param type array $settings_data - before sanitization
                 * @param type array $cld_settings - after sanitization
                 *
                 * @since 1.0.0
                 */
                do_action( 'cld_before_save_settings', $settings_data, $cld_settings );

                /**
                 * Filters the settings stored in the database
                 *
                 * @param type array $cld_settings
                 *
                 * @since 1.0.0
                 */
                update_option( 'cld_settings', apply_filters( 'cld_settings', $cld_settings ) );
                die( __( 'Settings saved successfully', CLD_TD ) );
            } else {
                die( 'No script kiddies please!!' );
            }
        }

        function no_permission() {
            die( 'No script kiddies please!!' );
        }

        function restore_settings() {
            $default_settings = $this->get_default_settings();
            update_option( 'cld_settings', $default_settings );
            die( __( 'Settings restored successfully.Redirecting...', CLD_TD ) );
        }

        /**
         * Adds settings link
         *
         * @since 1.0.0
         */
        function add_setting_link( $links ) {
            $settings_link = array(
                '<a href="' . admin_url( 'edit-comments.php?page=comments-like-dislike' ) . '">' . __( 'Settings', CLD_TD ) . '</a>',
            );
            return array_merge( $links, $settings_link );
        }

        function add_like_dislike_column( $columns ) {
            $columns['cld_like_column'] = __( 'Likes', 'comments-like-dislike' );
            $columns['cld_dislike_column'] = __( 'Dislikes', 'comments-like-dislike' );
            return $columns;
        }

        function display_like_dislike_values( $column, $comment_id ) {
            if ( 'cld_like_column' == $column ) {
                $like_count = get_comment_meta( $comment_id, 'cld_like_count', true );
                if ( empty( $like_count ) ) {
                    $like_count = 0;
                }
                echo $like_count;
            }
            if ( 'cld_dislike_column' == $column ) {
                $dislike_count = get_comment_meta( $comment_id, 'cld_dislike_count', true );
                if ( empty( $dislike_count ) ) {
                    $dislike_count = 0;
                }
                echo $dislike_count;
            }
        }

    }

    new CLD_Admin();
}
