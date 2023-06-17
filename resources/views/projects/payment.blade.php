@extends('layouts.main')
@section('body')
  <main class="">
    <h1 class="text-start">@lang('Payment')</h1>
    <h2>@lang('Your balance'): {{$user->money}}€</h2>
    <h2>@lang('Total to pay'): {{$project->cost}}€</h2>
    <h2>@lang('Remaining'): {{$remaining}}€</h2>
    <div>
      <a href="{{route('projects.close', ['id' => $project->id])}}"><button class="btn good">@lang('Close')</button></a>
    </div>
  </main>
@endsection
