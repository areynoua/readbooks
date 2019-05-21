<!-- Comments Theme -->
<?php if(post_password_required()): ?>

    <div class="password-required"><p><?php _e("Sorry but this article is password protected.", "book-rev-lite"); ?></p></div>

<?php return; endif; ?>

    <?php if(comments_open()): ?>

        <section id="comments-section">

            <header>

                <h2><?php comments_number(__('No Comments','book-rev-lite'), __('One Comment','book-rev-lite'), __('% Comments','book-rev-lite')); ?></h2>

            </header>

            <?php if(have_comments()): ?>

            <div id="comments-container">

                <ul>
                    <?php 
                    $arg = array('post_id' => $post->ID, 'include_unapproved' => true, 'max_depth' => 2);

                    $listComments = get_comments($arg);
                    

                    // comment_parent
                    $listCommentParent = array();
                    $orderListCommentaire = array();
                    foreach ($listComments as $key => $comment) {
                        if($comment->comment_parent == 0) {
                            $nbrLike = get_comment_meta($comment->comment_ID, 'cld_like_count', true);
                            $nbrDislike = get_comment_meta($comment->comment_ID, 'cld_dislike_count', true);
                            $score = $nbrLike-$nbrDislike;

                            $orderListCommentaire[$key] = $score;
                        } else {
                            $listCommentParent[$comment->comment_parent] = array($key);
                        }
                    }
                    arsort($orderListCommentaire);

                    $arg = array(
                                'walker' => '',
                                'max_depth' => 2, 
                                'style' => 'ul',
                                'callback' => 'book_rev_lite_comments',
                                'end-callback' => '',
                                'type' => 'all',
                                'page' => 0,
                                'per_page' => 0,
                                'avatar_size' => 32,
                                'format' => xhtml,
                                'echo' => 1);

                    foreach ($orderListCommentaire as $key => $value) {
                        $comment = $listComments[$key];
                        $numChildren = array_key_exists($comment->comment_ID, $listCommentParent) ? count($listCommentParent[$comment->comment_ID]) : 0;
                        $arg['has_children'] = $numChildren;
                        book_rev_lite_comments($comment, $arg, 1);

                        if($numChildren > 0) {
                            echo '<ul class="children">';
                            foreach ($listCommentParent[$comment->comment_ID] as $childrenKey) {
                                $arg['has_children'] = '';
                                book_rev_lite_comments($listComments[$childrenKey], $arg, 2);
                            }
                            echo '</ul>';
                        }
                    }
                    ?>
                    <?php // wp_list_comments('callback=book_rev_lite_comments'); ?>

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
    <?php endif; ?>