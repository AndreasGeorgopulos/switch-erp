$(function() {
    const JobPostion = {
        select_company_id: $('#job_position_form_company_id'),
        textarea_company_description: $('#job_position_form_company_description'),

        init: function () {
            this.eventHandlers();
        },

        eventHandlers: function () {
            const $this = this;

            $this.select_company_id.off('change');
            $this.select_company_id.on('change', function () {
                let selected_option = $(this).find('option:selected');
                $this.textarea_company_description.val('');
                if (selected_option !== undefined) {
                    $this.textarea_company_description.val(selected_option.data('description'));
                }
            });
        }
    };

    JobPostion.init();
});