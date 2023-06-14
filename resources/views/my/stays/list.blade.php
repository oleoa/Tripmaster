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
      <div class="grid grid-cols-6 w-full bg-slate-600 p-4 rounded-t">
        <h6>Name</h6>
        <h6>Status</h6>
        <h6>Capacity</h6>
        <h6>Price</h6>
        <h6>City</h6>
        <h6 class="text-end">Actions</h6>
      </div>
      <div class="grid grid-cols-1">
        @foreach ($stays as $stay)
          <div class="dark:bg-slate-700 bg-turquoise-100 [&>h3]:flex [&>h3]:items-center text-white p-4 grid grid-cols-6 w-full @if($loop->last) rounded-b @else border-b-2 @endif">
            <h3>{{$stay['title']}}</h3>
            <h3>{{$stay['rented']?'Rented':'Not rented'}}</h3>
            <h3>{{$stay['capacity']}}</h3>
            <h3>{{$stay['price']}}</h3>
            <h3>{{$stay['city']}}</h3>
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
