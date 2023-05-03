 
var lastAvatar;
var defaultAvatar;
var lastUsername;
var delay;

$(() => {
    lastAvatar = $('#headshot').attr('src');
    defaultAvatar = lastAvatar;

    $('input[name="username"]').keyup(function(event) {
        var username = $(this).val();

        if (username == lastUsername)
            return;

        lastUsername = username;

        clearTimeout(delay);

        delay = setTimeout(() => {
            $.get('/api/users/info', { username }).done(function(data) {
                var headshot = defaultAvatar;

                if (typeof data.error === 'undefined')
                    headshot = data.images.headshot;

                lastAvatar = headshot;

                $('#headshot').addClass('bounce-in').attr('src', headshot);
            });
        }, 500);

        $('#headshot').removeClass('bounce-in');
    });
});
