@vite('resources/js/dashboard.js')
@extends('layouts.main')
@section('body')
  <input type="hidden" id="rents" value={{json_encode($rents)}}>
  <main class="grid grid-cols-2">
    <h1 class="">{{$stay->title}}</h1>
    <div class="text-end">
      <a class="btn okay" href="{{route('stays.list')}}">@lang('My Stays')</a>
    </div>
    <div id='calendar'></div>
    <div>
      <h2>@lang('Total Views'): {{$totalViews}}</h2>
      <h2>@lang('Total Rents'): {{$totalRents}}</h2>
      <h2>@lang('Total Earnings'): {{$totalEarnings}}€</h2>
    </div>
  </main>
@endsection
