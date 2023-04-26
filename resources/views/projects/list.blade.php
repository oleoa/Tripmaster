@extends('layouts.main')
@section('body')
<div class="w-full grid justify-items-center p-4 gap-4">
  <div class="w-full border-2 border-black dark:border-white rounded">
    @if (isset($projects) && !empty($projects))
      <div class="grid grid-rows-2 gap-4 justify-items-start">
        <div class="w-full flex items-center justify-center">
          <x-h1 :text="'Project'"/>
        </div>
        <div class="grid gap-4 justify-items-start grid-cols-4">
          @foreach ($projects as $project)
            <x-project :data="$project"/>
          @endforeach
        </div>
      </div>
    @else
      <div class="flex items-center justify-center relative">
        <div class="py-6">
          <x-h1 :text="'There are no projects'"/>
        </div>
        <div class="absolute right-0 top-0 p-4 pt-8">
          <x-link.button :href="route('create.project')" :name="'Create Project'"/>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection