<!-- Hero Slider-->
<section class="hero-slider">
  <div  class="owl-carousel large-controls dots-inside pb-4" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 8000 }">
    @foreach ($homeSliders as $homeSlider)
        <div class="container-fluid bg-image" style="background-image: url(/content/posts/banner/{{ $homeSlider->thumb }})">
          <div class="row align-items-center h-100">
            <div class="col-lg-6 offset-lg-3 ">
              <div class="padding-top-3x padding-bottom-3x px-3 px-lg-5 text-center text-center from-bottom">
                <h1 class="text-white">{{ $homeSlider->title }}</h1>
                <p class="text-sm text-white d-none d-md-block">{{ \Str::limit(strip_tags($homeSlider->content), 80) }}</p>
                <a class="btn btn-outline-light rounded-0 mx-0 scale-up delay-1" href="/{{ $homeSlider->category->slug }}/{{ $homeSlider->slug }}">Ver más</a>

                <p class="mt-4 color-gold  d-none d-md-block">Por {{ $homeSlider->author->full_name }}</p>
              </div>
            </div>
          </div>
        </div>
    @endforeach
  </div>
</section>