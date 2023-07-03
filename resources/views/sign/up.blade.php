@extends('layouts.main')
@section('body')
  <div class="w-full flex flex-col justify-center items-center space-y-4">
    <div class="py-8">
      <h1>@lang('Sign up')</h1>
    </div>
    <form action="{{route('sign.ing-up')}}" method="post" class="grid grid-cols-1 gap-4 w-full lg:w-1/3">
      @csrf
      <label for="name"><h2>@lang('Name')</h2></label>
      <input type="text" name="name" id="name" value="{{old('name')}}"/>
      <label for="email"><h2>@lang('Email')</h2></label>
      <input type="text" name="email" id="email" value="{{old('email')}}"/>
      <x-password :min="$password_min_length" :max="$password_max_length"/>
      <label for="password_confirmation"><h2>@lang('Confirm Password')</h2></label>
      <input type="password" name="password_confirmation" id="password_confirmation" minlength="{{$password_min_length}}" maxlength="{{$password_max_length}}"/>
      <button type="submit" class="btn good">@lang('Sign up')</button>
    </form>
    <h2 class="text-2xl">@lang('Have an account?') <a class="text-blue-500" href="{{route('sign.in')}}">@lang('Sign in')</a>!</h2>
  </div>
@endsection
