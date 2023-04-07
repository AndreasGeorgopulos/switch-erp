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
				if (element.prop('type') == 'date' || element.prop('type') == 'datetime-local') {
					return false;
				}

				$this.sendData(element);
			});

			$this.table.find('input.input-data[type=date]').off('blur');
			$this.table.find('input.input-data[type=date]').on('blur', function (e) {
				e.preventDefault();
				$this.sendData($(this));
			});

			$this.table.find('input.input-data[type=datetime-local]').off('blur');
			$this.table.find('input.input-data[type=datetime-local]').on('blur', function (e) {
				e.preventDefault();
				$this.sendData($(this));
			});
		},

		sendData: function (element) {
			const tr = element.parents().closest('tr');
			const data = {
				applicant_id: tr.data('applicant'),
				job_position_id: tr.data('job'),
				status: tr.find('select[name="status"] option:selected').val(),
				send_date: tr.find('input[name="send_date"]').val(),
				information: tr.find('textarea[name="information"]').val(),
				interview_time: tr.find('input[name="interview_time"]').val(),
				last_contact_date: tr.find('input[name="last_contact_date"]').val(),
			};

			element.prop('disabled', true);

			$.post('/search_management/save_data', data, function () {
				element.prop('disabled', false);
			});
		}
	};

	SearchManagement.init();
}