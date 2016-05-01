
// Close modal on ESCAPE key press event
$(document).on('keyup',function(evt) {
    if (evt.keyCode == 27) {
       $('.modal').modal('hide');
    }
});

$(function(){
  $(".dropdown-menu > li > a.trigger").on("click",function(e){
    var current=$(this).next();
    var grandparent=$(this).parent().parent();
    if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
      $(this).toggleClass('right-caret left-caret');
    grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
    grandparent.find(".sub-menu:visible").not(current).hide();
    current.toggle();
    e.stopPropagation();
  });
  $(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
    var root=$(this).closest('.dropdown');
    root.find('.left-caret').toggleClass('right-caret left-caret');
    root.find('.sub-menu:visible').hide();
  });
});

$('#open-tab').on('click', function(){
  $('#table').toggleClass('table-hidden');
  $('#open-tab').toggleClass('table-hidden');
  $('#close-tab').toggleClass('table-hidden');
});

$('#close-tab').on('click', function(){
  $('#table').toggleClass('table-hidden');
  $('#open-tab').toggleClass('table-hidden');
  $('#close-tab').toggleClass('table-hidden');
});