<div class="">
  <div class="flex items-center justify-center pt-2 pb-4">
    <x-basics.h2 :text="'Tripmaster'"/>
  </div>
  <ul class="list-disc px-8 dark:text-white">
    <x-sidebar.li :href="route('home')" :name="'Home'" :current="false"/>
    <x-sidebar.li :href="route('stays')" :name="'Stays'" :current="false"/>
    <x-sidebar.li :href="route('projects')" :name="'Projects'" :current="false"/>
    <x-sidebar.li :href="route('toggle-theme')" :name="'Darkmode'" :current="false"/>
  </ul>
</div>