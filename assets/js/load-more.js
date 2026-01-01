jQuery(document).ready(function ($) {
    $('.hipsy-load-more').on('click', function (e) {
        e.preventDefault();

        var button = $(this);
        var offset = button.data('offset');
        var limit = button.data('limit');
        var container = $('.hipsy-events-widget');

        button.text('Loading...');

        $.ajax({
            url: hipsy_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'hipsy_load_more',
                offset: offset,
                limit: limit,
                nonce: hipsy_ajax.nonce
            },
            success: function (response) {
                if (response.trim() !== '') {
                    container.append(response);
                    button.data('offset', offset + limit);
                    button.text('Load more');
                } else {
                    button.hide();
                }
            },
            error: function () {
                alert('Error loading events.');
                button.text('Load more');
            }
        });
    });
});
