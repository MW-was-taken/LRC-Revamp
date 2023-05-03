 
$(() => {
    $('input[name="template"]').on('change', function() {
        if (this.files.length == 0)
            return;

        var fd = new FormData;
        fd.append('_token', _token);
        fd.append('type', $('select[name="type"]').val());
        fd.append('file', $(this)[0].files[0]);

        $.ajax({
            url: '/api/creator-area/render-preview',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false
        }).done(function(data) {
            $('#error').html('').hide();

            if (typeof data.error !== 'undefined')
                $('#error').html(data.error).show();

            $('#preview').attr('src', data.thumbnail);
        });
    });
});
