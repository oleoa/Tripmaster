<div class="">
  <div class="flex flex-col items-center justify-start pt-2 pb-4">
    <div class="py-4">
      <a href="https://www.booking.com/index.en-gb.html?aid=397594&label=gog235jc-1DCAEoggI46AdIM1gDaLsBiAEBmAEJuAEXyAEM2AED6AEBiAIBqAIDuALM-qWiBsACAdICJGZjZTFmYzQ5LTRiODItNDNmMi1hMjg5LWY5MGQ0OGFhZDIyNtgCBOACAQ&sid=976bbdb79e60801dd0ec93ca914b5599&keep_landing=1&sb_price_type=total&"><x-basics.h1 :text="'Tripmaster'"/></a>
    </div>
    <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
  </div>
  <ul class="px-2 dark:text-white">
    <x-sidebar.li :href="route('home')" :name="'Home'" :current="$current['home']"/>
    <x-sidebar.li :href="route('list.stays')" :name="'Stays'" :current="$current['stays']"/>
    <div class="py-4">
      <div class="h-0.5 w-full dark:bg-slate-300 bg-slate-800"></div>
    </div>
    <x-sidebar.li :href="route('my.projects')" :name="'Projects'" :current="$current['projects']"/>
    <x-sidebar.li :href="route('signin')" :name="'Signin'" :current="$current['signin']"/>
    <x-sidebar.li :href="route('signup')" :name="'Signup'" :current="$current['signup']"/>
    <x-sidebar.li :href="route('toggle-theme')" :name="'Darkmode'" :current="false"/>
  </ul>
</div>