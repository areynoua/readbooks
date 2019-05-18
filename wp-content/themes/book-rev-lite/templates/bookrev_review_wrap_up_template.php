<?php
/**
* The top area of the review template. *
* @package Bookrev Lite
*/

if ( function_exists( 'cwppos_show_review' ) && book_rev_lite_wpr_get_status() == 'Yes' ) : ?>

<div id="wrap-up" class="clearfix">

  <header>
    <h2><?php _e( 'Wrap Up', 'book-rev-lite' ); ?></h2>
  </header>

  <div class="review-content">

    <div class="review-header clearfix">

      <div class="review-info">
        <h3><?php echo book_rev_lite_wpr_get_title(); ?></h3>
      </div><!-- end .review-info -->

      <?php

      $book_rev_lite_wpr_get_affiliate_link = book_rev_lite_wpr_get_affiliate_link();
      $book_rev_lite_wpr_get_affiliate_text = book_rev_lite_wpr_get_affiliate_text();

      if ( ! empty( $book_rev_lite_wpr_get_affiliate_link ) && ! empty( $book_rev_lite_wpr_get_affiliate_text ) ) {
        ?>

        <div class="buy-button">
          <a href="<?php echo $book_rev_lite_wpr_get_affiliate_link; ?>"><?php echo $book_rev_lite_wpr_get_affiliate_text; ?></a>
        </div><!-- end .buy-button -->

      <?php } ?>

    </div><!-- end .review-header -->

    <div class="review-body clearfix">

      <div class="book-cover">

        <div class="inner-wrap">
          <img src="<?php echo book_rev_lite_wpr_get_product_image(); ?>">
        </div><!-- end .inner-wrap -->

      </div><!-- end .book-cover -->

      <?php
      $book_rev_lite_wpr_get_review_options = book_rev_lite_wpr_get_review_options();

      if ( ! empty( array_filter( $book_rev_lite_wpr_get_review_options ) ) ) {
        ?>

        <div class="review-options">

          <ul>

            <?php foreach ( $book_rev_lite_wpr_get_review_options as $option ) : ?>

              <?php if ( ! empty( $option['value'] ) ) : ?>

                <li class="clearfix">

                  <span class="grade"><?php echo $option['value'] / 10; ?>/10</span>

                  <div class="grade-bar">

                    <div class="bar grade <?php echo book_rev_lite_display_review_class( $option['value'] / 10 ); ?>" style="width: <?php echo $option['value']; ?>%;">

                    </div>

                  </div><!-- end .grade-bar -->

                  <span class="option-name"><?php echo $option['name']; ?></span>

                </li>

              <?php endif; ?>

            <?php endforeach; ?>

          </ul>

        </div><!-- end .review-options -->

      <?php                }                ?>

      <div class="proscons">

        <div class="pros">

          <?php

          $book_rev_lite_wpr_get_pros = book_rev_lite_wpr_get_pros();

          if ( ! empty( array_filter( $book_rev_lite_wpr_get_pros ) ) ) {

            echo apply_filters( 'wppr_review_pros_text',  '<h2>' . cwppos( 'cwppos_pros_text' ) . '</h2>' );

            echo '<ul>';

            foreach ( $book_rev_lite_wpr_get_pros as $pro ) {

              echo '<li>' . $pro . '</li>';

            }

            echo '</ul>';

          }

          ?>

        </div><!-- end .pros -->

        <div class="cons">

          <?php

           $book_rev_lite_wpr_get_cons = book_rev_lite_wpr_get_cons();

          if ( ! empty( array_filter( $book_rev_lite_wpr_get_cons ) ) ) {

            echo apply_filters( 'wppr_review_cons_text',  '<h2>' . cwppos( 'cwppos_cons_text' ) . '</h2>' );

            echo '<ul>';

            foreach ( $book_rev_lite_wpr_get_cons as $con ) {

              echo '<li>' . $con . '</li>';

            }

            echo '</ul>';

          }

          ?>

        </div><!-- end .cons -->

      </div><!-- end .procons -->

    </div><!-- end .review-body -->

  </div><!-- end .review-content -->

</div><!-- end .wrap-up -->

<?php endif; ?>
