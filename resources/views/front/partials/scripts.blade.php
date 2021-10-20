<script src="/js/vendor.min.js"></script>
<script src="/js/scripts.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="/js/calendar.js"></script>
<script src="/js/newsletter.js"></script>
<script src="/js/califications.js"></script>
<script>
    //NO REMOVER
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
</script>
