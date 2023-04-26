<div class="">
  <div class="flex items-center justify-center pt-2 pb-4">
    <x-basics.h2 :text="'Tripmaster'"/>
  </div>
  <ul class="list-disc px-8 dark:text-white">
    <x-sidebar.li :href="route('home')" :name="'Home'" :current="$current == 'home'"/>
    <x-sidebar.li :href="route('stays')" :name="'Stays'" :current="$current == 'stays.index'"/>
    <x-sidebar.li :href="route('projects')" :name="'Projects'" :current="$current == 'projects.list' || $current == 'projects.create'"/>
    <x-sidebar.li :href="route('toggle-theme')" :name="'Darkmode'" :current="false"/>
  </ul>
</div>