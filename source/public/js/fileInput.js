function fileInput(el)
{
	var form = $(el).parents('form')[0].getAttribute('id');
	var filename = $(el).val().replace(/C:\\fakepath\\/i, '');
	$('#'+form+' #name').text(filename);
}

function clickFile()
{
	$('input')[0].click();
}