@extends('layouts.main')
@section('body')
<main>
  <h1 class="text-center">{{$stay['title']}}</h1>
  @if ($stay->images)
    <div class="overflow-hidden">
      <x-carousel :images="$stay->images"/>
    </div>
  @endif
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
      <a href="{{route('stays.reviewer', ['id' => $stay['id']])}}" class="btn okay">@lang('Review')</a>
    </div>
    <div>
      <a href="{{$backHref}}" class="btn okay">@lang('Back')</a>
      @if($stay->status == 'available')
        <a href="{{route('stays.rent', ["id" => $stay['id']])}}" class="btn good">@lang('Rent')</a>
      @endif
    </div>
  </div>
  <div class="space-y-4">
    <h2 class="text-center">@lang('Reviews')</h2>
    @if (count($stay->reviews) > 0)
      <div class="grid grid-cols-1 gap-4 px-6">
        @foreach ($stay->reviews as $review)
          <div class="flex flex-col p-4 space-y-2 bg-slate-700 rounded-md">
            <div class="flex justify-between">
              <h2>{{$review['title']}}</h2>
              <div>
                @for($i = 0; $i < $review['rating']; $i++)
                  <span class="text-white">★</span> 
                @endfor
              </div>
            </div>
            <p>{{$review['comment']}}</p>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-center">@lang('No reviews yet')</p>
    @endif
  </div>
</main>
@endsection
