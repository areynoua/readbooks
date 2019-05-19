function addInput() {
    $('#nf-field-45-container').css('display', 'none');
    jQuery( '#nf-field-45').val(postId).trigger( 'change' );
}

$(function() {
    setTimeout(addInput, 1000);
});