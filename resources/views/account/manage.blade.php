@extends('layouts.main')
@section('body')
  <main class="justify-items-center">
    <h1 class="py-4">@lang('Manage Account')</h1>
    <div class="text-2xl text-white grid gap-4 justify-items-center">
      <a href="{{route('account.editor')}}"><button class="btn okay">Edit data</button></a>
      <a href="{{route('account.password.recover')}}"><button class="btn okay">Recover Password</button></a>
      <form action="{{ route('account.delete', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn danger">Delete Account</button>
      </form>
      <a href="{{route("account.index")}}"><button class="btn okay">Go back</button></a>
    </div>
  </main>
@endsection
