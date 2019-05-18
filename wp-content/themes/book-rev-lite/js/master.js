/*

	Master JS File

	@author Catalin Vasile

	codeinwp.com / themeisle.com / readythemes.com

	@description: General dynamic functionality for Bookrev WordPress Theme.

 */



// When the document is ready, run the scripts.

jQuery(document).ready(function(){



	// Sliding the submenu.

	jQuery('#main-menu nav ul').superfish();



    jQuery.fn.isAfter = function(sel){

        return this.prevAll().filter(sel).length !== 0;

    };



    jQuery.fn.isBefore= function(sel){

        return this.nextAll().filter(sel).length !== 0;

    };



	/* Top Bar - Search Form Animation on focus */

	jQuery("#top-bar-search input[type='text']").focus(function(){

		jQuery("#top-bar-search").animate({

			"width" : "16em"

		});

		jQuery("#top-bar-search .search-icon i").css({

			"color" : "#837c76"

		});

	});



	/* Top Bar - Search Form Animation on blur */

	jQuery("#top-bar-search input[type='text']").blur(function(){

		jQuery("#top-bar-search").animate({

			"width" : "14em"

		});

		jQuery("#top-bar-search .search-icon i").css({

			"color" : "#49433f"

		});

	});



	/* Select the last word in each newsblock header and wrap it in <span></span> tags for styling */

	jQuery(".newsblock header h2").each(function(){

		jQuery(this).html(jQuery(this).text().replace(/(\w+?)$/, '<span>$1</span>'));

	});



	/* Latest Reviews Block Slider Script */

	$navTop = jQuery(".lrb-navigation .nav-top");

	$navBottom = jQuery(".lrb-navigation .nav-bottom");

	$articleLink = jQuery(".lrb-navigation .article-link");

	var noLinks = $articleLink.length;

	var noLinksDisplayed = 4;



	// If there are more links that the links set in noLinksDisplayed variable.

	if (noLinks > noLinksDisplayed) {

		// Add the "hidden" class to the other elements.

		for (var i = noLinksDisplayed; i <= noLinks; i++) {

			jQuery(".lrb-navigation .article-link").eq(i).addClass("hidden");

		};



		// Add the "visible" class to the number of elements set to be visible. (noLinksDiplayed)

		for (var i = 0; i < noLinksDisplayed; i++) {

			jQuery(".lrb-navigation .article-link").eq(i).addClass("visible");

		};



		// Set the masterContainer var to 0.

		var masterContainer = 0;



		// Calculate the first visible elements combined height.

		jQuery(".lrb-navigation .article-link.visible").each(function(){

			masterContainer = masterContainer + jQuery(this).outerHeight();

		});



		// Set the height of the list according to the first visible elements set height.

		jQuery("#latest-reviews-block .lrb-navigation ul").css("height", masterContainer);

	}



	// When the top navigation button is clicked.

	$navTop.on("click", function(e){

		// Prevent the default behaviour.

		e.preventDefault();



		// Save the necessary elements in smart jQuery variables.

		$firstVisibleElement = jQuery("#latest-reviews-block .lrb-navigation .article-link.visible").eq(0);

		$lastVisibleElement = jQuery("#latest-reviews-block .lrb-navigation .article-link.visible:last");

		$firstHiddenElement = $lastVisibleElement.next();



		// If there is another element after the last visible element.

		if($firstHiddenElement.isAfter($lastVisibleElement)) {

			// Save the first visible element's outer height in fveHeight var.

			var fveHeight = $firstVisibleElement.outerHeight(); // fve = First Visible Element



			// Get its negative value and store it in the same var.

			fveHeight *= -1;

			

			// Get the first visible element, replace its visible class with hidden and animate it to the top.

			$firstVisibleElement.removeClass("visible").addClass("hidden").animate({"marginTop" : fveHeight}, 100);



			// Get the next element after the last visible element and replace its hidden class with visible.

			$lastVisibleElement.next().removeClass("hidden").addClass("visible");

		}

	});





	// When the bottom navigation link is clicked

	$navBottom.on("click", function(e){



		// Prevent the default behaviour.

		e.preventDefault();



		// Save the necessary elements in smart jQuery variables.

		$firstVisibleElement = jQuery("#latest-reviews-block .lrb-navigation .article-link.visible").eq(0);

		$lastVisibleElement = jQuery("#latest-reviews-block .lrb-navigation .article-link.visible:last");

		$firstHiddenElement = $lastVisibleElement.next();



		// If there is a hidden element before the first visible element.

		if(jQuery("#latest-reviews-block .lrb-navigation .article-link.hidden").eq(0).isBefore(jQuery("#latest-reviews-block .lrb-navigation .article-link.visible").eq(0))) {



			// Animate the first hidden element before the first visible element and replace its classes.

		 	$firstVisibleElement.prev().removeClass("hidden").addClass("visible").animate({"marginTop" : "0"}, 100);



		 	// Get the last visible element, and replace its classes.

		 	$lastVisibleElement.removeClass("visible").addClass("hidden");

		}

	});



	jQuery("#latest-reviews-block .lrb-navigation .article-link").on("click", function(e){

		e.preventDefault();

		jQuery("#latest-reviews-block .lrb-navigation .article-link.active").removeClass("active");

		jQuery("#latest-reviews-block .lrb-navigation .article-link.visible").removeClass("active");

		jQuery(this).addClass("active");

		var articleLinkID = jQuery(this).attr("id");

		jQuery("#latest-reviews-block .article-display .article-content.active").removeClass("active").hide();

		jQuery("#latest-reviews-block .article-display .article-content#" + articleLinkID).fadeIn().addClass("active");

	});



	// Making the menu responsive

	jQuery("#main-header #main-menu nav li a").addClass("top-level");

	jQuery("#main-header #main-menu nav .sub-menu li a").addClass("second-level");



	jQuery("<select class='main-dropdown'/>").appendTo("#main-header #main-menu nav");



	jQuery("<option />", {

		"selected"	: "selected",

		"value"		: "",

		"text"		: "Main Navigation"

	}).appendTo("#main-header #main-menu nav select");



	jQuery("#main-header #main-menu nav li a").each(function(){

		var link = jQuery(this);

		jQuery("<option />", {

			"value"		: link.attr("href"),

			"text"		: link.text(),

			"class"		: link.attr("class")

		}).appendTo("#main-header #main-menu nav select");

	});



	jQuery("#main-header #main-menu nav select").change(function(){

		window.location = jQuery(this).find("option:selected").val();

	});



	jQuery("<p>- </p>").prependTo("option.second-level");

	jQuery('#main-menu li.menu-item-has-children').append("<i class='fa fa-caret-down'></i>");
	
	
	/** User reviews comments **/
	
	jQuery(".comment_meta_slider").each(function() {
        var comm_meta_input = jQuery(this).parent(".comment-form-meta-option").children("input");
        jQuery(this).slider({
            min: 0,
            max: 100,
            value: 4,
            slide: function(event, ui) {
                jQuery(comm_meta_input).val(ui.value / 10);
            }
        });
    });


});