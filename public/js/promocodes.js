 
var routes = {};

$(() => {
    const meta = 'meta[name="routes"]';
    routes.redeem = $(meta).attr('data-redeem');

    $('#codeForm').submit(function(event) {
        event.preventDefault();

        const code = $(this).find('[name="code"]').val();

        $.post(routes.redeem, { _token, code }).done(function(data) {
            $('#message').removeClass('text-danger').removeClass('text-success');

            if (typeof data.error !== 'undefined')
                return $('#message').addClass('text-danger').html(data.error);

            $('#message').addClass('text-success').html(data.message);
        });
    });
});
