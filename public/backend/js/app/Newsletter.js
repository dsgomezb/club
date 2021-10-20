$(document).ready(function () {
    KT.create('#datatable', {
        resource: 'newsletter',
        columns: [
            'email',
            {
                column: 'id',
                filter: 'actions',
                setting: {
                    edit: false
                }
            },
        ]
    });
});