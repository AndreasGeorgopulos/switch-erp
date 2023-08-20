(function () {
	const tableFilter = {
		table: null,
		filter_row: null,
		filter_open_button: null,
		filter_close_button: null,

		init: function(table_id) {
			this.table = $(table_id);
			this.filter_row = this.table.find('tr.filter-row');
			this.filter_open_button = this.table.find('button.btn-table-filter-open');
			this.filter_close_button = this.table.find('button.btn-table-filter-close');
			this.eventHandler();
		},

		eventHandler: function () {
			const $this = this;

			$this.filter_open_button.off('click');
			$this.filter_open_button.on('click', function () {
				$this.filterRowOpen();
			});

			$this.filter_close_button.off('click');
			$this.filter_close_button.on('click', function () {
				$this.filterRowClose();
			});
		},

		filterRowOpen: function () {
			this.filter_row.removeClass('hidden');
			this.filter_open_button.addClass('hidden');
			this.filter_close_button.removeClass('hidden');
		},

		filterRowClose: function () {
			this.filter_row.addClass('hidden');
			this.filter_open_button.removeClass('hidden');
			this.filter_close_button.addClass('hidden');
		}
	};

	$(document).ready(function () {
		$.each(['#data-applicant-table', '#data-sales-table', '#contract-table'], function (index, table_id) {
			if (!$(table_id).length) {
				return;
			}
			tableFilter.init(table_id);
		});
	});
})();