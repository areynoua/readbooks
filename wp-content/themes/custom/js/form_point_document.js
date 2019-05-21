function addInput() {
    jQuery('#nf-field-45-container').css('display', 'none');
    jQuery( '#nf-field-45').val(postId).trigger( 'change' );
    jQuery('#nf-field-53-container').css('display', 'none');
    jQuery( '#nf-field-53').val(postId).trigger( 'change' );
    jQuery('#nf-field-49-container').css('display', 'none');
    jQuery( '#nf-field-49').val(modifiedPointId).trigger('change');
    jQuery('#nf-field-56-container').css('display', 'none');
    jQuery( '#nf-field-56').val(requestPointId).trigger('change');
}

if (typeof pointId === 'undefined') {
    var modifiedPointId = "";
} else {
    var modifiedPointId = pointId;
}

if (typeof requestPointId === 'undefined') {
    var requestPointId = "";
} else {
    var requestPointId = requestPointId;
}

jQuery(function() {
    setTimeout(addInput, 1000);
    setTimeout(addAutoComplete, 1000);
});


var availableTags = availableTags;
function addAutoComplete() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    
    applyAutoComplete(jQuery("#nf-field-54"));
    applyAutoComplete(jQuery("#nf-field-46"));

    function applyAutoComplete(element) {
        // don't navigate away from the field on tab when selecting an item
        jQuery(element).on( "keydown", function( event ) {
                if ( event.keyCode === jQuery.ui.keyCode.TAB &&
                    jQuery(this).autocomplete( "instance" ).menu.active ) {
                  event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 1,
                source: function(request, response) {
                    // delegate back to autocomplete, but extract the last term
                    response(jQuery.ui.autocomplete.filter(
                        availableTags, extractLast(request.term))
                    );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });
    }

    
}