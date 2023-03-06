if ($('#data-applicant-table').length) {
	const ApplicantManagement = {
		table_new: null,
		table_data: null,
		save_buttonbar: null,
		button_add: null,
		button_cancel: null,
		button_scroll_left: null,
		button_scroll_right: null,
		scroll_step: 700,
		button_reorder_save: null,
		button_reorder_cancel: null,

		init: function () {
			this.table_data = $('#data-applicant-table');
			this.table_new = $('#new-applicant-table');
			this.save_buttonbar = this.table_new.find('tfoot td.save-buttonbar');
			this.button_add = this.table_new.find('tfoot .btn-new');
			this.button_cancel = this.table_new.find('tfoot .btn-cancel');
			this.button_scroll_left = $('.applicant-management .foot-toolbar .btn-scroll-left');
			this.button_scroll_right = $('.applicant-management .foot-toolbar .btn-scroll-right');
			this.button_reorder_save = $('.applicant-management .foot-toolbar .btn-reorder-save');
			this.button_reorder_cancel = $('.applicant-management .foot-toolbar .btn-reorder-cancel');
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

			$this.button_scroll_left.off('click');
			$this.button_scroll_left.on('click', function (e) {
				e.preventDefault();
				$this.scrollHorizontal($this.scroll_step * -1);
			});

			$this.button_scroll_right.off('click');
			$this.button_scroll_right.on('click', function (e) {
				e.preventDefault();
				$this.scrollHorizontal($this.scroll_step);
			});

			$this.button_reorder_save.off('click');
			$this.button_reorder_save.on('click', function (e) {
				e.preventDefault();
				$this.saveReorder();
			});

			$this.button_reorder_cancel.off('click');
			$this.button_reorder_cancel.on('click', function (e) {
				e.preventDefault();
				$this.cancelReorder();
			});

			$this.table_data.tableDnD({
				onDragClass: 'onDragClass',
				dragHandle: '.dragHandle',
				onDrop: function(table, row) {
					$this.button_reorder_save.removeClass('hidden');
					$this.button_reorder_cancel.removeClass('hidden');
				}
			});
		},

		saveReorder: function () {
			const $this = this;
			const url = '/applicant_management/reorder/' + $('#hidden_applicant_group_id').val();
			let data = {
				_token: $('input[name="_token"]').val(),
				ids: []
			};

			$.each($this.table_data.find('tbody tr'), function (index, row) {
				data.ids.push($(row).attr('id'));
			});

			$this.button_reorder_save.prop('disabled', true);
			$this.button_reorder_cancel.prop('disabled', true);

			$.post(url, data, function () {
				$this.button_reorder_save.addClass('hidden');
				$this.button_reorder_cancel.addClass('hidden');
				document.location.reload();
			});
		},

		cancelReorder: function () {
			const $this = this;
			const table_area = $('.applicant-management .table-area');

			$this.button_reorder_save.prop('disabled', true);
			$this.button_reorder_cancel.prop('disabled', true);

			document.location.reload();
		},

		scrollHorizontal: function (scrollStep) {
			const table_area = $('.applicant-management .table-area');
			let scrollLeft = table_area.scrollLeft() + scrollStep;
			table_area.animate({ scrollLeft: scrollLeft }, 800);
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