
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
require('./search_management');

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


$(document).on('keydown', 'input.only-numbers', function (e) {
	let keyPressed;
	if (e.keyCode) keyPressed = e.keyCode;
	else if (e.which) keyPressed = e.which;
	const hasDecimalPoint = (($(this).val().split('.').length - 1) > 0);
	if ( keyPressed == 46 || keyPressed == 8 || ((keyPressed == 190||keyPressed == 110) && (!hasDecimalPoint && !e.shiftKey)) || keyPressed == 9 || keyPressed == 27 || keyPressed == 13 ||
		(keyPressed == 65 && e.ctrlKey === true) ||
		(keyPressed >= 35 && keyPressed <= 39)) {
		return;
	}
	else {
		if (e.shiftKey || (keyPressed < 48 || keyPressed > 57) && (keyPressed < 96 || keyPressed > 105 )) {
			e.preventDefault();
		}
	}
});

/**
 * Telefonszám formátum kezelés
 */
$(document).on('keyup', 'input.phone-number', function (e) {
	const exceptedKeyCodes = [8, 46, 37, 38, 39, 40];

	if (exceptedKeyCodes.indexOf(e.keyCode) !== -1) {
		return false;
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

/**
 * Fizetési igény kezelés
 */
$(document).on('keyup', 'input.salary', function (e) {
	$(this).change();
});

$(document).on('change', 'input.salary', function (e) {
	const numberWithThousands = function (number) {
		return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, ("$1."));
	}

	let value = $(this).val().replaceAll('.', '');

	$(this).val(numberWithThousands(value));
});

$('input.salary').change();