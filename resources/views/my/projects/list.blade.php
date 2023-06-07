@extends('layouts.main')
@section('body')
<div class="w-full grid justify-items-center p-4 gap-4">
  <div class="w-full border-2 border-slate-800 dark:border-slate-300 rounded">
    @if (isset($projects) && !empty($projects))
      <div class="flex flex-col p-4">
        <div class="flex items-center justify-center relative">
          <div class="py-6">
            <h1>@lang('Projects')</h1>
          </div>
          <div class="absolute right-0 top-0 p-4 pt-8">
            <a href="{{route('my.creator.project')}}" class="btn">@lang('Create Project')</a>
          </div>
        </div>
        <div class="grid gap-4 grid-cols-2">
          @foreach ($projects as $project)
            <article class="grid bg-slate-700 rounded p-4 space-y-4">
              <div class="grid grid-cols-2">
                <h1 class="py-4">{{$project['country']}}</h1>
                <div class="w-full flex justify-end">
                  <img src="{{$project['image']}}" alt="Country flag" class="w-24">
                </div>
              </div>
              <h2>{{$project['headcount']}} @lang($project['people']) goes</h2>
              <h2>@lang('Start at') {{$project['start']}}</h2>
              <h2>@lang('Ends at') {{$project['end']}}</h2>
              <div class="w-full flex justify-end space-x-4">
                <a href="{{route('home')}}" class="hover:no-underline p-4 rounded bg-red-500 text-white">Delete</a>
                <a href="{{route('home')}}" class="hover:no-underline p-4 rounded bg-green-500 text-white">Check</a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    @else
      <div class="flex items-center justify-center relative">
        <div class="py-6">
          <h1>@lang('You have no projects')</h1>
        </div>
        <div class="absolute right-0 top-0 p-4 pt-8">
          <a href="{{route('my.creator.project')}}" class="btn">@lang('Create Project')</a>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
