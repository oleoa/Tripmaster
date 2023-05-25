@extends('layouts.main')
@section('body')
<div class="p-4">
  <div class="w-full border-2 border-slate-800 dark:border-slate-300 rounded">
    @if (isset($stays) && !empty($stays))
      <div class="flex flex-col p-4">
        <div class="flex items-center justify-center relative">
          <div class="py-6">
            <h1>@lang('Stays')</h1>
          </div>
          <div class="absolute right-0 top-0 p-4 pt-8">
            <a href="{{route('my.creator.stay')}}" class="btn">@lang('Create Stay')</a>
          </div>
        </div>
        <div class="grid grid-cols-4 w-full bg-slate-600 p-4 rounded-t">
          <h2>Name</h2>
          <h2>Capacity</h2>
          <h2>Price</h2>
          <h2 class="text-end">Actions</h2>
        </div>
        <div class="grid grid-cols-1">
          @foreach ($stays as $stay)
            <div class="dark:bg-slate-700 bg-turquoise-100 text-white p-4 grid grid-cols-4 w-full @if($loop->last) rounded-b @else border-b-2 @endif">
              <h1>{{$stay['title']}}</h1>
              <h1>{{$stay['capacity']}}</h1>
              <h1>{{$stay['price']}}</h1>
              <div class="flex items-center justify-end space-x-4">
                <a class="px-6 py-4 bg-green-600 hover:bg-green-500 hover:no-underline rounded" href="">@lang('View')</a>
                <a class="px-6 py-4 bg-blue-600 hover:bg-blue-500 hover:no-underline rounded" href="{{route('my.editor.stay', ['id' => $stay['id']])}}">@lang('Edit')</a>
                <a class="px-6 py-4 bg-red-600 hover:bg-red-500 hover:no-underline rounded" href="{{route('my.delete.stay', ['id' => $stay['id']])}}">@lang('Delete')</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @else
      <div class="flex items-center justify-center relative">
        <div class="py-6">
          <h1>@lang('You have no stays')</h1>
        </div>
        <div class="absolute right-0 top-0 p-4 pt-8">
          <a href="{{route('my.creator.stay')}}" class="btn">@lang('Create Stay')</a>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
