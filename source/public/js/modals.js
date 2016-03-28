function modalToggle(el)
{
	var id = el.getAttribute('id');
	var link = el.getAttribute('link');
	var action = el.getAttribute('action');
	var msg = el.getAttribute('msg');

	$("#modalToggle form .text-warning b").text(msg);
	$('#modalToggle #id').attr('value', id);
	$('#modalToggle form').attr('action', link);
	$('#modalToggle #button-toggle').text(action);
	$('#modalToggle').modal('show');
}

function modalDelete(el) {
	var id = el.getAttribute('id');
	var	link = el.getAttribute('link');

	$('#modalDelete #id').attr('value', id);
	$('#modalDelete form').attr('action', link);
	$('#modalDelete').modal('show');
}