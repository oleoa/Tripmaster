@extends('layouts.main')
@section('body')
  <div class="p-6 grid">
    <h1 class="text-center">{{$stay['title']}}</h1>
    <p class="text-center">{{$stay['description']}}</p>
    
  </div>
@endsection
