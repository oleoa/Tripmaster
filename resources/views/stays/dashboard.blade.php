@vite('resources/js/dashboard.js')
@extends('layouts.main')
@section('body')
  <main class="grid grid-cols-2">
    <h1 class="col-span-2">{{$stay->title}}</h1>
    <input type="hidden" id="rents" value={{json_encode($rents)}}>
    <div id='calendar'></div>
  </main>
@endsection
