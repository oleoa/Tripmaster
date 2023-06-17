@extends('layouts.main')
@section('body')
  <div class="w-full flex flex-col justify-center items-center">
    <div class="py-12">
      <h1>@lang('Change Password')</h1>
    </div>
    <form action="{{route('account.password.edit')}}" method="post" class="grid grid-cols-1 gap-4 w-1/3">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" value="{{$id}}">
      <label for="password"><h2>@lang('New Password')</h2></label>
      <input type="password" name="password" id="password" minlength="{{$password_min_length}}" maxlength="{{$password_max_length}}"/>
      <label for="password_confirmation"><h2>@lang('Confirm Password')</h2></label>
      <input type="password" name="password_confirmation" id="password_confirmation" minlength="{{$password_min_length}}" maxlength="{{$password_max_length}}"/>
      <button type="submit" class="btn good w-full">@lang('Edit the password')</button>
    </form>
  </div>
@endsection
