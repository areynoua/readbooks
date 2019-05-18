function cld_setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function cld_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

jQuery(document).ready(function ($) {
    var ajax_flag = 0;
    $('body').on('click', '.cld-like-dislike-trigger', function () {
        if (ajax_flag == 0) {
            var restriction = $(this).data('restriction');
            var comment_id = $(this).data('comment-id');
            var trigger_type = $(this).data('trigger-type');
            var selector = $(this);
            var cld_cookie = cld_getCookie('cld_' + comment_id);
            var current_count = selector.closest('.cld-common-wrap').find('.cld-count-wrap').html();
            var new_count = parseInt(current_count) + 1;
            var ip_check = $(this).data('ip-check');
            var user_check = $(this).data('user-check');
            var like_dislike_flag = 1;
            if (restriction == 'cookie' && cld_cookie != '') {
                like_dislike_flag = 0;

            }
            if (restriction == 'ip' && ip_check == '1') {
                like_dislike_flag = 0;

            }
            if(restriction == 'user' && user_check == '1'){
                like_dislike_flag = 0;
            }
            if (like_dislike_flag == 1) {
                $.ajax({
                    type: 'post',
                    url: cld_js_object.admin_ajax_url,
                    data: {
                        comment_id: comment_id,
                        action: 'cld_comment_ajax_action',
                        type: trigger_type,
                        _wpnonce: cld_js_object.admin_ajax_nonce
                    },
                    beforeSend: function (xhr) {
                        ajax_flag = 1;
                        selector.closest('.cld-common-wrap').find('.cld-count-wrap').html(new_count);
                    },
                    success: function (res) {
                        ajax_flag = 0;
                        res = $.parseJSON(res);
                        if (res.success) {
                            if (restriction == 'ip') {
                                selector.closest('.cld-like-dislike-wrap').find('.cld-like-dislike-trigger').data('ip-check', 1);
                            }
                            if (restriction == 'user') {
                                selector.closest('.cld-like-dislike-wrap').find('.cld-like-dislike-trigger').data('user-check', 1);
                            }
                            var cookie_name = 'cld_' + comment_id;
                            cld_setCookie(cookie_name, 1, 365);
                            var latest_count = res.latest_count;
                            selector.closest('.cld-common-wrap').find('.cld-count-wrap').html(latest_count);
                        }
                    }

                });
            }
        }
    });


    $('.cld-like-dislike-wrap br,.cld-like-dislike-wrap p').remove();


});