if ($('#callback-applicants-table').length || $('#callback-sales-table').length) {
	const CallbackManagement = {
		table: null,
		button_scroll_left: null,
		button_scroll_right: null,
		scroll_step: 1000,

		init: function () {
			this.table = $( $('#callback-applicants-table').length ? 'callback-applicants-table' : '#callback-sales-table');
			this.button_scroll_left = $('.callback-management .foot-toolbar .btn-scroll-left');
			this.button_scroll_right = $('.callback-management .foot-toolbar .btn-scroll-right');
			this.eventHandlers();
		},

		eventHandlers: function () {
			const $this = this;

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

			$this.table.find('form.delete-sale').off('submit');
			$this.table.find('form.delete-sale').on('submit', function (e) {
				if (confirm('Biztos, hogy törölni akarja ezt a céget?')) {
					return true;
				}
				return false;
			});
		},

		selectRow: function (element) {
			this.deSelectRows();
			element.addClass('selectedRow');
		},

		deSelectRows: function () {
			this.table.find('.selectedRow').removeClass('selectedRow');
		},

		scrollHorizontal: function (scrollStep) {
			const table_area = $('.callback-management .table-area');
			let scrollLeft = table_area.scrollLeft() + scrollStep;
			table_area.animate({ scrollLeft: scrollLeft }, 800);
		},
	};

	CallbackManagement.init();
}