if ($('#search-table').length) {
	const SearchManagement = {
		table: null,

		init: function () {
			this.table = $('#search-table');
			this.eventHandlers();
		},

		eventHandlers: function () {
			const $this = this;

			$this.table.find('.input-data').off('change');
			$this.table.find('.input-data').on('change', function (e) {
				e.preventDefault();
				const element = $(this);
				const tr = $(this).parents().closest('tr');
				const data = {
					applicant_id: tr.data('applicant'),
					job_position_id: tr.data('job'),
					status: tr.find('select[name="status"] option:selected').val(),
					send_date: tr.find('input[name="send_date"]').val(),
				};

				element.prop('disabled', true);

				$.post('/search_management/save_data', data, function () {
					element.prop('disabled', false);
				});
			});
		}
	};

	SearchManagement.init();
}