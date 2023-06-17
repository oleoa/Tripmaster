@extends('layouts.main')
@section('body')
  <main class="grid justify-items-center">
    <div class="w-1/2">
      <div class="all-center relative w-full">
        <div class="w-24">
          <img src="https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg" alt="User Image" class="rounded-full"/>
        </div>
        <div class="absolute right-0 top-0">
          <a href="{{route('account.manage')}}"><img src="{{asset('images/config.png')}}" alt="Config" class="object-fill w-8"></a>
        </div>
      </div>
      <div class="grid grid-cols-2 p-4 py-8 gap-4">
        <h1>@lang('Name')</h1>
        <h1>{{$name}}</h1>
        <h2>@lang('Email:')</h2>
        <h2>{{$email}}</h2>
        <a href="{{route('projects.list')}}" class="btn okay">@lang('My Projects')</a>
        <a href="{{route('stays.list')}}" class="btn okay">@lang('My stays')</a>
      </div>
    </div>
  </main>
@endsection
