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

            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
            
        </article>

        

        <?php endwhile; ?>

            

        <?php comments_template(); ?>



    </div><!-- end .article-container -->



    <?php get_sidebar(); ?>



    </section><!-- end .main-content-inner -->

</section><!-- end #main-content -->



<?php get_footer(); ?>