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

        @if (!$isLogged)
          <div class="px-4 py-6 grid gap-6 [&>a]:text-2xl">
            <a href="{{route('contact')}}" class="@if($current['contact']) underline @endif">@lang('Contact us')</a>
          </div>
        @endif
        
        @if($isLogged)
          <div class="px-4 py-6 grid gap-6 [&>a]:text-2xl">
            <a href="{{route('contact')}}" class="@if($current['contact']) underline @endif">@lang('Contact us')</a>
            <a href="{{route('account.index')}}" class="@if($current['account']) underline @endif">@lang('Account')</a>
          </div>
        @endif

        <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>

        <div class="px-4 grid grid-cols-3 [&>a]:text-2xl space-y-6 py-6">
          @if ($isLogged)
            <a class="col-span-3 flex items-end justify-start" href="{{route('sign.out')}}">@lang('Sign out')</a>
            <details class="col-span-2 text-white text-2xl">
              <summary>@lang('Langs')</summary>
              <a href="{{route('language', ['locale' => 'pt'])}}">@lang('Portuguese')</a>
              <a href="{{route('language', ['locale' => 'en'])}}">@lang('English')</a>
            </details>
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
      <div id="opc" class="fixed top-0 right-0 w-full bg-slate-700/50 h-full">
        <dialog class="bg-slate-950 rounded my-4 w-1/2" open>
          <h1 class="message alert">@lang('Alert'):</h1>
          @foreach ($errors->all() as $error)
            @if($error == 'The password field format is invalid.')
              <p class="text-xl dark:text-yellow-500 py-4"><strong><code>@lang('The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character from the set [@ $ ! % * # ? &] to meet the minimum security requirements.')<code><strong></p>
            @else
              <p class="text-xl dark:text-yellow-500 py-4"><strong><code>@lang($error)<code><strong></p>
            @endif
          @endforeach
          <form method="dialog" class="text-end">
            <button class="btn alert text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
          </form>
        </dialog>
      </div>
    @endif

    <x-message :message="session('alert')" :title="'Alert'" :type="'alert'"/>
    <x-message :message="session('error')" :title="'Error'" :type="'danger'"/>
    <x-message :message="session('info')" :title="'Info'" :type="'okay'"/>
    <x-message :message="session('success')" :title="'Success'" :type="'good'"/>

  </body>
</html>
