<script src="/backend/js/vendors.bundle.js"></script>
<script src="/backend/js/app.bundle.js"></script>
<script src="/backend/js/notifications/toastr/toastr.js"></script>
<script src="/backend/js/datagrid/datatables/datatables.bundle.js"></script>
<script src="/backend/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/backend/js/formplugins/summernote/summernote.js"></script>
<script src="/backend/js/dependency/jquery-form/jquery-form.min.js"></script>
<script src="/backend/js/dependency/moment/moment.js"></script>
<script src="/backend/js/helpers/number-format.js"></script>
<script src="/backend/js/formplugins/select2/select2.bundle.js"></script>
<script src="/backend/js/formplugins/uploadPreview/jquery.uploadPreview.min.js"></script>

<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $('.select2').select2();
</script>

<script src="/backend/js/app/Form.js"></script>
<script src="/backend/js/kametable/i18n/spanish.js"></script>
<script src="/backend/js/kametable/KT.js"></script>
<script src="/backend/js/kametable/filters/limit.js"></script>
<script src="/backend/js/kametable/filters/actions.js"></script>
<script src="/backend/js/kametable/filters/image.js"></script>
<script src="/backend/js/kametable/filters/stateSwitcher.js"></script>
<script src="/backend/js/kametable/filters/moment.js"></script>
<script src="/backend/js/kametable/filters/callback.js"></script>
<script src="/backend/js/kametable/filters/money.js"></script>
<script src="/backend/js/kametable/filters/label.js"></script>