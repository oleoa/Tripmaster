@extends('layouts.main')
@section('body')
  <div class="p-6 grid">
    <h1 class="text-center">{{$p['country']}}</h1>
    <div class="grid grid-cols-2 [&>h2]:text-center">
      <h2>@lang('Start at') {{$p['start']}}</h2>
      <h2>@lang('Ends at') {{$p['end']}}</h2>
    </div>
    @if ($p['stay'])
      <h2 class="text-center">{{$s['title']}}</h2>
    @else
      <h2 class="text-center">Unselected stay</h2>  
    @endif
  </div>
@endsection
