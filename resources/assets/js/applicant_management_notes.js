if ($('#applicant-note-area').length) {
	const ApplicantManagementNotes = {
		applicant_id: null,
		area_add_btn: null,
		add_btn: null,
		area_form: null,
		area_list: null,
		select_company: null,
		select_job_positions: null,

		init: function () {
			this.applicant_id = $('#applicant-note-area input.applicant-id').val();
			this.area_add_btn = $('#applicant-note-area .area-add-btn');
			this.area_form = $('#applicant-note-area .area-form');
			this.area_list = $('#applicant-note-area .area-list');
			this.select_company = $('#applicant-note-area select.select-company');
			this.select_job_positions = $('#applicant-note-area select.select-job-position');

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

			this.select_company.on('change', function (e) {
				$this.loadSelectOptions($(this).val());
			});

			this.area_list.find('button.btn-delete-note').off('click');
			this.area_list.find('button.btn-delete-note').on('click', function (e) {
				e.preventDefault();
				if (confirm('Biztos, hogy törölni akarja ezt a bejegyzést?')) {
					$this.deleteNote($(this).data('href'));
				}
			});
		},

		openForm: function () {
			this.select_company.val(0).trigger('change');
			this.area_form.find('textarea[name="description"]').val('');
			this.area_add_btn.addClass('hidden');
			this.area_form.removeClass('hidden');
		},

		closeForm: function () {
			this.area_add_btn.removeClass('hidden');
			this.area_form.addClass('hidden');
		},

		submitForm: function () {
			const $this = this;
			const form = $this.area_form.find('form');
			let company_id, job_position_id, description;

			company_id = $this.select_company.find('option:selected').val();
			if (company_id == 0) {
				alert('Cég kiválasztása kötelező');
				return;
			}

			job_position_id = $this.select_job_positions.find('option:selected').val();
			if (job_position_id == 0) {
				alert('Pozíció kiválasztása kötelező');
				return;
			}

			description = $this.area_form.find('textarea[name="description"]').val();
			if (description == '') {
				alert('Jegyzet megadása kötelező');
				return;
			}

			const data = {
				_token: $this.area_form.find('input[name="_token"]').val(),
				applicant_id: $this.applicant_id,
				company_id: company_id,
				job_position_id: job_position_id,
				description: description,
			};

			$.ajax({
				url: '/applicant_management/add-note',
				type: 'post',
				dataType: 'json',
				data: data,
				success: function (response) {
					$this.loadList();
				},
				complete: function () {
					$this.closeForm();
				}
			});
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
				}
			});
		},

		loadSelectOptions: function (company_id) {
			const $this = this;

			if (company_id == 0) {
				$this.select_job_positions.html('<option value="0"></option>');
				return;
			}

			$this.select_company.prop('disabled', true);
			$this.select_job_positions.prop('disabled', true);

			$this.select_job_positions.html('<option>Betöltés...</option>');
			$.ajax({
				url: '/applicant_management/get-job-position-options/' + company_id,
				type: 'get',
				dataType: 'json',
				success: function (response) {
					$this.select_job_positions.html('<option value="0"></option>');
					$.each(response, function (index, item) {
						$this.select_job_positions.append('<option value="' + item.value + '">' + item.title + '</option>');
					});

					$this.select_company.prop('disabled', false);
					$this.select_job_positions.prop('disabled', false);
				}
			});
		},

		deleteNote: function (url) {
			const $this = this;

			$.ajax({
				url: url,
				type: 'get',
				success: function () {
					$this.loadList();
				}
			});
		}
	};

	ApplicantManagementNotes.init();
}