<?php

class FifuDb {

    private $posts;
    private $postmeta;
    private $termmeta;
    private $term_taxonomy;
    private $term_relationships;
    private $query;
    private $wpdb;
    private $author;

    function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->posts = $wpdb->prefix . 'posts';
        $this->postmeta = $wpdb->prefix . 'postmeta';
        $this->termmeta = $wpdb->prefix . 'termmeta';
        $this->term_taxonomy = $wpdb->prefix . 'term_taxonomy';
        $this->term_relationships = $wpdb->prefix . 'term_relationships';
        $this->author = 77777;
        $this->MAX_INSERT = 100;
        $this->MAX_URL_LENGTH = 2048;
        $this->types = $this->get_types();
    }

    function get_types() {
        $post_types = fifu_get_post_types();
        return join("','", $post_types);
    }

    /* alter table */

    function change_url_length() {
        $this->wpdb->get_results("
            ALTER TABLE " . $this->posts . "
            MODIFY COLUMN guid VARCHAR(" . $this->MAX_URL_LENGTH . ")"
        );
    }

    /* attachment metadata */

    // insert 1 _wp_attached_file for each attachment
    function insert_attachment_meta_url($ids) {
        $this->wpdb->get_results("
            INSERT INTO " . $this->postmeta . " (post_id, meta_key, meta_value) (
                SELECT p.id, '_wp_attached_file', CONCAT(';', p.guid) 
                FROM " . $this->posts . " p 
                WHERE p.post_parent IN (" . $ids . ") 
                AND p.post_type = 'attachment' 
                AND p.post_author = " . $this->author . " 
                AND NOT EXISTS (
                    SELECT 1 
                    FROM " . $this->postmeta . " 
                    WHERE post_id = id
                    AND meta_key = '_wp_attached_file'
                )
            )"
        );
    }

    // delete 1 _wp_attached_file or _wp_attachment_image_alt for each attachment
    function delete_attachment_meta($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . "
            WHERE meta_key IN ('_wp_attached_file', '_wp_attachment_image_alt')
            AND EXISTS (
                SELECT 1 
                FROM " . $this->posts . " p
                WHERE p.id = post_id
                AND p.post_parent IN (" . $ids . ")
                AND p.post_type = 'attachment' 
                AND p.post_author = " . $this->author . " 
            )"
        );
    }

    // insert 1 _wp_attachment_image_alt for each attachment
    function insert_attachment_meta_alt($ids) {
        $this->wpdb->get_results("
            INSERT INTO " . $this->postmeta . " (post_id, meta_key, meta_value) (
                SELECT p.id, '_wp_attachment_image_alt', p.post_title 
                FROM " . $this->posts . " p 
                WHERE p.post_parent IN (" . $ids . ") 
                AND p.post_type = 'attachment' 
                AND p.post_author = " . $this->author . " 
                AND NOT EXISTS (
                    SELECT 1 
                    FROM " . $this->postmeta . " 
                    WHERE post_id = id
                    AND meta_key = '_wp_attachment_image_alt'
                )
            )"
        );
    }

    // insert 1 _thumbnail_id for each attachment (posts)
    function insert_thumbnail_id($ids) {
        $this->wpdb->get_results("
            INSERT INTO " . $this->postmeta . " (post_id, meta_key, meta_value) (
                SELECT p.post_parent, '_thumbnail_id', p.id 
                FROM " . $this->posts . " p 
                WHERE p.post_parent IN (" . $ids . ") 
                AND p.post_type = 'attachment' 
                AND p.post_author = " . $this->author . " 
                AND NOT EXISTS (
                    SELECT 1 
                    FROM " . $this->postmeta . " 
                    WHERE post_id = p.post_parent 
                    AND meta_key = '_thumbnail_id'
                )
            )"
        );
    }

    // has attachment created bu FIFU
    function is_fifu_attachment($att_id) {
        return $this->wpdb->get_row("
            SELECT 1 
            FROM " . $this->posts . " 
            WHERE id = " . $att_id . " 
            AND post_author = " . $this->author
                ) != null;
    }

    // get ids from categories with external media and no thumbnail_id
    function get_categories_without_meta() {
        return $this->wpdb->get_results("
            SELECT DISTINCT term_id
            FROM " . $this->termmeta . " a
            WHERE a.meta_key IN ('fifu_image_url')
            AND a.meta_value IS NOT NULL 
            AND a.meta_value <> ''
            AND NOT EXISTS (
                SELECT 1 
                FROM " . $this->termmeta . " b 
                WHERE a.term_id = b.term_id 
                AND b.meta_key = 'thumbnail_id'
                AND b.meta_value <> 0
            )"
        );
    }

    // get ids from posts with external media and no _thumbnail_id
    function get_posts_without_meta() {
        return $this->wpdb->get_results("
            SELECT DISTINCT post_id
            FROM " . $this->postmeta . " a
            WHERE a.meta_key IN ('fifu_image_url')
            AND a.meta_value IS NOT NULL 
            AND a.meta_value <> ''
            AND NOT EXISTS (
                SELECT 1 
                FROM " . $this->postmeta . " b 
                WHERE a.post_id = b.post_id 
                AND b.meta_key = '_thumbnail_id'
            )"
        );
    }

    // get ids from posts with external url
    function get_posts_with_url() {
        return $this->wpdb->get_results("
            SELECT post_id 
            FROM " . $this->postmeta . " 
            WHERE meta_key = 'fifu_image_url'"
        );
    }

    // get ids from terms with external url
    function get_terms_with_url() {
        return $this->wpdb->get_results("
            SELECT term_id 
            FROM " . $this->termmeta . " 
            WHERE meta_key = 'fifu_image_url'
            AND meta_value <> ''
            AND meta_value IS NOT NULL"
        );
    }

    // get ids from fake attachments
    function get_fake_attachments() {
        return $this->wpdb->get_results("
            SELECT id 
            FROM " . $this->posts . " 
            WHERE post_type = 'attachment' 
            AND post_author = " . $this->author
        );
    }

    // get attachments without post
    function get_attachments_without_post($post_id) {
        $result = $this->wpdb->get_results("
            SELECT GROUP_CONCAT(id) AS ids 
            FROM " . $this->posts . " 
            WHERE post_parent = " . $post_id . " 
            AND post_type = 'attachment' 
            AND post_author = " . $this->author . "
            AND NOT EXISTS (
	            SELECT 1
                FROM " . $this->postmeta . "
                WHERE post_id = post_parent
                AND meta_key = '_thumbnail_id'
                AND meta_value = id
            )
            GROUP BY post_parent"
        );
        return $result ? $result[0]->ids : null;
    }

    function get_posts_with_valid_url() {
        return $this->wpdb->get_results("
            SELECT post_id 
            FROM " . $this->postmeta . " 
            WHERE meta_key = 'fifu_image_url'
            AND meta_value IS NOT NULL
            AND meta_value <> ''"
        );
    }

    function get_ctgr_attachments_without_post($term_id) {
        $result = $this->wpdb->get_results("
            SELECT GROUP_CONCAT(id) AS ids 
            FROM " . $this->posts . " 
            WHERE post_parent = " . $term_id . " 
            AND post_type = 'attachment' 
            AND post_author = " . $this->author . "
            AND NOT EXISTS (
	            SELECT 1
                FROM " . $this->termmeta . "
                WHERE term_id = post_parent
                AND meta_key = 'thumbnail_id'
                AND meta_value = id
            )
            GROUP BY post_parent"
        );
        return $result ? $result[0]->ids : null;
    }

    function get_posts_without_featured_image() {
        return $this->wpdb->get_results("
            SELECT id
            FROM " . $this->posts . " 
            WHERE post_type IN ('$this->types')
            AND post_status = 'publish'
            AND NOT EXISTS (
                SELECT 1
                FROM " . $this->postmeta . " 
                WHERE post_id = id
                AND meta_key IN ('_thumbnail_id', 'fifu_image_url')
            )"
        );
    }

    function get_number_of_posts() {
        return $this->wpdb->get_row("
            SELECT count(1) AS n
            FROM " . $this->posts . " 
            WHERE post_type IN ('$this->types')
            AND post_status = 'publish'"
                )->n;
    }

    function get_category_image_url($term_id) {
        return $this->wpdb->get_results("
            SELECT meta_value 
            FROM " . $this->termmeta . " 
            WHERE meta_key = 'fifu_image_url' 
            AND term_id = " . $term_id
        );
    }

    function get_featured_and_gallery_ids($post_id) {
        return $this->wpdb->get_results("
            SELECT GROUP_CONCAT(meta_value SEPARATOR ',') as 'ids'
            FROM " . $this->postmeta . "
            WHERE post_id = " . $post_id . "
            AND meta_key IN ('_thumbnail_id')"
        );
    }

    function insert_default_thumbnail_id($value) {
        $this->wpdb->get_results("
            INSERT INTO " . $this->postmeta . " (post_id, meta_key, meta_value)
            VALUES " . $value
        );
    }

    // clean metadata

    function delete_thumbnail_ids($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key = '_thumbnail_id' 
            AND meta_value IN (" . $ids . ")"
        );
    }

    function delete_thumbnail_ids_category($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->termmeta . " 
            WHERE meta_key = 'thumbnail_id' 
            AND term_id IN (" . $ids . ")"
        );
    }

    function delete_thumbnail_ids_category_without_attachment() {
        $this->wpdb->get_results("
            DELETE FROM " . $this->termmeta . " 
            WHERE meta_key = 'thumbnail_id' 
            AND NOT EXISTS (
                SELECT 1 
                FROM " . $this->posts . " p 
                WHERE p.id = meta_value
            )"
        );
    }

    function delete_invalid_thumbnail_ids($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key = '_thumbnail_id' 
            AND post_id IN (" . $ids . ") 
            AND (
                meta_value = -1 
                OR meta_value IS NULL 
                OR meta_value LIKE 'fifu:%'
            )"
        );
    }

    function delete_fake_thumbnail_id($ids) {
        $att_id = get_option('fifu_fake_attach_id');
        if ($att_id) {
            $this->wpdb->get_results("
                DELETE FROM " . $this->postmeta . " 
                WHERE meta_key = '_thumbnail_id' 
                AND post_id IN (" . $ids . ") 
                AND meta_value = " . $att_id
            );
        }
    }

    function delete_attachments($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->posts . " 
            WHERE id IN (" . $ids . ")
            AND post_type = 'attachment'
            AND post_author = " . $this->author
        );
    }

    function delete_attachment_meta_url_and_alt($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key IN ('_wp_attached_file','_wp_attachment_image_alt')
            AND post_id IN (" . $ids . ")"
        );
    }

    function delete_attachment_meta_url($ids) {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key = '_wp_attached_file' 
            AND post_id IN (" . $ids . ")"
        );
    }

    function delete_thumbnail_id_without_attachment() {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key = '_thumbnail_id' 
            AND NOT EXISTS (
                SELECT 1 
                FROM " . $this->posts . " p 
                WHERE p.id = meta_value
            )"
        );
    }

    function delete_attachment_meta_without_attachment() {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key IN ('_wp_attached_file', '_wp_attachment_image_alt') 
            AND NOT EXISTS (
                SELECT 1
                FROM " . $this->posts . " p 
                WHERE p.id = post_id
            )"
        );
    }

    function delete_empty_urls_category() {
        $this->wpdb->get_results("
            DELETE FROM " . $this->termmeta . " 
            WHERE meta_key = 'fifu_image_url'
            AND (
                meta_value = ''
                OR meta_value is NULL
            )"
        );
    }

    function delete_empty_urls() {
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key = 'fifu_image_url'
            AND (
                meta_value = ''
                OR meta_value is NULL
            )"
        );
    }

    function delete_metadata() {
        $fake_attach_id = get_option('fifu_fake_attach_id');
        $default_attach_id = get_option('fifu_default_attach_id');
        $value = '-1';
        $value = $fake_attach_id ? $value . ',' . $fake_attach_id : $value;
        $value = $default_attach_id ? $value . ',' . $default_attach_id : $value;
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key IN ('_thumbnail_id', '_product_image_gallery')
            AND meta_value IN (" . $value . ")"
        );
        $this->wpdb->get_results("
            DELETE FROM " . $this->postmeta . " 
            WHERE meta_key = '_wp_attached_file'
            AND meta_value IN ('Featured Image from URL', 'fifu.png')"
        );
        $this->wpdb->get_results("
            DELETE FROM " . $this->posts . " 
            WHERE guid = 'http://fifu.png'"
        );
    }

    /* insert attachment */

    function insert_attachment_by($value) {
        $this->wpdb->get_results("
            INSERT INTO " . $this->posts . " (post_author, guid, post_title, post_mime_type, post_type, post_status, post_parent, post_date, post_date_gmt, post_modified, post_modified_gmt, post_content, post_excerpt, to_ping, pinged, post_content_filtered) 
            VALUES " . $value);
    }

    function get_formatted_value($url, $alt, $post_parent) {
        return "(" . $this->author . ", '" . $url . "', '" . str_replace("'", "", $alt) . "', 'image/jpeg', 'attachment', 'inherit', '" . $post_parent . "', now(), now(), now(), now(), '', '', '', '', '')";
    }

    /* insert fake internal featured image */

    function insert_attachment_category() {
        $ids = null;
        $value = null;
        $i = 0;
        // insert 1 attachment for each selected category
        foreach ($this->get_categories_without_meta() as $res) {
            $ids = ($i++ == 0) ? $res->term_id : ($ids . "," . $res->term_id);
            $url = get_term_meta($res->term_id, 'fifu_image_url', true);
            if (!$url) {
                $result = $this->get_category_image_url($res->term_id);
                $url = $result[0]->meta_value;
            }
            $value = $this->get_formatted_value($url, get_term_meta($res->term_id, 'fifu_image_alt', true), $res->term_id);
            $this->insert_attachment_by($value);
            $att_id = $this->wpdb->insert_id;
            update_term_meta($res->term_id, 'thumbnail_id', $att_id);
        }
        if ($ids) {
            $this->insert_attachment_meta_url($ids);
            $this->insert_attachment_meta_alt($ids);
        }
    }

    function insert_attachment() {
        $ids = null;
        $value = null;
        $i = 1;
        $count = 1;
        // insert 1 attachment for each selected post
        $result = $this->get_posts_without_meta();
        foreach ($result as $res) {
            $ids = ($i == 1) ? $res->post_id : ($ids . "," . $res->post_id);
            $aux = $this->get_formatted_value(fifu_main_image_url($res->post_id), get_post_meta($res->post_id, 'fifu_image_alt', true), $res->post_id);
            $value = ($i == 1) ? $aux : ($value . "," . $aux);
            if ($value && (($i % $this->MAX_INSERT == 0) || ($i % $this->MAX_INSERT != 0 && count($result) == $count))) {
                wp_cache_flush();
                $this->insert_attachment_by($value);
                $this->insert_thumbnail_id($ids);
                $this->insert_attachment_meta_url($ids);
                $this->insert_attachment_meta_alt($ids);
                $ids = null;
                $value = null;
                $i = 1;
            } else
                $i++;
            $count++;
        }
    }

    /* delete fake internal featured image */

    function delete_attachment() {
        $ids = null;
        $i = 1;
        $count = 1;
        // delete fake attachments and _thumbnail_ids
        $result = $this->get_fake_attachments();
        foreach ($result as $res) {
            $ids = ($i == 1) ? $res->id : ($ids . "," . $res->id);
            if ($ids && (($i % $this->MAX_INSERT == 0) || ($i % $this->MAX_INSERT != 0 && count($result) == $count))) {
                wp_cache_flush();
                $this->delete_thumbnail_ids($ids);
                $this->delete_attachments($ids);
                $ids = null;
                $i = 1;
            } else
                $i++;
            $count++;
        }

        $ids = null;
        $i = 1;
        $count = 1;
        // delete attachment data and more _thumbnail_ids
        $result = $this->get_posts_with_url();
        foreach ($result as $res) {
            $ids = ($i == 1) ? $res->post_id : ($ids . "," . $res->post_id);
            if ($ids && (($i % $this->MAX_INSERT == 0) || ($i % $this->MAX_INSERT != 0 && count($result) == $count))) {
                wp_cache_flush();
                $this->delete_invalid_thumbnail_ids($ids);
                $this->delete_fake_thumbnail_id($ids);
                $this->delete_attachment_meta_url($ids);
                $ids = null;
                $i = 1;
            } else
                $i++;
            $count++;
        }

        // delete data without attachment
        $this->delete_thumbnail_id_without_attachment();
        $this->delete_attachment_meta_without_attachment();

        $this->delete_empty_urls();
    }

    function delete_attachment_category() {
        $ids = null;
        $i = 0;
        foreach ($this->get_terms_with_url() as $res)
            $ids = ($i++ == 0) ? $res->term_id : ($ids . "," . $res->term_id);
        if ($ids) {
            $this->delete_thumbnail_ids_category($ids);
            $this->delete_attachment_meta($ids);
            $this->delete_thumbnail_ids_category_without_attachment();
        }
        $this->delete_empty_urls_category();
    }

    /* save 1 post */

    function update_fake_attach_id($post_id) {
        $att_id = get_post_thumbnail_id($post_id);
        $url = fifu_main_image_url($post_id);
        $has_fifu_attachment = $att_id ? ($this->is_fifu_attachment($att_id) && get_option('fifu_default_attach_id') != $att_id) : false;
        // delete
        if (!$url) {
            if ($has_fifu_attachment) {
                wp_delete_attachment($att_id);
                delete_post_thumbnail($post_id);
                if (fifu_get_default_url())
                    set_post_thumbnail($post_id, get_option('fifu_default_attach_id'));
            } else {
                if (fifu_get_default_url())
                    set_post_thumbnail($post_id, get_option('fifu_default_attach_id'));
            }
        }
        else {
            // update
            $alt = get_post_meta($post_id, 'fifu_image_alt', true);
            if ($has_fifu_attachment) {
                update_post_meta($att_id, '_wp_attached_file', ';' . $url);
                update_post_meta($att_id, '_wp_attachment_image_alt', $alt);
                $this->wpdb->update($this->posts, $set = array('post_title' => $alt, 'guid' => $url), $where = array('id' => $att_id), null, null);
            }
            // insert
            else {
                $value = $this->get_formatted_value($url, $alt, $post_id);
                $this->insert_attachment_by($value);
                $att_id = $this->wpdb->insert_id;
                update_post_meta($post_id, '_thumbnail_id', $att_id);
                update_post_meta($att_id, '_wp_attached_file', ';' . $url);
                update_post_meta($att_id, '_wp_attachment_image_alt', $alt);
                $attachments = $this->get_attachments_without_post($post_id);
                if ($attachments) {
                    $this->delete_attachments($attachments);
                    $this->delete_attachment_meta_url_and_alt($attachments);
                }
            }
        }
    }

    /* save 1 category */

    function ctgr_update_fake_attach_id($term_id) {
        if (fifu_is_on('fifu_data_generation'))
            return;

        $att_id = get_term_meta($term_id, 'thumbnail_id');
        $att_id = $att_id ? $att_id[0] : null;
        $has_fifu_attachment = $att_id ? $this->is_fifu_attachment($att_id) : false;

        $url = get_term_meta($term_id, 'fifu_image_url', true);

        // delete
        if (!$url) {
            if ($has_fifu_attachment) {
                wp_delete_attachment($att_id);
                update_term_meta($term_id, 'thumbnail_id', 0);
            }
        } else {
            // update
            $alt = get_term_meta($term_id, 'fifu_image_alt', true);
            if ($has_fifu_attachment) {
                update_post_meta($att_id, '_wp_attached_file', ';' . $url);
                update_post_meta($att_id, '_wp_attachment_image_alt', $alt);
                $this->wpdb->update($this->posts, $set = array('guid' => $url, 'post_title' => $alt), $where = array('id' => $att_id), null, null);
            }
            // insert
            else {
                $value = $this->get_formatted_value($url, $alt, $term_id);
                $this->insert_attachment_by($value);
                $att_id = $this->wpdb->insert_id;
                update_term_meta($term_id, 'thumbnail_id', $att_id);
                update_post_meta($att_id, '_wp_attached_file', ';' . $url);
                update_post_meta($att_id, '_wp_attachment_image_alt', $alt);
                $attachments = $this->get_ctgr_attachments_without_post($term_id);
                if ($attachments) {
                    $this->delete_attachments($attachments);
                    $this->delete_attachment_meta_url_and_alt($attachments);
                }
            }
        }
    }

    /* default url */

    function create_attachment($url) {
        $value = $this->get_formatted_value($url, null, null);
        $this->insert_attachment_by($value);
        return $this->wpdb->insert_id;
    }

    function set_default_url() {
        $att_id = get_option('fifu_default_attach_id');
        if (!$att_id)
            return;
        $value = null;
        foreach ($this->get_posts_without_featured_image() as $res) {
            $aux = "(" . $res->id . ", '_thumbnail_id', " . $att_id . ")";
            $value = $value ? $value . ',' . $aux : $aux;
        }
        if ($value) {
            $this->insert_default_thumbnail_id($value);
            update_post_meta($att_id, '_wp_attached_file', ';' . get_option('fifu_default_url'));
        }
    }

    function update_default_url($url) {
        $att_id = get_option('fifu_default_attach_id');
        if ($url != wp_get_attachment_url($att_id)) {
            $this->wpdb->update($this->posts, $set = array('guid' => $url), $where = array('id' => $att_id), null, null);
            update_post_meta($att_id, '_wp_attached_file', ';' . $url);
        }
    }

    function delete_default_url() {
        $att_id = get_option('fifu_default_attach_id');
        wp_delete_attachment($att_id);
        delete_option('fifu_default_attach_id');
        $this->wpdb->delete($this->postmeta, array('meta_key' => '_thumbnail_id', 'meta_value' => $att_id));
    }

    /* delete post */

    function before_delete_post($post_id) {
        $default_url_enabled = fifu_is_on('fifu_enable_default_url');
        $default_att_id = $default_url_enabled ? get_option('fifu_default_attach_id') : null;
        $result = $this->get_featured_and_gallery_ids($post_id);
        if ($result) {
            $ids = explode(',', $result[0]->ids);
            $value = null;
            foreach ($ids as $id) {
                if ($id && $id != $default_att_id)
                    $value = ($value == null) ? $id : $value . ',' . $id;
            }
            if ($value) {
                $this->delete_attachments($value);
                $this->delete_attachment_meta_url_and_alt($value);
            }
        }
    }

    /* clean metadata */

    function enable_clean() {
        $this->delete_metadata();
        wp_delete_attachment(get_option('fifu_fake_attach_id'));
        wp_delete_attachment(get_option('fifu_default_attach_id'));
        delete_option('fifu_fake_attach_id');
        fifu_disable_fake();
        fifu_disable_fake2();
        update_option('fifu_fake', 'toggleoff', 'no');
        update_option('fifu_fake2', 'toggleoff', 'no');
        update_option('fifu_fake_created', false, 'no');
    }

    /* fake internal featured image 1 */

    function enable_fake1() {
        $old_attach_id = get_option('fifu_fake_attach_id');
        $value = $this->get_formatted_value('Featured Image from URL', null, 0);
        $this->insert_attachment_by($value);
        $att_id = $this->wpdb->insert_id;

        update_post_meta($att_id, '_wp_attached_file', ';');
        update_option('fifu_fake_attach_id', $att_id);

        foreach ($this->get_posts_without_meta() as $i)
            $this->wpdb->insert($this->postmeta, array('post_id' => $i->post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => $att_id));

        $this->wpdb->update($this->postmeta, array('meta_value' => $att_id), array('meta_key' => '_thumbnail_id', 'meta_value' => $old_attach_id), null, null);

        foreach ($this->get_posts_with_valid_url() as $i)
            $this->wpdb->update($this->postmeta, array('meta_value' => $att_id), array('post_id' => $i->post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => -1), null, null);
    }

    function disable_fake1() {
        $this->wpdb->delete($this->postmeta, array('meta_key' => '_thumbnail_id', 'meta_value' => get_option('fifu_fake_attach_id')));
        wp_delete_attachment(get_option('fifu_fake_attach_id'));
        delete_option('fifu_fake_attach_id');
    }

}

