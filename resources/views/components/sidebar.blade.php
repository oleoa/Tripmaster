<div class="">
  <div class="flex items-center justify-center pt-2 pb-4">
    <x-basics.h2 :text="'Tripmaster'"/>
  </div>
  <ul class="list-disc px-8 dark:text-white">
    <li><a href="{{route('home')}}">Home</a></li>
    <li><a href="{{route('stays')}}">Stays</a></li>
    <li><a href="{{route('projects')}}">Projects</a></li>
    <li><a href="{{route('toggle-theme')}}">Darkmode</a></li>
  </ul>
</div>