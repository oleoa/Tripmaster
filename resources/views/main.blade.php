@extends('layouts.main')
@section('body')
  <main>
    
    <h1 class="text-start">{{$project->country}} @lang('travel')</h1>

    <div class="w-full rounded bg-slate-700 p-4 grid gap-4">
      <h2 class="">@lang('Dates'):</h2>
      <div class="flex space-x-4">
        <h3>@lang('Start at') {{$project->start}}</h3>
        <h3>@lang('Ends at') {{$project->end}}</h3>
      </div>
    </div>

    <div class="w-full rounded bg-slate-700 p-4 grid gap-4">
      <h2>Selected stay</h2>
      @if (isset($stay) && $stay != null)
        <div class="overflow-hidden flex">
          <img class="w-60 object-cover object-center" src="{{asset('storage/stays/'.$stay->image)}}" alt="{{$stay->title}}">
          <div class="px-4">
            <h1 class="text-2xl font-semibold">{{$stay->title}}</h1>
            <p class="mt-2 text-white">{{$stay->description}}</p>
            <span class="font-semibold text-white">{{$stay->price}}€</span>
            <div class="flex justify-start space-x-4 items-center mt-4">
              <a href="{{route('stays.show', $stay->id)}}" class="btn-okay">View</a>
              <a href="{{route('projects.stays.remove', $stay->id)}}" class="btn-danger">Remove</a>
            </div>
          </div>
        </div>
      @else
        <h3 class="text-start">@lang('You have not selected a stay'). <a href="{{route("stays.index")}}" class="dark:text-blue-500">@lang('Select one')</a>!</h3>
      @endif
    </div>
    
  </main>
@endsection
