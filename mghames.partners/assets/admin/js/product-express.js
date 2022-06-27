(function($) {
    "use strict";
    $('.express_form').on('submit', function(e) {
        e.preventDefault();
        var required = false;
        if ($('.req').length > 0) {
            $('.req:checked').each(function() {
                if (this.checked == true) {
                    required = true;
                } else {
                    required = false;
                }
            });
            if (required == false) {
                $('.required_option').show();
            } else {
                $('.required_option').hide();
            }
        } else {
            required = true;
        }
        if (required == true) {
            var base_url = $('#base_url').val()
            var form_data = $(this).serialize();
            var url = base_url + "/express?" + form_data;
            $('.express_url').text(url);
            $('.exp_area').show()
        }
    });
})(jQuery);