if ($('#search-table').length) {
	const SearchManagement = {
		table: null,
		button_scroll_left: null,
		button_scroll_right: null,
		scroll_step: 800,
		active_checkbox: null,

		init: function () {
			this.table = $('#search-table');
			this.button_scroll_left = $('.search-management .foot-toolbar .btn-scroll-left');
			this.button_scroll_right = $('.search-management .foot-toolbar .btn-scroll-right');
			this.active_checkbox = $('.search-management .active-applicants input[type="checkbox"]');
			this.reOrderTable();
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

			$this.active_checkbox.off('change');
			$this.active_checkbox.on('change', function (e) {
				if ($(this).prop('checked')) {
					$this.showOnlyActiveApplicants();
				} else {
					$this.showAllApplicants();
				}
			});
		},

		sendData: function (element) {
			const $this = this;
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

				for(let i = 1; i <= 7; i++) {
					tr.removeClass('status-' + i);
				}
				tr.addClass('status-' + tr.find('select[name="status"] option:selected').val());

				$this.loadApplicantCounters(data.job_position_id);

				$this.reOrderTable();
				$this.eventHandlers();
			});
		},

		scrollHorizontal: function (scrollStep) {
			const table_area = $('.search-management .table-area');
			let scrollLeft = table_area.scrollLeft() + scrollStep;
			table_area.animate({ scrollLeft: scrollLeft }, 800);
		},

		loadApplicantCounters: function (job_position_id) {
			const url = '/search_management/get_counters' + (job_position_id ? ('/' + job_position_id) : '');
			$.get(url, function (response) {
				const htmlStr = '<div class="counter"><span class="all">' + response.counters.all + '</span>/<span class="active">' + response.counters.active + '</span> <span class="ready">(' + response.counters.ready + ')</span>' + '</div>';
				$('.applicant-counter').html(htmlStr);
			});
		},

		showOnlyActiveApplicants: function () {
			const selectors = 'tr.status-2, tr.status-3, tr.status-7';
			this.table.find(selectors).hide();
		},

		showAllApplicants: function () {
			const selectors = 'tr';
			this.table.find(selectors).show();
		},

		reOrderTable: function () {
			const $this = this;

			$.each([1, 4, 5, 6, 7, 2, 3], function (index, status) {
				$this.table.find('tr.status-' + status).each(function () {
					$(this).remove();
					$this.table.find('tbody').append($(this));
				});
			});

			if ($this.active_checkbox.prop('checked') === true) {
				$this.showOnlyActiveApplicants();
			}
		}
	};

	SearchManagement.init();
}