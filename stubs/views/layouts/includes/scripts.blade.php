<!-- General JS Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
@stack('script_libraries')
<script src="{{ mix('js/app.js') }}"></script>
@stack('script_block')
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        @stack('script_doc_ready')
    });
</script>
