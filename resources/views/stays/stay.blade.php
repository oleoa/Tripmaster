@extends('layouts.main')
@section('body')
  <div class="p-6 grid">
    <h1 class="text-center">{{$stay['title']}}</h1>
    <div class="grid grid-cols-3 py-6">
      @foreach ($images as $image)
        <div class="flex justify-center p-6">
          <img src="{{asset('storage/stays/'.$image['image_path'])}}" alt="{{$stay['title']}}" class="w-full h-full">
        </div>
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
      <a href="{{route('list.stays')}}" class="btn">@lang('Back')</a>
      <a href="{{route('list.stays')}}" class="btn bg-green-500">@lang('Buy')</a>
    </div>
  </div>
@endsection
