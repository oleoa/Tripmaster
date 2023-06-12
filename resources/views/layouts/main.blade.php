<!DOCTYPE html>
<html lang="en">
<x-head :title="$title"/>
<body class="dark">

  <nav class='h-full w-48 border-r-2 border-turquoise-200 dark:border-slate-300 fixed left-0 flex flex-col justify-between'>
    <div>
      <div class="flex flex-col items-center justify-start pt-2 pb-4">
        <div class="py-6">
          <a class="no-underline" href="https://www.booking.com/index.en-gb.html?aid=397594&label=gog235jc-1DCAEoggI46AdIM1gDaLsBiAEBmAEJuAEXyAEM2AED6AEBiAIBqAIDuALM-qWiBsACAdICJGZjZTFmYzQ5LTRiODItNDNmMi1hMjg5LWY5MGQ0OGFhZDIyNtgCBOACAQ&sid=976bbdb79e60801dd0ec93ca914b5599&keep_landing=1&sb_price_type=total&"><h1>@lang('Tripmaster')</h1></a>
        </div>
        <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
      </div>
      @if($isLogged)
        <div class="grid gap-6 px-4 pb-6 justify-items-start [&>a]:text-2xl">
          <a href="{{route('main')}}" class="@if($current['main']) underline @endif">@lang('Main')</a>
          <a href="{{route('list.stays')}}" class="@if($current['stays']) underline @endif">@lang('Stays')</a>
        </div>
        <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
      @endif
      <div class="px-4 py-6 grid gap-6 [&>a]:text-2xl">
        @if($isLogged)
          <a href="{{route('my.account')}}" class="@if($current['account']) underline @endif">@lang('Account')</a>
          <a href="{{route('my.list.projects')}}" class="@if($current['projects']) underline @endif">@lang('My Projects')</a>
          <a href="{{route('my.list.stays')}}" class="@if($current['myStays']) underline @endif">@lang('My stays')</a>
        @endif
      </div>
    </div>
    <div>
      <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
      <div class="px-4 grid grid-cols-3 [&>a]:text-2xl space-y-6 py-6">
        @if ($isLogged)
          <a class="col-span-2 flex items-end justify-start" href="{{route('signout')}}">@lang('Sign out')</a>
        @else
          <a href="{{route('signin')}}" class="col-span-3 @if($current['signin']) underline @endif">@lang('Sign in')</a>
          <a href="{{route('signup')}}" class="col-span-2 @if($current['signup']) underline @endif">@lang('Sign up')</a>
        @endif
        @if(false)
          <button class="w-8" onclick="//document.querySelector('body').classList.toggle('dark')"><img src="{{asset('images/darkmode.svg')}}" alt="Darkmode"></button>
        @endif
      </div>
    </div>
  </nav>

  <main class='pl-48 min-h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </main>
  
  @if($errors->any())
    <div class="fixed top-0 w-full h-full bg-black/70 flex items-start justify-center p-6" id="errors">
      <div class="bg-slate-700 py-4 px-8 rounded text-red-500 [&>ul>li]:py-2 ">
        <h1>@lang('Errors:')</h1>
        <ul>
          @foreach ($errors->all() as $error)
            <li class="text-2xl">@lang($error)</li>
          @endforeach
        </ul>
        <button class="px-6 py-4 bg-slate-600 rounded hover:bg-slate-500 text-white">Okay</button>
      </div>
    </div>
    <script>
      document.querySelector("#errors").onclick = function(){this.style.display = "none"};
    </script>
  @endif

  @if (session('alert'))
    <dialog class="bg-slate-700 px-8 rounded text-red-500 [&>*]:py-4" id="errors" open>
      <h1>@lang('Alert'):</h1>
      <p class="text-xl"><strong><code>@lang(session("alert"))<code><strong></p>
      <form method="dialog">
        <button class="px-6 py-4 bg-slate-600 hover:bg-slate-500 text-white rounded">@lang('Okay')</button>
      </form>
    </dialog>
    <script>
      document.querySelector("#errors")?.close();
      document.querySelector("#errors")?.showModal();
    </script>
  @endif

</body>
</html>
