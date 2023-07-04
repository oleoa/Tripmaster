@extends('layouts.main')
@section('body')
  <main class="grid grid-cols-1 lg:grid-cols-3">

    <div class="all-center relative lg:col-span-3">
      <div class="py-6">
        <h1>@lang('Images Editor')</h1>
      </div>
      <div class="absolute right-0">
        <a href="{{route('stays.list')}}" class="btn okay">@lang('List Stays')</a>
      </div>
    </div>

    <form action="{{route('stays.images.add')}}" class="lg:col-span-3 grid gap-4" method="POST" enctype="multipart/form-data">
      @csrf      
      <label for="image">@lang('Add Image')</label>
      <input type="file" name="image[]" id="image" class="block" multiple/>
      <input type="hidden" name="stay" value="{{$stayId}}">
      <button type="submit" class="btn good">@lang('Add')</button>
    </form>
    @if(count($images) == 0)
      <h1>@lang('No images')</h1>
    @else
      @foreach ($images as $image)
        <div class="relative">
          <img src="{{asset('storage/stays/'.$image->image_path)}}" alt="Stay Image" class="w-full h-full object-cover"/>
          <div class="absolute top-0 right-0 grid grid-cols-2 p-4">
            <form action="{{route('stays.images.main')}}" method="POST" class="">
              @csrf
              @method('PUT')
              <input type="hidden" name="image" value="{{$image->image_path}}">
              <input type="hidden" name="stay" value="{{$stayId}}">
              <button type="submit" class="btn okay">@lang('Main')</button>
            </form>
            <form action="{{route('stays.images.destroy', $image->id)}}" method="POST" class="">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn danger">@lang('Delete')</button>
            </form>
          </div>
        </div>
      @endforeach
    @endif
  </main>
@endsection
