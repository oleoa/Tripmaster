@extends('layouts.main')
@section('body')
    <div class="w-full flex flex-col justify-center items-center">
        <div class="py-12">
            <x-basics.h1 :text="'Sign up'"/>
        </div>
        <form action="{{route('signing-up')}}" method="post" class="grid grid-cols-1 gap-4 w-1/3">
            @csrf
            <label for="email"><x-basics.h2 :text="__('Email').':'"/></label>
            <x-form.input :type="'text'" :name="'email'" :id="'email'"/>
            <label for="password"><x-basics.h2 :text="__('Password').':'"/></label>
            <x-form.input :type="'password'" :name="'password'" :id="'password'"/>
            <label for="password_confirmation"><x-basics.h2 :text="__('Confirm Password').':'"/></label>
            <x-form.input :type="'password'" :name="'password_confirmation'" :id="'password_confirmation'"/>
            <x-form.submit :value="__('Sign up')"/>
        </form>
    </div>
@endsection