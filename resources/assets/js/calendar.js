const calendarArea = $('#calendar');

if (calendarArea.length) {
	const refreshCalendarEvents = function (calendar) {
		calendar.removeAllEvents();
		$.ajax({
			url: calendarArea.data('load-url'),
			type: 'get',
			success: function (response) {
				$.each(response.events, function (index, item) {
					calendar.addEvent(item);
				});
			}
		});
	};

	const VacationEvent = {
		id: null,
		calendar: null,
		info: null,
		modal: $('#vacationModal'),
		vacation_approve_btn: $('#vacation_approve_btn'),
		vacation_reject_btn: $('#vacation_reject_btn'),
		vacation_delete_btn: $('#vacation_delete_btn'),
		vacation_modal_close_btn: $('#vacation_modal_close_btn'),
		approve_url: $('#vacationModal').data('approve-url'),
		reject_url: $('#vacationModal').data('reject-url'),
		delete_url: $('#vacationModal').data('delete-url'),

		init: function (calendar) {
			this.calendar = calendar;
			this.eventHandlers();
		},

		openModal: function (info) {
			const titleElement = this.modal.find('h4.modal-title');
			const noticeElement = this.modal.find('p.notice');

			this.id = info.event.id.replace('vacation-', '');
			this.modal.show();

			if (titleElement !== null) {
				titleElement.html(info.event.title);
			}

			if (noticeElement !== null) {
				noticeElement.html(info.event.extendedProps.notice);
			}

			if (info.event.extendedProps.is_approvable == 1) {
				this.vacation_approve_btn.show();
			} else {
				this.vacation_approve_btn.hide();
			}

			if (info.event.extendedProps.is_rejectable == 1) {
				this.vacation_reject_btn.show();
			} else {
				this.vacation_reject_btn.hide();
			}

			if (info.event.extendedProps.is_deletable == 1) {
				this.vacation_delete_btn.show();
			} else {
				this.vacation_delete_btn.hide();
			}
		},

		closeModal: function () {
			this.modal.hide();
		},

		approve: function () {
			const $this = this;
			if (confirm('Biztos, hogy elfogadja a szabadság kérelmet?')) {
				$.ajax({
					url: $this.approve_url,
					type: 'post',
					data: {
						_token: $('input[name="_token"]').val(),
						id: $this.id,
					},
					success: function (response) {
						refreshCalendarEvents($this.calendar);
						$this.closeModal();
					}
				});
			}
		},

		reject: function () {
			const $this = this;
			if (confirm('Biztos, hogy elutasítja a szabadság kérelmet?')) {
				$.ajax({
					url: $this.reject_url,
					type: 'post',
					data: {
						_token: $('input[name="_token"]').val(),
						id: $this.id,
					},
					success: function (response) {
						refreshCalendarEvents($this.calendar);
						$this.closeModal();
					}
				});
			}
		},

		delete: function () {
			const $this = this;
			if (confirm('Biztos, hogy törli a szabadság kérelmet?')) {
				$.ajax({
					url: $this.delete_url,
					type: 'post',
					data: {
						_token: $('input[name="_token"]').val(),
						id: $this.id,
					},
					success: function (response) {
						refreshCalendarEvents($this.calendar);
						$this.closeModal();
					}
				});
			}
		},

		eventHandlers: function () {
			const $this = this;

			$this.vacation_approve_btn.off();
			$this.vacation_approve_btn.on('click', function () {
				$this.approve();
			});

			$this.vacation_reject_btn.off();
			$this.vacation_reject_btn.on('click', function () {
				$this.reject();
			});

			$this.vacation_delete_btn.off();
			$this.vacation_delete_btn.on('click', function () {
				$this.delete();
			});

			$this.vacation_modal_close_btn.off();
			$this.vacation_modal_close_btn.on('click', function () {
				$this.closeModal();
			});
		}
	};

	document.addEventListener('DOMContentLoaded', function() {
		const calendarEl = document.getElementById('calendar');
		const calendar = new Calendar(calendarEl, {
			plugins: [
				dayGridPlugin,
			],
			headerToolbar: {
				left: '',
				center: 'title',
				right: 'prev,today,next',
			},
			locale: huLocale,
			initialView: 'dayGridMonth',
			contentHeight: 'auto',
			weekends: true,
			events: [],
		});

		calendar.on('eventClick', function(info) {
			if (info.event.id.indexOf('vacation-') > -1) {
				VacationEvent.openModal(info);
			}
		});

		VacationEvent.init(calendar);
		refreshCalendarEvents(calendar);

		calendar.render();
	});
}