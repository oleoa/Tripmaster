@extends('layouts.main')
@section('body')
  <div class="w-full flex flex-col justify-center items-center">
    <div class="py-12">
      <x-basics.h1 :text="'Signin'"/>
    </div>
    <form action="{{route('signing-in')}}" method="post" class="grid grid-cols-1 gap-4 w-1/3">
      @csrf
      <label for="email"><x-basics.h2 :text="__('Email').':'"/></label>
      <x-form.input :type="'text'" :name="'email'" :id="'email'"/>
      <label for="password"><x-basics.h2 :text="__('Password').':'"/></label>
      <x-form.input :type="'password'" :name="'password'" :id="'password'"/>
      <x-form.submit :value="__('Sign in')"/>
    </form>
    <div class="p-4">
      <h2 class="text-2xl">Don't have an account? <x-link.a :href="route('signup')" :text="__('Create one!')"/></h2>
    </div>
  </div>
@endsection
