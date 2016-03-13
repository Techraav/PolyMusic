function fileInput(el)
{
	var form = $(el).parents('form')[0].getAttribute('id');
	var filename = $(el).val().replace(/C:\\fakepath\\/i, '');
	$('#'+form+' #name').text(filename);
	var fileExtension = filename.substr(filename.lastIndexOf('.')+1);
	var allowedExtension = $(el).data("extension");
	allowedExtension = allowedExtension.replace(/'/g,"");
	allowedExtension = allowedExtension.replace(/ /g,"");
	allowedExtension = allowedExtension.substr(1,allowedExtension.length-2);
	allowedExtension = allowedExtension.split(',');
	var check = false;
	check = allowedExtension.indexOf(fileExtension) != -1;
	if(!check){
		$('.filename').addClass('file-error');
	}
	else {
		$('.filename').removeClass('file-error');
	}

}

function clickFile()
{
	$('input')[0].click();
}