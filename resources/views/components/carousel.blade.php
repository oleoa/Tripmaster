@vite(['resources/css/carousel.css', 'resources/js/carousel.js'])
<ul class="gallery" style="grid-template-columns: repeat({{count($images)}}, 80vw);">
  @foreach ($images as $image)
    <li class="flex items-start justify-center">
      <img src="{{$image}}" alt="Stay Image" class="object-contain">
    </li>
  @endforeach
</ul>
