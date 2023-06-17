@extends('layouts.main')
@section('body')
  <main class="grid-cols-2">
    <article class="space-y-4">
      <h1 class="text-start">{{$project->country}} @lang('project')</h1>
      <h2>Dates</h2>
    </article>
    <div class="grid gap-4">
      <h2>@lang('Selected stays')</h2>
      @foreach ($project->stays as $stay)  
        <x-mini-stay :stay="$stay"/>
      @endforeach
    </div>
    <footer class="col-span-2">
      <p class="text-xl">
        @lang('To close a project means that it can no longer be edited and cannot be reopened.') <br>
        @lang('It also means that the stays associated with the project can no longer be edited and cannot be reopened.') <br>
        @lang('All selected stays will be paid now and will be unavailable to others.') <br>
      </p>
      <!-- <a href="{{route('projects.close', ['id' => $project->id])}}" class="w-full"><button class="btn good">@lang('Close Project')</button></a> -->
      <a href="{{route('projects.payment')}}" class="w-full"><button class="btn good">@lang('Close Project')</button></a>
    </footer>
  </main>
@endsection
