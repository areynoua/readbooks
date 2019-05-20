<?php
/**
* Plugin Name: Read Book
* Plugin URI: https://vub.ac.be
* Description: Plugin to add custom code
* Version: 1.0
* Author: R. Detobel, A. Reynouard
**/

$GOOGLE_KEY = 'AIzaSyCclMD62R4J9hv6SSzPznRjpP6MNWtG6Sg';
$PREVIEW_LEN = 200;

$APPROUVED_MIN_COMMENT = 5;
$APPROUVED_MIN_SCORE = 3;

$MONEY_POINT_APPROUVED = 1; // In euro


///////////////// POST TYPE /////////////////

function init_document() {
	register_cpt_document();
	publication_type_taxonomy();
	theme_taxonomy();
}
add_action('init', 'init_document');

function register_cpt_document() {
    $labels = array(
        'name' => _x('Document', 'document'),
        'singular_name' => _x('Document', 'document'),
        'add_new' => _x('Add New', 'document'),
        'add_new_item' => _x('Add New Document', 'document'),
        'edit_item' => _x('Edit Document', 'document'),
        'new_item' => _x('New Document', 'document'),
        'view_item' => _x('View Document', 'document'),
        'search_items' => _x('Search document', 'document'),
        'not_found' => _x('No document found', 'document'),
        'not_found_in_trash' => _x('No document found in Trash', 'document'),
        'parent_item_colon' => _x('Parent Document:', 'document'),
        'menu_name' => _x('Document', 'document'),
    );
 
    $args = array(
        'label' => 'Documents',
        'can_export' => true,
        'capability_type' => 'post', // 'capability_type' => array('document', 'documents'),
        'delete_with_user' => false,
        'description' => 'Documents for which users indicate points of interest',
        'exclude_from_search' => false,
        'has_archive' => true,
        'hierarchical' => false,
        'labels' => $labels,
        'menu_icon' => 'dashicons-book-alt',
        'menu_position' => 5,
        'public' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array( "slug" => "document", "with_front" => true ),
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'supports' => array('title', 'thumbnail', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'author')//,
        //'taxonomies' => array('PublicationTypes', 'Theme')
    );
    register_post_type('document', $args );

}

function publication_type_taxonomy() {
    register_taxonomy(
        'PublicationTypes',
        'document',
        array(
            'hierarchical' => false,
            'label' => 'Publication Type',
            'query_var' => true,
	    'public' => true,
            'rewrite' => array(
                'slug' => 'type',
                'with_front' => false
            )
        )
    );
}

function theme_taxonomy() {
    register_taxonomy(
        'Theme',
        'document',
        array(
            'hierarchical' => false,
            'label' => 'Theme',
            'query_var' => true,
	    'public' => true,
            'rewrite' => array(
                'slug' => 'theme',
                'with_front' => false
            )
        )
    );
}


function register_cpt_document_point() {
 
    $labels = array(
        'name' => _x('Document point', 'document_point'),
        'singular_name' => _x('Document point', 'document_point'),
        'add_new' => _x('Add New', 'document_point'),
        'add_new_item' => _x('Add New Point to Document', 'document_point'),
        'edit_item' => _x('Edit Document point', 'document_point'),
        'new_item' => _x('New Point to a Document', 'document_point'),
        'view_item' => _x('View Document point', 'document_point'),
        'search_items' => _x( 'Search Document Point', 'document_point'),
        'not_found' => _x('No document point found', 'document_point'),
        'not_found_in_trash' => _x('No document point found in Trash', 'document_point'),
        'parent_item_colon' => _x('Parent Document:', 'document_point'),
        'menu_name' => _x('Document Point', 'document_point'),
    );
 
    $args = array(
        'can_export' => true,
        'capability_type' => 'post',
        'description' => 'Relevant point of a document',
        'exclude_from_search' => false,
        'has_archive' => true, // Sure?
        'hierarchical' => false,
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-comments',
        'menu_position' => 5,
        'public' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array( "slug" => "document/%document_name%", "with_front" => true ),
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'trackbacks', 
            'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array()
    );
 
    register_post_type('document_point', $args);
}
add_action('init', 'register_cpt_document_point');



///////////////// PARENT POST TYPE MANAGEMENT /////////////////

// function removeMetaBox() {
//     remove_meta_box('pageparentdiv', 'chapter', 'normal');
// }

add_action('add_meta_boxes', function() {
    add_meta_box('document_point-parent', 'Document', 'document_point_attributes_meta_box', 'document_point', 'side', 'default');
});

