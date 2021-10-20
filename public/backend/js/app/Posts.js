$(document).ready(function () {
    KT.create('#datatable', {
        resource: 'posts',
        columns: [
            'images[0].src|image',
            {
                column: 'author.firstname',
                filter: 'callback',
                setting: {
                    callback: function (row, prop, parameters) {
                        return eval('row.author.firstname') + ' ' + eval('row.author.lastname')
                    }
                }
            },
            'published_at|moment:DD-MM-YYYY',
            'title|limit',
            'category.value',
            {
                column: 'is_visible',
                filter: 'stateSwitcher',
                setting: {
                    states: {
                        0:{label:'danger', value:'Oculto'},
                        1:{label:'success', value:'Visbile'}
                    }
                }
            },
            {
                column: 'id',
                filter: 'actions',
                setting: {
                    /*
                    extraButtons: [
                        {
                            'title': 'Ver',
                            'class': 'primary',
                            'href': 'posts/${row.id}',
                            'icon': 'fa-eye',
                            'data-id': '${row.id}'
                        },
                    ],
                    */
                    edit: false
                }
            },
        ],
    });
});