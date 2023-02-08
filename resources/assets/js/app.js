
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

/**
 * Törlés gombok click esemény kezelése
 */
$(document).on('click', 'button.btn-delete', function (e) {
	const url = $(this).data('href');
	const message = $(this).data('message');

	if (!url || !message) {
		return;
	}

	if (confirm(message)) {
		document.location.href = url;
	}
});

/**
 * Telefonszám formátum kezelés
 */
$(document).on('keyup', 'input.phone-number', function (e) {
	const exceptedKeyCodes = [8, 46, 37, 38, 39, 40];

	if (exceptedKeyCodes.indexOf(e.keyCode) !== -1) {
		return;
	}

	$(this).change();
});

$(document).on('change', 'input.phone-number', function () {
	let value = $(this).val();

	if (value.length > 2 && value.indexOf('/') !== 2) {
		value = value.slice(0, 2) + '/' + value.slice(2);
		$(this).val(value);
	}

	if (value.length > 6 && value.indexOf('-') !== 6) {
		value = value.slice(0, 6) + '-' + value.slice(6)
		$(this).val(value);
	}
});