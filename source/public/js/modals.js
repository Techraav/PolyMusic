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

function modalDelete(id, link) {
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

function modalEditInstrument(id, link, name)
{
	$('#modalEdit form').attr('action', link);
	$('#modalEdit #name').attr('value', name);
	$('#modalEdit #id').attr('value', id);
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



// CONTROLS CLICK
$('.control-button').on('click', function(){
	var value = $(this).data('value');
	var title = value == -2 ? 'Ne plus enseigner ce cours' 
			  : value == -1 ? 'Se désinscrire du cours' 
			  : value == 1 ? 'S\'inscrire au cours' 
			  : 'Demander à devenir un professeur de ce cours';

	var text = value == -2 ? 'Souhaitez-vous vraiment vous retirer des professeurs ?' 
			  : value == -1 ? 'Souhaitez-vous vraiment vous désinscrire de ce cours ? <br /> Attention ! Vous ne pourrez plus avoir accès aux documents mis en ligne par les professeurs !' 
			  : value == 1 ? "Souhaitez-vous vraiment vous inscrire à ce cours ? <br /> Votre demande sera mise en attente jusqu'a ce qu'un professeur ou administrateur la traite. <br /> Cela ne devrait pas prendre beaucoup de temps, vous en serez informé immédiatement."
			  : 'Vous souhaitez faire partie des professeurs de ce cours ? Indiquez nous compétences et motivations, votre demande sera analysée par le reponsable du cours en question, vous serez informé immédiatement lorsqu\'elle aura été traitée.';

	if(value < 0)
	{
		$('#modalControl #danger').html(text);
		$('#modalControl #warning').html('');
		$('#modalControl #password').attr('required', true);
		$('#modalControl #control-pw').attr('hidden', false);
	}else
	{
		$('#modalControl #warning').html(text);
		$('#modalControl #danger').html('');
		$('#modalControl #password').attr('required', false);
		$('#modalControl #control-pw').attr('hidden', true);
	}

	$('#modalControl #modal-title').text(title);


	$('#control-textarea').attr('hidden', true);
	if(value == 2)
	{
		$('#control-textarea').attr('hidden', false);
	}

	$('#modalControl form #value').attr('value', value);
	$('#modalControl').modal('show');
});

$('.delete-button').on('click', function(){
	var id = $(this).data('id');
	var link = $(this).data('link');
	modalDelete(id, link);
});

$('.edit-instrument-button').on('click', function(){
	var id = $(this).data('id');
	var link = $(this).data('link');
	var name = $(this).data('name');
	modalEditInstrument(id, link, name);
});