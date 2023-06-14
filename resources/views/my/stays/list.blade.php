@extends('layouts.main')
@section('body')
<main>
  @if (isset($stays) && !empty($stays))

    <div class="all-center relative">
      <div class="py-6">
        <h1>@lang('Stays')</h1>
      </div>
      <div class="absolute right-0">
        <a href="{{route('my.creator.stay')}}" class="btn-good">@lang('Create Stay')</a>
      </div>
    </div>

    <div>
      <div class="grid grid-cols-5 w-full bg-slate-600 p-4 rounded-t">
        <h2>Name</h2>
        <h2>Capacity</h2>
        <h2>Price</h2>
        <h2>City</h2>
        <h2 class="text-end">Actions</h2>
      </div>
      <div class="grid grid-cols-1">
        @foreach ($stays as $stay)
          <div class="dark:bg-slate-700 bg-turquoise-100 [&>h1]:flex [&>h1]:items-center text-white p-4 grid grid-cols-5 w-full @if($loop->last) rounded-b @else border-b-2 @endif">
            <h1>{{$stay['title']}}</h1>
            <h1>{{$stay['capacity']}}</h1>
            <h1>{{$stay['price']}}</h1>
            <h1>{{$stay['city']}}</h1>
            <div class="flex items-center justify-end space-x-4">
              <a class="btn" href="{{route("show.stay", ['id' => $stay['id']])}}">@lang('View')</a>
              <a class="btn-okay" href="{{route('my.editor.stay', ['id' => $stay['id']])}}">@lang('Edit')</a>
              <a class="btn-danger" href="{{route('my.delete.stay', ['id' => $stay['id']])}}">@lang('Delete')</a>
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
</main>
@endsection
