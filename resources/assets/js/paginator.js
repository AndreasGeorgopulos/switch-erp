const paginatorArea = $('.paginator');

if (paginatorArea.length) {
    const Paginator = {
        select_lengths: null,
        select_pages: null,

        init: function () {
            this.select_lengths = $('.paginator .items_per_page select.select_lengths');
            this.select_pages = $('.paginator .pages select.select_pages');
            this.makeEventHandlers();
        },

        changeLength: function (url) {
            document.location.href = url;
        },

        changePage: function (url) {
            document.location.href = url;
        },

        makeEventHandlers: function () {
            const $this = this;

            $this.select_lengths.off();
            $this.select_lengths.on('change', function (e) {
                $this.changeLength($(this).val());
            });

            $this.select_pages.off();
            $this.select_pages.on('change', function (e) {
                $this.changePage($(this).val());
            });
        }
    };

    Paginator.init();
}