@extends('layouts.main')
@section('body')
  <main>
    <form action="{{route("projects.stays.rent", ['id' => $stay->id])}}" class="grid gap-4">
      <div class="grid gap-4 grid-cols-2">
        <div class="grid gap-4">
          <h2><label for="start_date">@lang('Start date')</label></h2>
          <input type="date" name="start_date" id="start_date" min="{{$minDate}}" max="{{$maxDate}}">
        </div>
        <div class="grid gap-4">
          <h2><label for="end_date">@lang('End date')</label></h2>
          <input type="date" name="end_date" id="end_date" min="{{$minDate}}" max="{{$maxDate}}">
        </div>
      </div>
      <h2><label for="headcount">@lang('How many people will use this stay')?</label></h2>
      <input type="number" name="headcount" id="headcount" min="1" max="{{$maxHeadcount}}">
      <button type="submit" class="btn-good">@lang('Rent it')</button>
    </form>
  </main>
@endsection
