$(document).ready(function () {
    KT.create('#datatable', {
        resource: 'categories',
        columns: [
            'value|limit',
            'posts_count',
            'id|actions'
        ]
    });
});