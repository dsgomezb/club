KT.create('#datatable', {
    resource: 'users',
    columns: [
        'image|image',
        'username|limit',
        'email|limit',
        {
            column: 'is_banned',
            filter: 'label',
            setting: {
                states: {
                    0:{label:'success', value:'Activo'},
                    1:{label:'danger', value:'Baneado'},
                }
            }
        },
        {
            column: 'id',
            filter: 'actions',
            setting: {
                extraButtons: [
                    {
                        'title': 'Bloquear',
                        'class': 'secondary',
                        'href': '/admin/users/ban',
                        'icon': 'fa-ban',
                        'showIf': function (row) {
                            return !row.is_banned;
                        },
                        'data-id': '${row.id}'
                    },
                    {
                        'title': 'Desbloquear',
                        'class': 'success',
                        'href': '/admin/users/unban',
                        'icon': 'fa-check-circle',
                        'showIf': function (row) {
                            return row.is_banned;
                        },
                        'data-id': '${row.id}'
                    },
                ],
                edit: false
            }
        },
    ]
});

//ban
$("#datatable").on('click', 'a[href="/admin/users/ban"]', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var dialog = bootbox.confirm({
        title: "Bloquear usuario",
        message: $('#modal-ban').html().replace('${id}', id),
        buttons: {
            confirm: {
                label: 'Bloquear',
                className: 'btn-danger'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if(result) {
                dialog.find('.bootbox-body').html('<p><i class="fal fa-spin fa-spinner"></i> Aguarde...</p>');
                $('#modal-ban-form').attr('action', '/admin/users/' + id + '/ban');
                $('#modal-ban-form').submit();
                return false;
            }
        }
    });
});

//unban
$("#datatable").on('click', 'a[href="/admin/users/unban"]', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var dialog = bootbox.confirm({
        title: "Desbloquear usuario",
        message: '¿Está seguro que desea desbloquear a este usuario?',
        buttons: {
            confirm: {
                label: 'Desbloquear',
                className: 'btn-success'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if(result) {
                dialog.find('.bootbox-body').html('<p><i class="fal fa-spin fa-spinner"></i> Aguarde...</p>');
                $('#unband-form').attr('action', '/admin/users/' + id + '/unban');
                $('#unband-form').submit();
                return false;
            }
        }
    });
});


//message
$('body').on('change', 'input[name="send-message"]', function () {
    var $form = $(this).parents('#modal-ban-form');

    if($(this).val() == 1) {
        $('#message-section', $form).removeClass('d-none');
    } else {
        $('#message-section', $form).addClass('d-none');
    }
})