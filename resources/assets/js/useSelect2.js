require('select2');
$('.select2').select2();

$(document).ready(function () {
	$(document).on('select2:open', function (e) {
		const select2 = $(e.target).data('select2');
		if (!select2.options.get('multiple')) {
			select2.dropdown.$search.get(0).focus();
		}
	});
});