function document_point_attributes_meta_box($post) {
        $pages = wp_dropdown_pages(array('post_type' => 'document', 'selected' => $post->post_parent, 
            'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 
            'sort_column'=> 'menu_order, post_title', 'echo' => 0));
        if ( ! empty($pages) ) {
            echo $pages;
        } // end empty pages check
}

add_action( 'init', function() {
    add_rewrite_rule( '^document/(.*)/([^/]+)/?$','index.php?document_point=$matches[2]','top' );
});

add_filter('post_type_link', function($link, $post) {
    if ('document_point' == get_post_type($post)) {
        //Lets go to get the parent cartoon-series name
        if($post->post_parent) {
            $parent = get_post($post->post_parent);
            if( !empty($parent->post_name) ) {
                return str_replace( '%document_name%', $parent->post_name, $link );
            }
        } else {
            //This seems to not work. It is intented to build pretty permalinks
            //when episodes has not parent, but it seems that it would need
            //additional rewrite rules
            return str_replace( '/%document_name%', '', $link );
        }

    }
    return $link;
}, 10, 2 );



///////////////// HOME /////////////////

function wpc_cpt_in_home($query) {
    if (! is_admin() && $query->is_main_query()) {
        if ($query->is_home) {
            $query->set('post_type', array('document'));
        }
    }
}
add_action('pre_get_posts','wpc_cpt_in_home');




///////////////// SEARCH /////////////////

function wpc_cpt_in_search($query) {
    if (! is_admin() && $query->is_main_query()) {
        if ($query->is_search) {
            $query->set('post_type', array('post', 'document_point', 'document'));
        }
    }
}
add_action('pre_get_posts','wpc_cpt_in_search');

function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'cf_search_join');

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter('posts_where', 'cf_search_where');

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter('posts_distinct', 'cf_search_distinct');




///////////////// SUBMIT /////////////////

function submit_document_point_callback($form_data) {
    global $ninja_forms_processing;
    $form_fields   =  $form_data['fields'];

    /*
    point_text
    point_title
    text_id
    */

    foreach($form_fields as $field){
        // $field_id    = $field['id'];
        // $field_key   = $field['key'];
        // $field_value = $field['value'];

        switch ($field['key']) {
            case 'point_title':
                $point_title = $field['value'];
                break;

            case 'point_text':
                $point_text = $field['value'];
                break;

            case 'point_category':
                $point_category = $field['value'];
                break;

            case 'text_id':
                $text_id = $field['value'];
                break;

            case 'point_id':
                $point_id = $field['value'];
                break;

        }
    }

    $postarr = array(
            'post_content' => $point_text,
            'post_title' => $point_title,
            'post_type' => 'document_point',
            'post_status' => 'publish',
            'post_parent' => $text_id
        );
    if(isset($point_id)) {
        $postarr['ID'] = $point_id;

        if(get_post_meta($point_id, 'document_parent', true) != $text_id) {
            echo 'Error with parent ID !';
            exit();
        }

        wp_update_post($postarr, true);
        if (is_wp_error($post_id)) {
            $errors = $post_id->get_error_messages();
            foreach ($errors as $error) {
                echo $error;
            }
            exit();
        }
        delete_post_meta($point_id, 'category');

        if(isset($point_category)) {
            foreach (explode(",", $point_category) as $category) {
                add_post_meta($point_id, 'category', strtolower(trim($category)));
            }
        }

    } else {
        $insertElement = wp_insert_post($postarr);
        add_post_meta($insertElement, 'point_approved', 0);
        add_post_meta($insertElement, 'document_parent', $text_id);
        if(isset($point_category)) {
            foreach (explode(",", $point_category) as $category) {
                add_post_meta($insertElement, 'category', strtolower(trim($category)));
            }
        }
    }

}
add_action('submit_document_point', 'submit_document_point_callback');


