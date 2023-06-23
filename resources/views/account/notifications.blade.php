@extends('layouts.main')
@section('body')
  <main>
    <h1>@lang('Notifications')</h1>
    <div class="grid grid-cols-2">
      <p>@lang('Here you can see all your notifications').</p>
      @if(count($notifications) == 0)
        <a href="{{route('account.notifications.deleteAll')}}" class="text-end"><button class="btn danger">@lang('Delete All')</button></a>
      @endif
    </div>
    <div>
      @if(count($notifications) > 0)
        <div class="grid grid-cols-6 p-4 [&>p]:text-xl bg-slate-600 border-b rounded-t">
          <p>@lang('Title')</p>
          <p class="col-span-3">@lang('Body')</p>
          <p class="text-end">@lang('At')</p>
          <p class="text-end">@lang('Actions')</p>
        </div>
        <div class="grid grid-cols-1 rounded-b">
          @foreach ($notifications as $notification)
            <div class="bg-slate-700 grid grid-cols-6 p-4 [&>p]:text-2xl @if($loop->last) rounded-b @else border-b-2 @endif">
              <p class="flex items-center">{{ $notification->title }}</h2>
              <p class="col-span-3 flex justify-center items-center">{{ $notification->body }}</p>
              <p class="flex items-center justify-end">{{ $notification->created_at }}</p>
              <div class="w-full flex items-center justify-end"><a href="{{route('account.notifications.delete', ['id' => $notification->id])}}" class="flex items-center justify-end"><button class="btn danger">@lang('Delete')</button></a></div>
            </div>
          @endforeach
        </div>
      @else
        <h1>@lang('You have no notifications').</h1>
      @endif
    </div>
  </main>
@endsection
