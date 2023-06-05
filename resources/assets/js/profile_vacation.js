$(function() {
	const vacationArea = $('#vacation-area');

	if (vacationArea.length) {
		const VacationManager = {
			vacationArea: vacationArea,
			formArea: vacationArea.find('.form-area'),
			tableArea: vacationArea.find('.table-area'),
			alertWindow: vacationArea.find('.alert.alert-warning'),
			userId: vacationArea.data('user-id'),
			loadUrl: vacationArea.data('load-url'),
			saveUrl: vacationArea.data('save-url'),
			deleteUrl: vacationArea.data('delete-url'),
			daysPerYear: vacationArea.data('vacation_days_per_year'),
			freeDays: vacationArea.data('free_vacation_days'),
			usedDays: vacationArea.data('used_vacation_days'),

			init: function() {
				this.loadList();
				this.eventHandlers();
			},

			eventHandlers: function() {
				const $this = this;

				$this.vacationArea.off('click', '.btn-new');
				$this.vacationArea.on('click', '.btn-new', function(e) {
					e.preventDefault();
					$this.formArea.removeClass('hidden');
				});

				$this.vacationArea.off('click', '.btn-form-cancel');
				$this.vacationArea.on('click', '.btn-form-cancel', function(e) {
					e.preventDefault();
					$this.resetForm();
				});

				$this.vacationArea.off('click', '.btn-form-save');
				$this.vacationArea.on('click', '.btn-form-save', function(e) {
					e.preventDefault();
					$this.save();
				});

				$this.vacationArea.off('click', '.btn-edit');
				$this.vacationArea.on('click', '.btn-edit', function(e) {
					e.preventDefault();
					$this.edit($(this));
				});

				$this.vacationArea.off('click', '.btn-delete');
				$this.vacationArea.on('click', '.btn-delete', function(e) {
					e.preventDefault();
					if (confirm('Biztos, hogy törölni akarja ezt a szabadság kérelmet?')) {
						$this.delete($(this));
					}
				});
			},

			edit: function (button) {
				const $this = this;
				const tr = button.closest('tr');

				$this.formArea.find('input[name="id"]').val(button.data('id'));
				$this.formArea.find('input[name="begin_date"]').val(tr.find('td').eq(1).html());
				$this.formArea.find('input[name="end_date"]').val(tr.find('td').eq(2).html());
				$this.formArea.find('textarea[name="notice"]').val(tr.find('td').eq(4).html());

				$this.formArea.removeClass('hidden');
			},

			save: function() {
				const $this = this;
				$this.formArea.find('.btn-form-save').prop('disabled', true);
				$this.formArea.find('.btn-form-cancel').prop('disabled', true);

				const token = $('input[name="_token"]').val();
				const id = $this.formArea.find('input[name="id"]').val();
				const beginDate = $this.formArea.find('input[name="begin_date"]').val();
				const endDate = $this.formArea.find('input[name="end_date"]').val();
				const notice = $this.formArea.find('textarea[name="notice"]').val();

				const data = {
					_token: token,
					id: id,
					begin_date: beginDate,
					end_date: endDate,
					notice: notice
				};

				$.ajax({
					url: $this.saveUrl,
					data: data,
					type: 'post',
					dataType: 'json',
					success: function(response) {
						if (!response.success && response.errors !== undefined) {
							$this.formArea.find('.btn-form-save').prop('disabled', false);
							$this.formArea.find('.btn-form-cancel').prop('disabled', false);

							const ul = $('<ul>');
							$.each(response.errors, function (key, item) {
								const li = $('<li>').html(item[0]);
								ul.append(li);
							});
							$this.alertWindow.find('p.errors').html(ul);
							$this.alertWindow.removeClass('hidden');
						} else {
							$this.daysPerYear = response.days_per_year;
							$this.freeDays = response.free_days;
							$this.usedDays = response.used_days;
							$this.loadList();
							$this.resetForm();
						}
					},
					error: function() {
						alert('Hiba történt a mentés során.');
					},
					complete: function() {
						$this.formArea.find('.btn-form-save').prop('disabled', false);
						$this.formArea.find('.btn-form-cancel').prop('disabled', false);
					}
				});
			},

			delete: function(button) {
				const $this = this;
				const token = $('input[name="_token"]').val();
				const id = button.data('id');

				$.ajax({
					url: $this.deleteUrl,
					data: { _token: token, id: id },
					type: 'post',
					dataType: 'json',
					success: function(response) {
						$this.daysPerYear = response.days_per_year;
						$this.freeDays = response.free_days;
						$this.usedDays = response.used_days;
						$this.loadList();
						$this.resetForm();
					}
				});
			},

			resetForm: function() {
				const $this = this;
				$this.formArea.addClass('hidden');
				$this.formArea.find('input').val(null);
				$this.formArea.find('textarea').val(null);
				$this.formArea.find('.btn-form-save').prop('disabled', false);
				$this.formArea.find('.btn-form-cancel').prop('disabled', false);

				$this.alertWindow.find('p.errors').html('');
				$this.alertWindow.addClass('hidden');

				if ($this.freeDays <= 0) {
					$this.vacationArea.find('.btn-new').hide();
				} else {
					$this.vacationArea.find('.btn-new').show();
				}
			},

			loadList: function() {
				const $this = this;
				$this.tableArea.html('<div class="text-center">Lista betöltése folyamatban...</div>');

				$.ajax({
					url: $this.loadUrl,
					type: 'get',
					dataType: 'html',
					success: function(html) {
						$this.tableArea.html(html);
					},
					error: function() {
						$this.tableArea.html('Lista betöltése sikertelen...');
					},
					complete: function() {
						$this.eventHandlers();
					}
				});
			}
		};

		VacationManager.init();
	}
});