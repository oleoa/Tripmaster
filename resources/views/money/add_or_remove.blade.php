@extends('layouts.main')
@section('body')
  <main class="justify-items-center">
    <h1>@lang($title)</h1>
    <form action="{{$action}}" class="space-y-4" method="POST">
      @csrf
      @method('PUT')
      <label for="amount">@lang('Amount in €')</label>
      <input type="number" name="amount" id="amount">
      <button type="submit" class="btn {{$btnColor}} w-full">@lang($btnText)</button>
    </form>
    <a href="{{route('account.manage.money')}}"><button class="btn okay">Go back</button></a>
  </main>
@endsection
