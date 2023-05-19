@extends('layouts.main')
@section('body')
  <div class="w-full flex flex-col justify-center items-center">
    <div class="py-12">
      <h1>@lang('Signin')</h1>
    </div>
    <form action="{{route('signing-in')}}" method="post" class="grid grid-cols-1 gap-4 w-1/3">
      @csrf
      <label for="email"><h2>@lang('Email')</h2></label>
      <input type="text" name="email" id="email"/>
      <label for="password"><h2>@lang('Password')</h2></label>
      <input type="password" name="password" id="password"/>
      <x-form.submit :value="__('Sign in')"/>
    </form>
    <div class="p-4">
      <h2 class="text-2xl dark:text-white">Don't have an account? <x-link.a :href="route('signup')" :text="__('Create one!')"/></h2>
    </div>
    <div>
      <h1 class="text-xl text-white">{{session('message')}}</h1>
    </div>
  </div>
@endsection
