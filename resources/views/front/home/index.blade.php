@extends("front.layouts.app")

@section("content")
	{{-- @include("front.home._sliders") --}}
  	
    <section class="container-fluid padding-top-3x padding-bottom-3x">
		<div class="row">
			<div class="col-md-9 ">
				<div class="isotope-grid cols-3">
					<div class="gutter-sizer"></div>
            		<div class="grid-sizer"></div>
				    
				    @each('front.home._card', $posts, 'post')
				</div>
			</div>
			@include("front.partials._sidebar")
		</div>
    </section>
@endsection

@section('scripts')
	<script>
		var pending = false, page = 0;

		$(window).on('scroll', function() {
	        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
	            getMore();
	        }
	    });

	    function getMore() {
	        if (!pending) {
	    		page++;
	            pending = true;
	            $.ajax({
	                url: location.url,
	                type: 'get',
	                data: {page: page},
	                dataType: 'json',
	                success: function (response) {
	                    if (page >= response.lastPage) $(window).off('scroll');
	                    $('.isotope-grid')
                    		.isotope('insert', $(response.data))
	                    	.isotope('layout')
						;

	                    pending = false;
	                }
	            });
	        }
	    }
	</script>
@endsection