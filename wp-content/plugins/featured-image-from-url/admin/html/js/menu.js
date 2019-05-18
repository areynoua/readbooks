jQuery(document).ready(function () {
    jQuery('.wrap').css('opacity', 1);
});

function homeUrl() {
    var href = window.location.href;
    var index = href.indexOf('/wp-admin');
    var homeUrl = href.substring(0, index);
    return homeUrl;
}

function invert(id) {
    if (jQuery("#fifu_toggle_" + id).attr("class") == "toggleon") {
        jQuery("#fifu_toggle_" + id).attr("class", "toggleoff");
        jQuery("#fifu_input_" + id).val('off');
    } else {
        jQuery("#fifu_toggle_" + id).attr("class", "toggleon");
        jQuery("#fifu_input_" + id).val('on');
    }
}

jQuery(function () {
    var url = window.location.href;

    //forms with id started by...
    jQuery("form[id^=fifu_form]").each(function (i, el) {
        //onsubmit
        jQuery(this).submit(function () {
            save(this);
        });
    });

    jQuery("#tabs-flickr").tabs();
    jQuery("#accordionClean").accordion();
    jQuery("#tabs").tabs();
    jQuery("#tabs-top").tabs();
    jQuery("#fifu_input_spinner_cron_metadata").spinner({min: 1, step: 1});
    jQuery("#fifu_input_spinner_db").spinner({min: 100, step: 100});
    jQuery("#fifu_input_spinner_image").spinner({min: 0});
    jQuery("#fifu_input_spinner_video").spinner({min: 0});
    jQuery("#fifu_input_spinner_slider").spinner({min: 0});
    jQuery("#fifu_input_slider_speed").spinner({min: 0});
    jQuery("#fifu_input_slider_pause").spinner({min: 0});
    jQuery("#tabsApi").tabs();
    jQuery("#tabsCrop").tabs();
    jQuery("#tabsPremium").tabs();
    jQuery("#tabsWooImport").tabs();
    jQuery("#tabsWpAllImport").tabs();
});

function save(formName, url) {
    var frm = jQuery(formName);
    jQuery.ajax({
        type: frm.attr('method'),
        url: url,
        data: frm.serialize(),
        success: function (data) {
            //alert('saved');
        }
    });
}

jQuery(function () {
    jQuery("#dialog").dialog({
        autoOpen: false,
        modal: true,
        width: "630px",
    });

    jQuery("#opener").on("click", function () {
        jQuery("#dialog").dialog("open");
    });
});

function fifu_fake_js() {
    jQuery('.wrap').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    toggle = jQuery("#fifu_toggle_fake2").attr('class');
    switch (toggle) {
        case "toggleon":
            option = "enable_fake_api";
            break;
        case "toggleoff":
            option = "disable_fake_api";
            break;
        default:
            option = "none_fake_api";
    }
    jQuery.ajax({
        method: "POST",
        url: homeUrl() + '/wp-json/featured-image-from-url/v2/' + option + '/',
        async: true,
        success: function (data) {
            jQuery('.wrap').unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            jQuery('.wrap').unblock();
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        timeout: 0
    });
}

function fifu_clean_js() {
    if (jQuery("#fifu_toggle_data_clean").attr('class') != 'toggleon')
        return;

    jQuery('.wrap').block({message: 'Please wait some seconds...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: homeUrl() + '/wp-json/featured-image-from-url/v2/data_clean_api/',
        async: true,
        success: function (data) {
            window.location.href = '#tabs-j';
            jQuery("#fifu_toggle_data_clean").attr('toggleoff');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            window.location.href = '#tabs-j';
            jQuery("#fifu_toggle_data_clean").attr('toggleoff');
            location.reload();
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}
