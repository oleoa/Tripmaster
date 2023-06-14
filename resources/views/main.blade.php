@extends('layouts.main')
@section('body')
  <main>
    
    <h1 class="text-start">{{$p['country']}} @lang('travel')</h1>

    <div class="w-full rounded bg-slate-700 p-4 grid gap-4">
      <h2 class="">@lang('Dates'):</h2>
      <div class="flex space-x-4">
        <h3>@lang('Start at') {{$p['start']}}</h3>
        <h3>@lang('Ends at') {{$p['end']}}</h3>
      </div>
    </div>

    <div class="w-full rounded bg-slate-700 p-4 grid gap-4">
      <h2>Selected stay</h2>
      @if ($p['stay'])
        <? $stay = $p['stay']; ?>
        <div class="overflow-hidden flex">
          <img class="w-60 object-cover object-center" src="{{asset('storage/stays/'.$stay->image)}}" alt="{{$stay->title}}">
          <div class="px-4">
            <h1 class="text-2xl font-semibold">{{$stay->title}}</h1>
            <p class="mt-2 text-white">{{$stay->description}}</p>
            <div class="flex justify-between items-center mt-4">
              <a href="{{route('show.stay', $stay->id)}}" class="btn-okay">View</a>
              <span class="font-semibold text-xl text-white">{{$stay->price}}€</span>
            </div>
          </div>
        </div>
      @else
        <h3 class="text-start">@lang('You have not selected a stay')</h3>
      @endif
    </div>
  </main>
@endsection
