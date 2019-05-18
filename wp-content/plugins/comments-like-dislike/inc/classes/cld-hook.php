<?php

if ( !class_exists( 'CLD_Comments_Hooks' ) ) {

    class CLD_Comments_Hooks extends CLD_Library {

        function __construct() {
            parent::__construct();
            add_filter( 'comment_text', array( $this, 'comments_like_dislike' ), 200, 2 ); // hook to add html for like dislike
            add_action( 'cld_like_dislike_output', array( $this, 'generate_like_dislike_html' ), 10, 2 );
            add_action( 'wp_head', array( $this, 'custom_styles' ) );
        }

        function comments_like_dislike( $comment_text, $comment = null ) {

            /**
             * Don't append like dislike when links are being checked
             * 
             * @1.0.6
             */
            if ( isset( $_REQUEST['comment'] ) ) {
                return $comment_text;
            }
            /**
             * Don't implement on admin section
             *
             * @since 1.0.2
             */
            if ( is_admin() ) {
                return $comment_text;
            }
            ob_start();

            /**
             * Fires while generating the like dislike html
             *
             * @param type string $comment_text
             * @param type array $comment
             *
             * @since 1.0.0
             */
            do_action( 'cld_like_dislike_output', $comment_text, $comment );

            $like_dislike_html = ob_get_contents();
            ob_end_clean();
            $cld_settings = $this->cld_settings;
            if ( $cld_settings['basic_settings']['like_dislike_position'] == 'after' ) {
                /**
                 * Filters Like Dislike HTML
                 *
                 * @param string $like_dislike_html
                 * @param array $cld_settings
                 *
                 * @since 1.0.0
                 */
                $comment_text .= apply_filters( 'cld_like_dislike_html', $like_dislike_html, $cld_settings );
            } else {
                $comment_text = apply_filters( 'cld_like_dislike_html', $like_dislike_html, $cld_settings ) . $comment_text;
            }
            return $comment_text;
        }

        function generate_like_dislike_html( $comment_text, $comment ) {
            include(CLD_PATH . '/inc/views/frontend/like-dislike-html.php');
        }

        function custom_styles() {
            $cld_settings = $this->cld_settings;
            echo "<style>";
            if ( $cld_settings['design_settings']['icon_color'] != '' ) {
                echo 'a.cld-like-dislike-trigger {color: ' . esc_attr( $cld_settings['design_settings']['icon_color'] ) . ';}';
            }
            if ( $cld_settings['design_settings']['count_color'] != '' ) {
                echo 'span.cld-count-wrap {color: ' . esc_attr( $cld_settings['design_settings']['count_color'] ) . ';}';
            }
            echo "</style>";
        }

    }

    new CLD_Comments_Hooks();
}
