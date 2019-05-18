<?php

define('FIFU_SETTINGS', serialize(array('fifu_social', 'fifu_original', 'fifu_lazy', 'fifu_content', 'fifu_content_page', 'fifu_enable_default_url', 'fifu_fake', 'fifu_fake2', 'fifu_css', 'fifu_default_url', 'fifu_default_width', 'fifu_wc_lbox', 'fifu_wc_zoom', 'fifu_hide_page', 'fifu_hide_post', 'fifu_get_first', 'fifu_pop_first', 'fifu_ovw_first', 'fifu_column_height', 'fifu_priority', 'fifu_grid_category', 'fifu_auto_alt', 'fifu_data_generation', 'fifu_data_clean')));

add_action('admin_menu', 'fifu_insert_menu');

function fifu_insert_menu() {
    if (strpos($_SERVER['REQUEST_URI'], 'featured-image-from-url') !== false) {
        wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.7.0/css/all.css');
        wp_enqueue_style('jquery-ui-style', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css');
        wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
        wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-1.11.3.min.js');
        wp_enqueue_script('jquery-block-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js');
    }

    add_menu_page('Featured Image from URL', 'Featured Image from URL', 'administrator', 'featured-image-from-url', 'fifu_get_menu_html', plugins_url() . '/featured-image-from-url/admin/images/favicon.png', 57);

    add_action('admin_init', 'fifu_get_menu_settings');
}

function fifu_get_menu_html() {
    flush();

    // css and js
    wp_enqueue_style('fifu-menu-css', plugins_url('/html/css/menu.css', __FILE__));
    wp_enqueue_script('fifu-menu-js', plugins_url('/html/js/menu.js', __FILE__));

    $enable_social = get_option('fifu_social');
    $enable_original = get_option('fifu_original');
    $enable_lazy = get_option('fifu_lazy');
    $enable_content = get_option('fifu_content');
    $enable_content_page = get_option('fifu_content_page');
    $enable_fake = get_option('fifu_fake');
    $enable_fake2 = get_option('fifu_fake2');
    $css_style = get_option('fifu_css');
    $default_url = get_option('fifu_default_url');
    $default_width = get_option('fifu_default_width');
    $enable_default_url = get_option('fifu_enable_default_url');
    $enable_wc_lbox = get_option('fifu_wc_lbox');
    $enable_wc_zoom = get_option('fifu_wc_zoom');
    $enable_hide_page = get_option('fifu_hide_page');
    $enable_hide_post = get_option('fifu_hide_post');
    $enable_get_first = get_option('fifu_get_first');
    $enable_pop_first = get_option('fifu_pop_first');
    $enable_ovw_first = get_option('fifu_ovw_first');
    $column_height = get_option('fifu_column_height');
    $enable_priority = get_option('fifu_priority');
    $enable_grid_category = get_option('fifu_grid_category');
    $enable_auto_alt = get_option('fifu_auto_alt');
    $enable_data_generation = get_option('fifu_data_generation');
    $enable_data_clean = get_option('fifu_data_clean');

    include 'html/menu.html';

    fifu_update_menu_options();

    // fake 1
    if (fifu_is_on('fifu_fake')) {
        update_option('fifu_data_generation', 'toggleon');
        fifu_enable_fake();
    } else
        fifu_disable_fake();

    // default
    if (!empty($default_url) && fifu_is_on('fifu_enable_default_url') && fifu_is_on('fifu_fake2')) {
        if (!wp_get_attachment_url(get_option('fifu_default_attach_id'))) {
            $att_id = fifu_db_create_attachment($default_url);
            update_option('fifu_default_attach_id', $att_id);
            fifu_db_set_default_url();
        } else
            fifu_db_update_default_url($default_url);
    } else
        fifu_db_delete_default_url();
}

function fifu_get_menu_settings() {
    foreach (unserialize(FIFU_SETTINGS) as $i)
        fifu_get_setting($i);
}

function fifu_get_setting($type) {
    register_setting('settings-group', $type);

    $arrEmpty = array('fifu_default_url', 'fifu_default_width', 'fifu_css');
    $arr64 = array('fifu_column_height');
    $arrOn = array('fifu_fake2', 'fifu_auto_alt', 'fifu_wc_zoom', 'fifu_wc_lbox');
    $arrOffNo = array('fifu_data_clean');

    if (!get_option($type)) {
        if (in_array($type, $arrEmpty))
            update_option($type, '');
        else if (in_array($type, $arr64))
            update_option($type, "64", 'no');
        else if (in_array($type, $arrOn))
            update_option($type, 'toggleon');
        else if (in_array($type, $arrOffNo))
            update_option($type, 'toggleoff', 'no');
        else
            update_option($type, 'toggleoff');
    }
}

function fifu_update_menu_options() {
    fifu_update_option('fifu_input_social', 'fifu_social');
    fifu_update_option('fifu_input_original', 'fifu_original');
    fifu_update_option('fifu_input_lazy', 'fifu_lazy');
    fifu_update_option('fifu_input_content', 'fifu_content');
    fifu_update_option('fifu_input_content_page', 'fifu_content_page');
    fifu_update_option('fifu_input_fake', 'fifu_fake');
    fifu_update_option('fifu_input_fake2', 'fifu_fake2');
    fifu_update_option('fifu_input_css', 'fifu_css');
    fifu_update_option('fifu_input_default_url', 'fifu_default_url');
    fifu_update_option('fifu_input_default_width', 'fifu_default_width');
    fifu_update_option('fifu_input_enable_default_url', 'fifu_enable_default_url');
    fifu_update_option('fifu_input_wc_lbox', 'fifu_wc_lbox');
    fifu_update_option('fifu_input_wc_zoom', 'fifu_wc_zoom');
    fifu_update_option('fifu_input_hide_page', 'fifu_hide_page');
    fifu_update_option('fifu_input_hide_post', 'fifu_hide_post');
    fifu_update_option('fifu_input_get_first', 'fifu_get_first');
    fifu_update_option('fifu_input_pop_first', 'fifu_pop_first');
    fifu_update_option('fifu_input_ovw_first', 'fifu_ovw_first');
    fifu_update_option('fifu_input_column_height', 'fifu_column_height');
    fifu_update_option('fifu_input_priority', 'fifu_priority');
    fifu_update_option('fifu_input_grid_category', 'fifu_grid_category');
    fifu_update_option('fifu_input_auto_alt', 'fifu_auto_alt');
    fifu_update_option('fifu_input_data_generation', 'fifu_data_generation');
    fifu_update_option('fifu_input_data_clean', 'fifu_data_clean');
}

function fifu_update_option($input, $type) {
    if (isset($_POST[$input])) {
        if ($_POST[$input] == 'on')
            update_option($type, 'toggleon');
        else if ($_POST[$input] == 'off')
            update_option($type, 'toggleoff');
        else
            update_option($type, wp_strip_all_tags($_POST[$input]));
    }
}

function fifu_enable_fake2() {
    if (get_option('fifu_fake_created') && get_option('fifu_fake_created') != null)
        return;
    update_option('fifu_fake_created', true, 'no');

    fifu_db_insert_attachment();
    fifu_db_insert_attachment_category();
}

function fifu_disable_fake2() {
    if (fifu_is_on('fifu_fake'))
        return;
    if (!get_option('fifu_fake_created') && get_option('fifu_fake_created') != null)
        return;
    update_option('fifu_fake_created', false, 'no');

    fifu_db_delete_attachment();
    fifu_db_delete_attachment_category();
}

function fifu_enable_fake() {
    if (get_option('fifu_fake_attach_id'))
        return;
    fifu_db_enable_fake1();
}

function fifu_disable_fake() {
    fifu_db_disable_fake1();
}

function fifu_version() {
    $plugin_data = get_plugin_data(FIFU_PLUGIN_DIR . 'featured-image-from-url.php');
    return $plugin_data ? $plugin_data['Name'] . ':' . $plugin_data['Version'] : '';
}

