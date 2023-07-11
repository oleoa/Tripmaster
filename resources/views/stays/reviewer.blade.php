@extends('layouts.main')
@section('body')
  <main>
    <h1 class="text-center">@lang('Stay Review')</h1>
    <div class="grid grid-cols-2">
      <div class="space-y-4 p-4">
        <h1>{{$stay->title}}</h1>
        <p>{{$stay->description}}</p>
        <div class="w-96">
          <x-swiper :images="$stay->images"/>
        </div>
      </div>
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
    </div>
  </main>
@endsection
