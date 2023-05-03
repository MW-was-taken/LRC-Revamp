 
$(() => {
    var searchDelay;

    $('#navbarSearch').keyup(function() {
        const search = $(this).val();

        if (search.length == 0) {
            $('#navbarSearchResults').hide();
            $('#navbarSearchResults').html('');
            return;
        }

        clearTimeout(searchDelay);

        searchDelay = setTimeout(() => {
            $.get('/api/search/all', { search }).done(function(data) {
                $('#navbarSearchResults').html('');
                $('#navbarSearchResults').show();

                if (typeof data.error !== 'undefined' && data.error)
                    return $('#navbarSearchResults').html(`<div class="navbar-search-error">${data.error}</div>`);

                $.each(data, function() {
                    $('#navbarSearchResults').append(`
                    <div class="navbar-search-result">
                        <a href="${this.url}">
                            <div class="row">
                                <div class="col-1">
                                    <img src="${this.image}">
                                </div>
                                <div class="col-10 align-self-center" style="font-size:18px;">${this.name}</div>
                                <div class="col-1 align-self-center text-right"><i class="fas fa-arrow-right mr-2"></i></div>
                            </div>
                        </a>
                    </div>`);
                });
            }).fail(() => $('#navbarSearchResults').html('<div class="navbar-search-error">No results found.</div>'));
        }, 500);
    });
});
