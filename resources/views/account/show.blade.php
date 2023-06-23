@extends('layouts.main')
@section('body')
  <main class="grid justify-items-center">
    <div class="w-1/2">
      <div class="all-center relative w-full">
        <div class="w-24">
          <img src="https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg" alt="User Image" class="rounded-full"/>
        </div>
        <div class="absolute right-0 top-0 flex space-x-4">
          <a href="{{route('account.notifications.list')}}" class="flex">
            <img src="{{asset('images/notifications.png')}}" alt="Config" class="object-fill w-8">
            @if($hasNewNotifications)
              <div class="w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                <span class="text-xs">{{$newNotificationsCount}}</span>
              </div>
            @endif
          </a>
          <a href="{{route('account.manage.index')}}"><img src="{{asset('images/gear.png')}}" alt="Config" class="object-fill w-8"></a>
        </div>
      </div>
      <div class="grid grid-cols-2 p-4 py-8 gap-4">
        <h1>@lang('Name')</h1>
        <h1>{{$user->name}}</h1>
        <h2>@lang('Email'):</h2>
        <h2>{{$user->email}}</h2>
        <h2>@lang('Money'):</h2>
        <h2>{{$user->money}}€</h2>
        <a href="{{route('projects.list')}}" class="btn okay">@lang('My Projects')</a>
        <a href="{{route('stays.list')}}" class="btn okay">@lang('My stays')</a>
        <a href="{{route('account.manage.money')}}" class="btn good col-span-2">@lang('Manage money')</a>
      </div>
    </div>
  </main>
@endsection
