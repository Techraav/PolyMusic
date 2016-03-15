
// Close modal on ESCAPE key press event
$(document).on('keyup',function(evt) {
    if (evt.keyCode == 27) {
       $('.modal').modal('hide');
    }
});