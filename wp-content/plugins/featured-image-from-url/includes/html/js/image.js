jQuery(document).ready(function ($) {
    // lazy load
    if ('<?php echo fifu_is_on("fifu_lazy"); ?>') {
        jQuery.extend(jQuery.lazyLoadXT, {
            srcAttr: 'data-src',
            visibleOnly: false,
            updateEvent: 'load orientationchange resize scroll touchmove focus hover'
        });
    }

    // woocommerce lightbox/zoom
    disableClick($);

    // for all images at single product page
    setTimeout(function () {
        resizeImg($);
        jQuery('a.woocommerce-product-gallery__trigger').css('visibility', 'visible');
    }, 2500);
});

jQuery(window).on('ajaxComplete', function () {
    if ('<?php echo fifu_is_on("fifu_lazy"); ?>') {
        setTimeout(function () {
            jQuery(window).lazyLoadXT();
        }, 300);
    }
});

jQuery(window).on('load', function () {
    jQuery('.flex-viewport').css('height', '100%');
});

function resizeImg($) {
    var imgSelector = ".post img, .page img, .widget-content img, .product img, .wp-admin img, .tax-product_cat img, .fifu img";
    var resizeImage = function (sSel) {
        jQuery(sSel).each(function () {
            //original size
            var width = $(this)['0'].naturalWidth;
            var height = $(this)['0'].naturalHeight;
            jQuery(this).attr('data-large_image_width', width);
            jQuery(this).attr('data-large_image_height', height);

            //100%
            //var ratio = width / height;
            //jQuery(this).attr('data-large_image_width', jQuery(window).width() * ratio);
            //jQuery(this).attr('data-large_image_height', jQuery(window).width());
        });
    };
    resizeImage(imgSelector);
}

function disableClick($) {
    if ('<?php echo !fifu_woo_lbox(); ?>') {
        jQuery('.woocommerce-product-gallery__image').each(function (index) {
            jQuery(this).children().click(function () {
                return false;
            });
            jQuery(this).children().children().css("cursor", "default");
        });
    }
}
