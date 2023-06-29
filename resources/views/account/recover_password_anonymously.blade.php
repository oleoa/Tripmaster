@extends('layouts.main')
@section('body')
  <main>
    <h1>@lang('Recover Password')</h1>
    <form action="" method="POST" class="grid gap-4">
      @csrf
      <label for="email">@lang('Email')</label>
      <input type="text" name="email" id="email">
      <button type="submit" class="btn good">@lang('Recover Password')</button>
    </form>
  </main>
@endsection
