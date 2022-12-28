if ($('#applicant-table').length) {
	const ApplicantManagement = {
		table: null,
		save_buttonbar: null,
		button_add: null,
		button_cancel: null,

		init: function () {
			this.table = $('#applicant-table');
			this.save_buttonbar = this.table.find('tfoot td.save-buttonbar');
			this.button_add = this.table.find('tfoot .btn-new');
			this.button_cancel = this.table.find('tfoot .btn-cancel');
			this.eventHandlers();
		},

		eventHandlers: function () {
			const $this = this;
			$this.table.find('tfoot .btn-new').off('click');
			$this.table.find('tfoot .btn-new').on('click', function () {
				$this.addNewRow();
			});

			$this.table.find('tfoot .btn-cancel').off('click');
			$this.table.find('tfoot .btn-cancel').on('click', function () {
				$this.cancelRows();
			});
		},

		addNewRow: function () {
			this.save_buttonbar.removeClass('hidden');

			const rowIndex = this.table.find('tbody tr.new-row').length;

			const tr = $('<tr>');
			tr.addClass('new-row');
			tr.append($('<td><input type="text" required="required" class="form-control input-sm" name="applicant[' + rowIndex + '][name]" /></td>'))
			tr.append($('<td><input type="number" required="required" class="form-control input-sm" name="applicant[' + rowIndex + '][experience_year]" /></td>'))
			tr.append($('<td><select required="required" name="applicant[' + rowIndex + '][in_english]" class="form-control select2"></select></td>'))
			tr.append($('<td><select required="required" name="applicant[' + rowIndex + '][skills][]" class="form-control select2" multiple></select></td>'))
			tr.append($('<td><input type="email" required="required" class="form-control input-sm" name="applicant[' + rowIndex + '][email]" /></td>'))
			tr.append($('<td colspan="2"><input type="text" class="form-control input-sm" name="applicant[' + rowIndex + '][linked_in]" /></td>'))

			this.table.find('tbody').append(tr);

			$.each(this.table.find('tbody').find('select.select2'), function (index, item) {
				if (index == 0 && $(item).html() == '') {
					$(item).html($('#hidden_select_in_english').html());
				} else if (index == 1 && $(item).html() == '') {
					$(item).html($('#hidden_select_skills').html());
				}
			});

			this.table.find('tbody').find('.select2').select2({
				closeOnSelect: true,
				tags: true
			});
		},

		cancelRows: function () {
			this.table.find('tbody tr.new-row').remove();
			this.save_buttonbar.addClass('hidden');
		},
	};

	ApplicantManagement.init();
}