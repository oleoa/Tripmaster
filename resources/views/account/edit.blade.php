@extends('layouts.main')
@section('body')
  <div class="w-full flex flex-col justify-center items-center">
    <div class="py-12">
      <h1>@lang('Edit Account')</h1>
    </div>
    <form action="{{route('account.edit')}}" method="post" class="grid grid-cols-1 gap-4 w-1/3">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" value="{{$user->id}}">
      <label for="name"><h2>@lang('Name')</h2></label>
      <input type="text" name="name" id="name" value="{{$user->name}}"/>
      <label for="email"><h2>@lang('Email')</h2></label>
      <input type="text" name="email" id="email" value="{{$user->email}}"/>
      <label for="password"><h2>@lang('Password')</h2></label>
      <input type="password" name="password" id="password" minlength="{{$password_min_length}}" maxlength="{{$password_max_length}}"/>
      <button type="submit" class="btn good">@lang('Edit')</button>
    </form>
    <a href="{{route('account.manage')}}" class="p-4"><button class="btn okay">Go back</button></a>
  </div>
@endsection
