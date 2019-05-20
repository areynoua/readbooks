<?php get_header(); ?>
<!-- single-document_point Theme -->
<section id="main-content" class="clearfix">
    <section id="main-content-inner" class="container">
    <div class="article-container post clearfix">

        <?php while ( have_posts() ) : the_post(); ?>
                
        <header class="book-metadata">
            <?php 
			$tmt = get_post(get_post_meta($post->ID, "document_parent", true));
            $link_to_book = true;
			require("templates/readbook_text_metadata_template.php");
			?>
        </header>

        <article <?php post_class("clearfix"); ?>>
            <?php if(get_post_meta($post->ID, 'text_img', true) != "") {
                echo '<img class="text-img" src="' . get_post_meta($post->ID, 'text_img', true) . '" />';
            } ?>
            <?php the_content(); ?>
            
        <div class="article-tags">
            Write by: <?php the_author(); ?>
        <?php the_tags( __( 'Tags: ', 'book-rev-lite' ), __( ', ', 'book-rev-lite' ), '<br />' ); ?> 
        </div>
        <?php
        if(wp_get_current_user()->data->ID == get_the_author_meta('ID')) {
            echo '<a href="http://readbook.ddns.net/edit-point/?id='.$post->ID.'">Edit</a>';
        }
        ?>


        </article>

        

        <?php get_template_part("templates/bookrev_review_wrap_up_template"); ?>



        <?php wp_link_pages(); ?>

        

        <?php endwhile; ?>
          
        <nav class="nav-single link-pages">
            <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'book-rev-lite' ) . '</span> %title' ); ?></span>
            <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'book-rev-lite' ) . '</span>' ); ?></span>
            <div style="clear:both;"></div>
        </nav><!-- .nav-single -->

        <?php comments_template(); ?>



    </div><!-- end .article-container -->



    <?php get_sidebar(); ?>



    </section><!-- end .main-content-inner -->

</section><!-- end #main-content -->



<?php get_footer(); ?>