function addInput() {
    $('#nf-field-45-container').css('display', 'none');
    jQuery( '#nf-field-45').val(postId).trigger( 'change' );
    $('#nf-field-49-container').css('display', 'none');
    jQuery( '#nf-field-49').val(modifiedPointId).trigger('change');
}

if (typeof pointId === 'undefined') {
    var modifiedPointId = "";
} else {
    var modifiedPointId = pointId;
}

$(function() {
    setTimeout(addInput, 1000);
});