function removeImage() {
    jQuery("#fifu_input_alt").hide();
    jQuery("#fifu_image").hide();
    jQuery("#fifu_link").hide();

    jQuery("#fifu_input_alt").val("");
    jQuery("#fifu_input_url").val("");

    jQuery("#fifu_button").show();
}

function previewImage() {
    var $url = jQuery("#fifu_input_url").val();
    $url = fifu_convert($url);

    if ($url) {
        jQuery("#fifu_button").hide();
        jQuery("#fifu_news").hide();

        jQuery("#fifu_image").css('background-image', "url('" + $url + "')");

        jQuery("#fifu_input_alt").show();
        jQuery("#fifu_image").show();
        jQuery("#fifu_link").show();
    }
}
