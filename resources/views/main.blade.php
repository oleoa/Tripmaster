@extends('layouts.main')
@section('body')
  <div class="p-6 grid gap-4">
    <h1 class="text-start">{{$p['country']}}</h1>
    <h2>@lang('Start at') {{$p['start']}}</h2>
    <h2>@lang('Ends at') {{$p['end']}}</h2>
    @if ($p['stay'])
      <h2 class="text-start">{{$p['stay']['title']}}</h2>
    @else
      <h2 class="text-start">Unselected stay</h2>
    @endif
  </div>
@endsection
