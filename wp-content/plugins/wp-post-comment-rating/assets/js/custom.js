jQuery( document ).ready(function() {
jQuery( ".wpcr_author_stars" ).each(function() { 
		// Get the value
		var val = jQuery(this).data("rating");
		// Make sure that the value is in 0 - 5 range, multiply to get width
		var size = Math.max(0, (Math.min(5, val))) * 16;
		// Create stars holder
		var $span = jQuery('<span />').width(size);
		// Replace the numerical value with stars
		jQuery(this).html($span);
	});
	
	//val = Math.round(val * 4) / 4; <!-- To round to nearest quarter -->
	//val = Math.round(val * 2) / 2; <!-- To round to nearest half -->
	
	jQuery(function() {
		//jQuery('span.author_stars').stars();
	});
	jQuery( ".wpcr_averageStars" ).each(function() { 
		// Get the value
		var val1 = jQuery(this).attr("id");
		//alert(val1);
		// Make sure that the value is in 0 - 5 range, multiply to get width
		var size1 = Math.max(0, (Math.min(5, val1))) * 16;
		// Create stars holder
		var $span1 = jQuery('<span />').width(size1);
		// Replace the numerical value with stars
		jQuery(this).html($span1);
	});
	


	jQuery( ".reply a.comment-reply-link" ).click(function() {
		jQuery('fieldset.rating').attr('id', 'hide-stars');
	});
	
    jQuery(".wpcr_floating_links").prependTo( jQuery("body.wpcr_single_post" ));

});
	

	