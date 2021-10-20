$(document).ready(function () {
    KT.create('#datatable', {
        resource: 'payments',
        ajax: '/admin/payments/'+state+'/json',
        columns: [
            'updated_at|moment:DD-MM-YYYY',
            'price|money',
            'user.username',
            'user.email',
        ]
    });
});