function submit_document_callback($form_data) {
    global $GOOGLE_KEY;
    $form_fields   =  $form_data['fields'];

    /*
    text_isbn_issn
    text_title
    text_author
    text_category
    text_theme
    text_link
    */

    foreach($form_fields as $field){
        // $field_id    = $field['id'];
        // $field_key   = $field['key'];
        // $field_value = $field['value'];

        switch ($field['key']) {
            case 'text_isbn_issn':
                $text_isbn_issn = $field['value'];
                break;

            case 'text_title':
                $text_title = $field['value'];
                break;

            case 'text_author':
                $text_author = $field['value'];
                break;

            case 'text_category':
                $text_category = $field['value'];
                break;

            case 'text_theme':
                $text_themes = $field['value'];
                break;

            case 'text_link':
                $text_link = $field['value'];
                break;

            case 'text_date':
                $text_date = $field['value'];
                break;
        }
    }


    $postarr = array(
            'post_content' => "",
            'post_title' => $text_title,
            'post_type' => 'document',
            'post_status' => 'publish',
            'tax_input' => array(
                    'PublicationTypes' => $text_category,
                    'Theme' => implode(", ", $text_themes)
                )
        );

    $insertElement = wp_insert_post($postarr);
    add_post_meta($insertElement, 'text_author', $text_author);
    add_post_meta($insertElement, 'text_date', $text_date);
    if(isset($text_link)) {
        add_post_meta($insertElement, 'text_link', $text_link);
    }
    if(isset($text_isbn_issn)) {
        add_post_meta($insertElement, 'text_isbn_issn', $text_isbn_issn);
    }

    $googleUrl = 'https://www.googleapis.com/books/v1/volumes?q=';
    if(isset($text_isbn_issn)) {
        $googleUrl .= 'isbn:' . urlencode($text_isbn_issn);
    } else {
        $googleUrl .= 'intitle:' . urlencode($text_title) . '+inauthor:' . urlencode($text_author);
    }
    $googleUrl .= '&key=' . $GOOGLE_KEY;

    // Doc: https://developers.google.com/books/docs/v1/using#ids
    $json = file_get_contents($googleUrl);
    $result = json_decode($json);

    if($result != NULL && $result != "" && $result->totalItems > 0) {
        if(isset($result->items[0]->volumeInfo)) {
            $firstResult = $result->items[0];
            $volumeInfo = $firstResult->volumeInfo;

            if(isset($volumeInfo) && $volumeInfo != NULL) {
                if(isset($volumeInfo->imageLinks)) {
                    $imageLinks = $volumeInfo->imageLinks;
                }

                if(isset($imageLinks->thumbnail)) {
                    $url = $imageLinks->thumbnail;
                } else if(isset($imageLinks->smallThumbnail)) {
                    $url = $imageLinks->smallThumbnail;
                }

                if(isset($url)) {
                    add_post_meta($insertElement, 'text_img', $url);
                } else {
                    add_post_meta($insertElement, 'text_img_error', 'error URL');
                }

                if(isset($volumeInfo->infoLink)) {
                    add_post_meta($insertElement, 'text_google_link', $volumeInfo->infoLink);
                }
                
            }
        }

    } else {
        add_post_meta($insertElement, 'text_google_link', 'Google error: ' . $googleUrl);
    }
}
add_action('submit_document', 'submit_document_callback');


function listTermsToText($listTerms, $pre_markup = '', $post_markup = '') {
    $res = "";
    foreach ($listTerms as $term) {
        if($res != "") {
            $res .= ', ';
        }
		$res .= str_replace('%term%',$term->name,$pre_markup) . $term->name . str_replace('%term%',$term->name,$post_markup);
    }
    return $res;
}



///////////// Custom user Field /////////////
add_action('show_user_profile', 'crf_show_extra_profile_fields');
add_action('edit_user_profile', 'crf_show_extra_profile_fields');

function crf_show_extra_profile_fields($user) {
    ?>
    <h3><?php esc_html_e('Personal Information', 'crf'); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="money"><?php esc_html_e('Money earn', 'crf'); ?></label></th>
            <td><?php echo esc_html(get_the_author_meta('money', $user->ID)); ?></td>
        </tr>
    </table>
    <?php
}


///////////// Custom Widget  /////////////

// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
 
// Creating the widget 
class wpb_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'wpb_widget', 
            // Widget name will appear in UI
            __('WPBeginner Widget', 'wpb_widget_domain'), 
            // Widget description
            array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 
                'wpb_widget_domain' ), ) 
        );
    }
 
    // Creating widget front-end
 
    public function widget($args, $instance) {
        // $text_title = $instance['title'];

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if(!is_user_logged_in()) {
            $text_title = 'Register/Login';
            $text_text = "<p style=\"text-align: center;\">" .
                        "<a href=\"" . get_site_url() . "/my-account\">Login</a> " .
                        "<a href=\"" . get_site_url() . "/registration\">Register</a>".
                        "</p>";
        } else {
            $text_title = 'Account';
            $text_text = "<p>You have: " . get_the_author_meta('money', get_current_user_id()) . "€</p>";
            $text_text .= "<p><a href=\"" . get_site_url() . "/my-account\">Edit account</a></p>";
        }

        $title = apply_filters('widget_title', $text_title);
        echo $args['before_title'] . $title . $args['after_title'];
        echo $text_text;
        echo $args['after_widget'];
    }
         
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __( 'New title', 'wpb_widget_domain' );
        }

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

} // Class wpb_widget ends here

// function add_before_my_siderba


