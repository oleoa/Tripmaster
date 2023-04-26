@extends('layouts.main')
@section('body')
<div class="w-full grid grid-rows-2 justify-items-center p-4 gap-4">
  <div class="p-4 rounded border-black border-2 flex flex-col justify-center items-center">
    <div>
      <img src="{{$image_path??'image.jpg'}}" alt="User Image">
    </div>
    <h1>Name</h1>
    <h2>Email</h2>
  </div>
  <div class="w-full border-2 border-black rounded">
    @if (isset($projects) && !empty($projects))
      @foreach ($projects as $project)
        <x-project :data="$project"/>
      @endforeach
    @else
      <div class="flex items-center justify-center">
        <h1 class="text-4xl">There are no projects</h1>
      </div>
    @endif
  </div>
</div>
@endsection