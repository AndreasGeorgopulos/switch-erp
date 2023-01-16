if ($('#applicant-note-area').length) {
	const ApplicantManagementNotes = {
		applicant_id: null,
		area_add_btn: null,
		add_btn: null,
		area_form: null,
		area_list: null,

		init: function () {
			this.applicant_id = $('#applicant-note-area input.applicant-id').val();
			this.area_add_btn = $('#applicant-note-area .area-add-btn');
			this.area_form = $('#applicant-note-area .area-form');
			this.area_list = $('#applicant-note-area .area-list');

			this.area_form.addClass('hidden');
			this.loadList();
		},

		setEventHandlers: function () {
			const $this = this;

			this.area_add_btn.find('button.add-btn').off('click');
			this.area_add_btn.find('button.add-btn').on('click', function () {
				$this.openForm();
			});

			this.area_form.find('button.ok-btn').off('click');
			this.area_form.find('button.ok-btn').on('click', function (e) {
				e.preventDefault();
				$this.submitForm();
			});

			this.area_form.find('button.cancel-btn').off('click');
			this.area_form.find('button.cancel-btn').on('click', function (e) {
				e.preventDefault();
				$this.closeForm();
			});
		},

		openForm: function () {
			this.area_add_btn.addClass('hidden');
			this.area_form.removeClass('hidden');
		},

		closeForm: function () {
			this.area_add_btn.removeClass('hidden');
			this.area_form.addClass('hidden');
		},

		submitForm: function () {
			const $this = this;
			$this.closeForm();
		},

		loadList: function () {
			const $this = this;
			$this.area_list.html('<span class="text-center">Jegyzetek betöltése...</span>');
			$.ajax({
				url: '/applicant_management/get-notes/' + $this.applicant_id,
				type: 'get',
				dataType: 'html',
				success: function (html) {
					$this.area_list.html(html);
					$this.setEventHandlers();
					alert($this.applicant_id);
				}
			});
		}
	};

	ApplicantManagementNotes.init();
}