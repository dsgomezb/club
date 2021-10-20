KT.create('#datatable', {
    resource: 'admissions',
    columns: [
        'image|image',
        'username|limit',
        'email|limit',
        {
            column: 'id',
            filter: 'actions',
            setting: {
                extraButtons: [
                    {
                        'title': 'Admitir',
                        'class': 'success',
                        'href': 'approve',
                        'icon': 'fa-check-circle',
                        'data-id': '${row.id}'
                    },
                    {
                        'title': 'Rechazar',
                        'class': 'danger',
                        'href': 'disapprove',
                        'icon': 'fa-ban',
                        'data-id': '${row.id}'
                    },
                ],
                delete: false,
                edit: false
            }
        },
    ]
});

var map = {
    approve: {
        title: 'Admitir usuario',
        message: '¿Está seguro que desea admitir a este usuairo?',
        btn: {
            label: 'Admitir',
            className: 'btn-success'
        },
        action: 'approve'
    },
    disapprove: {
        title: 'Rechazar usuario',
        message: '¿Está seguro que desea rechazar a este usuairo?',
        btn: {
            label: 'Rechazar',
            className: 'btn-danger'
        },
        action: 'disapprove'
    }
}

//action
$("#datatable").on('click', 'a[href="approve"], a[href="disapprove"]', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var config = map[$(this).attr('href')];

    var dialog = bootbox.confirm({
        title: config.title,
        message: config.message,
        buttons: {
            confirm: {
                label: config.btn.label,
                className: config.btn.className,
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if(result) {
                dialog.find('.bootbox-body').html('<p><i class="fal fa-spin fa-spinner"></i> Aguarde...</p>');
                $('#form').attr('action', '/admin/admissions/' + id + '/' + config.action);
                $('#form').submit();
                return false;
            }
        }
    });
});