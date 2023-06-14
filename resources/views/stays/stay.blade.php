@extends('layouts.main')
@section('body')
  <div class="p-6 grid">
    <h1 class="text-center">{{$stay['title']}}</h1>
    <div class="grid grid-cols-2 gap-4 py-6">
      @foreach ($images as $image)
        <? // temporário ?>
        @if($loop->index < 2)
          <img src="{{asset('storage/stays/'.$image['image_path'])}}" alt="{{$stay['title']}}">
        @endif
      @endforeach
    </div>
    <div class="grid grid-cols-2 px-6 space-y-4">
      <p class="text-2xl">{{$stay['description']}}</p>
      <p class="text-2xl text-end">{{$stay['price']}}€</p>
      <p class="text-2xl">@lang('Capacity'): {{$stay['capacity']}}</p>
      <p class="text-2xl">@lang('Address'): {{$stay['address']}}</p>
      <p class="text-2xl">@lang('City'): {{$stay['city']}}</p>
      <p class="text-2xl">@lang('Country'): {{$stay['country']}}</p>
    </div>
    <div class="flex justify-end w-full p-6 space-x-4">
      <a href="{{$backHref}}" class="btn-okay">@lang('Back')</a>
      @if ($stay['rented'])
        <a class="btn-disabled">@lang('Rent')</a>
      @else
        <a href="{{route('rent.stay', ["id" => $stay['id']])}}" class="btn-good">@lang('Rent')</a>  
      @endif
    </div>
  </div>
@endsection
