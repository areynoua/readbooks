<?php

add_filter('wp_head', 'fifu_add_js');
add_filter('wp_head', 'fifu_add_social_tags');
add_filter('wp_head', 'fifu_apply_css');

function fifu_add_js() {
    if (fifu_is_on('fifu_lazy')) {
        wp_enqueue_script('lazyload', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyloadxt/1.1.0/jquery.lazyloadxt.min.js');
        wp_enqueue_script('lazyload-srcset', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyloadxt/1.1.0/jquery.lazyloadxt.srcset.min.js');
        wp_enqueue_style('lazyload-spinner', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyloadxt/1.1.0/jquery.lazyloadxt.spinner.min.css');
    }
    include 'html/script.html';
}

function fifu_add_social_tags() {
    $post_id = get_the_ID();
    $url = fifu_main_image_url($post_id);
    $title = get_the_title($post_id);
    $description = wp_strip_all_tags(get_post_field('post_content', $post_id));

    if ($url && fifu_is_on('fifu_social'))
        include 'html/social.html';
}

function fifu_apply_css() {
    if (fifu_is_off('fifu_wc_lbox'))
        echo '<style>[class$="woocommerce-product-gallery__trigger"] {display:none !important;}</style>';
    else
        echo '<style>[class$="woocommerce-product-gallery__trigger"] {visibility:hidden;}</style>';
}

add_action('the_post', 'fifu_choose');

function fifu_choose($post) {
    if (fifu_is_off('fifu_data_generation'))
        return;

    $post_id = $post->ID;

    $image_url = fifu_main_image_url($post_id);

    $featured_image = get_post_meta($post_id, '_thumbnail_id', true);

    if ($image_url || (get_option('fifu_default_url') && fifu_is_on('fifu_enable_default_url'))) {
        if (!$featured_image)
            update_post_meta($post_id, '_thumbnail_id', -1);
    }
    else {
        if ($featured_image == -1)
            delete_post_meta($post_id, '_thumbnail_id');
    }
}

add_filter('woocommerce_product_get_image', 'fifu_woo_replace', 10, 5);

function fifu_woo_replace($html, $product, $woosize) {
    return fifu_replace($html, get_the_id(), null, null);
}

add_filter('post_thumbnail_html', 'fifu_replace', 10, 4);

function fifu_replace($html, $post_id, $post_thumbnail_id, $size) {
    if (fifu_is_off('fifu_data_generation')) {
        $width = fifu_get_attribute('width', $html);
        $height = fifu_get_attribute('height', $html);

        if (fifu_is_on('fifu_lazy') && !is_admin())
            $html = str_replace("src", "data-src", $html);

        $url = get_post_meta($post_id, 'fifu_image_url', true);
        $alt = get_post_meta($post_id, 'fifu_image_alt', true);
        $css = get_option('fifu_css');

        if ($url)
            return $css ? str_replace('/>', ' style="' . $css . '"/>', $html) : $html;

        return !$url ? $html : fifu_get_html($url, $alt, $width, $height);
    }
    $url = get_post_meta($post_id, 'fifu_image_url', true);
    $alt = get_post_meta($post_id, 'fifu_image_alt', true);

    return !$url || fifu_show_internal_instead_of_external($post_id) ? $html : fifu_get_html($url, $alt, null, null);
}

function is_ajax_call() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || wp_doing_ajax();
}

function fifu_get_html($url, $alt, $width, $height) {
    $css = get_option('fifu_css');

    if (fifu_should_hide()) {
        $css = 'display:none';
    }

    if (fifu_is_off('fifu_data_generation')) {
        return sprintf('<!-- Powered by Featured Image from URL plugin --> <img %s alt="%s" title="%s" style="%s" data-large_image="%s" data-large_image_width="%s" data-large_image_height="%s" onerror="%s" width="%s" height="%s">', fifu_lazy_url($url), $alt, $alt, $css, $url, "800", "600", "jQuery(this).hide();", $width, $height);
    }

    return sprintf('<!-- Featured Image from URL plugin --> <img %s alt="%s" title="%s" style="%s">', fifu_lazy_url($url), $alt, $alt, $css);
}

add_filter('the_content', 'fifu_add_to_content');

function fifu_add_to_content($content) {
    return is_singular() && has_post_thumbnail() && ((is_singular('post') && fifu_is_on('fifu_content')) or ( is_singular('page') && fifu_is_on('fifu_content_page'))) ? get_the_post_thumbnail() . $content : $content;
}

function fifu_should_hide() {
    return ((is_singular('post') && fifu_is_on('fifu_hide_post')) || (is_singular('page') && fifu_is_on('fifu_hide_page')));
}

function fifu_main_image_url($post_id) {
    $url = get_post_meta($post_id, 'fifu_image_url', true);

    if (!$url && fifu_no_internal_image($post_id) && !fifu_is_on('fifu_fake2') && (get_option('fifu_default_url') && fifu_is_on('fifu_enable_default_url')))
        $url = get_option('fifu_default_url');

    return $url;
}

function fifu_no_internal_image($post_id) {
    return get_post_meta($post_id, '_thumbnail_id', true) == -1 || get_post_meta($post_id, '_thumbnail_id', true) == null || get_post_meta($post_id, '_thumbnail_id', true) == get_option('fifu_default_attach_id');
}

function fifu_lazy_url($url) {
    if (fifu_is_off('fifu_lazy') || is_ajax_call())
        return 'src="' . $url . '"';
    return (fifu_is_main_page() ? 'data-src="' : 'src="') . $url . '"';
}

function fifu_is_main_page() {
    return is_home() || (class_exists('WooCommerce') && is_shop());
}

function fifu_has_internal_image($post_id) {
    $att_id = get_post_meta($post_id, '_thumbnail_id', true);
    return $att_id && $att_id != -1 && $att_id != get_option('fifu_fake_attach_id') && (get_post($att_id) && get_post($att_id)->post_author != 77777);
}

function fifu_show_internal_instead_of_external($post_id) {
    if (!fifu_has_internal_image($post_id))
        return false;
    return fifu_is_in_editor() || fifu_internal_priority();
}

function fifu_is_in_editor() {
    return !is_admin() || get_current_screen() == null ? false : get_current_screen()->parent_base == 'edit';
}

function fifu_internal_priority() {
    return fifu_is_on('fifu_priority');
}

function fifu_get_image_sizes() {
    global $_wp_additional_image_sizes;
    $sizes = array();
    foreach (get_intermediate_image_sizes() as $_size) {
        if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
            $sizes[$_size]['width'] = get_option("{$_size}_size_w");
            $sizes[$_size]['height'] = get_option("{$_size}_size_h");
            $sizes[$_size]['crop'] = (bool) get_option("{$_size}_crop");
        } elseif (isset($_wp_additional_image_sizes[$_size])) {
            $sizes[$_size] = array(
                'width' => $_wp_additional_image_sizes[$_size]['width'],
                'height' => $_wp_additional_image_sizes[$_size]['height'],
                'crop' => $_wp_additional_image_sizes[$_size]['crop'],
            );
        }
    }
    return $sizes;
}

function fifu_get_image_size($size) {
    $sizes = fifu_get_image_sizes();
    if (is_array($size)) {
        $arr_size = array();
        $arr_size['width'] = count($size) > 0 ? $size[0] : null;
        $arr_size['height'] = count($size) > 1 ? $size[1] : null;
        return $arr_size;
    }
    return isset($sizes[$size]) ? $sizes[$size] : false;
}

function fifu_get_default_url() {
    return wp_get_attachment_url(get_option('fifu_default_attach_id'));
}

