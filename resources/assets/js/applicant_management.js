if ($('#data-applicant-table').length) {
	const ApplicantManagement = {
		table_new: null,
		table_data: null,
		save_buttonbar: null,
		button_add: null,
		button_cancel: null,

		init: function () {
			this.table_data = $('#data-applicant-table');
			this.table_new = $('#new-applicant-table');
			this.save_buttonbar = this.table_new.find('tfoot td.save-buttonbar');
			this.button_add = this.table_new.find('tfoot .btn-new');
			this.button_cancel = this.table_new.find('tfoot .btn-cancel');
			this.eventHandlers();
		},

		eventHandlers: function () {
			const $this = this;
			$this.table_new.find('tfoot .btn-new').off('click');
			$this.table_new.find('tfoot .btn-new').on('click', function () {
				$this.addNewRow();
			});

			$this.table_new.find('tfoot .btn-cancel').off('click');
			$this.table_new.find('tfoot .btn-cancel').on('click', function () {
				$this.cancelRows();
			});

			$this.table_data.find('thead input.search-input').off('keyup keypress');
			$this.table_data.find('thead input.search-input').on('keyup keypress', function (e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) {
					e.preventDefault();
					$this.filterRows();
					return false;
				}
			});

			$this.table_data.find('thead select.search-input').off('change');
			$this.table_data.find('thead select.search-input').on('change', function (e) {
				e.preventDefault();
				$this.filterRows();
				return false;
			});
		},

		filterRows: function () {
			const $this = this;
			let getItems = [];
			$.each($this.table_data.find('thead .search-input'), function (index, item) {
				if ($(item).val() != '') {
					const option = $(item).attr('name') + '=' + $(item).val();
					if (getItems.lastIndexOf(option) == -1) {
						getItems.push(option);
					}
				}
			});

			if (getItems.length) {
				let urlParts = document.location.href.split('?');
				document.location.replace(urlParts[0] + '?' + getItems.join('&'));
			}
		},

		addNewRow: function () {
			this.save_buttonbar.removeClass('hidden');
			this.table_new.find('thead').removeClass('hidden');

			const rowIndex = this.table_new.find('tbody tr.new-row').length;

			const tr = $('<tr>');
			tr.addClass('new-row');
			tr.append($('<td><input type="text" required="required" class="form-control input-sm" name="applicant[' + rowIndex + '][name]" /></td>'))
			tr.append($('<td><input type="number" required="required" class="form-control input-sm" name="applicant[' + rowIndex + '][experience_year]" /></td>'))
			tr.append($('<td><select required="required" name="applicant[' + rowIndex + '][in_english]" class="form-control select2 in_english"></select></td>'))
			tr.append($('<td><select required="required" name="applicant[' + rowIndex + '][skills][]" class="form-control select2 skills" multiple></select></td>'))
			tr.append($('<td><input type="email" required="required" class="form-control input-sm" name="applicant[' + rowIndex + '][email]" /></td>'))
			tr.append($('<td colspan="2"><input type="text" class="form-control input-sm" name="applicant[' + rowIndex + '][linked_in]" /></td>'))

			this.table_new.find('tbody').append(tr);

			$.each(this.table_new.find('tbody').find('select.select2'), function (index, item) {
				if ($(item).hasClass('in_english') && $(item).html() == '') {
					$(item).html($('#hidden_select_in_english').html());
				} else if ($(item).hasClass('skills') && $(item).html() == '') {
					$(item).html($('#hidden_select_skills').html());
				}
			});

			this.table_new.find('tbody').find('.select2').select2({
				closeOnSelect: true,
				tags: true
			});
		},

		cancelRows: function () {
			this.table_new.find('tbody tr.new-row').remove();
			this.save_buttonbar.addClass('hidden');
			this.table_new.find('thead').addClass('hidden');
		},
	};

	ApplicantManagement.init();
}