//// GIVE MONEY ////
function user_register_callback($userId) {
    update_user_meta($userId, 'money', 0);
}
add_action('user_register', 'user_register_callback');

function comment_post_callback($comment_ID) {
    global $APPROUVED_MIN_COMMENT;
    global $APPROUVED_MIN_SCORE;

    $fp = fopen('/var/www/html/readbook/wp-content/log.txt', 'w');
    fwrite($fp, "Test\n");

    $infoComment = get_comment($comment_ID);
    $parentPost = $infoComment->comment_post_ID;
    $pointApproved = get_post_meta($parentPost, 'point_approved', true);
    if($pointApproved == 0) {
        fwrite($fp, "Infos " . $comment_ID . "\n");

        fwrite($fp, "Parent post:  " . $parentPost . "\n");
        fwrite($fp, "Comment number OLD:  " . get_comments_number($parentPost) . "\n");

        $numComment = count(get_comments(array('post_id' => $parentPost, 'parent' => 0)));
        fwrite($fp, "Comment number:  " . $numComment . "\n");
        
        if($numComment >= $APPROUVED_MIN_COMMENT and get_post_score($parentPost) >= $APPROUVED_MIN_SCORE) {
            fwrite($fp, "Update parent:  " . $parentPost . "\n");
            $parentPostInfo = get_post($parentPost);
            update_post_meta($parentPost, 'point_approved', 1);
            addUserMoney($parentPostInfo->post_author, $MONEY_POINT_APPROUVED);
        }
        fclose($fp);
    }
}
add_action('comment_post', 'comment_post_callback');


//// CUSTOM FUNCTION ////

function get_list_category_of_document($document_id) {
    global $wpdb;
    $request = $wpdb->prepare("SELECT DISTINCT meta_value " .
        "FROM wp_postmeta " .
            "JOIN wp_posts " .
                " ON wp_posts.post_parent = %s " .
        "WHERE meta_key = 'category' AND wp_postmeta.post_id = wp_posts.ID;", $document_id);
    $listCategory = $wpdb->get_results($request, ARRAY_A);
    return array_column($listCategory, 'meta_value');
}

function get_category_color($category_name) {
    $listColor = array('#f44f4f', '#78d53d', '#f4d84f', '#8585ff', '#db4ff4');
    $num = ord(substr($category_name, 0, 1))%count($listColor);
    return $listColor[$num];
}

function get_post_score($postId) {
    $args = array('post_id' => $postId);
    
    $comments = get_comments($args);
    //var_dump($comments);
    
    $sum = 0;
    $count=0;
    
    foreach($comments as $comment) :
    
        $approvedComment = $comment->comment_approved; 
    
        if($approvedComment > 0){  
            $rates = get_comment_meta( $comment->comment_ID, 'rating', true );
        }
        if($rates){
            $sum = $sum + (int)$rates;
            $count++;
        }
    
    endforeach;
    if($count != 0){ 
        $result = $sum/$count;
    } else {
        $result = 0;
    }

    return $result;
}

function order_post_by_score($listPost) {
    $order_listPost = array();
    $result_list = array();
    foreach ($listPost as $key => $post) {
        $result_list[$key] = get_post_score($post->ID);
    }
    arsort($result_list);
    foreach ($result_list as $key => $value) {
        $order_listPost[] = $listPost[$key];
    }
    return $order_listPost;
}

function format_preview_text($text) {
    global $PREVIEW_LEN;
    $text = str_replace('<br/>', ' ', $text);
    $text = str_replace('<br>', ' ', $text);
    $text = str_replace('</li>', ' ', $text);
    $text = str_replace('</p>', ' ', $text);
    $text = strip_tags($text);
    $text = substr($text, 0, $PREVIEW_LEN);
    if(strlen($text) > $PREVIEW_LEN) { 
        $text .= '...'; 
    }
    return $text;
}

function addUserMoney($userId, $moneyToAdd) {
    $newMoneyValue = get_user_meta($userId, 'money', true) + $moneyToAdd;
    update_user_meta($userId, 'money', $newMoneyValue);
}


//// LOGIN ACCOUNT ////

add_action('login_init', 'user_registration_login_init');
function user_registration_login_init () {
    if(!is_user_logged_in()) {
        wp_redirect('/my-account');
        exit;
    }
}

//// AUTHOR COMMENT ////

function comment_form_before_callback() {
    global $post;

    if($post->post_author == get_current_user_id() && !isset($_GET['replytocom'])) {
        echo '<div style="display:none;">';
    } else {
        echo '<div>';
    }
}
add_action('comment_form_before', 'comment_form_before_callback');

function comment_form_after_callback() {
    echo '</div>';
}
add_action('comment_form_after', 'comment_form_after_callback');