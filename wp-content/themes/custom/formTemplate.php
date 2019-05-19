<?php /* Template Name: FormTemplate */ ?>
<?php get_header(); ?>
<!-- Single Page Theme -->


<section id="main-content" class="clearfix">

    <section id="main-content-inner" class="container">

    <div class="article-container post">

        <?php while ( have_posts() ) : the_post(); ?>

        <header class="clearfix">

            <div class="article-details">

                <h1 class="title"><?php the_title(); ?></h1>

                <?php if(!get_post_meta($post->ID, 'hide_date', true)) { ?>
                    <div class="meta">
                        <span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                    </div><!-- end .meta -->
                <?php } ?>

            </div><!-- end .article-details -->  

        </header>

        <article class="clearfix">
            <?php
            $postId = $_GET['id'];
            $postInfos = get_post($postId);

            if(wp_get_current_user()->data->ID == $postInfos->post_author) {
                the_content();
            } else {
                echo 'You must to be the author of this point to edit !';
            }

            wp_link_pages(); ?>
            
        </article>

        

        <?php endwhile; ?>

            

        <?php comments_template(); ?>



    </div><!-- end .article-container -->



    <?php get_sidebar(); ?>



    </section><!-- end .main-content-inner -->

</section><!-- end #main-content -->



<?php get_footer(); ?>


<script>
var postId = <?php echo $postId; ?>;
</script>
<script src="<?php echo get_template_directory_uri(). "/../custom/js/form_point_document.js"; ?>"></script>

<script>
function addInputOfPost() {
    $("h1.title").text("Edit point: \"<?php echo addslashes($postInfos->post_title); ?>\"");
    jQuery( '#nf-field-44').val("<?php echo addslashes($postInfos->post_title); ?>");
    jQuery( '#nf-field-42').val("<?php echo addslashes($postInfos->post_content); ?>");
    jQuery('#nf-field-42-wrap .note-editable.panel-body').html("<?php echo addslashes($postInfos->post_content); ?>");
    jQuery( '#nf-field-46').val("<?php echo addslashes(implode(',', get_post_meta($postInfos->ID, 'category'))); ?>");
}

$(function() {
    setTimeout(addInputOfPost, 1000);
});
</script>
