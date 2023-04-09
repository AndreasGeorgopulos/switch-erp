if ($('#data-sales-table').length) {
	const SalesManagement = {
		table_new: null,
		table_data: null,
		save_buttonbar: null,
		button_add: null,
		button_cancel: null,
		button_scroll_left: null,
		button_scroll_right: null,
		scroll_step: 1000,
		button_reorder_save: null,
		button_reorder_cancel: null,
		button_modify_save: null,
		button_modify_cancel: null,

		init: function () {
			this.table_data = $('#data-sales-table');
			this.table_new = $('#new-sales-table');
			this.save_buttonbar = this.table_new.find('tfoot td.save-buttonbar');
			this.button_add = this.table_new.find('tfoot .btn-new');
			this.button_cancel = this.table_new.find('tfoot .btn-cancel');
			this.button_scroll_left = $('.sales-management .foot-toolbar .btn-scroll-left');
			this.button_scroll_right = $('.sales-management .foot-toolbar .btn-scroll-right');
			this.button_reorder_save = $('.sales-management .foot-toolbar .btn-reorder-save');
			this.button_reorder_cancel = $('.sales-management .foot-toolbar .btn-reorder-cancel');
			this.button_modify_save = $('.sales-management .foot-toolbar .btn-modify-save');
			this.button_modify_cancel = $('.sales-management .foot-toolbar .btn-modify-cancel');
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

			$this.table_data.find('tbody tr input, tbody tr select').off('change');
			$this.table_data.find('tbody tr input, tbody tr select').on('change', function (e) {
				e.preventDefault();
				$this.modifyCell($(this));
			});

			$this.button_modify_save.off('click');
			$this.button_modify_save.on('click', function (e) {
				e.preventDefault();
				$this.saveModify();
			});

			$this.button_modify_cancel.off('click');
			$this.button_modify_cancel.on('click', function (e) {
				e.preventDefault();
				$this.cancelModify();
			});

			$this.table_data.find('input, select').off('focus');
			$this.table_data.find('input, select').on('focus', function (e) {
				e.preventDefault();
				$this.selectRow($(this).parents('tr'));
			});

			this.table_data.find('form.delete-sale').off('submit');
			this.table_data.find('form.delete-sale').on('submit', function (e) {
				if (confirm('Biztos, hogy törölni akarja ezt a céget?')) {
					return true;
				}
				return false;
			});
		},

		selectRow: function (element) {
			this.deSelectRows();
			element.addClass('selectedRow');
		},

		deSelectRows: function () {
			this.table_data.find('.selectedRow').removeClass('selectedRow');
		},

		modifyCell: function (element) {
			const $this = this;

			element.addClass('modified-input');
			element.parents('tr').addClass('modified-row');

			$this.button_modify_save.removeClass('hidden');
			$this.button_modify_cancel.removeClass('hidden');
		},

		saveModify: function () {
			const $this = this;
			const url = '/sales_management/update';

			let data = {
				_token: $('input[name="_token"]').val(),
				sales: {}
			};
			$.each($this.table_data.find('tbody tr.modified-row'), function (index, row) {
				let sale = {};
				$.each($(row).find('.modified-input'), function (item, input) {
					sale[$(input).attr('name')] = $(input).val();
				});
				data.sales[$(row).attr('id')] = sale;
			});

			$this.button_modify_save.prop('disabled', true);
			$this.button_modify_cancel.prop('disabled', true);

			$.ajax({
				url: url,
				data: data,
				type: 'post',
				dataType: 'json',
				success: function () {
					$this.button_modify_save.addClass('hidden');
					$this.button_modify_cancel.addClass('hidden');
					$this.deSelectRows();

					$.each($this.table_data.find('tbody tr.modified-row'), function (index, row) {
						$.each($(row).find('.modified-input'), function (item, element) {
							$(element).data('value', $(element).val());
							$(element).removeClass('modified-input');
						});
						$(row).removeClass('modified-row');
					});
				},
				complete: function () {
					$this.button_modify_save.prop('disabled', false);
					$this.button_modify_cancel.prop('disabled', false);
				},
				error: function (response, error, responseText) {
					alert(responseText + '\n\n' + response.responseJSON.error);
				}
			});
		},

		cancelModify: function () {
			const $this = this;

			$.each($this.table_data.find('tbody tr.modified-row .modified-input'), function (index, input) {
				$(input).val($(input).data('value')).removeClass('modified-input');
			});

			$this.button_modify_save.addClass('hidden');
			$this.button_modify_cancel.addClass('hidden');
			$this.deSelectRows();
		},

		saveReorder: function () {
			const $this = this;
			const url = '/sales_management/reorder';
			let data = {
				_token: $('input[name="_token"]').val(),
				ids: []
			};

			$.each($this.table_data.find('tbody tr'), function (index, row) {
				data.ids.push($(row).attr('id'));
			});

			$this.button_reorder_save.prop('disabled', true);
			$this.button_reorder_cancel.prop('disabled', true);

			$.ajax({
				url: url,
				data: data,
				type: 'post',
				dataType: 'json',
				success: function () {
					$this.button_reorder_save.addClass('hidden');
					$this.button_reorder_cancel.addClass('hidden');
					$this.deSelectRows();
				},
				complete: function () {
					$this.button_reorder_save.prop('disabled', false);
					$this.button_reorder_cancel.prop('disabled', false);
				},
				error: function (response, error, responseText) {
					alert(responseText + '\n\n' + response.responseJSON.error);
				}
			});
		},

		cancelReorder: function () {
			const $this = this;
			const table_area = $('.sales-management .table-area');

			$this.button_reorder_save.prop('disabled', true);
			$this.button_reorder_cancel.prop('disabled', true);

			document.location.reload();
		},

		scrollHorizontal: function (scrollStep) {
			const table_area = $('.sales-management .table-area');
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

			let urlParts = document.location.href.split('?');
			document.location.replace(urlParts[0] + (getItems.length ? ('?' + getItems.join('&')) : '') );
		},

		addNewRow: function () {
			this.save_buttonbar.removeClass('hidden');
			this.table_new.find('thead').removeClass('hidden');

			const rowIndex = this.table_new.find('tbody tr.new-row').length;

			const tr = $('<tr>');
			tr.addClass('new-row');
			tr.append($('<td><input type="text" required="required" class="form-control input-sm" name="sales[' + rowIndex + '][company_name]" /></td>'));
			tr.append($('<td><input type="date" class="form-control input-sm" name="sales[' + rowIndex + '][callback_date]" max="2999-12-31" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][contact]" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][position]" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][phone]" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][email]" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][information]" /></td>'));
			tr.append($('<td><input type="date" class="form-control input-sm" name="sales[' + rowIndex + '][last_contact_date]" max="2999-12-31" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][web]" /></td>'));
			tr.append($('<td><input type="text" class="form-control input-sm" name="sales[' + rowIndex + '][monogram]" /></td>'));

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

	SalesManagement.init();
}