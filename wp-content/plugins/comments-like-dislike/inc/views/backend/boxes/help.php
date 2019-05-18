<div class="cld-settings-section" data-settings-ref="help" style="display:none">
    <h3><?php _e( 'Status', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used to enable or disable like dislike in the frontend comments.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Like Dislike Position', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used to control whether like dislike should be shown before.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Like Dislike Display', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used to control whether like or dislike or both should be shown.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Like Dislike Restriction', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used to prevent liking or disliking same comments from same liker or disliker through Cookie or IP.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Like Dislike Display Order', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used control the display order of like and dislike.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Like Dislike Templates', CLD_TD ); ?></h3>
    <p><?php _e( 'There are altogether 5 templates including a custom template. Custom templates can be used to customize the like and dislike display by uploading your own icons.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Icon Color', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used to override the color of icon provided by your active theme.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>

    <h3><?php _e( 'Count Color', CLD_TD ); ?></h3>
    <p><?php _e( 'This can be used to override the color of count provided by your active theme.', CLD_TD ); ?></p>

    <div class="cld-separator"></div>
    <h3><?php _e( 'Available Filters', CLD_TD ); ?></h3>
    <div class="cld-fixed-height">

        <pre>
/**
 * Filters the tabs
 *
 * @since 1.0.0
 *
 * @param array $cld_tabs
 */
$cld_tabs = apply_filters( 'cld_admin_tabs', $cld_tabs );
        </pre>

        <pre>
/**
 * Filters total number or templates
 *
 * @param int
 *
 * @since 1.0.0
 */
$cld_total_templates = apply_filters( 'cld_total_templates', 4 );
        </pre>
        <pre>
/**
 * Filters the array stored in the database
 *
 * @param type array $cld_settings
 *
 * @since 1.0.0
 */
update_option( 'cld_settings', apply_filters( 'cld_settings', $cld_settings ) );
        </pre>
        <pre>
/**
* Filters Like Dislike HTML
*
* @param string $like_dislike_html
* @param array $cld_settings
*
* @since 1.0.0
*/
$comment_text .= apply_filters( 'cld_like_dislike_html', $like_dislike_html, $cld_settings );
        </pre>
        <pre>
/**
 * Filters deault settings
 *
 * @param type array $default_settings
 *
 * @since 1.0.0
 */
return apply_filters( 'cld_default_settings', $default_settings );
        </pre>
        <pre>
/**
 * Filters like count
 *
 * @param type int $like_count
 * @param type int $comment_id
 *
 * @since 1.0.0
 */
$like_count = apply_filters( 'cld_like_count', $like_count, $comment_id );
        </pre>
        <pre>
/**
 * Filters dislike count
 *
 * @param type int $dislike_count
 * @param type int $comment_id
 *
 * @since 1.0.0
 */
$dislike_count = apply_filters( 'cld_dislike_count', $dislike_count, $comment_id );
        </pre>
    </div>
    <div class="cld-separator"></div>

    <h3><?php _e( 'Available Actions', CLD_TD ); ?></h3>
    <div class="cld-fixed-height">
        <pre>
/**
 * Fires before storing the settings array into database
 *
 * @param type array $settings_data - before sanitization
 * @param type array $cld_settings - after sanitization
 *
 * @since 1.0.0
 */
 do_action( 'cld_before_save_settings', $settings_data, $cld_settings );
        </pre>
        <pre>
/**
 * Fires while generating the like dislike html
 *
 * @param type string $comment_text
 * @param type array $comment
 *
 * @since 1.0.0
 */
do_action( 'cld_like_dislike_output', $comment_text, $comment );
        </pre>
        <pre>
/**
 * Fires when Init hook is fired through plugin
 *
 * @since 1.0.0
 */
do_action('cld_init');
        </pre>
        <pre>
/**
 * Fires on backend template preview* Fires on backend template preview
 *
 * Useful to add additional templates in backend
 * Fires on backend template preview* Fires on backend template preview*
 * @param array $cld_settings
 *
 * @since 1.0.0
 *
 */
do_action( 'cld_template_previews' );
        </pre>
        <pre>
/**
 * Fires when displaying the tabs section
 *
 * @param array $cld_settings
 *
 * @since 1.0.0
 */
do_action( 'cld_admin_tab_section', $cld_settings );
        </pre>
        <pre>
/**
 * Fires when template is being loaded
 *
 * @param array $cld_settings
 *
 * @since 1.0.0
 */
do_action( 'cld_dislike_template', $cld_settings );
        </pre>
        <pre>
/**
 * Fires when template is being loaded
 *
 * @param array $cld_settings
 *
 * @since 1.0.0
 */
do_action( 'cld_like_template', $cld_settings );
        </pre>
        <pre>
/**
 * Action cld_before_ajax_process
 *
 * Fires just before processing the ajax request when like or dislike button is clicked
 *
 * @param type int $comment_id
 *
 * @since 1.0.7
 */
 do_action( 'cld_before_ajax_process', $comment_id );
        </pre>
        <pre>
/**
 * Action cld_after_ajax_process
 *
 * Fires after the ajax process is complete when like or dislike button is clicked just before printing the response
 *
 * @param type int $comment_id
 *
 * @since 1.0.7
 */
do_action( 'cld_after_ajax_process', $comment_id );
        </pre>
    </div>
</div>