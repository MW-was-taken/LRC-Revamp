 
$(() => {
    const onsaleUntil = $('meta[name="item-info"]').attr('data-onsale-until');
    const endTimestamp = moment.tz(onsaleUntil, 'UTC').toDate();

    $('#timer').countdown(endTimestamp, function(event) {
        var string;

        if (event.offset.totalSeconds == 0) {
            $(this).remove();
            $('[data-target="#purchaseConfirmation"]').attr('disabled', true);
        }

        if (event.offset.totalSeconds > 86400)
            string = '%-D day%!D, %-H hour%!H, %-M minute%!M, %-S second%!S:s;';
        else if (event.offset.totalSeconds > 3600)
            string = '%-H hour%!H, %-M minute%!M, %-S second%!S:s;';
        else if (event.offset.totalSeconds > 60)
            string = '%-M minute%!M, %-S second%!S:s;';
        else
            string = '%-S second%!S:s;';

        $(this).text(event.strftime(string));
    });
});
