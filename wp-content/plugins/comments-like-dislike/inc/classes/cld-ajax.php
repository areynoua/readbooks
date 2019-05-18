<?php

if ( !class_exists( 'CLD_Ajax' ) ) {

    class CLD_Ajax extends CLD_Library {

        function __construct() {
            add_action( 'wp_ajax_cld_comment_ajax_action', array( $this, 'like_dislike_action' ) );
            add_action( 'wp_ajax_nopriv_cld_comment_ajax_action', array( $this, 'like_dislike_action' ) );
        }

        function like_dislike_action() {
            if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'cld-ajax-nonce' ) ) {
                $comment_id = sanitize_text_field( $_POST['comment_id'] );
                /**
                 * Action cld_before_ajax_process
                 *
                 * @param type int $comment_id
                 *
                 * @since 1.0.7
                 */
                do_action( 'cld_before_ajax_process', $comment_id );
                $type = sanitize_text_field( $_POST['type'] );
                $user_ip = $this->get_user_IP();
                if ( $type == 'like' ) {
                    $like_count = get_comment_meta( $comment_id, 'cld_like_count', true );
                    if ( empty( $like_count ) ) {
                        $like_count = 0;
                    }
                    $like_count = $like_count + 1;
                    $check = update_comment_meta( $comment_id, 'cld_like_count', $like_count );

                    if ( $check ) {

                        $response_array = array( 'success' => true, 'latest_count' => $like_count );
                    } else {
                        $response_array = array( 'success' => false, 'latest_count' => $like_count );
                    }
                } else {
                    $dislike_count = get_comment_meta( $comment_id, 'cld_dislike_count', true );
                    if ( empty( $dislike_count ) ) {
                        $dislike_count = 0;
                    }
                    $dislike_count = $dislike_count + 1;
                    $check = update_comment_meta( $comment_id, 'cld_dislike_count', $dislike_count );
                    if ( $check ) {
                        $response_array = array( 'success' => true, 'latest_count' => $dislike_count );
                    } else {
                        $response_array = array( 'success' => false, 'latest_count' => $dislike_count );
                    }
                }
                /**
                 * Check the liked ips and insert the user ips for future checking
                 *
                 */
                $liked_ips = get_comment_meta( $comment_id, 'cld_ips', true );
                $liked_ips = (empty( $liked_ips )) ? array() : $liked_ips;
                if ( !in_array( $user_ip, $liked_ips ) ) {
                    $liked_ips[] = $user_ip;
                }
                /**
                 * Check if user is logged in to check user login for like dislike action
                 */
                if ( is_user_logged_in() ) {

                    $liked_users = get_comment_meta( $comment_id, 'cld_users', true );
                    $liked_users = (empty( $liked_users )) ? array() : $liked_users;
                    $current_user_id = get_current_user_id();
                    if ( !in_array( $current_user_id, $liked_users ) ) {
                        $liked_users[] = $current_user_id;
                    }
                    update_comment_meta( $comment_id, 'cld_users', $liked_users );
                }

                update_comment_meta( $comment_id, 'cld_ips', $liked_ips );
                /**
                 * Action cld_after_ajax_process
                 *
                 * @param type int $comment_id
                 *
                 * @since 1.0.7
                 */
                do_action( 'cld_after_ajax_process', $comment_id );
                echo json_encode( $response_array );

                //$this->print_array( $response_array );
                die();
            } else {
                die( 'No script kiddies please!' );
            }
        }

    }

    new CLD_Ajax();
}
