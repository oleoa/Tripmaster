@extends('layouts.main')
@section('body')
  <main>
    <h1 class="text-center">@lang('Stay Review')</h1>
    <div class="grid grid-cols-2">
      <form action="{{route("stays.review", ['id' => $stay->id])}}" method="POST" class="grid gap-4">
        @csrf
        <label for="title">@lang('Title')</label>
        <input type="text" name="title" id="title">
        <label for="comment">@lang('Comment')</label>
        <textarea type="text" name="comment" id="comment"></textarea>
        <label for="rating">@lang('Rating')</label>
        <x-rating/>
        <button class="btn good" type="submit">@lang('Review')</button>
      </form>
      <div class="space-y-4 p-4">
        <h2>{{$stay->title}}</h2>
        <p>{{$stay->description}}</p>
      </div>
    </div>
  </main>
@endsection
