const ListTable = function (table_id) {
	var currentPage = 1;
	var sort = 'id';
	var direction = 'asc';

	this.load = function () {
		var $this = this;
		$.ajax({
			url: document.location.href + '?page=' + currentPage,
			data: {
				length: $(table_id + ' select[name="length"]').find('option:selected').val(),
				sort: sort,
				direction: direction,
				searchtext: $(table_id + ' input[name="searchtext"]').val(),
				_token: $('input[name="_token"]').val()
			},
			dataType: 'html',
			type: 'post',
			success: function (response) {
				if (response == '' && currentPage > 1) {
					currentPage = 1;
					$this.load();
				} else {
					$('#listTable').html(response);

					$(table_id + ' select[name="length"]').off('change');
					$(table_id + ' select[name="length"]').on('change', function () {
						$this.load();
					});

					$(table_id + ' .paginate_button').off('click');
					$(table_id + ' li.paginate_button a').on('click', function () {
						if (!$(this).parent().hasClass('disabled')) {
							currentPage = $(this).attr('data-page');
							$this.load();
						}
						return false;
					});

					$(table_id + ' table th').off('click');
					$(table_id + ' table th').on('click', function () {
						sort = $(this).attr('data-column');
						direction = $(this).hasClass('sorting_desc') ? 'asc' : 'desc';
						$this.load();
					});

					$(table_id + ' input[name="searchtext"]').off('keyup');
					$(table_id + ' input[name="searchtext"]').on('keyup', function (event) {
						if (event.keyCode == 13 || $(table_id + ' input[name="searchtext"]').val() == '') {
							$this.load();
						}
					});

					$(table_id + ' button[name="searchtext"]').off('click');
					$(table_id + ' button[name="searchtext"]').on('click', function () {
						$this.load();
					});

					$(table_id + ' a.confirm').on('click', function () {
						var href = $(this).attr('href');
						$('#confirm_modal').modal();
						$('#confirm_modal .yes_btn').off('click');
						$('#confirm_modal .yes_btn').on('click', function () {
							document.location.replace(href);
						});
						return false;
					});
				}
			},
			errors: function (response) {
				console(JSON.stringify(response));
			}
		});
	};
};

$(document).ready(function () {
	if ($('#listTable').length) {
		new ListTable('#listTable').load();
	}
});