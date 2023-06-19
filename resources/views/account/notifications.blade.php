@extends('layouts.main')
@section('body')
  <main>
    <h1>Notifications</h1>
    <div class="grid grid-cols-2">
      <p>Here you can see all your notifications.</p>
      <a href="{{route('account.notifications.deleteAll')}}" class="text-end"><button class="btn danger">Delete All</button></a>
    </div>
    <div>
      <div class="grid grid-cols-6 p-4 [&>p]:text-xl bg-slate-600 border-b rounded-t">
        <p>Title</p>
        <p class="col-span-3">Body</p>
        <p class="text-end">Date</p>
        <p class="text-end">Actions</p>
      </div>
      <div class="grid grid-cols-1 rounded-b">
        @foreach ($notifications as $notification)
          <div class="bg-slate-500 grid grid-cols-6 p-4 [&>p]:text-2xl @if($loop->last) rounded-b @else border-b-2 @endif">
            <p>{{ $notification->title }}</h2>
            <p class="col-span-3">{{ $notification->body }}</p>
            <p class="text-end">{{ $notification->created_at }}</p>
            <a href="{{route('account.notifications.delete', ['id' => $notification->id])}}" class="text-end"><button class="text-end btn danger">Delete</button></a>
          </div>
        @endforeach
      </div>
    </div>
  </main>
@endsection
