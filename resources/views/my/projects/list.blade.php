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
        <div class="grid gap-4">
          @foreach ($projects as $project)
            <div class="dark:bg-slate-700 bg-turquoise-100 [&>h1]:flex [&>h1]:items-center text-white p-4 grid grid-cols-5 w-full @if($loop->last) rounded-b @else border-b-2 @endif">
              <h1>{{$project['country']}}</h1>
              <h1>{{$project['start']}}</h1>
              <h1>{{$project['end']}}</h1>
              <div class="flex items-center justify-end space-x-4">
                <a class="px-6 py-4 bg-green-600 hover:bg-green-500 hover:no-underline rounded" href="">@lang('View')</a>
                <a class="px-6 py-4 bg-blue-600 hover:bg-blue-500 hover:no-underline rounded" href="{{route('my.editor.project', ['id' => $project['id']])}}">@lang('Edit')</a>
                <a class="px-6 py-4 bg-red-600 hover:bg-red-500 hover:no-underline rounded" href="{{route('my.delete.project', ['id' => $project['id']])}}">@lang('Delete')</a>
              </div>
            </div>
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
