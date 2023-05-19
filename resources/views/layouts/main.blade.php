<!DOCTYPE html>
<html lang="en">
<x-head :title="$title"/>
<body class='{{$theme}}'>
  <nav class='h-full w-48 border-r-2 border-turquoise-200 dark:border-slate-300 fixed left-0'>
    <div class="">
      <div class="flex flex-col items-center justify-start pt-2 pb-4">
        <div class="py-6">
          <a class="no-underline" href="https://www.booking.com/index.en-gb.html?aid=397594&label=gog235jc-1DCAEoggI46AdIM1gDaLsBiAEBmAEJuAEXyAEM2AED6AEBiAIBqAIDuALM-qWiBsACAdICJGZjZTFmYzQ5LTRiODItNDNmMi1hMjg5LWY5MGQ0OGFhZDIyNtgCBOACAQ&sid=976bbdb79e60801dd0ec93ca914b5599&keep_landing=1&sb_price_type=total&"><h1>@lang('Tripmaster')</h1></a>
        </div>
        <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
      </div>
      <ul class="px-2 dark:text-white">
        <div class="grid gap-4">
          @if(!$isLogged)
            <x-sidebar.li :href="route('signin')" :name="'Sign in'" :current="$current['signin']"/>
            <x-sidebar.li :href="route('signup')" :name="'Sign up'" :current="$current['signup']"/>
          @else
            <x-sidebar.li :href="route('my.account')" :name="'Account'" :current="$current['account']"/>
            <x-sidebar.li :href="route('my.list.projects')" :name="'Projects'" :current="$current['projects']"/>
            <x-sidebar.li :href="route('my.list.stays')" :name="'My stays'" :current="$current['myStays']"/>
            <x-link.button :href="route('signout')" :name="'Sign out'"/>
          @endif
          <x-link.button :href="route('toggle-theme')" :name="$inverseTheme"/>
        </div>
      </ul>
    </div>
  </nav>
  <main class='pl-48 min-h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </main>
</body>
</html>
