<?php

define("FIFU_URL", "/localhost/fifu/");

add_filter('get_attached_file', 'fifu_replace_attached_file', 10, 2);

function fifu_replace_attached_file($att_url, $att_id) {
    if (fifu_is_off('fifu_data_generation')) {
        if ($att_url) {
            $url = explode(";", $att_url);
            if (sizeof($url) > 1)
                return strpos($url[1], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $url[1];
        }
    }
    return $att_url;
}

add_filter('wp_get_attachment_url', 'fifu_replace_attachment_url', 10, 2);

function fifu_replace_attachment_url($att_url, $att_id) {
    if (fifu_is_off('fifu_data_generation')) {
        if ($att_url) {
            $url = explode(";", $att_url);
            if (sizeof($url) > 1)
                return strpos($url[1], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $url[1];
            else {
                // external wordpress images
                if (sizeof($url) > 0 && strpos($url[0], fifu_get_internal_image_path()) !== false) {
                    if (get_post($att_id)) {
                        $url = get_post($att_id)->guid;
                        if ($url)
                            return $url;
                    }
                }
            }
        }
    }

    if (fifu_show_internal_instead_of_external(get_the_ID()))
        return $att_url;

    if ($att_id == get_post_thumbnail_id(get_the_ID())) {
        $url = fifu_main_image_url(get_the_ID());
        if ($url)
            $att_url = $url;
    }
    return $att_url;
}

add_filter('posts_where', 'fifu_query_attachments');

function fifu_query_attachments($where) {
    if (isset($_POST['action']) && ($_POST['action'] == 'query-attachments'))
        $where .= ' AND post_author <> 77777 ';
    return $where;
}

add_filter('wp_get_attachment_image_src', 'fifu_replace_attachment_image_src', 10, 3);

function fifu_replace_attachment_image_src($image, $att_id, $size) {
    if (fifu_is_internal_image($image))
        return $image;

    $post = get_post($att_id);

    if (fifu_is_off('fifu_data_generation')) {
        if (fifu_should_hide())
            return null;
        $image_size = fifu_get_image_size($size);
        if (fifu_is_on('fifu_original')) {
            return array(
                strpos($image[0], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $image[0],
                null,
                null,
                null,
            );
        }
        return array(
            strpos($image[0], fifu_get_internal_image_path()) !== false ? get_post($att_id)->guid : $image[0],
            isset($image_size['width']) ? $image_size['width'] : (get_option('fifu_default_width') ? get_option('fifu_default_width') : 800),
            isset($image_size['height']) ? $image_size['height'] : 600,
            isset($image_size['crop']) ? $image_size['crop'] : '',
        );
    }

    if (fifu_show_internal_instead_of_external(get_the_ID()))
        return $image;

    if ($att_id == get_post_thumbnail_id(get_the_ID())) {
        $url = fifu_main_image_url(get_the_ID());
        if ($url) {
            return array(
                $url,
                0,
                0,
                false
            );
        }
    }
    return $image;
}

function fifu_is_internal_image($image) {
    return $image && $image[1] > 1 && $image[2] > 1;
}

function fifu_get_internal_image_path() {
    return $_SERVER['SERVER_NAME'] . "/wp-content/uploads/";
}

// yoast warnings and notices

add_filter('wp_get_attachment_metadata', 'fifu_filter_wp_get_attachment_metadata', 10, 2);

function fifu_filter_wp_get_attachment_metadata($data, $post_id) {
    if (!function_exists('is_plugin_active'))
        require_once(ABSPATH . '/wp-admin/includes/plugin.php');

    if (is_plugin_active('wordpress-seo/wp-seo.php') && !$data) {
        $arr_size = array();
        $arr_size['width'] = null;
        $arr_size['height'] = null;
        return $arr_size;
    }
    return $data;
}

