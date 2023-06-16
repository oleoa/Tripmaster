<!DOCTYPE html>
<html lang="en">
<x-head :title="$title"/>
  <body class="dark">

    <nav class="bg-slate-800 all-center p-4">
      <h1 class="text-7xl"><a href="{{route('home')}}">Tripmaster</a></h1>
    </nav>

    <div class='p-4 min-h-screen w-full bg-slate-800'>
      @yield('body')
    </div>
    
  </body>
</html>
