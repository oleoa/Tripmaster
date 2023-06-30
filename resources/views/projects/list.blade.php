@extends('layouts.main')
@section('body')
<main>

    <div class="all-center relative">
      <h1 class="py-8">@lang('My Projects')</h1>
      <div class="absolute right-0 px-4">
        <a href="{{route('projects.creator')}}" class="btn good">@lang('Create Project')</a>
      </div>
    </div>
    
    @if(isset($projects) && !empty($projects))
      <div class="grid gap-4 grid-cols-2">
        @foreach ($projects as $project)
          <article class="flex flex-col rounded">

            <div class="grid grid-cols-3 bg-slate-700 rounded-t p-4">
              <div class="grid grid-cols-4 col-span-2">
                <h2 class="py-4 col-span-2">{{$project['country']}}</h2>
                <h2 class="py-4">{{$project['cost']}}€</h2>
                @if($project['closed'] == true && $project['finished'] == false)
                  <h2 class="py-4 dark:text-yellow-500">@lang('Closed')</h2>
                @elseif($project['closed'] == true && $project['finished'] == true)
                  <h2 class="py-4 dark:text-red-500">@lang('Finished')</h2>
                @endif
              </div>
              <div class="w-full grid justify-items-end">
                <img src="{{$project['image']}}" alt="Country flag" class="w-24">
              </div>
            </div>

            <div class="p-4 rounded-b bg-slate-600">
              <h2>{{$project['headcount']}} @lang($project['people'])</h2>
              <h2>@lang('Starts at') {{$project['start']}}</h2>
              <h2>@lang('Ends at') {{$project['end']}}</h2>
              <div class="w-full flex justify-end space-x-4">
                @if($project['closed'] == false)
                  <a href="{{route('projects.delete', ['id' => $project['id']])}}" class="btn danger">@lang('Delete')</a>
                  <a href="{{route('projects.editor', ['id' => $project['id']])}}" class="btn okay">@lang('Edit')</a>
                  <a href="{{route('projects.set', ['id' => $project['id']])}}" class="btn good">@lang('Check')</a>
                @else
                  <a class="btn disabled">@lang('Delete')</a>
                  <a class="btn disabled">@lang('Check')</a>
                @endif
              </div>
            </div>

          </article>
        @endforeach
      </div>
    @endif

</main>
@endsection
