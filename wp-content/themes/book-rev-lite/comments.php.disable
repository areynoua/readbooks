<!-- parent comments.php -->
<?php if(post_password_required()): ?>

    <div class="password-required"><p><?php _e("Sorry but this article is password protected.", "book-rev-lite"); ?></p></div>

<?php return; endif; ?>



        <section id="comments-section">

            <header>

                <h2><?php comments_number(__('No Comments','book-rev-lite'), __('One Comment','book-rev-lite'), __('% Comments','book-rev-lite')); ?></h2>

            </header>

            <?php if(have_comments()): ?>

            <div id="comments-container">

                <ul>

                    <?php wp_list_comments('callback=book_rev_lite_comments'); ?>

                </ul>



                <!-- Comments Navigation -->

                <?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : ?>

                    <div class="older-comments"><?php previous_comments_link(_e('Older Comments','book-rev-lite')); ?></div>

                    <div class="newer-comments"><?php next_comments_link(_e('Newer Comments','book-rev-lite')); ?></div>

                    <div class="clearfix"></div>

                <?php endif; ?>

                <!-- Comments Navigation -->



            </div><!-- end #comments-container -->



            <?php elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>

                <p class='comments-are-closed'><?php _e("Comments are closed.", "book-rev-lite"); ?></p>

            <?php endif; ?> 



            <?php get_template_part('comment-form'); ?>

        </section><!-- end .comments-section -->