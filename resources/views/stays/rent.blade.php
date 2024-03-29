@vite('resources/js/selectAll.js')
@extends('layouts.main')
@section('body')
  <main>
    
    <form action="{{route("projects.stays.rent", ['id' => $stay->id])}}" class="grid gap-4">

      <div id="calendars" class="grid gap-4 grid-cols-2 lg:grid-cols-4">

        <h1 class="col-span-4 text-center p-4">@lang('This stay is rented in the following days')</h1>
        @foreach($months as $month)
          <div class="bg-slate-600 pb-4 px-3 rounded">
            <h1 class="text-center p-4">@lang($month->format('F'))</h1>
            <div class="grid grid-cols-7 gap-1">
              @foreach (array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturnday') as $weekday)
                <div class="text-white flex items-center justify-center">
                  @lang(substr($weekday, 0, 3))
                </div>
              @endforeach
              @foreach (array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturnday') as $weekday)
                @if ($weekday != date('l', strtotime($month->format('Y-m'.'-01'))))
                  <div class="bg-slate-600 rounded flex items-center justify-center"></div>
                @else
                  @break
                @endif
              @endforeach
              @foreach(range(1, $month->daysInMonth) as $day)
                @if(in_array($month->format('Y-m').'-'.sprintf("%02d", $day), $rents))
                  <div class="bg-red-500 rounded flex items-center justify-center">
                    {{$day}}
                  </div>
                @else
                  <div class="bg-white rounded flex items-center justify-center">
                    {{$day}}
                  </div>
                @endif
              @endforeach
            </div>
          </div>
        @endforeach

      </div>

      <div class="grid gap-4" style="grid-template-columns: 45% 45% 10%">
        <input type="hidden" id="min_date" value="{{$minDate}}">
        <input type="hidden" id="max_date" value="{{$maxDate}}">
        <input type="hidden" id="max_headcount" value="{{$maxHeadcount}}">
        <div class="grid gap-4">
          <h2><label for="start_date">@lang('Start date')</label></h2>
          <input type="date" name="start_date" id="start_date" min="{{$minDate}}" max="{{$maxDate}}">
        </div>
        <div class="grid gap-4">
          <h2><label for="end_date">@lang('End date')</label></h2>
          <input type="date" name="end_date" id="end_date" min="{{$minDate}}" max="{{$maxDate}}">
        </div>
        <div class="flex items-end">
          <span class="btn okay" id="selectAllDatesButton">@lang('Select All')</span>
        </div>
        <div class="col-span-2 grid gap-4">
          <h2><label for="headcount">@lang('How many people will use this stay')?</label></h2>
          <input type="number" name="headcount" id="headcount" min="1" max="{{$maxHeadcount}}">
        </div>
        <div class="flex items-end">
          <span class="btn okay" id="selectAllPeopleButton">@lang('Select All')</span>
        </div>
      </div>     

      <button type="submit" class="btn good">@lang('Rent it')</button>

    </form>
  </main>
@endsection
