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

function dialogEditCategory(el)
{
	var id = el.getAttribute('category-id');
	var name = el.getAttribute('category-name');
	var link = el.getAttribute('link');

	$('#modalEdit form').attr('action', link);
	$('#modalEdit #name').attr('value', name);
	$('#modalEdit #category_id').attr('value', id);
	$('#modalEdit').modal('toggle');
}	

function modalPicture(el)
{
	var src = el.getAttribute('src');

	$('#modalPicture .modal-body #picture').attr('src', src);
	$('#modalPicture').modal('show');
}

$('#modalPicture .modal-body #picture').click(function() {
	$('#modalPicture').modal('hide');
});