@extends('layouts.main')
@section('body')
  <main class="grid justify-items-center">
    <h1>@lang('Contact us')</h1>
    <form action="{{route('contact')}}" method="POST" class="grid gap-4 grid-cols-2 [&>div]:grid [&>div]:gap-4">
      @csrf
      <div>
        <label for="name">@lang('Name')</label>
        <input type="text" name="name" id="name" value="{{old('name')}}">
      </div>
      <div>
        <label for="phone">@lang('Phone number')</label>
        <input type="number" id="phone" name="phone" value="{{old('phone')}}">
      </div>
      <div class="col-span-2">
        <label for="email">@lang('Email')</label>
        <input type="text" id="email" name="email" value="{{old('email')}}">
      </div>
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
