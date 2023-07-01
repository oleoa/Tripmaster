@extends('layouts.main')
@section('body')
  <main>
    
    <h1 class="text-center">{{$stay['title']}}</h1>

    <div class="grid grid-cols-2 gap-4">
      <!-- Carousel
        @if($stay->images)
          <div class="overflow-hidden">
            <x-carousel :images="$stay->images"/>
          </div>
        @endif
      -->
      <img src="{{$stay->image}}" alt="Stay Image"/>
      <x-map lat="{{$stay->lat}}" lon="{{$stay->lon}}"/>
    </div>

    <div class="grid grid-cols-2 px-6 space-y-4">
      <p class="text-2xl">{{$stay['description']}}</p>
      <p class="text-2xl text-end">{{$stay['price']}}€</p>
      <p class="text-2xl">@lang('Capacity'): {{$stay['capacity']}}</p>
      <p class="text-2xl">@lang('Address'): {{$stay['address']}}</p>
      <p class="text-2xl">@lang('City'): {{$stay['city']}}</p>
      <p class="text-2xl">@lang('Country'): {{$stay['country']}}</p>
    </div>
    <div class="flex justify-between w-full p-6 space-x-4">
      <div>
        @if($canReview)
          <a href="{{route('stays.reviewer', ['id' => $stay['id']])}}" class="btn okay">@lang('Review')</a>
        @endif
      </div>
      <div>
        <a href="{{$backHref}}" class="btn okay">@lang('Back')</a>
        @if($stay->status == 'available')
          <a href="{{route('stays.rent', ["id" => $stay['id']])}}" class="btn good">@lang('Rent')</a>
        @endif
      </div>
    </div>

    @if(count($stay->reviews) > 0)
      <div class="space-y-4">
        <h2 class="text-center">@lang('Reviews')</h2>
        <div class="grid grid-cols-1 gap-4 px-6">
          @foreach ($stay->reviews as $review)
            <div class="grid gap-4 grid-cols-2 bg-slate-700 rounded p-4">
              <h2>{{$review['title']}}</h2>
              <div class="text-end">
                @for($i = 0; $i < $review['rating']; $i++)
                  <span class="text-white">★</span> 
                @endfor
              </div>
              <p class="flex items-center">{{$review['comment']}}</p>
              <h3 class="text-end">{{$review['user']}}<a href="{{route('report.review', ['id' => $review['id']])}}" class="text-red-500 text-sm pl-4">Report</a></h3>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </main>
@endsection
