<!DOCTYPE html>
<html lang="en">
<x-head :title="$title"/>
<body class="dark">

  <nav class='h-full w-48 fixed left-0 flex flex-col justify-between bg-slate-950'>
    <div>

      <div class="flex flex-col items-center justify-start pt-2 pb-4">
        <div class="py-6">
          <a class="no-underline" href="{{route('home')}}"><h1>@lang('Tripmaster')</h1></a>
        </div>
        <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
      </div>

      @if($isLogged)
        <div class="grid gap-6 px-4 justify-items-start [&>a]:text-2xl">
          <a href="{{route('projects.index')}}" class="@if($current['main']) underline @endif">@lang('Main')</a>
          <a href="{{route('stays.index')}}" class="@if($current['stays']) underline @endif">@lang('Stays')</a>
        </div>
      @endif

    </div>

    <div>

      @if($isLogged)
        <div class="px-4 py-6 grid gap-6 [&>a]:text-2xl">
          <a href="{{route('account.index')}}" class="@if($current['account']) underline @endif">@lang('Account')</a>
        </div>
      @endif

      <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>

      <div class="px-4 grid grid-cols-3 [&>a]:text-2xl space-y-6 py-6">
        @if ($isLogged)
          <a class="col-span-2 flex items-end justify-start" href="{{route('sign.out')}}">@lang('Sign out')</a>
        @else
          <a href="{{route('sign.in')}}" class="col-span-3 @if($current['signin']) underline @endif">@lang('Sign in')</a>
          <a href="{{route('sign.up')}}" class="col-span-2 @if($current['signup']) underline @endif">@lang('Sign up')</a>
        @endif

        @if(false)
          <button class="w-8" onclick="document.querySelector('body').classList.toggle('dark')"><img src="{{asset('images/darkmode.svg')}}" alt="Darkmode"></button>
        @endif
      </div>

    </div>
  </nav>

  <div class='pl-52 p-4 min-h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </div>
  
  @if($errors->any())
    <div id="opc" class="fixed top-0 left-0 w-full h-full bg-slate-700/50"></div>
    <dialog class="fixed top-0 bg-white rounded my-4" open>
      <h1 class="dark:text-yellow-500">@lang('Alert'):</h1>
      @foreach ($errors->all() as $error)
        <p class="text-xl dark:text-yellow-500 py-4"><strong><code>@lang($error)<code><strong></p>
      @endforeach  
      <form method="dialog">
        <button class="btn-error text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
      </form>
    </dialog>
  @endif

  <!-- Alerts are used when the user tried to make something he shouldn't -->
  @if(session('alert'))
    <div id="opc" class="fixed top-0 left-0 w-full h-full bg-slate-700/50"></div>
    <dialog class="fixed top-0 bg-white rounded my-4" open>
      <h1 class="dark:text-orange-500">@lang('Alert'):</h1>
      <p class="text-xl dark:text-orange-500 py-4"><strong><code>@lang(session("alert"))<code><strong></p>
      <form method="dialog">
        <button class="btn-alert text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
      </form>
    </dialog>
  @endif

  <!-- Errors are used when something shoulnd't happen -->
  @if(session('error'))
    <div id="opc" class="fixed top-0 left-0 w-full h-full bg-slate-700/50"></div>
    <dialog class="fixed top-0 bg-white rounded my-4" open>
      <h1 class="dark:text-red-500">@lang('Error'):</h1>
      <p class="text-xl dark:text-red-500 py-4"><strong><code>@lang(session("error"))<code><strong></p>
      <form method="dialog">
        <button class="btn-danger text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
      </form>
    </dialog>
  @endif

  <!-- Infos are used when the programmer has to say something to the client -->
  @if(session('info'))
    <div id="opc" class="fixed top-0 left-0 w-full h-full bg-slate-700/50"></div>
    <dialog class="fixed top-0 bg-white rounded my-4" open>
      <h1 class="dark:text-blue-500">@lang('Info'):</h1>
      <p class="text-xl dark:text-blue-500 py-4"><strong><code>@lang(session("info"))<code><strong></p>
      <form method="dialog">
        <button class="btn-okay text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
      </form>
    </dialog>
  @endif

  <!-- Infos are used when the programmer has to say something to the client -->
  @if(session('success'))
    <div id="opc" class="fixed top-0 left-0 w-full h-full bg-slate-700/50"></div>
    <dialog class="fixed top-0 bg-white rounded my-4" open>
      <h1 class="dark:text-green-500">@lang('Success'):</h1>
      <p class="text-xl dark:text-green-500 py-4"><strong><code>@lang(session("success"))<code><strong></p>
      <form method="dialog">
        <button class="btn-good text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
      </form>
    </dialog>
  @endif

</body>
</html>
