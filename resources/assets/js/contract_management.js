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
	};

	ContractManagement.init();
}