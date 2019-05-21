<?php /* Template Name: FormNewDocument */ ?>
<?php wp_enqueue_style('jquery-ui', 'http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'); ?>
<?php get_header(); ?>
<!-- Single Page Theme -->


<section id="main-content" class="clearfix">

    <section id="main-content-inner" class="container">

    <div class="article-container post">

        <?php while ( have_posts() ) : the_post(); ?>


        <header class="clearfix" style="border-bottom: 0px;">

            <div class="article-details">

                <h1 class="title form-title"><?php the_title(); ?></h1>

                <?php if(!get_post_meta($post->ID, 'hide_date', true)) { ?>
                    <div class="meta">
                        <span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                    </div><!-- end .meta -->
                <?php } ?>

            </div><!-- end .article-details -->  

        </header>
        
        <article class="clearfix">
            <?php
            the_content();
            wp_link_pages(); 
            ?>
            
        </article>

        

        <?php endwhile; ?>

            

    </div><!-- end .article-container -->



    <?php get_sidebar(); ?>



    </section><!-- end .main-content-inner -->

</section><!-- end #main-content -->



<?php get_footer(); ?>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
console.log('chargement')
jQuery(function() {
    setTimeout(addAutoComplete, 1000);
});

function addAutoComplete() {
    console.log('add auto')
    function log( message ) {
        jQuery( "<div>" ).text( message ).prependTo( "#log" );
        jQuery( "#log" ).scrollTop( 0 );
    }

    function selectFunction(event, ui ) {
        var docInfo = ui.item.documentInfo;

        // console.log('ISBN: ' + docInfo.industryIdentifiers[0].identifier)
        console.log('selected')
        console.log(docInfo)
        jQuery('#nf-field-47').val(getIsbn(docInfo))
        jQuery('#nf-field-35').val(docInfo.title);
        jQuery('#nf-field-36').val(docInfo.authors.join(', '));
        jQuery('#nf-field-48').val(new Date(docInfo.publishedDate).getFullYear());
        // TODO !
        // jQuery('#nf-field-?').val(docInfo.categories)
    }

    function getIsbn(bookInformation) {
        try {
            if(bookInformation.industryIdentifiers[0].type == "ISBN_13" || 
                bookInformation.industryIdentifiers[0].type == "ISBN_10") {
               return bookInformation.industryIdentifiers[0].identifier;
            }
        } catch(err) {
        }
        return "";
    }

    function successFetchGoogle(data) {
        console.log(data.items)
        var listResponse = []
        if(data.totalItems > 0) {
            jQuery.each(data.items, function(key, value) {
                var objectInfo = {};
                objectInfo.label = value.volumeInfo.title + " - " + getIsbn(value.volumeInfo);
                objectInfo.value = "";
                objectInfo.documentInfo = value.volumeInfo;
                listResponse.push(objectInfo)
            });
        }
        return listResponse;
    }

    jQuery("#nf-field-47").autocomplete({
        source: function( request, response ) {
            jQuery.ajax( {
                url: "https://www.googleapis.com/books/v1/volumes",
                type: "GET",
                data: {
                    q: 'isbn:' + request.term,
                    key: '<?php echo $GOOGLE_KEY; ?>'
                },
                success: function( data ) {
                    response(successFetchGoogle(data));
                }
            } );
        },
        minLength: 2,
        select: selectFunction
    } );

    jQuery("#nf-field-35").autocomplete({
        source: function( request, response ) {
            jQuery.ajax( {
                url: "https://www.googleapis.com/books/v1/volumes",
                type: "GET",
                data: {
                    q: 'intitle:' + request.term,
                    key: '<?php echo $GOOGLE_KEY; ?>'
                },
                success: function( data ) {
                    response(successFetchGoogle(data));
                }
            } );
        },
        minLength: 2,
        select: selectFunction
    } );
}

</script>



