<?php
/**
* Plugin Name: Read Book
* Plugin URI: https://vub.ac.be
* Description: Plugin to add custom code
* Version: 1.0
* Author: R. Detobel, A. Reynouard
**/

$GOOGLE_KEY = 'AIzaSyCclMD62R4J9hv6SSzPznRjpP6MNWtG6Sg';

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
        'capability_type' => array('document', 'documents'),
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
        'supports' => array('title', 'editor', 'thumbnail', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'author')//,
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
        'rewrite' => array( "slug" => "document/%series_name%", "with_front" => true ),
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

add_filter('post_type_link', function( $link, $post ) {
    if ('document_point' == get_post_type( $post ) ) {
        //Lets go to get the parent cartoon-series name
        if( $post->post_parent ) {
            $parent = get_post( $post->post_parent );
            if( !empty($parent->post_name) ) {
                return str_replace( '%series_name%', $parent->post_name, $link );
            }
        } else {
            //This seems to not work. It is intented to build pretty permalinks
            //when episodes has not parent, but it seems that it would need
            //additional rewrite rules
            return str_replace( '/%series_name%', '', $link );
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



function submit_document_point_callback($form_data) {
    global $ninja_forms_processing;
    $form_fields   =  $form_data['fields'];

    /*
    point_text
    point_title
    text_id
    */

    foreach($form_fields as $field){
        $field_id    = $field['id'];
        $field_key   = $field['key'];
        $field_value = $field['value'];

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

        }
    }


    $postarr = array(
            'post_content' => $point_text,
            'post_title' => $point_title,
            'post_type' => 'document_point',
            'post_status' => 'publish',
            'post_parent' => $text_id
        );

    $insertElement = wp_insert_post($postarr);
    update_post_meta($insertElement, 'point_approved', 0);
    update_post_meta($insertElement, 'document_parent', $text_id);
    if(isset($point_category)) {
        // foreach (explode(",", $point_category) as $category) {
        //     $category
        // }
        
    }
}

add_action('submit_document_point', 'submit_document_point_callback');



function submit_book_callback($form_data) {
    global $GOOGLE_KEY;
    $form_fields   =  $form_data['fields'];

    /*
    text_title
    text_author
    text_category
    text_theme
    text_link
    */

    foreach($form_fields as $field){
        $field_id    = $field['id'];
        $field_key   = $field['key'];
        $field_value = $field['value'];

        switch ($field['key']) {
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
    update_post_meta($insertElement, 'text_author', $text_author);
    if(isset($text_link)) {
        update_post_meta($insertElement, 'text_link', $text_link);
    }

    // Doc: https://developers.google.com/books/docs/v1/using#ids

    $googleUrl = 'https://www.googleapis.com/books/v1/volumes?q=intitle:' . urlencode($text_title) . 
                            '+inauthor:' . urlencode($text_author) . 
                            '&key=' . $GOOGLE_KEY;
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
                    update_post_meta($insertElement, 'text_img', $url);
                    update_post_meta($insertElement, 'fifu_image_url', fifu_convert($url));
                    fifu_update_fake_attach_id($insertElement);
                } else {
                    update_post_meta($insertElement, 'text_img_error', 'erreur URL');
                }

                if(isset($volumeInfo->infoLink)) {
                    update_post_meta($insertElement, 'text_google_link', $volumeInfo->infoLink);
                }
                
            }
        }

    } else {
        update_post_meta($insertElement, 'text_img_error', 'erreur google ' . $googleUrl);
    }
}
add_action('submit_book', 'submit_book_callback');


function listTermsToText($listTerms) {
    $res = "";
    foreach ($listTerms as $term) {
        if($res != "") {
            $res .= ', ';
        }
        $res .= $term->name;
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
                        "<a href=\"http://readbook.ddns.net/wp-login.php\">Login</a> " .
                        "<a href=\"http://readbook.ddns.net/wp-login.php?action=register\">Register</a>".
                        "</p>";
        } else {
            $text_title = 'Money';
            $text_text = "<p>You have: " . get_the_author_meta('money', get_current_user_id()) . "€</p>";
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
