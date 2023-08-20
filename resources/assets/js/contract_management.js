if ($('#contract-table').length) {
	const ContractManagement = {
		table: null,
		save_buttonbar: null,
		button_add: null,
		button_cancel: null,

		init: function () {
			this.table = $('#contract-table');
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

			$this.table.find('thead select.search-input').off('change');
			$this.table.find('thead select.search-input').on('change', function (e) {
				e.preventDefault();
				$this.filterRows();
			});

			$this.table.find('thead input.search-input[type=date]').off('change');
			$this.table.find('thead input.search-input[type=date]').on('change', function (e) {
				e.preventDefault();
				$this.filterRows();
			});
		},

		addNewRow: function () {
			this.save_buttonbar.removeClass('hidden');

			const rowIndex = this.table.find('tbody tr.new-row').length;

			const tr = $('<tr>');
			tr.addClass('new-row');
			tr.append($('<td><input type="text" required="required" class="form-control input-sm" name="contract[' + rowIndex + '][name]" /></td>'))
			tr.append($('<td colspan="3"></td>'))

			this.table.find('tbody').append(tr);
		},

		cancelRows: function () {
			this.table.find('tbody tr.new-row').remove();
			this.save_buttonbar.addClass('hidden');
		},

		filterRows: function () {
			const $this = this;
			let getItems = [];
			$.each($this.table.find('thead .search-input'), function (index, item) {
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
	};

	ContractManagement.init();
}