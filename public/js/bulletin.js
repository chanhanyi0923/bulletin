tinymce.init({
	selector:'#content',
	language:'zh_TW',
	height: 500,
	theme: 'modern',
	content_css : "http://www.ylsh.ilc.edu.tw/css/tinymce.css",
	plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools jbimages'
	],
	toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages',
	toolbar2: 'print preview media | forecolor backcolor emoticons',
	image_advtab: true,
	relative_urls: false
});
function removeURL()
{
	if (url_last_id < 0) {
		return;
	}
	$("#url_" + url_last_id).remove();
	url_last_id --;
}
function addURL()
{
	$("#url").append('<input name="url[]" type="text" class="input-url" id="url_' + (++ url_last_id) + '">');
}
function removeFile()
{
	if (file_last_id < 0) {
		return;
	}
	$("#file_" + file_last_id).remove();
	file_last_id --;
}
function addFile()
{
	$("#file").append('<input name="file[]" type="file" class="input-file" id="file_' + (++ file_last_id) + '">')
}