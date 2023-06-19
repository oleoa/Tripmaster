@extends('layouts.main')
@section('body')
  <main class="grid-cols-3">
    <article class="space-y-4">
      <h1 class="text-start">{{$project->country}} @lang('project')</h1>
      <h2>Start at {{$project->start}}</h2>
      <h2>Ends at {{$project->end}}</h2>
    </article>
    <div class="grid gap-4 col-span-2">
      <h2>@lang('Selected stays')</h2>
      @if(count($project->rents) == 0)
        <h3>@lang('No stays selected')</h3>
        <h4><a href="{{route('stays.index')}}" class="dark:text-blue-500">@lang('Select one')</a>!</h4>
      @else
        @foreach ($project->rents as $stay)  
          <x-mini-stay :stay="$stay"/>
        @endforeach
      @endif
      <h3>Total cost: {{$project->cost}}€</h3>
    </div>
    <footer class="col-span-2 absolute bottom-0 py-4">
      <p class="text-xl py-4">
        @lang('To close a project means that it can no longer be edited and cannot be reopened.') <br>
        @lang('It also means that the stays associated with the project can no longer be edited and cannot be reopened.') <br>
        @lang('All selected stays will be paid now and will be unavailable to others.') <br>
      </p>
      <!-- <a href="{{route('projects.close', ['id' => $project->id])}}" class="w-full"><button class="btn good">@lang('Close Project')</button></a> -->
      <a href="{{route('projects.payment')}}" class="w-full"><button class="btn good">@lang('Close Project')</button></a>
    </footer>
  </main>
@endsection
