jQuery(document).ready(function ($) {
    var info_timer;
    /**
     * Tab Show and hide
     */
    $('.cld-wrap .nav-tab').click(function () {
        var settings_ref = $(this).data('settings-ref');
        $('.cld-wrap .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.cld-settings-section').hide();
        $('.cld-settings-section[data-settings-ref="' + settings_ref + '"]').show();
        if(settings_ref == 'help' || settings_ref == 'about'){
            $('.cld-settings-action').hide();
        }else{
            $('.cld-settings-action').show();
        }

    });

    /**
     * Template Preview Toggle
     */
    $('.cld-template-dropdown').change(function () {
        var template = $(this).val();
        if (template != 'custom') {
            $('.cld-custom-ref').hide();
            $('.cld-template-ref').show();
            $('.cld-each-template-preview').hide();
            $('.cld-each-template-preview[data-template-ref="' + template + '"]').show();
        } else {
            $('.cld-each-template-preview').hide();
            $('.cld-template-ref').hide();
            $('.cld-custom-ref').show();
        }

    });

    /**
     * Colorpicker Initialize
     */
    $('.cld-colorpicker').wpColorPicker();

    /**
     * Open Media Uploader
     */
    $('.cld-file-uploader').click(function () {
        var selector = $(this);

        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
                .on('select', function (e) {
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    console.log(uploaded_image);
                    var image_url = uploaded_image.toJSON().url;
                    // Let's assign the url value to the input field
                    selector.parent().find('input[type="text"]').val(image_url);
                    selector.parent().find('.cld-preview-holder').html('<img src="'+image_url+'"/>');
                });
    });

    /**
     * Save Settings
     */
    $('.cld-settings-save-trigger').click(function () {
        var settings_data = '';
        $('.cld-form-field').each(function () {
            var value = $(this).val();
            if($(this).attr('type') && $(this).attr('type') == 'checkbox'){
                if(!$(this).is(':checked')){
                    var value = 0;
                }
            }
            
            var name = $(this).attr('name');
            var parse_value = name + '=' + value;
            if (settings_data != '') {
                settings_data += '&' + parse_value;
            } else {
                settings_data = parse_value;
            }
        });
        settings_data = encodeURI(settings_data);
        $.ajax({
            type: 'post',
            url: cld_admin_js_object.admin_ajax_url,
            data: {
                action: 'cld_settings_save_action',
                settings_data: settings_data,
                _wpnonce: cld_admin_js_object.admin_ajax_nonce
            },
            beforeSend: function (xhr) {
                clearTimeout(info_timer);
                $('.cld-info-wrap').slideDown(500);
                $('.cld-info').html(cld_admin_js_object.messages.wait)
                $('.cld-loader').show();
            },
            success: function (res) {
                $('.cld-loader').hide();
                $('.cld-info').html(res);
                info_timer = setTimeout(function () {
                    $('.cld-info-wrap').slideUp(500);
                }, 5000);

            }
        });
    });

    /**
     * Close Info 
     * 
     */
    $('.cld-close-info').click(function () {
        $(this).parent().slideUp(500);
    });

    /**
     * Default settings restore
     */
    $('.cld-settings-restore-trigger').click(function () {
        if (confirm(cld_admin_js_object.messages.restore_confirm)) {
            $.ajax({
                type: 'post',
                url: cld_admin_js_object.admin_ajax_url,
                data: {
                    action: 'cld_settings_restore_action',
                    _wpnonce: cld_admin_js_object.admin_ajax_nonce
                },
                beforeSend: function (xhr) {
                    clearTimeout(info_timer);
                    $('.cld-info-wrap').slideDown(500);
                    $('.cld-info').html(cld_admin_js_object.messages.wait)
                    $('.cld-loader').show();
                },
                success: function (res) {
                    $('.cld-loader').hide();
                    $('.cld-info').html(res);
                    location.reload();
                    

                }
            });
        }
    });
});