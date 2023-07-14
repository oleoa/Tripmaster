@extends('layouts.main')
@section('body')
  <main class="grid justify-items-center">
    <div class="w-full relative text-center grid gap-4 lg:block">
      <h1 class="text-center">@lang('Contact stay owner')</h1>
      <a class="lg:absolute top-0 right-0 btn okay" href="{{$go_back}}">@lang('Go back')</a>
    </div>
    <form action="{{$form_route}}" method="POST" class="grid gap-4 grid-cols-2 [&>div]:grid [&>div]:gap-4">
      @csrf
      <div class="col-span-2">
        <label for="subject">@lang('Subject')</label>
        <input type="text" id="subject" name="subject" value="{{old('subject')}}">
      </div>
      <div class="col-span-2">
        <label for="message">@lang('Message')</label>
        <textarea name="message" id="message" rows="8" cols="80" value="{{old('message')}}"></textarea>
      </div>
      <button type="submit" name="button" class="btn good col-span-2">@lang('Send')</button>
    </form>
  </main>
@endsection
