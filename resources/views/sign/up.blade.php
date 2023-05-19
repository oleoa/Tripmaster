@extends('layouts.main')
@section('body')
  <div class="w-full flex flex-col justify-center items-center">
    <div class="py-12">
      <h1>@lang('Sign up')</h1>
    </div>
    <form action="{{route('signing-up')}}" method="post" class="grid grid-cols-1 gap-4 w-1/3">
      @csrf
      <label for="name"><h2>@lang('Name')</h2></label>
      <input type="text" name="name" id="name"/>
      <label for="email"><h2>@lang('Email')</h2></label>
      <input type="text" name="email" id="email"/>
      <label for="password"><h2>@lang('Password')</h2></label>
      <input type="password" name="password" id="password"/>
      <label for="password_confirmation"><h2>@lang('Confirm Password')</h2></label>
      <input type="password" name="password_confirmation" id="password_confirmation"/>
      <x-form.submit :value="__('Sign up')"/>
    </form>
    <div class="p-4">
      <h2 class="text-2xl">Have an account? <x-link.a :href="route('signin')" :text="__('Sign in!')"/></h2>
    </div>
    <x-validate-errors :errors="$errors"/>
  </div>
@endsection
