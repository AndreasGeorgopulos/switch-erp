<script>
	const VacationEvent = {
		info: null,
		modal: document.getElementById('vacationModal'),
		vacation_approve_btn: document.getElementById('vacation_approve_btn'),
		vacation_reject_btn: document.getElementById('vacation_reject_btn'),
		vacation_delete_btn: document.getElementById('vacation_delete_btn'),
		vacation_modal_close_btn: document.getElementById('vacation_modal_close_btn'),

		openModal: function (info) {
			const titleElement = this.modal.querySelector('h4.modal-title');
			const noticeElement = this.modal.querySelector('p.notice');

			this.info = info;
			this.modal.style.display = 'block';

			if (titleElement !== null) {
				titleElement.textContent = this.info.event.title;
			}

			if (noticeElement !== null) {
				noticeElement.textContent = this.info.event.extendedProps.notice;
			}

			this.vacation_approve_btn.disabled = this.info.event.extendedProps.is_approvable == 1 ? false : true;
			this.vacation_reject_btn.disabled = this.info.event.extendedProps.is_rejectable == 1 ? false : true;
			this.vacation_delete_btn.disabled = this.info.event.extendedProps.is_deletable == 1 ? false : true;
		},

		closeModal: function () {
			this.info = null;
			this.modal.style.display = 'none';
		},

		approve: function () {
			alert('approve');
		},

		reject: function () {
			alert('reject');
		},

		delete: function () {
			alert('delete');
		},

		eventHandlers: function () {
			const $this = this;

			$this.vacation_approve_btn.addEventListener('click', function() {
				$this.approve();
			});

			$this.vacation_reject_btn.addEventListener('click', function() {
				$this.reject();
			});

			$this.vacation_delete_btn.addEventListener('click', function() {
				$this.delete();
			});

			$this.vacation_modal_close_btn.addEventListener('click', function() {
				$this.closeModal();
			});
		}
	};

	VacationEvent.eventHandlers();

	document.addEventListener('DOMContentLoaded', function() {
		const calendarEl = document.getElementById('calendar');
		const calendar = new Calendar(calendarEl, {
			plugins: [
				dayGridPlugin,
			],
			headerToolbar: {
				center: "title",
				right: "prev,today,next",
			},
			locale: huLocale,
			initialView: 'dayGridMonth',
			contentHeight: 'auto',
			weekends: true,
			events: [
					@foreach($events as $e)
				{
					id : '{{$e['id']}}',
					title : '{{$e['title']}}',
					start : '{{$e['start']}}',
					end : '{{$e['end']}}',
					classNames: '{{$e['classNames']}}',
					extendedProps: {
						notice : '{{$e['notice']}}',
						is_deletable: {{$e['is_deletable']}},
						is_approvable: {{$e['is_approvable']}},
						is_rejectable: {{$e['is_rejectable']}},
					}
				},
				@endforeach
			],
		});

		calendar.on('eventClick', function(info) {
			if (info.event.id.indexOf('vacation-') > -1) {
				VacationEvent.openModal(info);
			}

			// Itt tudod végrehajtani a szükséges tevékenységeket az eseményre kattintva

			// Példa: az esemény adatainak kiírása a konzolon
			/*console.log(info.event.vacation_id);
			console.log(info.event.title);
			console.log(info.event.description);
			console.log(info.event.start);
			console.log(info.event.end);*/
		});

		//const eventOptions = document.getElementById('eventOptions');


		calendar.render();
	});

	/*document.addEventListener('click', function(event) {
		if (event.target === vacationModal) {
			vacationModal.style.display = 'none'; // Modal elrejtése
		}
	});*/
</script>