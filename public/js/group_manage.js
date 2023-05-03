 
var id;
var currentRank;

$(() => {
    const meta = 'meta[name="group-info"]';
    id = parseInt($(meta).attr('data-id'));

    getMembers(1, 1);

    $('#membersTab .form-control').change(function() {
        getMembers($(this).val(), 1);
    });

    $('#payout').submit(function(event) {
        event.preventDefault();

        const username = $(this).find('input[name="username"]').val();
        const amount = $(this).find('input[name="amount"]').val();

        $.post('/api/groups/manage/payout', { _token, id, username, amount }).done((data) => {
            $('#payoutError').html('');

            if (typeof data.error !== 'undefined') {
                $('#payoutError').html(data.error);
            } else {
                $('#wallPostError').html('');
                $('#vaultAmount').html(data.vault);
                $(this).find('input[name="username"]').val('');
                $(this).find('input[name="amount"]').val('');
            }
        }).fail(() => $('#payoutError').html('Unable to payout member.'));
    });
});

function getMembers(rank, page)
{
    $.get('/api/groups/members', { id, rank, page }).done((data) => {
        $('#members').html('');
        currentRank = rank;

        var ranks = '';

        if (rank < 255) {
            ranks = $('#membersTab .form-control').html()
                .replace(`<option value="${rank}">`, `<option value="${rank}" selected>`)
                .replace('<option value="255">', '<option value="255" disabled>');

            ranks = `<select class="form-control mt-2" onchange="rankMember(userId, this.value)">${ranks}</select>`;
        }

        if (typeof data.error !== 'undefined')
            return $('#members').html(`<div class="col">${data.error}</div>`);

        $.each(data.members, function() {
            var kick = '';

            if (rank < 255)
                kick = `<i class="fas fa-times text-danger" style="font-size:20px;cursor:pointer;position:absolute;" onclick="kickMember(${this.id})"></i>`;

            $('#members').append(`
            <div class="col-6 col-md-3">
                <div class="card text-center" style="border:none;">
                    ${kick}
                    <a href="${this.url}">
                        <img src="${this.thumbnail}">
                        <div class="text-truncate mt-2">${this.username}</div>
                    </a>
                    ${ranks.replace('userId', this.id)}
                </div>
            </div>`);
        });

        if (data.total_pages > 1) {
            const previousDisabled = (data.current_page == 1) ? 'disabled' : '';
            const nextDisabled = (data.current_page == data.total_pages) ? 'disabled' : '';
            const previousPage = data.current_page - 1;
            const nextPage = data.current_page + 1;

            $('#members').append(`
            <div class="col-12 text-center">
                <button class="btn btn-sm btn-danger" onclick="getMembers(${rank}, ${previousPage})" ${previousDisabled}>&laquo;</button>
                <span class="text-muted ml-2 mr-2">${data.current_page} of ${data.total_pages}</span>
                <button class="btn btn-sm btn-success" onclick="getMembers(${rank}, ${nextPage})" ${nextDisabled}>&raquo;</button>
            </div>`);
        }
    }).fail(() => $('#members').html('<div class="col">Unable to get members.</div>'));
}

function kickMember(userId)
{
    $.post('/api/groups/manage/kick-member', { _token, id, userId }).done((data) => getMembers(currentRank, 1));
}

function rankMember(userId, rank)
{
    $.post('/api/groups/manage/rank-member', { _token, id, userId, rank }).done((data) => getMembers(currentRank, 1));
}
