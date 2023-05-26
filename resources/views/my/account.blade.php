@extends('layouts.main')
@section('body')
  <div class="p-4">
    <div class="flex flex-col items-center justify-center">
      <div class="w-24">
        <img src="https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg" alt="User Image" class="rounded-full"/>
      </div>
      <div class="grid grid-cols-2 p-4 py-8 gap-4">
        <h1>@lang('Name')</h1>
        <h1>{{$name}}</h1>
        <h2>@lang('Email:')</h2>
        <h2>{{$email}}</h2>
        <h2>@lang('Tempo como user:')</h2>
        <h2>@lang($user_time_since_created)</h2>
        <h2>@lang('Número de projetos:')</h2>
        <h2>@lang($projects_count)</h2>
      </div>
    </div>
    <div class="grid grid-cols-3 gap-4 px-24 py-4">
      <x-account.item :itemData="$stays"/>
      <x-account.item :itemData="$cars"/>
    </div>
  </div>
@endsection
