<!DOCTYPE html>
<html lang="en">
<x-head :title="$title"/>
<body class='{{$theme}}'>

  <nav class='h-full w-48 border-r-2 border-turquoise-200 dark:border-slate-300 fixed left-0 flex flex-col justify-between'>
    <div>
      <div class="flex flex-col items-center justify-start pt-2 pb-4">
        <div class="py-6">
          <a class="no-underline" href="https://www.booking.com/index.en-gb.html?aid=397594&label=gog235jc-1DCAEoggI46AdIM1gDaLsBiAEBmAEJuAEXyAEM2AED6AEBiAIBqAIDuALM-qWiBsACAdICJGZjZTFmYzQ5LTRiODItNDNmMi1hMjg5LWY5MGQ0OGFhZDIyNtgCBOACAQ&sid=976bbdb79e60801dd0ec93ca914b5599&keep_landing=1&sb_price_type=total&"><h1>@lang('Tripmaster')</h1></a>
        </div>
        <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
      </div>
      <div class="px-4 grid gap-6 [&>a]:text-2xl">
        @if($isLogged)
          <a href="{{route('my.account')}}" class="@if($current['account']) underline @endif">@lang('Account')</a>
          <a href="{{route('my.list.projects')}}" class="@if($current['projects']) underline @endif">@lang('Projects')</a>
          <a href="{{route('my.list.stays')}}" class="@if($current['myStays']) underline @endif">@lang('My stays')</a>
        @endif
      </div>
    </div>
    <div class="px-4 flex flex-col justify-end [&>a]:text-2xl space-y-6 py-6">
      @if ($isLogged)
        <a href="{{route('signout')}}">@lang('Sign out')</a>
      @else
        <a href="{{route('signin')}}" class="@if($current['signin']) underline @endif">@lang('Sign in')</a>
        <a href="{{route('signup')}}" class="@if($current['signup']) underline @endif">@lang('Sign up')</a>
      @endif
      <a href="{{route('toggle-theme')}}">{{$inverseTheme}}</a>
    </div>
  </nav>

  <main class='pl-48 min-h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </main>
  
</body>
</html>
