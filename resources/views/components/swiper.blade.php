@vite('resources/js/swiper.js')
<div class="swiper w-full h-full">
  <div class="swiper-wrapper">
    @foreach ($images as $img)  
      <div class="swiper-slide"><img src="{{$img}}" alt="Stay Image"></div>
    @endforeach
  </div>
</div>
