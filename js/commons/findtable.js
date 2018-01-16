$('#filtrar').keyup(function () {
	var rex = new RegExp($(this).val(), 'i');
	$('.find tr').hide();
	$('.find tr').filter(function () {
		return rex.test($(this).text());
	}).show();
});