/* fake internal featured image */

function fifu_db_insert_attachment_category() {
    $db = new FifuDb();
    $db->insert_attachment_category();
}

function fifu_db_insert_attachment() {
    $db = new FifuDb();
    $db->insert_attachment();
}

function fifu_db_delete_attachment_category() {
    $db = new FifuDb();
    $db->delete_attachment_category();
}

function fifu_db_delete_attachment() {
    $db = new FifuDb();
    $db->delete_attachment();
}

function fifu_db_change_url_length() {
    $db = new FifuDb();
    $db->change_url_length();
}

/* clean metadata */

function fifu_db_enable_clean() {
    $db = new FifuDb();
    $db->enable_clean();
}

/* save post */

function fifu_db_update_fake_attach_id($post_id) {
    $db = new FifuDb();
    $db->update_fake_attach_id($post_id);
}

/* save category */

function fifu_db_ctgr_update_fake_attach_id($term_id) {
    $db = new FifuDb();
    $db->ctgr_update_fake_attach_id($term_id);
}

/* default url */

function fifu_db_create_attachment($url) {
    $db = new FifuDb();
    return $db->create_attachment($url);
}

function fifu_db_set_default_url() {
    $db = new FifuDb();
    return $db->set_default_url();
}

function fifu_db_update_default_url($url) {
    $db = new FifuDb();
    return $db->update_default_url($url);
}

function fifu_db_delete_default_url() {
    $db = new FifuDb();
    return $db->delete_default_url();
}

/* delete post */

function fifu_db_before_delete_post($post_id) {
    $db = new FifuDb();
    $db->before_delete_post($post_id);
}

/* number of posts */

function fifu_db_number_of_posts() {
    $db = new FifuDb();
    return $db->get_number_of_posts();
}

/* fake internal featured image 1 */

function fifu_db_enable_fake1() {
    $db = new FifuDb();
    return $db->enable_fake1();
}

function fifu_db_disable_fake1() {
    $db = new FifuDb();
    return $db->disable_fake1();
}

