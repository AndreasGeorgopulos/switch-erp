
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('select2');
$('.select2').select2();


require('./listTable');
require('./applicant_management');
require('./applicant_management_notes');
require('./contract_management');

$(document).on('click', 'button.btn-delete', function (e) {
	const url = $(this).data('href');
	const message = $(this).data('message');

	if (!url || !message) {
		alert('szarrrr');
		return;
	}

	if (confirm(message)) {
		document.location.href = url;
	}
});