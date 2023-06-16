@extends('layouts.main')
@section('body')
<main>

  @if (isset($projects) && !empty($projects))

    <div class="all-center relative">
      <h1 class="py-8">@lang('Projects')</h1>
      <div class="absolute right-0 px-4">
        <a href="{{route('projects.creator')}}" class="btn-good">@lang('Create Project')</a>
      </div>
    </div>

    <div class="grid gap-4 grid-cols-2">
      @foreach ($projects as $project)
        <article class="flex flex-col rounded">

          <div class="grid grid-cols-2 bg-slate-700 rounded-t p-4">
            <h1 class="py-4">{{$project['country']}}</h1>
            <div class="w-full flex justify-end">
              <img src="{{$project['image']}}" alt="Country flag" class="w-24">
            </div>
          </div>

          <div class="p-4 rounded-b bg-slate-600">
            <h2>{{$project['headcount']}} @lang($project['people']) goes</h2>
            <h2>@lang('Start at') {{$project['start']}}</h2>
            <h2>@lang('Ends at') {{$project['end']}}</h2>
            <div class="w-full flex justify-end space-x-4">
              <a href="{{route('projects.delete', ['id' => $project['id']])}}" class="btn-danger">@lang('Delete')</a>
              <a href="{{route('projects.set', ['id' => $project['id']])}}" class="btn-okay">@lang('Check')</a>
            </div>
          </div>

        </article>
      @endforeach
    </div>

  @else

    <div class="flex items-center justify-center relative">
      <div class="py-6">
        <h1>@lang('You have no projects')</h1>
      </div>
      <div class="absolute right-0 top-0 p-4 pt-8">
        <a href="{{route('projects.creator')}}" class="btn">@lang('Create Project')</a>
      </div>
    </div>

  @endif

</main>
@endsection
