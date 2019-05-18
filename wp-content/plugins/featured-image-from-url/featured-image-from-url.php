<?php

/*
 * Plugin Name: Featured Image from URL
 * Plugin URI: https://featuredimagefromurl.com/
 * Description: Use an external image as Featured Image of your post/page/custom post type (WooCommerce). Includes Auto Set (External Post), Product Gallery, Social Tags and more.
 * Version: 2.4.6
 * Author: Marcel Jacques Machado 
 * Author URI: https://www.linkedin.com/in/marceljm/
 */

define('FIFU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FIFU_INCLUDES_DIR', FIFU_PLUGIN_DIR . 'includes');
define('FIFU_ADMIN_DIR', FIFU_PLUGIN_DIR . 'admin');

require_once (FIFU_INCLUDES_DIR . '/attachment.php');
require_once (FIFU_INCLUDES_DIR . '/convert-url.php');
require_once (FIFU_INCLUDES_DIR . '/external-post.php');
require_once (FIFU_INCLUDES_DIR . '/thumbnail.php');
require_once (FIFU_INCLUDES_DIR . '/thumbnail-category.php');
require_once (FIFU_INCLUDES_DIR . '/util.php');
require_once (FIFU_INCLUDES_DIR . '/woo.php');

require_once (FIFU_ADMIN_DIR . '/api.php');
require_once (FIFU_ADMIN_DIR . '/db.php');
require_once (FIFU_ADMIN_DIR . '/category.php');
require_once (FIFU_ADMIN_DIR . '/column.php');
require_once (FIFU_ADMIN_DIR . '/menu.php');
require_once (FIFU_ADMIN_DIR . '/meta-box.php');

register_activation_hook(__FILE__, 'fifu_activate');

function fifu_activate($network_wide) {
    if (is_multisite() && $network_wide) {
        global $wpdb;
        foreach ($wpdb->get_col("SELECT blog_id FROM $wpdb->blogs") as $blog_id) {
            switch_to_blog($blog_id);
            fifu_db_change_url_length();
        }
    } else
        fifu_db_change_url_length();
}

add_action('upgrader_process_complete', 'fifu_upgrade', 10, 2);

function fifu_upgrade($upgrader_object, $options) {
    $current_plugin_path_name = plugin_basename(__FILE__);
    if ($options['action'] == 'update' && $options['type'] == 'plugin') {
        foreach ($options['plugins'] as $each_plugin) {
            if ($each_plugin == $current_plugin_path_name)
                fifu_db_change_url_length();
        }
    }
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fifu_action_links');
add_filter('network_admin_plugin_action_links_' . plugin_basename(__FILE__), 'fifu_action_links');

function fifu_action_links($links) {
    $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=featured-image-from-url')) . '">Settings</a>';
    $links[] = '<a style="color:black">Support Email:</a>';
    $links[] = '<br><center style="width:275px;color:white;background-color:#02a0d2;border-radius:0px 30px">marcel@featuredimagefromurl.com</center>';
    return $links;
}

