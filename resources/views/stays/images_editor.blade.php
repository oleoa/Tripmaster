@extends('layouts.main')
@section('body')
  <main class="grid grid-cols-1 lg:grid-cols-3">
    <form action="{{route('stays.images.add')}}" class="lg:col-span-3 grid gap-4" method="POST" enctype="multipart/form-data">
      @csrf      
      <label for="image">@lang('Add Image')</label>
      <input type="file" name="image" id="image" class="block"/>
      <input type="hidden" name="stay" value="{{$stayId}}">
      <button type="submit" class="btn good">@lang('Add')</button>
    </form>
    @if(count($images) == 0)
      <h1>@lang('No images')</h1>
    @else
      @foreach ($images as $image)
        <div class="relative">
          <img src="{{asset('storage/stays/'.$image->image_path)}}" alt="{{$image->name}}" class="w-full h-full object-cover"/>
          <div class="absolute top-0 right-0">
            <form action="{{route('stays.images.destroy', $image->id)}}" method="POST" class="p-4">
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
