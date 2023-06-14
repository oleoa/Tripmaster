@extends('layouts.main')
@section('body')
  <div class="p-6 grid">
    <div class="all-center relative">
      @if($staySelected)
        <div class="absolute left-0 p-4">
          <p class="dark:text-red-500">@lang('You have already selected a stay')</p>
        </div>
      @endif
      <h1 class="text-center">Stays for {{$country}}</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
      @foreach ($stays as $stay)
        @if ($stay->status != 'disabled')
          <div class="bg-slate-700 rounded-lg shadow-lg overflow-hidden">
            <img class="object-cover object-center" src="{{$stay->image}}" alt="{{$stay->title}}">
            <div class="p-4">
              <h1 class="text-2xl font-semibold">{{$stay->title}}</h1>
              <p class="mt-2 text-white">{{$stay->description}}</p>
              <div class="flex justify-between items-center mt-4">
                <a href="{{route('show.stay', $stay->id)}}" class="btn-okay">View</a>
                <span class="font-semibold text-xl text-white">{{$stay->price}}€</span>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@endsection
