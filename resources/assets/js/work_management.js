if ($('#work-table').length) {
	const WorkManagement = {
		table: null,
		button_scroll_left: null,
		button_scroll_right: null,
		scroll_step: 800,

		init: function () {
			this.table = $('#work-table');
			this.button_scroll_left = $('.work-management .foot-toolbar .btn-scroll-left');
			this.button_scroll_right = $('.work-management .foot-toolbar .btn-scroll-right');
			this.eventHandlers();
		},

		eventHandlers: function () {
			const $this = this;

			$this.table.find('.input-data').off('change');
			$this.table.find('.input-data').on('change', function (e) {
				e.preventDefault();
				const element = $(this);
				if (element.prop('type') == 'date') {
					return false;
				}

				$this.sendData(element);
			});

			$this.table.find('input.input-data[type=date]').off('blur');
			$this.table.find('input.input-data[type=date]').on('blur', function (e) {
				e.preventDefault();
				$this.sendData($(this));
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
		},

		sendData: function (element) {
			const tr = element.parents().closest('tr');
			const data = {
				applicant_id: tr.data('applicant'),
				job_position_id: tr.data('job'),
				salary: tr.find('input[name="salary"]').val(),
				work_begin_date: tr.find('input[name="work_begin_date"]').val(),
				follow_up: tr.find('textarea[name="follow_up"]').val(),
				monogram: tr.find('input[name="monogram"]').val(),
			};

			element.prop('disabled', true);

			$.post('/work_management/save_data', data, function () {
				element.prop('disabled', false);
			});
		},

		scrollHorizontal: function (scrollStep) {
			const table_area = $('.work-management .table-area');
			let scrollLeft = table_area.scrollLeft() + scrollStep;
			table_area.animate({ scrollLeft: scrollLeft }, 800);
		},
	};

	WorkManagement.init();
}